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
 * Class HCGrid
 * @package HoneyComb\Starter\Forms
 */
class HCGrid
{
    const XS = 'xs';
    const SM = 'sm';
    const MD = 'md';
    const LG = 'lg';
    const XL = 'xl';
    const XXL = 'xxl';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param float $size
     * @return HCGrid
     */
    public function xs(float $size): HCGrid
    {
        return $this->add(self::XS, $size);
    }

    /**
     * @param float $size
     * @return HCGrid
     */
    public function sm(float $size): HCGrid
    {
        return $this->add(self::SM, $size);
    }

    /**
     * @param float $size
     * @return HCGrid
     */
    public function md(float $size): HCGrid
    {
        return $this->add(self::MD, $size);
    }

    /**
     * @param float $size
     * @return HCGrid
     */
    public function lg(float $size): HCGrid
    {
        return $this->add(self::LG, $size);
    }

    /**
     * @param float $size
     * @return HCGrid
     */
    public function xl(float $size): HCGrid
    {
        return $this->add(self::XL, $size);
    }

    /**
     * @param float $size
     * @return HCGrid
     */
    public function xxl(float $size): HCGrid
    {
        return $this->add(self::XXL, $size);
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
     * @param float $size
     * @return HCGrid
     */
    private function add(string $type, float $size = 1): HCGrid
    {
        $this->data[$type] = $size;

        return $this;
    }
}
