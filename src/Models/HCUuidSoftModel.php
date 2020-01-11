<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HCUuidSoftModel
 * @package HoneyComb\Starter\Models
 */
class HCUuidSoftModel extends HCUuidModel
{
    use SoftDeletes;

    /**
     * Soft delete database field.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
