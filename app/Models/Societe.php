<?php

namespace App\Models;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSociete
 */
class Societe extends Model
{
    use HasSites;

    protected $fillable = ['logo', 'nom', 'sigle', 'siege', 'capital'];

    protected $casts = ['capital' => 'integer'];

    const RULES = [
        'nom' => 'required',
        'logo' => 'nullable|image',
        'siege' => 'required',
        'capital' => 'required|numeric',
        'sigle' => 'required|unique:societes,sigle',
    ];

    /**
     *
     * @return array<string, string>
     */
    public static function editRules(int $id): array
    {
        return [
            'nom' => 'required',
            'image' => 'nullable|image',
            'siege' => 'required',
            'capital' => 'required|numeric',
            'sigle' => 'required|unique:societes,sigle,' . $id,
        ];
    }
}
