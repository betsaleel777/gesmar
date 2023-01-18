<?php

namespace App\Models\Architecture;

use App\Enums\ModeServiceAnnexe;
use App\Traits\HasContrats;
use App\Traits\HasSites;
use App\Traits\RecentOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperServiceAnnexe
 */
class ServiceAnnexe extends Model
{
    use SoftDeletes, HasSites, HasContrats, RecentOrder;

    protected $fillable = ['code', 'nom', 'site_id', 'prix', 'description', 'mode'];

    public const RULES = [
        'nom' => 'required|max:250',
        'prix' => 'required',
        'site_id' => 'required',
        'mode' => 'required',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['code'] = ANNEXE_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function forfaitaire(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::FORFAIT;
    }

    public function quotidien(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::QUOTIDIEN;
    }

    public function mensuel(): void
    {
        $this->attributes['mode'] = ModeServiceAnnexe::MENSUEL;
    }
}
