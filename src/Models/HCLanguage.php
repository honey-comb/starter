<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Models;

/**
 * Class HCLanguage
 * @package HoneyComb\Starter\Models
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $language_family
 * @property string $language
 * @property string $native_name
 * @property string $iso_639_1
 * @property string $iso_639_2
 * @property boolean $is_content
 * @property boolean $is_interface
 */
class HCLanguage extends HCUuidSoftModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_language';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'language_family',
        'language',
        'native_name',
        'iso_639_1',
        'iso_639_2',
        'is_content',
        'is_interface',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_content' => 'boolean',
        'is_interface' => 'boolean',
    ];
}
