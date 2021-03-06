<?php

declare(strict_types=1);

namespace HoneyComb\Starter\Repositories\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Trait HCQueryBuilderTrait
 * @package HoneyComb\Starter\Repositories\Traits
 */
trait HCQueryBuilderTrait
{
    /**
     * Keys which can be updated by strict method
     *
     * @var array
     */
    protected $strictUpdateKeys = [];

    /**
     * Minimum search input length
     *
     * @var int
     */
    protected $minimumSearchInputLength = 0;

    /**
     * Creating data query
     *
     * @param Request $request
     * @param array $columns
     * @param bool $merge
     * @param bool $defaultOrder
     * @return Builder
     */
    protected function createBuilderQuery(
        Request $request,
        array $columns = [],
        bool $merge = true,
        bool $defaultOrder = true
    ): Builder
    {
        if ($merge) {
            $availableFields = array_merge($this->getModel()::getFillableFields(), $columns);

            if (($key = array_search('*', $availableFields)) !== false) {
                unset($availableFields[$key]);
            }
        } else {
            $availableFields = $columns;
        }

        $builder = $this->getModel()::select($availableFields)
            ->where(function (Builder $query) use ($request, $availableFields) {
                // add request filtering
                $this->filterByRequestParameters($query, $request, $availableFields);
            });

        // check if soft deleted records must be shown
        $builder = $this->checkForTrashed($builder, $request);

        // search through items
        $builder = $this->search($builder, $request);

        // set order
        if ($defaultOrder) {
            $builder = $this->orderData($builder, $request, $availableFields);
        }

        return $builder;
    }

    /**
     * Get only valid request params for records filtering
     *
     * @param Builder $query
     * @param Request $request
     * @param array $availableFields - Model available fields to select
     * @return Builder
     */
    protected function filterByRequestParameters(Builder $query, Request $request, array $availableFields): Builder
    {
        $givenFields = $this->getRequestParameters($request);

        foreach ($givenFields as $fieldName => $value) {
            $from = substr($fieldName, 0, -5);
            $to = substr($fieldName, 0, -3);

            if (in_array($from, $availableFields) && $value != '') {
                $query->where($from, '>=', $value);
            }

            if (in_array($to, $availableFields) && $value != '') {
                $query->where($to, '<=', $value);
            }

            if (in_array($fieldName, $availableFields)) {
                if (is_array($value)) {
                    $query->whereIn($fieldName, $value);
                } else {
                    if ($value === 'NOT_NULL') {
                        $query->whereNotNull($fieldName);
                    } elseif ($value === 'NULL') {
                        $query->whereNull($fieldName);
                    } else {
                        $query->where($fieldName, '=', $value);
                    }
                }
            }
        }

        return $query;
    }

    /**
     * Gathering all request parameters except cms reserved
     *
     * @param Request $request
     * @return array
     */
    protected function getRequestParameters(Request $request): array
    {
        return $request->except(['page', 'q', 'trashed', 'sort_by', 'sort_order']);
    }

    /**
     * Gathering all allowed request parameters for strict update
     *
     * @param Request $request
     * @return array
     */
    protected function getStrictRequestParameters(Request $request): array
    {
        $data = [];

        foreach ($this->strictUpdateKeys as $value) {
            if ($request->filled($value)) {
                $data[$value] = $request->input($value);
            }
        }

        return $data;
    }

    /**
     * Ordering content
     *
     * @param Builder $query
     * @param Request $request
     * @param array $availableFields
     * @return Builder
     */
    protected function orderData(Builder $query, Request $request, array $availableFields): Builder
    {
        $sortBy = $request->input('sort_by');
        $sortOrder = $request->input('sort_order');
        $modelPrefix = $this->model()::getTableName() . '.';

        if (in_array($sortBy, $availableFields)) {
            if (in_array(strtolower($sortOrder), ['asc', 'desc'])) {
                return $query->orderBy($modelPrefix . $sortBy, $sortOrder);
            }
        }

        return $query->orderBy($modelPrefix . 'created_at', 'desc');
    }

    /**
     * Creating data list based on search
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     * @throws BindingResolutionException
     */
    protected function search(Builder $query, Request $request): Builder
    {
        $phrase = $request->input('q');

        if (!$phrase || strlen($phrase) < $this->minimumSearchInputLength) {
            return $query;
        }

        if ($this->translationModel()) {
            return $this->searchQueryTranslations($query, $phrase);
        }

        return $this->searchQuery($query, $phrase);
    }

    /**
     * Check for trashed records option
     *
     * @param Builder $query
     * @param Request $request
     * @return mixed
     */
    protected function checkForTrashed(Builder $query, Request $request): Builder
    {
        if ($request->filled('trashed') && $request->input('trashed') === '1') {
            $query->onlyTrashed();
        }

        return $query;
    }

    /**
     * List search elements
     *
     * @param Builder $query
     * @param string $phrase
     * @return Builder
     */
    protected function searchQuery(Builder $query, string $phrase): Builder
    {
        $fields = $this->getModel()::getFillableFields();

        return $query->where(function (Builder $query) use ($fields, $phrase) {
            foreach ($fields as $key => $field) {
                $method = $key == 0 ? 'where' : 'orWhere';

                if (strpos($field, '_at') === false) {
                    $query->{$method}($field, 'LIKE', '%' . $phrase . '%');
                }
            }

            return $query;
        });
    }

    /**
     * List search elements
     *
     * @param Builder $query
     * @param string $phrase
     * @return Builder
     * @throws BindingResolutionException
     */
    protected function searchQueryTranslations(Builder $query, string $phrase): Builder
    {
        $r = $this->getModel()::getTableName();
        $rf = $this->getModel()::getFillableFields(true);

        $t = $this->translationModel()::getTableName();
        $tf = $this->translationModel()::getFillableFields(true);

        return $query->join($t, "$r.id", "=", "$t.record_id")
            ->where($t . '.language_code', app()->getLocale())
            ->where(function (Builder $query) use ($t, $rf, $tf, $phrase) {

                $fields = array_merge($rf, $tf);
                $count = 0;

                foreach ($fields as $key => $field) {

                    if (strpos($field, '_at') ||
                        strpos($field, 'id') ||
                        strpos($field, 'language_code')) {

                    } else {

                        $method = $count == 0 ? 'where' : 'orWhere';
                        $count++;
                        $query->{$method}($field, 'LIKE', '%' . $phrase . '%');
                    }
                }

                return $query;
            });
    }

    /**
     * @param Request $request
     * @return Collection
     * @throws BindingResolutionException
     */
    public function getList(Request $request): Collection
    {
        return $this->createBuilderQuery($request)->get();
    }

    /**
     * @param Request $request
     * @param int $perPage
     * @param array $columns
     * @param array $with
     * @return LengthAwarePaginator
     * @throws BindingResolutionException
     */
    public function getListPaginate(
        Request $request,
        array $with = [],
        int $perPage = self::DEFAULT_PER_PAGE,
        array $columns = ['*']
    ): LengthAwarePaginator
    {

        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
        }

        return $this->createBuilderQuery($request, $columns)->with($with)->paginate($perPage,
            $columns)->appends($request->all());
    }
}
