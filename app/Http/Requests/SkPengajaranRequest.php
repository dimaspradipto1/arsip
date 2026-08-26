<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkPengajaranRequest extends FormRequest
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
            'nomor_sk'         => 'required|string|max:255',
            'dokumen'          => 'required|string',
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [
            'tahunakademik_id.required' => 'Tahun Akademik wajib dipilih.',
            'user_id.required'          => 'Nama Dosen wajib dipilih.',
            'nomor_sk.required'         => 'Nomor SK wajib diisi.',
            'dokumen.required'          => 'Dokumen SK wajib diisi.',
        ];
    }
}
