<?php

namespace HoneyComb\Starter\Repositories;

use HoneyComb\Starter\Enum\BoolEnum;
use HoneyComb\Starter\Http\Requests\HCLanguageRequest;
use HoneyComb\Starter\Models\HCLanguage;
use HoneyComb\Starter\Repositories\Traits\HCQueryBuilderTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use ReflectionException;

/**
 * Class HCLanguageRepository
 * @package HoneyComb\Starter\Repositories
 */
class HCLanguageRepository extends HCBaseRepository
{
    use HCQueryBuilderTrait;

    /**
     * @var string
     */
    protected $interfaceCacheKey = '_hc_interface_languages';

    /**
     * @return string
     */
    public function model(): string
    {
        return HCLanguage::class;
    }

    /**
     * @return string
     */
    public function getInterfaceCacheKey(): string
    {
        return $this->interfaceCacheKey;
    }

    /**
     * @param HCLanguageRequest $request
     * @return \Illuminate\Support\Collection|static
     * @throws BindingResolutionException
     */
    public function getOptions(HCLanguageRequest $request)
    {
        return $this->createBuilderQuery($request)->get()->map(function ($record) {
            return [
                'id' => $record->id,
                'language' => $record->language,
            ];
        });
    }

    /**
     * @return Collection
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function getContentLanguages(): Collection
    {
        return $this->makeQuery()
            ->where('is_content', BoolEnum::yes()->id())
            ->get();
    }

    /**
     * @return Collection
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function getInterfaceLanguages(): Collection
    {
        return $this->makeQuery()
            ->where('is_interface', BoolEnum::yes()->id())
            ->get();
    }
}
