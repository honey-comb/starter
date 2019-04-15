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
 * Interface HCViewContract
 * @package HoneyComb\Starter\Contracts
 */
interface HCViewContract
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param string $key
     * @return HCViewContract
     */
    public function setKey(string $key): HCViewContract;

    /**
     * @param string|null $label
     * @return HCViewContract
     */
    public function setLabel(string $label = null): HCViewContract;

    /**
     * @param string $key
     * @param mixed $value
     * @return HCViewContract
     */
    public function addConfig(string $key, $value): HCViewContract;

    /**
     * @param HCViewContract $view
     * @return HCViewContract
     */
    public function addView(HCViewContract $view): HCViewContract;

    /**
     * @param HCDataTableContract $dataTable
     * @return HCViewContract
     */
    public function addDataTable(HCDataTableContract $dataTable): HCViewContract;

    /**
     * @param string $key
     * @param HCFormContract $form
     * @param string $type
     * @return HCViewContract
     */
    public function addForm(string $key, HCFormContract $form, string $type = null): HCViewContract;

    /**
     * @param string $key
     * @param string $formId
     * @param string|null $type
     * @return HCViewContract
     */
    public function addFormSource(string $key, string $formId, string $type = null): HCViewContract;

    /**
     * @param string $permission
     * @return HCViewContract
     */
    public function addPermission(string $permission): HCViewContract;

    /**
     * @param array $permissions
     * @return HCViewContract
     */
    public function setPermissions(array $permissions): HCViewContract;

    /**
     * @param string $key
     * @param string|null $label
     * @return array
     */
    public function getDefaultStructure(string $key, string $label = null): array;

    /**
     * @return array
     */
    public function toArray(): array;
}