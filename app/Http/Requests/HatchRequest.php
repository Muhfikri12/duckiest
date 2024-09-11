<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HatchRequest extends FormRequest
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
    public function messages()
    {
        return [
            'generation.required' => 'Nama wajib diisi!',
            'date_of_birth.required' => 'Tanggal penetasan wajib diisi!',
            'type_eggs.required' => 'Jenis telur wajib dipilih!',
        ];
    }
}
