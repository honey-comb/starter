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

use HoneyComb\Starter\Contracts\HCDataTableContract;
use HoneyComb\Starter\Contracts\HCFormContract;
use HoneyComb\Starter\Contracts\HCViewContract;
use HoneyComb\Starter\Enum\HCFormTypeEnum;

/**
 * Class HCView
 * @package HoneyComb\Starter\Views
 */
class HCView implements HCViewContract
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * HCView constructor.
     * @param string $key
     * @param string|null $label
     */
    public function __construct(string $key, string $label = null)
    {
        $this->data = $this->getDefaultStructure($key, $label);
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
     * @return HCViewContract
     */
    public function setKey(string $key): HCViewContract
    {
        $this->data['key'] = $key;

        return $this;
    }

    /**
     * @param string|null $label
     * @return HCViewContract
     */
    public function setLabel(string $label = null): HCViewContract
    {
        $this->data['label'] = $label;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return HCViewContract
     */
    public function addConfig(string $key, $value): HCViewContract
    {
        $this->data['config'][$key] = $value;

        return $this;
    }

    /**
     * @param HCViewContract $view
     * @return HCViewContract
     */
    public function addView(HCViewContract $view): HCViewContract
    {
        $this->data['views'][$view->getKey()] = $view->toArray();

        return $this;
    }

    /**
     * @param HCDataTableContract $dataTable
     * @return HCViewContract
     */
    public function addDataTable(HCDataTableContract $dataTable): HCViewContract
    {
        $this->data['data_tables'][$dataTable->getKey()] = $dataTable->toArray();

        return $this;
    }

    /**
     * @param string $key
     * @param string $formId
     * @param string|null $type
     * @return HCViewContract
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function addFormSource(string $key, string $formId, string $type = null): HCViewContract
    {
        $this->data['form_sources'][$key] = route('v1.api.form-manager', ['id' => $formId, 'type' => $type]);

        return $this;
    }

    /**
     * @param string $key
     * @param HCFormContract $form
     * @param string|null $type
     * @return HCViewContract
     * @throws \ReflectionException
     */
    public function addForm(string $key, HCFormContract $form, string $type = null): HCViewContract
    {
        $formList = [];

        $newType = HCFormTypeEnum::new()->id();
        $editType = HCFormTypeEnum::edit()->id();
        $both = is_null($type) || HCFormTypeEnum::both()->id();

        if ($type === $newType || $both) {
            $formList[$newType] = $form->getStructure(false);
        }

        if ($type === $editType || $both) {
            $formList[$editType] = $form->getStructure(true);
        }

        $this->data['forms'][$key] = $formList;
    }


    /**
     * @param string $permission
     * @return HCViewContract
     */
    public function addPermission(string $permission): HCViewContract
    {
        $this->data['permissions'][] = $permission;

        return $this;
    }

    /**
     * @param array $permissions
     * @return HCViewContract
     */
    public function setPermissions(array $permissions): HCViewContract
    {
        $this->data['permissions'] = $permissions;

        return $this;
    }

    /**
     * @param string $key
     * @param string|null $label
     * @return array
     */
    public function getDefaultStructure(string $key, string $label = null): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'views' => [],
            'forms' => [],
            'form_sources' => [],
            'data_tables' => [],
            'permissions' => [],
            'config' => [],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
