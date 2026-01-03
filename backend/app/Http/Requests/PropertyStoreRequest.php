<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PropertyStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'is_corner' => ['required', 'boolean'],
            'distance_convenience_store' => ['nullable', 'integer', 'min:0'],
            'sunlight_score' => ['required', 'integer', 'min:1', 'max:5'],
            'noise_score' => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function payload(): array
    {
        return [
            'name' => (string) $this->input('name'),
            'is_corner' => (bool) $this->boolean('is_corner'),
            'distance_convenience_store' => $this->filled('distance_convenience_store')
                ? (int) $this->input('distance_convenience_store')
                : null,
            'sunlight_score' => (int) $this->input('sunlight_score'),
            'noise_score' => $this->filled('noise_score')
                ? (int) $this->input('noise_score')
                : null,
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => '入力内容に誤りがあります。',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
