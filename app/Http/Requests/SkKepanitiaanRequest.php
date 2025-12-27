<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkKepanitiaanRequest extends FormRequest
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
            'kategorysk_id' => 'required',
            'nomor_sk' => 'required',
            'dokumen' => 'required',    
        ];
    }

    public function messages()
    {
        return [
            'tahunakademik_id.required' => 'Tahun Akademik wajib diisi',
            'kategorysk_id.required' => 'Kategory SK wajib diisi',
            'nomor_sk.required' => 'Nomor SK wajib diisi',
            'dokumen.required' => 'Link Dokumen wajib diisi',
        ];
    }
}
