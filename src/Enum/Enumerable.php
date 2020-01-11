<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Enum;

use HoneyComb\Starter\Enum\Exceptions\EnumNotFoundException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Enumerable
 * @package HoneyComb\Starter\Enum
 */
abstract class Enumerable
{
    /**
     * @var
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Enumerable constructor.
     * @param $id
     * @param string $name
     * @param string $description
     */
    public function __construct($id, string $name, string $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;

        self::$instances[get_called_class()][$id] = $this;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * @param string $id
     * @return Enumerable
     * @throws EnumNotFoundException
     * @throws ReflectionException
     */
    public static function from(string $id): Enumerable
    {
        $enum = self::enum();
        if (!isset($enum[$id])) {
            throw new EnumNotFoundException(strtr('Unable to find enumerable with id :id of type :type', [
                ':id' => $id,
                ':type' => get_called_class(),
            ]));
        }

        return $enum[$id];
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public static function enum(): array
    {
        $reflection = new ReflectionClass(get_called_class());
        $finalMethods = $reflection->getMethods(ReflectionMethod::IS_FINAL);

        $return = [];
        foreach ($finalMethods as $key => $method) {
            /** @var Enumerable $enum */
            $enum = $method->invoke(null);
            $return[$enum->id()] = $enum;
        }

        return $return;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public static function options(): array
    {
        return array_values(array_map(function (Enumerable $enumerable) {
            return ['id' => $enumerable->id(), 'label' => $enumerable->name()];
        }, self::enum()));
    }

    /**
     * @param array $keys
     * @return array
     * @throws ReflectionException
     */
    public static function only(array $keys): array
    {
        return array_values(array_filter(self::options(), function (array $enumerable) use ($keys) {
            return in_array($enumerable['id'], $keys);
        }));
    }

    /**
     * @param array $keys
     * @return array
     * @throws ReflectionException
     */
    public static function except(array $keys): array
    {
        return array_values(array_filter(self::options(), function (array $enumerable) use ($keys) {
            return !in_array($enumerable['id'], $keys);
        }));
    }


    /**
     * @return string
     * @throws ReflectionException
     */
    public static function json(): string
    {
        return json_encode(array_map(function (Enumerable $enumerable) {
            return $enumerable->name();
        }, self::enum()));
    }

    /**
     * @param array $state
     * @return Enumerable
     * @throws ReflectionException
     */
    public static function __set_state(array $state): self
    {
        return self::make($state['id'], $state['name'], $state['description']);
    }

    /**
     * @param $id
     * @param string $name
     * @param string $description
     * @return Enumerable
     * @throws ReflectionException
     */
    protected static function make($id, string $name, string $description = ''): Enumerable
    {
        $class = get_called_class();

        if (isset(self::$instances[$class][$id])) {
            return self::$instances[$class][$id];
        }

        $reflection = new ReflectionClass($class);

        /** @var Enumerable $instance */
        $instance = $reflection->newInstance($id, $name, $description);
        $refConstructor = $reflection->getConstructor();
        $refConstructor->setAccessible(true);

        return self::$instances[$class][$id] = $instance;
    }
}
