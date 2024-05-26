<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseFormRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'total_price' => 'required|numeric|between:0,99999999.99',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'nif' => 'required|string|size:9', 
            'payment_type' => ['required', Rule::in(['VISA', 'PAYPAL', 'MBWAY'])],
            'payment_ref' => 'required|string|max:255',
            'receipt_pdf_filename' => 'nullable|string|max:255',
        ];
    }
}
