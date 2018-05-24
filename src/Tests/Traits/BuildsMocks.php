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

namespace HoneyComb\Starter\Tests\Traits;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Trait BuildsMocks
 * @package HoneyComb\Starter\Tests\Traits
 */
trait BuildsMocks
{
    /**
     * @param string $mockClass
     * @param string|null $injectorClass
     * @param bool $method
     * @param array|null $constructorArgs
     * @param bool $onlyForInjector
     * @return PHPUnit_Framework_MockObject_MockObject
     * @throws \ReflectionException
     */
    public function initPHPUnitMock(
        string $mockClass,
        string $injectorClass = null,
        $method = false,
        array $constructorArgs = null,
        bool $onlyForInjector = false
    ): PHPUnit_Framework_MockObject_MockObject {
        $this->forgetInstances($mockClass, $injectorClass);
        $mock = $this->createPHPUnitMockBuilder($mockClass, $constructorArgs, $method);
        $this->injectMockToLaravel($mockClass, $mock, $onlyForInjector, $injectorClass);

        return $mock;
    }

    /**
     * @param string $mockClass
     * @param string|null $injectorClass
     * @param bool $onlyForInjector
     * @return MockInterface
     */
    public function initMockeryMock(
        string $mockClass,
        string $injectorClass = null,
        bool $onlyForInjector = false
    ): MockInterface {
        $this->forgetInstances($mockClass, $injectorClass);
        $mock = Mockery::mock($mockClass);
        $this->injectMockToLaravel($mockClass, $mock, $onlyForInjector, $injectorClass);

        return $mock;
    }

    /**
     * @param string $mockClass
     * @param string|null $injectorClass
     */
    private function forgetInstances(string $mockClass, string $injectorClass = null): void
    {
        $this->app->forgetInstance($mockClass);

        if (isset($injectorClass)) {
            $this->app->forgetInstance($injectorClass);
        }
    }

    /**
     * @param string $mockClass
     * @param array|null $constructorArgs
     * @param array|null|bool $methods
     * @return PHPUnit_Framework_MockObject_MockObject
     * @throws \ReflectionException
     */
    private function createPHPUnitMockBuilder(
        string $mockClass,
        array $constructorArgs = null,
        $methods = false
    ): PHPUnit_Framework_MockObject_MockObject {
        /** @var MockBuilder $builder */
        $builder = $this->getMockBuilder($mockClass);

        if (isset($constructorArgs)) {
            $builder->setConstructorArgs($constructorArgs);
        } else {
            $builder->disableOriginalConstructor();
        }

        if ($methods !== false) {
            $builder->setMethods($methods);
        }

        return $builder->getMock();
    }

    /**
     * @param string $mockClass
     * @param PHPUnit_Framework_MockObject_MockObject|MockInterface $mock
     * @param bool $onlyForInjector
     * @param string|null $injectorClass
     */
    private function injectMockToLaravel(
        string $mockClass,
        $mock,
        bool $onlyForInjector = false,
        string $injectorClass = null
    ): void {
        if ($onlyForInjector) {
            if (!isset($injectorClass)) {
                throw new \RuntimeException('Injector class must be specified when using "onlyForInjector" bind');
            }

            $this->app->when($injectorClass)->needs($mockClass)->give(function () use ($mock) {
                return $mock;
            });
        } else {
            $this->app->instance($mockClass, $mock);
        }
    }
}
