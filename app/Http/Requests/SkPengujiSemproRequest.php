<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkPengujiSemproRequest extends FormRequest
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
            'user_ids'         => 'required|array|min:1',
            'user_ids.*'       => 'exists:users,id',
            'nomor_sk'         => 'required|string|max:255',
            'nama_mahasiswa'   => 'required|string|max:255',
            'npm'              => 'required|string|max:50',
            'tanggal_sk'       => 'required|date',
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
            'user_ids.required'         => 'Nama Dosen wajib dipilih minimal satu.',
            'user_ids.min'              => 'Pilih minimal satu Dosen Penguji.',
            'nomor_sk.required'         => 'Nomor SK wajib diisi.',
            'nama_mahasiswa.required'   => 'Nama Mahasiswa wajib diisi.',
            'npm.required'              => 'NPM wajib diisi.',
            'tanggal_sk.required'       => 'Tanggal SK wajib diisi.',
            'tanggal_sk.date'           => 'Format Tanggal SK tidak valid.',
            'dokumen.required'          => 'Dokumen SK wajib diisi.',
        ];
    }
}

