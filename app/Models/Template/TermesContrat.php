<?php

namespace App\Models\Template;

use App\Enums\StatusTermeContrat;
use App\Models\User;
use App\Traits\HasSites;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTermesContrat
 */
class TermesContrat extends Model
{
    use SoftDeletes, HasSites;

    protected $fillable = ['code', 'user_id', 'site_id', 'contenu', 'type', 'status'];

    const RULES = ['site_id' => 'required', 'contenu' => 'required'];

    /**
     * Undocumented function
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
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
}
