<?php

namespace App\Models\Bordereau;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Collecte extends Model implements ContractsAuditable
{
    use Auditable;
    protected $fillable = ['bordereau_id', 'emplacement_id', 'jour', 'montant'];
    protected $dates = ['created_at'];
    protected $casts = ['jour' => 'date', 'montant' => 'integer'];
}
