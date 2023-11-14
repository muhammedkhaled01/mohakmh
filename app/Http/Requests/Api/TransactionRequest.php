<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'package_id' => 'required',
            'status' => 'required',
            'bank_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'package_id.required' => 'الباقة مطلوبة',
            'status.required' => 'الحالة مطلوبة',
            'bank_name.required' => 'اسم البنك مطلوبة',
        ];
    }
}
