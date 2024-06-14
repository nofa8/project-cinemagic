<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
        ];
        if (strtolower($this->getMethod()) == 'post') {
            // This will merge 2 arrays:
            // (adds the "abbreviation" rule to the $rules array)
            $rules = array_merge($rules, [
                'code' => 'required|string|max:20|unique:genres,code',
            ]);
        }
        return $rules;
    }
}
