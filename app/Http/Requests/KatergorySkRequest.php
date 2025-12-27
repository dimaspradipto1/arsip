<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KatergorySkRequest extends FormRequest
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
            'kategory_sk' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'kategory_sk.required' => 'Kategory SK wajib diisi',
            'kategory_sk.string' => 'Kategory SK harus string',
        ];
    }
}
