<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
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
            'tahun_terbit' => 'required|string|max:50',
            'user_id'      => 'required|exists:users,id',
            'isbn'         => 'required|string|max:100',
            'penerbit'     => 'required|string|max:255',
            'judul_buku'   => 'required|string',
            'dokumen'      => 'required|string',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tahun_terbit.required' => 'Tahun Terbit wajib diisi.',
            'user_id.required'      => 'Nama Dosen wajib dipilih.',
            'user_id.exists'        => 'Dosen yang dipilih tidak valid.',
            'isbn.required'         => 'ISBN wajib diisi.',
            'penerbit.required'     => 'Penerbit wajib diisi.',
            'judul_buku.required'   => 'Judul Buku wajib diisi.',
            'dokumen.required'      => 'Link Dokumen wajib diisi.',
        ];
    }
}
