<?php

namespace App\Models\caisse;

use App\Models\Architecture\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

class Guichet extends Model
{
    use HasStatuses;

    protected $fillable = ['nom', 'code', 'site_id'];
    /**
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = GUICHET_CODE_PREFIXE . str_pad((string)$rang, 7, '0', STR_PAD_LEFT);
    }

    const RULES = [
        'nom' => 'required|max:255',
        'site_id' => 'required|numeric'
    ];

    /**
     * Obtenir les sites correspondant à un Guichet
     * @return BelongsTo<Site, Guichet>
     * @author Ahoussou Jean-Chris
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
