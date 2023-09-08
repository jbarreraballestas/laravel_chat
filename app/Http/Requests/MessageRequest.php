<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'recipient_id' => 'required',
            'file' => 'nullable|file|mimes:jpg,png,mp4,pdf|max:2048',
        ];

        // Add the 'message' field as required only if 'file' is not present
        if (!$this->hasFile('file')) {
            $rules['message'] = 'required';
        }

        return $rules;
    }
}
