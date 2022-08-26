<?php

namespace App\Models\Architecture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTypeEquipement
 */
class TypeEquipement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'site_id', 'frais_penalite', 'caution_abonnement'];

    const RULES = [
        'nom' => 'required|max:150',
        'site_id' => 'required',
        'frais_penalite' => 'required|min:1|max:100',
        'caution_abonnement' => 'required|numeric',
    ];

    /**
     * Undocumented function
     *
     * @return HasMany<Equipement>
     */
    public function equipements(): HasMany
    {
        return $this->hasMany(Equipement::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site, TypeEquipement>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
