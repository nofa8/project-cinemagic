<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CartConfirmationFormRequest extends FormRequest
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
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->user()) {
                    if ($this->user()->type == 'C') {
                        $nif = $this->user()?->customer?->nif;
                        if ($this->nif != $nif) {
                            $validator->errors()->add('nif', "Your nif is $nif");
                        }
                    }
                }
            }
        ];
    }
}
