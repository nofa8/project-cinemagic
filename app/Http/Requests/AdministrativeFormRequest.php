<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdministrativeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Adds the user information (from the administrative route parameter) to the Request
        // if it is a post, user = null
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'user' => null,
            ]);
        } else {
            $this->merge([
                'user' => $this->route('administrative'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user?->id)
            ],
            'admin' => 'required|boolean',
            'photo_filename' => 'sometimes|image|max:4096', // maxsize = 4Mb
        ];
    }
}
