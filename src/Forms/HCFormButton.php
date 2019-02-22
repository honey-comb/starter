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

/**
 * Class HCFormButton
 * @package HoneyComb\Starter\Forms
 */
class HCFormButton
{
    const SUBMIT = 'submit';
    const RESET = 'reset';
    const BUTTON = 'button';

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
        $this->data['label'] = $label;

        $this->setType(self::BUTTON);
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
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @param string $type
     */
    private function setType(string $type): void
    {
        $this->data['type'] = $type;
    }
}
