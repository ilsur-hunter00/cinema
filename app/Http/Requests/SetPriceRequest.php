<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetPriceRequest extends FormRequest
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
            'standart-chair' => 'required|numeric|max:1000',
            'vip-chair' => 'required|numeric|max:2000'
        ];
    }
}
