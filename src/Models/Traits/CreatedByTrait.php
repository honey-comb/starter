<?php

namespace HoneyComb\Starter\Models\Traits;

use HoneyComb\Core\Models\HCUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait CreatedByTrait
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
         * Attach to the 'creating' Model Event to provide record with user id which is now creating this record
         */
        static::creating(function($model) {

            if (auth()->user()) {
                $creatorId = auth()->id();
            } else {
                $creatorId = null;
            }

            $model->{'created_by'} = $creatorId;
        });
    }

    /**
     * Returning creator
     *
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(HCUser::class, 'id', 'created_by');
    }
}