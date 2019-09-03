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
declare(strict_types=1);

namespace HoneyComb\Starter\Forms;

/**
 * Class HCGrid
 * @package HoneyComb\Starter\Forms
 */
class HCGridResponsive
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
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    public function xs(float $size, float $offset = null, float $push = null): HCGridResponsive
    {
        return $this->add(self::XS, $size, $offset, $push);
    }

    /**
     * @param float $size
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    public function sm(float $size, float $offset = null, float $push = null): HCGridResponsive
    {
        return $this->add(self::SM, $size, $offset, $push);
    }

    /**
     * @param float $size
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    public function md(float $size, float $offset = null, float $push = null): HCGridResponsive
    {
        return $this->add(self::MD, $size, $offset, $push);
    }

    /**
     * @param float $size
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    public function lg(float $size, float $offset = null, float $push = null): HCGridResponsive
    {
        return $this->add(self::LG, $size, $offset, $push);
    }

    /**
     * @param float $size
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    public function xl(float $size, float $offset = null, float $push = null): HCGridResponsive
    {
        return $this->add(self::XL, $size, $offset, $push);
    }

    /**
     * @param float $size
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    public function xxl(float $size, float $offset = null, float $push = null): HCGridResponsive
    {
        return $this->add(self::XXL, $size, $offset, $push);
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
     * @param float|null $offset
     * @param float|null $push
     * @return HCGridResponsive
     */
    private function add(string $type, float $size = 1, float $offset = null, float $push = null): HCGridResponsive
    {
        $this->data[$type] = [
            'span' => $size,
            'offset' => $offset,
            'push' => $push
        ];

        return $this;
    }
}
