<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'corner' => ['nullable', 'boolean'],
            'min_sunlight' => ['nullable', 'integer', 'min:1', 'max:5']
        ];
    }

    public function filters(): array
    {
        return [
            'corner' => $this->boolean('corner'),
            'min_sunlight' => $this->filled('min_sunlight') ? (int) $this->input('min_sunlight') : null,
        ];
    }
}
