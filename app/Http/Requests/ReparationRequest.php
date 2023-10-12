<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReparationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'titre' => 'required|max:50',
            'emplacement_id' => 'required|numeric',
            'site_id' => 'required|numeric',
            'description' => 'required',
        ];
    }
}
