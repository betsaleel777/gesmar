<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratSignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachment' => 'required|image',
            'date_signature' => 'required',
        ];
    }
}
