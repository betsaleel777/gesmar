<?php

namespace App\Models\Finance;

use App\Models\Architecture\Emplacement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial extends Model
{
    use HasFactory, SoftDeletes;

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
        'jour' => 'required',
        'zones' => 'required',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = COMMERCIAL_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Obtenir l'utilisateur lié à un commercial
     *
     * @return BelongsTo<User, Commercial>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les emplacements attribués à un commercial
     *
     * @return BelongsToMany<Emplacement>
     */
    public function emplacements(): BelongsToMany
    {
        return $this->belongsToMany(Emplacement::class, 'attribution_emplacements', 'commercial_id', 'emplacement_id')
            ->withPivot('jour')->withTimestamps();
    }
}
