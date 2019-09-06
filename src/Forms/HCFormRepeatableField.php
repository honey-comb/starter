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

namespace HoneyComb\Starter\Forms;

use Illuminate\Support\Arr;

/**
 * Class HCFormRepeatableFields
 * @package HoneyComb\Starter\Forms
 */
class HCFormRepeatableField
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param int $amount
     * @return HCFormRepeatableField
     */
    public function setMaxAmount(int $amount = 5): HCFormRepeatableField
    {
        return $this->addProperty('maxAmount', $amount);
    }

    /**
     * @param string $label
     * @param callable|null $callable
     * @return HCFormRepeatableField
     */
    public function addButton(string $label, callable $callable = null): HCFormRepeatableField
    {
        $this->initProperty('buttons', []);

        $button = new HCFormButton($label);

        if (!is_null($callable)) {
            $instance = $callable($button);

            if ($instance instanceof HCFormButton) {
                $button = $instance;
            }
        }

        $this->data['buttons'][] = $button->toArray();

        return $this;
    }

    /**
     * @param string $fieldName
     * @param string|null $label
     * @param callable|null $callable
     * @return HCFormRepeatableField
     */
    public function addField(string $fieldName, string $label = null, callable $callable = null): HCFormRepeatableField
    {
        $this->initProperty('structure', []);

        $field = new HCFormField($label);

        if (!is_null($callable)) {
            $instance = $callable($field);

            if ($instance instanceof HCFormField) {
                $field = $instance;
            }
        }

        $this->data['structure'][$fieldName] = $field->toArray();

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return HCFormRepeatableField
     */
    public function addProperty(string $key, $value): HCFormRepeatableField
    {
        $this->initProperty('properties', []);

        $this->data['properties'][$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @param string $param
     * @param mixed $value
     */
    private function initProperty(string $param, $value = null): void
    {
        if (!Arr::has($this->data, $param)) {
            $this->data[$param] = $value;
        }
    }
}
