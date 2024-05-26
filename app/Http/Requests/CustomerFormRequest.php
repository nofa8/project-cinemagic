<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerFormRequest extends FormRequest
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
            'nif' => 'required|string|size:9',  // Assuming NIF is exactly 9 characters
            'payment_type' => [
                'required',
                Rule::in(['VISA', 'PAYPAL', 'MBWAY'])
            ],
            'payment_ref' => 'required|string|max:255',
        ];
    }


    protected function prepareForValidation(): void
    {
        // Adds the user information (from the Customer route parameter) to the Request
        // if it is a post, user = null
        if (strtolower($this->getMethod()) == 'post') {
            $this->merge([
                'user' => null,
            ]);
        } else {
            $this->merge([
                'user' => $this->route('customer')->user,
            ]);
        }
    }

}