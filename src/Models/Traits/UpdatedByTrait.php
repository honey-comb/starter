<?php

namespace HoneyComb\Starter\Models\Traits;

use HoneyComb\Core\Models\HCUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UpdatedByTrait
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
        static::updating(function($model) {

            if (auth()->user()) {
                $updatorId = auth()->id();
            } else {
                $updatorId = null;
            }

            $model->{'updated_by'} = $updatorId;
        });
    }

    /**
     * Returning updator
     *
     * @return HasOne
     */
    public function updator(): HasOne
    {
        return $this->hasOne(HCUser::class, 'id', 'updated_by');
    }
}