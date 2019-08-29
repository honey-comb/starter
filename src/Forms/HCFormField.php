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
    const RADIO_LIST = 'radioList';

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
     * @param bool $inRow
     * @return HCFormField
     */
    public function checkboxList(bool $inRow = false): HCFormField
    {
        return $this->setFieldType(self::CHECKBOX_LIST)
            ->addProperty('inRow', $inRow);
    }

    /**
     * @param bool $inRow
     * @return HCFormField
     */
    public function radioList(bool $inRow = false): HCFormField
    {
        return $this->setFieldType(self::RADIO_LIST)
            ->addProperty('inRow', $inRow);
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
            ->addProperty('filterable', $filterable)
            ->setValue(null);
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
     * @param bool $status
     * @return HCFormField
     */
    public function isFullWidth(bool $status = true): HCFormField
    {
        return $this->addProperty('fullWidth', $status);
    }

    /**
     * @param mixed $value
     * @return HCFormField
     */
    public function setValue($value = null): HCFormField
    {
        $this->data['value'] = $value;

        return $this;
    }

    /**
     * @param string|null $note
     * @return HCFormField
     */
    public function setNote(string $note = null): HCFormField
    {
        $this->data['note'] = $note;

        return $this;
    }

    /**
     * @param string|null $placeholder
     * @return HCFormField
     */
    public function setPlaceholder(string $placeholder = null): HCFormField
    {
        $this->data['placeholder'] = $placeholder;

        return $this;
    }

    /**
     * @param string|null $message
     * @return HCFormField
     */
    public function setValidateMessage(string $message = null): HCFormField
    {
        $this->data['validateMessage'] = $message;

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
     * @param array $options
     * @param string $idKey
     * @param string $labelKey
     * @return HCFormField
     */
    public function setOptions(array $options, string $idKey = 'value', string $labelKey = 'label'): HCFormField
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
     * @param string|null $optionsUrl
     * @return HCFormField
     */
    public function setOptionsUrl(string $optionsUrl = null): HCFormField
    {
        if ($this->hasOptions()) {
            $this->addProperty('optionsUrl', $optionsUrl);
        }

        return $this;
    }

    /**
     * @param string $url
     * @return HCFormField
     */
    public function setSearchUrl(string $url): HCFormField
    {
        if ($this->hasOptions()) {
            return $this->addProperty('searchUrl', $url);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return HCFormField
     */
    public function addProperty(string $key, $value): HCFormField
    {
        $this->setDefaultParam('properties', []);

        $this->data['properties'][$key] = $value;

        return $this;
    }

    /**
     * @param $id
     * @param string|null $label
     * @return HCFormField
     */
    public function addOption($id, string $label = null): HCFormField
    {
        if ($this->hasOptions()) {
            $this->setDefaultParam('options', []);

            $this->data['options'][] = [
                'value' => $id,
                'label' => $label,
            ];
        }

        return $this;
    }

    /**
     * @param $id
     * @param string|null $label
     * @return HCFormField
     */
    public function prependOption($id, string $label = null): HCFormField
    {
        if ($this->hasOptions()) {
            $this->setDefaultParam('options', []);

            array_unshift($this->data['options'], [
                'value' => $id,
                'label' => $label,
            ]);
        }

        return $this;
    }

    /**
     * @param string $fieldName
     * @param array $value
     * @param string $type
     * @param string|null $sendAs
     * @return HCFormField
     */
    public function addDependency(
        string $fieldName,
        array $value = [],
        string $sendAs = null,
        string $type = 'any'
    ): HCFormField {
        $this->dependencies[$fieldName] = [
            'value' => $value,
            'sendAs' => $sendAs,
            'type' => $type,
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
        return in_array($this->getType(), [self::SELECT, self::CHECKBOX_LIST, self::RADIO_LIST]);
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
