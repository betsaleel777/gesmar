<?php

namespace App\Models\Caisse;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCompte
 */
class Compte extends Model
{
    use HasFactory, HasSites;

    protected $fillable = ['code', 'nom', 'site_id'];

    /**
     *
     * @var array<int, string>
     */
    protected $with = ['site'];

    const RULES = [
        'code' => 'required',
        'nom' => 'required|max:191',
    ];
}
