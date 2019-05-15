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
use Illuminate\Support\Arr;

/**
 * Class HCFormField
 * @package HoneyComb\Starter\Forms
 */
class HCFormField
{
    const EMAIL = 'email';
    const NUMBER = 'number';
    const SELECT = 'select';
    const PASSWORD = 'password';
    const TEXT_AREA = 'textArea';
    const CHECKBOX = 'checkBox';
    const SINGLE_LINE = 'singleLine';
    const CHECKBOX_LIST = 'checkBoxList';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $dependencies = [];

    /**
     * HCFormField constructor.
     * @param string|null $label
     */
    public function __construct(string $label = null)
    {
        $this->data = $this->getDefaultStructure($label);
        // TODO add radio and switches field types
    }

    /**
     * @return HCFormField
     */
    public function singleLine(): HCFormField
    {
        return $this->setFieldType(self::SINGLE_LINE);
    }

    /**
     * @return HCFormField
     */
    public function password(): HCFormField
    {
        return $this->setFieldType(self::PASSWORD);
    }

    /**
     * @return HCFormField
     */
    public function textArea(): HCFormField
    {
        return $this->setFieldType(self::TEXT_AREA);
    }

    /**
     * @return HCFormField
     */
    public function email(): HCFormField
    {
        return $this->setFieldType(self::EMAIL);
    }

    /**
     * @return HCFormField
     */
    public function number(): HCFormField
    {
        return $this->setFieldType(self::NUMBER);
    }

    /**
     * @return HCFormField
     */
    public function checkbox(): HCFormField
    {
        return $this->setFieldType(self::CHECKBOX)
            ->setValue(false);
    }

    /**
     * @return HCFormField
     */
    public function checkboxList(): HCFormField
    {
        return $this->setFieldType(self::CHECKBOX_LIST);
    }

    /**
     * @param bool $multiple
     * @param bool $filterable
     * @return HCFormField
     */
    public function select(bool $multiple = false, bool $filterable = false): HCFormField
    {
        return $this->setFieldType(self::SELECT)
            ->addProperty('multiple', $multiple)
            ->addProperty('filterable', $filterable);
    }

    /**
     * @param bool $status
     * @return HCFormField
     */
    public function isDisabled(bool $status = true): HCFormField
    {
        $this->data['disabled'] = $status;

        return $this;
    }

    /**
     * @param bool $status
     * @return HCFormField
     */
    public function isRequired(bool $status = true): HCFormField
    {
        $this->data['required'] = $status;

        return $this;
    }

    /**
     * @param bool $status
     * @return HCFormField
     */
    public function isReadOnly(bool $status = true): HCFormField
    {
        $this->data['readonly'] = $status;

        return $this;
    }

    /**
     * @param bool $status
     * @return HCFormField
     */
    public function isHidden(bool $status = true): HCFormField
    {
        $this->data['hidden'] = $status;

        return $this;
    }

    /**
     * @param mixed $value
     * @return HCFormField
     */
    public function setValue($value): HCFormField
    {
        $this->data['value'] = $value;

        return $this;
    }

    /**
     * @param string $url
     * @return HCFormField
     */
    public function setSearchUrl(string $url): HCFormField
    {
        $this->data['searchUrl'] = $url;

        return $this;
    }

    /**
     * @param string|null $newUrl
     * @return HCFormField
     */
    public function setNew(string $newUrl = null): HCFormField
    {
        $this->data['new'] = $newUrl;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return HCFormField
     */
    public function addProperty(string $key, $value): HCFormField
    {
        $this->data['properties'][$key] = $value;

        return $this;
    }

    /**
     * @param array $properties
     * @return HCFormField
     */
    public function setProperties(array $properties): HCFormField
    {
        $this->data['properties'] = $properties;

        return $this;
    }

    /**
     * @param int $length
     * @return HCFormField
     */
    public function setMinLength(int $length): HCFormField
    {
        return $this->addProperty('minLength', $length);
    }

    /**
     * @param int $length
     * @return HCFormField
     */
    public function setMaxLength(int $length): HCFormField
    {
        return $this->addProperty('maxLength', $length);
    }

    /**
     * @param string $note
     * @return HCFormField
     */
    public function setNote(string $note): HCFormField
    {
        return $this->addProperty('note', $note);
    }

    /**
     * @param string $id
     * @param string $label
     * @return HCFormField
     */
    public function addOption(string $id, string $label): HCFormField
    {
        if ($this->hasOptions()) {
            $this->data['options'][] = [
                'id' => $id,
                'label' => $label,
            ];
        }

        return $this;
    }

    /**
     * @param array $options
     * @param string $idKey
     * @param string $labelKey
     * @return HCFormField
     */
    public function setOptions(array $options, string $idKey = 'id', string $labelKey = 'label'): HCFormField
    {
        if ($this->hasOptions()) {
            $this->data['options'] = [];

            foreach ($options as $option) {
                $this->addOption(Arr::get($option, $idKey), Arr::get($option, $labelKey));
            }
        }

        return $this;
    }

    /**
     * @param string $fieldId
     * @param array $value
     * @param bool $ignore
     * @param string|null $sendAs
     * @return HCFormField
     */
    public function setDependency(
        string $fieldId,
        array $value,
        bool $ignore = false,
        string $sendAs = null
    ): HCFormField
    {
        $this->dependencies[$fieldId] = [
            'value' => $value,
            'ignore' => $ignore,
            'sendAs' => $sendAs,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->fillDependencies();

        return $this->data;
    }

    /**
     * @param string $label
     * @return array
     */
    protected function getDefaultStructure(string $label = null): array
    {
        return [
            'type' => self::SINGLE_LINE,
            'label' => $label,
            'value' => null,
            'hidden' => false,
            'readonly' => false,
            'disabled' => false,
            'required' => false,
            'properties' => [
                'note' => null
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getType(): string
    {
        return $this->data['type'];
    }

    /**
     * @return bool
     */
    protected function hasOptions(): bool
    {
        return ($this->getType() === self::SELECT);
    }

    /**
     * @param string $type
     * @return HCFormField
     */
    private function setFieldType(string $type): HCFormField
    {
        $this->data['type'] = $type;

        if ($this->hasOptions()) {
            $this->data['options'] = [];
        }

        return $this;
    }

    /**
     * Fill dependencies into data
     */
    private function fillDependencies(): void
    {
        if (count($this->dependencies) !== 0) {
            $this->data['dependencies'] = $this->dependencies;
        }
    }
}
