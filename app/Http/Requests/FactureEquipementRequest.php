<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FactureEquipementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_limite' => ['required', 'date_format:Y-m-d'],
            'factures' => ['required', 'array'],
            'factures.*.index_fin' => ['required', 'gte:factures.*.index_depart']
        ];
    }
}
