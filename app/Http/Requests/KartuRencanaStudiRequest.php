<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KartuRencanaStudiRequest extends FormRequest
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
            'ketua_panitia_id' => 'required|exists:users,id',
            'sekretaris_id'    => 'required|exists:users,id',
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
            'ketua_panitia_id.required' => 'Ketua Panitia wajib dipilih.',
            'ketua_panitia_id.exists'   => 'Ketua Panitia yang dipilih tidak valid.',
            'sekretaris_id.required'    => 'Sekretaris wajib dipilih.',
            'sekretaris_id.exists'      => 'Sekretaris yang dipilih tidak valid.',
            'dokumen.required'          => 'Link Dokumen wajib diisi.',
        ];
    }
}
