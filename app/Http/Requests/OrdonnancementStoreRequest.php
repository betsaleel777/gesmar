<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdonnancementStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'contrat' => 'required',
            'nature_paiement' => 'required',
            'paiements' => 'required|array',
            'paiements.*.montant' => ['required', 'lte:paiements.*.aPayer', 'not_in:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'paiements.required' => "Aucun montant de facture spécifié",
        ];
    }

    public function attributes(): array
    {
        return [
            'nature_paiement' => 'nature de paiement',
            'paiements.*.montant' => 'montant'
        ];
    }
}
