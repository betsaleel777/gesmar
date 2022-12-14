<?php

namespace App\Models\Caisse;

use App\Models\Architecture\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperBanque
 */
class Banque extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'nom', 'site_id'];

    /**
     *
     * @var array<int, string>
     */
    protected $with = ['site'];

    const RULES = [
        'code' => 'required',
        'nom' => 'required|max:191'
    ];

    /**
     * Obtenir l'unique site (marché) qui est lié à une banque
     *
     * @return BelongsTo<Site, Banque>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
