<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Services;

use Exception;
use HoneyComb\Starter\Http\Requests\HCLanguageRequest;
use HoneyComb\Starter\Repositories\HCLanguageRepository;
use HoneyComb\Starter\Repositories\Traits\HCQueryBuilderTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use ReflectionException;

/**
 * Class HCUserService
 * @package HoneyComb\Starter\Services
 */
class HCLanguageService
{
    use HCQueryBuilderTrait;

    /**
     * @var HCLanguageRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $interfaceCacheKey = '_hc_interface_languages';

    /**
     * HCUserService constructor.
     * @param HCLanguageRepository $repository
     */
    public function __construct(HCLanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return HCLanguageRepository
     */
    public function getRepository(): HCLanguageRepository
    {
        return $this->repository;
    }

    /**
     * @param HCLanguageRequest $request
     * @param string $languageId
     * @throws Exception
     */
    public function update(HCLanguageRequest $request, string $languageId): void
    {
        cache()->forget($this->interfaceCacheKey);

        $this->getRepository()->update($request->getStrictUpdateValues(), $languageId);
    }

    /**
     * Get all available interface languages
     *
     * @return Collection
     * @throws Exception
     */
    public function getInterfaceActiveLanguages(): Collection
    {
        return cache()->remember($this->interfaceCacheKey, now()->addWeek(), function () {
            return $this->getRepository()->getInterfaceLanguages();
        });
    }

    /**
     * @param string|null $currentLanguage
     * @return array
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function getFilteredContentLanguages(string $currentLanguage = null): array
    {
        $languages = $this->getRepository()
            ->getContentLanguages()
            ->pluck('iso_639_1')
            ->toArray();

        if (!$currentLanguage || !in_array($currentLanguage, $languages)) {
            return $languages;
        }

        $filtered = array_diff($languages, [$currentLanguage]);

        array_unshift($filtered, $currentLanguage);

        return $filtered;
    }
}
