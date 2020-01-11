<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class HCLanguageRequest
 * @package HoneyComb\Starter\Http\Requests
 */
class HCLanguageRequest extends FormRequest
{
    /**
     * Get only available to update fields
     *
     * @return array
     */
    public function getStrictUpdateValues(): array
    {
        return $this->only(['is_content', 'is_interface']);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'is_content' => 'boolean',
            'is_interface' => 'boolean',
        ];
    }
}
