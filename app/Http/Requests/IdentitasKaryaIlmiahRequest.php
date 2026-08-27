<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdentitasKaryaIlmiahRequest extends FormRequest
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
            'user_id'             => 'required|exists:users,id',
            'tahun'               => 'required',
            'judul_karya_ilmiah'  => 'required|string',
            'nama_jurnal'         => 'required|string',
            'nomor_issn'          => 'nullable|string|max:100',
            'volume_nomor_tahun'  => 'nullable|string|max:100',
            'doi_artikel'         => 'nullable|string',
            'alamat_web'          => 'nullable|string',
            'indexing'            => 'nullable|string|max:100',
            'kategori_publikasi'  => 'required|string|max:100',
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [
            'user_id.required'            => 'Dosen / Penulis wajib dipilih.',
            'user_id.exists'              => 'Dosen yang dipilih tidak valid.',
            'tahun.required'              => 'Tahun wajib diisi.',
            'judul_karya_ilmiah.required' => 'Judul Karya Ilmiah wajib diisi.',
            'nama_jurnal.required'        => 'Nama Jurnal wajib diisi.',
            'kategori_publikasi.required' => 'Kategori Publikasi wajib diisi.',
        ];
    }
}
