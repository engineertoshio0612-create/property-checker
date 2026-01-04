<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PropertyUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'filled', 'string', 'max:255'],
            'is_corner' => ['sometimes', 'boolean'],
            'distance_convenience_store' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'sunlight_score' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'noise_score' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function payload(): array
    {
        // PATCHとして「来たキーだけ更新」するための抽出
        $data = [];

        if ($this->has('name')) {
            $data['name'] = (string) $this->input('name');
        }

        if ($this->has('is_corner')) {
            $data['is_corner'] = (bool) $this->boolean('is_corner');
        }

        if ($this->has('distance_convenience_store')) {
            $data['distance_convenience_store'] = $this->filled('distance_convenience_store')
                ? (int) $this->input('distance_convenience_store')
                : null;
        }

        if ($this->has('sunlight_score')) {
            $data['sunlight_score'] = (int) $this->input('sunlight_score');
        }

        if ($this->has('noise_score')) {
            $data['noise_score'] = $this->filled('noise_score')
                ? (int) $this->input('noise_score')
                : null;
        }

        return $data;
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
