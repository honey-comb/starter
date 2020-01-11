<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Models;

use Ramsey\Uuid\Uuid;

/**
 * Class HCUuidModel
 * @package HoneyComb\Starter\Models
 */
class HCUuidModel extends HCModel
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `id` field (provided by $model->getKeyName())
         */
        static::creating(function ($model) {
            if (!isset($model->attributes['id'])) {
                $model->attributes['id'] = Uuid::uuid4()->toString();
            }

            /** @var HCUuidModel $model */
            $model->{$model->getKeyName()} = $model->attributes['id'];
        });
    }
}
