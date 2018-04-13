<?php
/**
 * @copyright 2018 interactivesolutions
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
 * Contact InteractiveSolutions:
 * E-mail: hello@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

declare(strict_types = 1);

namespace Tests\Enum;


use HoneyComb\Starter\Enum\Enumerable;
use HoneyComb\Starter\Enum\Exceptions\EnumNotFoundException;
use Tests\TestCase;

/**
 * Class EnumerableTest
 * @package Tests\Enum
 */
class EnumerableTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_id_and_name_getters_correct_data(): void
    {
        $enum = TestEnum::testOne();

        $this->assertEquals('test_id_1', $enum->id());
        $this->assertEquals('test_name_1', $enum->name());
    }

    /**
     * @test
     */
    public function it_should_cache_enum_tests(): void
    {
        $enum1 = TestEnum::testOne();
        $enum2 = TestEnum::testOne();

        $this->assertEquals($enum1, $enum2);
    }

    /**
     * @test
     */
    public function it_should_return_only_final_public_static_enum_methods(): void
    {
        $enum = TestEnum::enum();

        $this->assertArrayHasKey('test_id_1', $enum);
        $this->assertArrayHasKey('test_id_2', $enum);
        $this->assertArrayNotHasKey('random_id', $enum);

        $this->assertSame(TestEnum::testOne(), $enum['test_id_1']);
        $this->assertSame(TestEnum::testTwo(), $enum['test_id_2']);
    }

    /**
     * @test
     */
    public function it_should_return_only_final_public_json_methods(): void
    {
        $this->assertJsonStringEqualsJsonString(TestEnum::json(), json_encode([
            'desc_id' => 'desc_name',
            'test_id_1' => 'test_name_1',
            'test_id_2' => 'test_name_2',
        ]));
    }

    /**
     * @test
     */
    public function it_should_create_tests_enums_from_id(): void
    {
        $this->assertSame(TestEnum::testOne(), TestEnum::from('test_id_1'));
        $this->assertSame(TestEnum::testTwo(), TestEnum::from('test_id_2'));
    }

    /**
     * @test
     */
    public function it_should_throws_exception_when_trying_to_get_non_existing_enum(): void
    {
        $this->expectException(EnumNotFoundException::class);
        $this->expectExceptionMessage('Unable to find enumerable with id test_enum of type ' . get_class(TestEnum::testOne()));

        TestEnum::from('test_enum');
    }

    /**
     * @test
     */
    public function it_should_returns_description(): void
    {
        $this->assertEquals('description', TestEnum::withDescription()->description());
        $this->assertEquals('', TestEnum::testOne()->description());
    }

    /**
     * @test
     */
    public function it_should_creates_new_instance_with_set_state(): void
    {
        $newInstance = TestEnum::__set_state(['id' => 'rand_id', 'name' => 'rand_name', 'description' => 'rand_desc']);

        $this->assertInstanceOf(TestEnum::class, $newInstance);
        $this->assertEquals('rand_id', $newInstance->id());
        $this->assertEquals('rand_name', $newInstance->name());
        $this->assertEquals('rand_desc', $newInstance->description());
    }

    /**
     * @test
     */
    public function it_should_return_id_when_calling_to_string(): void
    {
        $this->assertSame((string)TestEnum::withDescription(), TestEnum::withDescription()->id());
    }

    /**
     * @test
     */
    public function it_should_return_enum_ids_and_names_as_key_value_pairs_on_calling_options_method(): void
    {
        $this->assertEquals([
            [
                'id' => 'desc_id',
                'label' => 'desc_name',
            ],
            [
                'id' => 'test_id_1',
                'label' => 'test_name_1',
            ],
            [
                'id' => 'test_id_2',
                'label' => 'test_name_2',
            ],
        ], TestEnum::testOne()->options());
    }
}

/**
 * Class TestEnum
 * @package Tests\Enum
 */
class TestEnum extends Enumerable
{
    /**
     * @return TestEnum|Enumerable
     */
    final public static function withDescription(): TestEnum
    {
        return self::make('desc_id', 'desc_name', 'description');
    }

    /**
     * @return TestEnum|Enumerable
     */
    final public static function testOne(): TestEnum
    {
        return self::make('test_id_1', 'test_name_1');
    }

    /**
     * @return TestEnum|Enumerable
     */
    final public static function testTwo(): TestEnum
    {
        return self::make('test_id_2', 'test_name_2');
    }

    /**
     * @return TestEnum|Enumerable
     */
    public static function randomMethod(): TestEnum
    {
        return self::make('random_id', 'random_name');
    }
}
