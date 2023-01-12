<?php

namespace App\Models\Caisse;

use App\Models\Exploitation\Ordonnancement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encaissement extends Model
{
    protected $fillable = ['ordonnancement_id', 'payable_id'];

    const RULES = [
        'ordonnancement_id' => 'required',
    ];

    public function ordonnancement(): BelongsTo
    {
        return $this->belongsTo(Ordonnancement::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }
}
