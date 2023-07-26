<?php

namespace App\Models\Caisse;

use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperBanque
 */
class Banque extends Model implements Auditable
{
    use HasSites;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['sigle', 'nom', 'site_id'];
    protected $auditExclude = ['site_id'];
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
