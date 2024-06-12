<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieFormRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'genre_code' => 'required|string|max:20|exists:genres,code',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'poster_filename' => 'sometimes|image|max:4096',
            'synopsis' => 'required|string',
            'trailer_url' => 'required|url|max:255',
        ];
    }
}
