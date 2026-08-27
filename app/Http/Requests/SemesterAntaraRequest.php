<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SemesterAntaraRequest extends FormRequest
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
            'ketua_id'         => 'required|exists:users,id',
            'sekretaris_id'    => 'required|array|min:1',
            'sekretaris_id.*'  => 'exists:users,id',
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
            'ketua_id.required'         => 'Ketua wajib dipilih.',
            'ketua_id.exists'           => 'Ketua yang dipilih tidak valid.',
            'sekretaris_id.required'    => 'Sekretaris wajib dipilih minimal 1.',
            'sekretaris_id.array'       => 'Format data Sekretaris tidak valid.',
            'sekretaris_id.*.exists'    => 'Sekretaris yang dipilih tidak valid.',
            'dokumen.required'          => 'Link Dokumen wajib diisi.',
        ];
    }
}
