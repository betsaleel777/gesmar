<?php

namespace App\Models\Caisse;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCompte
 */
class Compte extends Model implements Auditable
{
    use HasFactory, HasSites;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['code', 'nom', 'site_id'];
    protected $dates = ['created_at'];
    protected $auditExclude = ['site_id', 'code'];

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
