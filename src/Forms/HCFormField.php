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
 * Class HCFormField
 * @package HoneyComb\Starter\Forms
 */
class HCFormField
{
    const EMAIL = 'email';
    const NUMBER = 'number';
    const PASSWORD = 'password';
    const TEXTAREA = 'textArea';
    const CHECKBOX = 'checkBox';
    const SINGLE_LINE = 'singleLine';
    const DROPDOWN_LIST = 'dropDownList';
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
     * @param string $label
     * @param bool $required
     * @param bool $readonly
     * @param bool $hidden
     */
    public function __construct(
        string $label,
        bool $required = false,
        bool $readonly = false,
        bool $hidden = false
    ) {
        $this->data['label'] = $label;

        $this->isHidden($hidden);
        $this->isReadOnly($readonly);
        $this->isRequired($required);

        $this->setFieldType(self::SINGLE_LINE);

        // TODO add radio and switches field types
    }

    /**
     * @param array $options
     * @return HCFormField
     */
    public function setOptions(array $options): HCFormField
    {
        $this->data['options'] = $options;

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
    ): HCFormField {
        $this->dependencies[$fieldId] = [
            'value' => $value,
            'ignore' => $ignore,
            'sendAs' => $sendAs,
        ];

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
     * @param int $length
     * @return HCFormField
     */
    public function setMinLength(int $length): HCFormField
    {
        $this->data['minLength'] = $length;

        return $this;
    }

    /**
     * @param int $length
     * @return HCFormField
     */
    public function setMaxLength(int $length): HCFormField
    {
        $this->data['maxLength'] = $length;

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
     * @return HCFormField
     */
    public function singleLine(): HCFormField
    {
        $this->setFieldType(self::SINGLE_LINE);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function password(): HCFormField
    {
        $this->setFieldType(self::PASSWORD);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function textArea(): HCFormField
    {
        $this->setFieldType(self::TEXTAREA);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function email(): HCFormField
    {
        $this->setFieldType(self::EMAIL);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function number(): HCFormField
    {
        $this->setFieldType(self::NUMBER);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function checkbox(): HCFormField
    {
        $this->setValue(false);

        $this->setFieldType(self::CHECKBOX);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function checkboxList(): HCFormField
    {
        $this->setFieldType(self::CHECKBOX_LIST);

        return $this;
    }

    /**
     * @return HCFormField
     */
    public function dropDownList(): HCFormField
    {
        $this->setFieldType(self::DROPDOWN_LIST);

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
     * @param string $type
     */
    private function setFieldType(string $type): void
    {
        $this->data['type'] = $type;
    }

    /**
     *
     */
    private function fillDependencies(): void
    {
        if (count($this->dependencies) !== 0) {
            $this->data['dependencies'] = $this->dependencies;
        }
    }
}
