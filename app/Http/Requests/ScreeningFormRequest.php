<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningFormRequest extends FormRequest
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
            'abbreviation' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'name_pt' => 'required|string|max:255',
            'course' => 'required|max:20|exists:courses,abbreviation',
            'year' => 'required|integer|between:1,3',
            'semester' => 'required|integer|in:0,1,2',
            'ECTS' => 'required|integer|between:1,100',
            'hours' => 'required|integer|between:1,1000',
            'optional' => 'required|boolean',
        ];
    }
}
