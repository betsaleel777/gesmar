<?php

namespace App\Models\Template;

use App\Models\Architecture\Site;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermesContrat extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'user_id', 'site_id', 'contenu', 'date_using', 'type'];
    protected $appends = ['status'];

    const RULES = ['site_id' => 'required', 'contenu' => 'required'];
    private const USING = 'en utilisation';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    public function generate(string $prefixe): void
    {
        $rang = $this->get()->count() + 1;
        $this->attributes['code'] = $prefixe . str_pad($rang, 2, '0', STR_PAD_LEFT) . Carbon::now()->format('my');
    }

    public function using(): void
    {
        $this->attributes['date_using'] = Carbon::now();
    }

    public function getStatusAttribute()
    {
        return !empty($this->atrributes['date_using']) ? self::USING : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
