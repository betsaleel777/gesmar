<?php

namespace App\Models\Caisse;

use App\Models\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperFermeture
 */
class Fermeture extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['ouverture_id', 'total'];
    protected $casts = ['total' => 'integer'];
    protected $dates = ['created_at'];

    const RULES = [
        'caissier_id' => 'required',
        'total' => 'required|gte:total_normal'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);

        static::created(function (Fermeture $fermeture) {
            $ouverture = Ouverture::with('encaissements')->find($fermeture->ouverture_id);
            $ouverture->setConfirmed();
            foreach ($ouverture->encaissements as $encaissement) {
                $encaissement->setClose();
            }
            Guichet::find($ouverture->guichet_id)->setClose();
        });
    }

    public function ouverture(): BelongsTo
    {
        return $this->belongsTo(Ouverture::class);
    }
}
