<?php


declare(strict_types = 1);

namespace HoneyComb\Starter\Enum;

use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionException;

/**
 * Class BoolEnum
 * @package HoneyComb\Starter\Enum
 */
class BoolEnum extends Enumerable
{
    /**
     * @return BoolEnum | Enumerable
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    final public static function no(): BoolEnum
    {
        return self::make(0, trans('HCStarter::starter.enum.boolean_no'));
    }

    /**
     * @return BoolEnum | Enumerable
     * @throws BindingResolutionException
     * @throws ReflectionException
     */
    final public static function yes(): BoolEnum
    {
        return self::make(1, trans('HCStarter::starter.enum.boolean_yes'));
    }
}
