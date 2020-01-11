<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HCModel
 * @package HoneyComb\Starter\Models
 */
class HCModel extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Function which gets table name
     *
     * @return mixed
     */
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }

    /**
     * Function which gets fillable fields array
     *
     * @param bool $join
     * @return array
     */
    public static function getFillableFields(bool $join = false)
    {
        $list = with(new static)->getFillable();

        if ($join)
        {
            //to use default sort_by command
            array_push($list, 'created_at');
            foreach ($list as &$value)
                $value = self::getTableName() . '.' . $value;
        }

        return $list;
    }
}
