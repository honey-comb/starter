<?php
/**
 * @copyright 2019 innovationbase
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

/**
 * Class HCFormFieldDependencyTypeEnum
 * @package HoneyComb\Starter\Enum
 */
class HCFormFieldDependencyTypeEnum extends Enumerable
{
    /**
     * @return HCFormFieldDependencyTypeEnum
     * @throws \ReflectionException
     */
    final public static function any(): HCFormFieldDependencyTypeEnum
    {
        return self::make('any', trans('HCStarter::starter.enum.form_field_dependency_type_any'));
    }

    /**
     * @return HCFormFieldDependencyTypeEnum
     * @throws \ReflectionException
     */
    final public static function strict(): HCFormFieldDependencyTypeEnum
    {
        return self::make('strict', trans('HCStarter::starter.enum.form_field_dependency_type_strict'));
    }
}
