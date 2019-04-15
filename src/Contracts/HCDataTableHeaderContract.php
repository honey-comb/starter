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

namespace HoneyComb\Starter\Contracts;


/**
 * Interface HCDataTableHeaderContract
 * @package HoneyComb\Starter\Contracts
 */
interface HCDataTableHeaderContract
{
    /**
     * @param string|null $label
     * @return HCDataTableHeaderContract
     */
    public function setLabel(string $label = null): HCDataTableHeaderContract;

    /**
     * @param bool $status
     * @return HCDataTableHeaderContract
     */
    public function isSortable(bool $status = true): HCDataTableHeaderContract;

    /**
     * @param string $key
     * @param mixed $value
     * @return HCDataTableHeaderContract
     */
    public function addProperty(string $key, $value): HCDataTableHeaderContract;

    /**
     * @return HCDataTableHeaderContract
     */
    public function text(): HCDataTableHeaderContract;

    /**
     * @return HCDataTableHeaderContract
     */
    public function html(): HCDataTableHeaderContract;

    /**
     * @return HCDataTableHeaderContract
     */
    public function checkbox(): HCDataTableHeaderContract;

    /**
     * @param bool $external
     * @return HCDataTableHeaderContract
     */
    public function url(bool $external = true): HCDataTableHeaderContract;

    /**
     * @param string $field
     * @param string|null $label
     * @return array
     */
    public function getDefaultStructure(string $field, string $label = null): array;

    /**
     * @return array
     */
    public function toArray(): array;
}