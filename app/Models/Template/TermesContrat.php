<?php

namespace App\Models\Template;

use App\Models\Architecture\Site;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTermesContrat
 */
class TermesContrat extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'user_id', 'site_id', 'contenu', 'date_using', 'type'];

    /**
     * Undocumented variable
     *
     * @var array<int, string>
     */
    protected $appends = ['status'];

    const RULES = ['site_id' => 'required', 'contenu' => 'required'];

    private const USING = 'en utilisation';

    /**
     * Undocumented function
     *
     * @return Attribute<get:(callable():string|null)>
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get:fn () => ! empty($this->atrributes['date_using']) ? self::USING : null
        );
    }

    /**
     * Undocumented function
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function generate(string $prefixe): void
    {
        $rang = $this->get()->count() + 1;
        $this->attributes['code'] = $prefixe.str_pad((string) $rang, 2, '0', STR_PAD_LEFT).Carbon::now()->format('my');
    }

    public function using(): void
    {
        $this->attributes['date_using'] = Carbon::now();
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<User, TermesContrat>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Undocumented function
     *
     * @return BelongsTo<Site, TermesContrat>
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
