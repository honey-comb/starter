<?php
/**
 * Created by PhpStorm.
 * User: Zygis
 * Date: 2019-02-04
 * Time: 17:03
 */

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
        return $this->data;
    }

    /**
     * @param string $type
     * @return HCFormField
     */
    private function setFieldType(string $type): HCFormField
    {
        $this->data['type'] = $type;

        return $this;
    }
}