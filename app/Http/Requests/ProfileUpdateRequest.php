<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['sometimes', 'string', 'max:255'],
            'nif' => ['sometimes', 'integer', 'digits:9'],
            'payment_type' => ['sometimes', Rule::in(['MBWAY', 'PAYPAL', 'VISA'])],
            'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];

        $rules['payment_ref'] = ['sometimes'];
        $paymentType = $this->input('payment_type');

        if ($paymentType === 'PAYPAL') {
            $rules['payment_ref'][] = 'email';
        } elseif ($paymentType === 'MBWAY') {
            $rules['payment_ref'][] = 'integer';
            $rules['payment_ref'][] = 'digits:9';
        } elseif ($paymentType === 'VISA') {
            $rules['payment_ref'][] = 'integer';
            $rules['payment_ref'][] = 'digits:16';
        }

        return $rules;
    }
}
