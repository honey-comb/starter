<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Models\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;

/**
 * Trait HCTranslation
 * @package HoneyComb\Starter\Models\Traits
 */
trait HCTranslation
{
    /**
     * Translations
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationClass(), 'record_id', 'id');
    }

    /**
     * Single translation only
     *
     * @return HasOne
     * @throws BindingResolutionException
     */
    public function translation(): HasOne
    {
        return $this->hasOne(
            $this->getTranslationClass(),
            'record_id',
            'id'
        )->where('language_code', app()->getLocale());
    }

    /**
     * Update translations
     *
     * @param array $data
     * @return Model|null|object|static
     */
    public function updateTranslation(array $data)
    {
        $translation = $this->translations()->where([
            'record_id' => $this->id,
            'language_code' => Arr::get($data, 'language_code'),
        ])->first();

        if (is_null($translation)) {
            $translation = $this->translations()->create($data);
        } else {
            $translation->update($data);
        }

        return $translation;
    }

    /**
     * Update multiple translations at once
     *
     * @param array $data
     */
    public function updateTranslations(array $data = []): void
    {
        foreach ($data as $translationsData) {
            $this->updateTranslation($translationsData);
        }
    }

    /**
     * @return string
     */
    public function getTranslationClass(): string
    {
        return get_class($this) . 'Translation';
    }
}
