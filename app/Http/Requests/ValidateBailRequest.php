<?php

namespace App\Http\Requests;

use App\Models\Finance\Facture;
use Illuminate\Foundation\Http\FormRequest;
use Log;

class ValidateBailRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    // ne dois pas être superieur au montant total de la facture de premier decompte (initiale)
    public function rules(): array
    {
        $facture = Facture::firstWhere('contrat_id', $this->id);
        return [
            'apport_initial' => 'required|lte:' . $facture->getFactureInitialeTotalAmount(),
        ];
    }
}
