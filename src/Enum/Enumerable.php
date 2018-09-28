<?php
/**
 * @copyright 2018 innovationbase
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Contact InnovationBase:
 * E-mail: hello@innovationbase.eu
 * https://innovationbase.eu
 */

declare(strict_types = 1);

namespace HoneyComb\Starter\Enum;

use HoneyComb\Starter\Enum\Exceptions\EnumNotFoundException;

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
     * @throws \ReflectionException
     */
    public static function enum(): array
    {
        $reflection = new \ReflectionClass(get_called_class());
        $finalMethods = $reflection->getMethods(\ReflectionMethod::IS_FINAL);

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
     */
    public static function except(array $keys): array
    {
        return array_values(array_filter(self::options(), function (array $enumerable) use ($keys) {
            return !in_array($enumerable['id'], $keys);
        }));
    }


    /**
     * @return string
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
     * @throws \ReflectionException
     */
    protected static function make($id, string $name, string $description = ''): Enumerable
    {
        $class = get_called_class();

        if (isset(self::$instances[$class][$id])) {
            return self::$instances[$class][$id];
        }

        $reflection = new \ReflectionClass($class);

        /** @var Enumerable $instance */
        $instance = $reflection->newInstance($id, $name, $description);
        $refConstructor = $reflection->getConstructor();
        $refConstructor->setAccessible(true);

        return self::$instances[$class][$id] = $instance;
    }
}
