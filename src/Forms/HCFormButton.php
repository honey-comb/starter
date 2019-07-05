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
 * Class HCFormButton
 * @package HoneyComb\Starter\Forms
 */
class HCFormButton
{
    const SUBMIT = 'submit';
    const RESET = 'reset';
    const BUTTON = 'button';
    const DELETE = 'delete';
    const CANCEL = 'cancel';

    /**
     * @var array
     */
    private $data = [];

    /**
     * HCFormField constructor.
     * @param string $label
     */
    public function __construct(string $label)
    {
        $this->data = $this->getDefaultStructure($label);
    }

    /**
     * @return HCFormButton
     */
    public function submit(): HCFormButton
    {
        $this->setType(self::SUBMIT);

        return $this;
    }

    /**
     * @return HCFormButton
     */
    public function reset(): HCFormButton
    {
        $this->setType(self::RESET);

        return $this;
    }

    /**
     * @return HCFormButton
     */
    public function delete(): HCFormButton
    {
        $this->setType(self::DELETE);

        return $this;
    }

    /**
     * @return HCFormButton
     */
    public function cancel(): HCFormButton
    {
        $this->setType(self::CANCEL);

        return $this;
    }

    /**
     * @param bool $status
     * @return HCFormButton
     */
    public function isFullWidth(bool $status = true): HCFormButton
    {
        return $this->addProperty('fullWidth', $status);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return HCFormButton
     */
    public function addProperty(string $key, $value): HCFormButton
    {
        $this->setDefaultParam('properties', []);

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
     * @param string $label
     * @return array
     */
    protected function getDefaultStructure(string $label = null): array
    {
        return [
            'type' => self::BUTTON,
            'label' => $label,
            'properties' => [
                'fullWidth' => false,
            ],
        ];
    }

    /**
     * @param string $type
     */
    private function setType(string $type): void
    {
        $this->data['type'] = $type;
    }

    /**
     * @param string $param
     * @param mixed $value
     */
    private function setDefaultParam(string $param, $value = null): void
    {
        if (!Arr::has($this->data, $param)) {
            $this->data[$param] = $value;
        }
    }
}
