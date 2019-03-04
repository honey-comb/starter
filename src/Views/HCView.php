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

namespace HoneyComb\Starter\Views;

/**
 * Class HCView
 * @package HoneyComb\Starter\Views
 */
class HCView
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * HCView constructor.
     * @param string $key
     * @param string|null $label
     */
    public function __construct(string $key, string $label = null)
    {
        $this->data = [
            'key' => $key,
            'label' => $label,
            'views' => [],
            'forms' => [],
            'data_list' => [],
            'actions' => [],
            'config' => [],
        ];
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->data['key'];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addConfig(string $key, $value): HCView
    {
        $this->data['config'][$key] = $value;

        return $this;
    }

    /**
     * @param array $actions
     * @return HCView
     */
    public function addActions(array $actions): HCView
    {
        $this->data['actions'] = $actions;

        return $this;
    }

    /**
     * @param string $key
     * @param string $formId
     * @param string|null $type
     * @return HCView
     */
    public function addForm(string $key, string $formId, string $type = null): HCView
    {
        $this->data['forms'][$key] = route('v1.api.form-manager', ['id' => $formId, 'type' => $type]);

        return $this;
    }

    /**
     * @param HCView $view
     * @return HCView
     */
    public function addView(HCView $view): HCView
    {
        $this->data['views'][$view->getKey()] = $view->toArray();

        return $this;
    }

    /**
     * @param HCDataList $dataList
     * @return HCView
     */
    public function addDataList(HCDataList $dataList): HCView
    {
        $this->data['data_list'][$dataList->getKey()] = $dataList->toArray();

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
