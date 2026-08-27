<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanPenelitianRequest extends FormRequest
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
            'tahun_kegiatan'   => 'required|string|max:50',
            'user_id'          => 'required|exists:users,id',
            'judul_penelitian' => 'required|string',
            'dokumen'          => 'required|string',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tahun_kegiatan.required'   => 'Tahun Kegiatan wajib diisi.',
            'user_id.required'          => 'Nama Dosen wajib dipilih.',
            'user_id.exists'            => 'Dosen yang dipilih tidak valid.',
            'judul_penelitian.required' => 'Judul Penelitian wajib diisi.',
            'dokumen.required'          => 'Link Dokumen wajib diisi.',
        ];
    }
}
