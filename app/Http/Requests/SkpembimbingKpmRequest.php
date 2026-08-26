<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkpembimbingKpmRequest extends FormRequest
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
            'tahunakademik_id' => 'required',
            'user_ids'          => 'required|array|min:1',
            'user_ids.*'        => 'exists:users,id',
            'nomor_sk'         => 'required',
            'prodi'            => 'nullable|string',
            'dokumen'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tahunakademik_id.required' => 'Tahun Akademik wajib diisi',
            'user_ids.required'          => 'Nama Dosen wajib dipilih minimal 1',
            'user_ids.min'               => 'Nama Dosen wajib dipilih minimal 1',
            'nomor_sk.required'         => 'Nomor SK wajib diisi',
            'dokumen.required'          => 'Link Dokumen wajib diisi',
        ];
    }
}
