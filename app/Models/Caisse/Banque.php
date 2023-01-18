<?php

namespace App\Models\Caisse;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    use HasSites;
    protected $fillable = ['sigle', 'nom', 'site_id'];

    /**
     *
     * @var array<int, string>
     */
    protected $with = ['site'];

    const RULES = [
        'sigle' => 'required',
        'nom' => 'required|max:191',
    ];
}
