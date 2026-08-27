<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HKIRequest extends FormRequest
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
            'tahunakademik_id' => 'required|exists:tahun_akademiks,id',
            'user_id'          => 'required|exists:users,id',
            'nomor_hki'        => 'nullable|string|max:255',
            'dokumen'          => 'required|string',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tahunakademik_id.required' => 'Tahun Akademik wajib dipilih.',
            'tahunakademik_id.exists'   => 'Tahun Akademik yang dipilih tidak valid.',
            'user_id.required'          => 'Nama Dosen wajib dipilih.',
            'user_id.exists'            => 'Dosen yang dipilih tidak valid.',
            'dokumen.required'          => 'Link Dokumen wajib diisi.',
        ];
    }
}
