<?php

namespace App\Models\Caisse;

use App\Traits\RecentOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caissier extends Model
{
    use HasFactory, RecentOrder;

    protected $fillable = ['code', 'user_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $with = ['user'];
    const RULES = [
        'user_id' => 'required|numeric',
    ];

    const ATTRIBUTION_RULES = [
        'jours' => 'required',
        'guichet_id' => 'required|numeric',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = CAISSIER_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Obtenir l'utilisateur lié à un caissier
     *
     * @return BelongsTo<User, Caissier>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
