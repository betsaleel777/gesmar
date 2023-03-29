<?php

namespace App\Models\Caisse;

use App\Models\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

/**
 * @mixin IdeHelperOuverture
 */
class Ouverture extends Model
{
    use HasStatuses, \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $fillable = ['guichet_id', 'caissier_id', 'date', 'code'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];
    protected $with = ['guichet.site', 'caissier'];

    const RULES = [
        'guichet_id' => 'required|numeric',
        'caissier_id' => 'required|numeric',
        'date' => 'required|date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentScope);
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = OUVERTURE_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function caissier(): BelongsTo
    {
        return $this->belongsTo(Caissier::class,);
    }

    public function guichet(): BelongsTo
    {
        return $this->belongsTo(Guichet::class);
    }
}
