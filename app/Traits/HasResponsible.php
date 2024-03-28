<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Models\Audit;

trait HasResponsible
{

    public function scopeWithResponsible(Builder $query): Builder
    {
        return $query->with('audit:id,user_type,user_id,audits.auditable_id,audits.auditable_type',
            'audit.user:id,name', 'audit.user.avatar:id,model_id,model_type,disk,file_name');
    }

    public function scopeWithNameResponsible(Builder $query): Builder
    {
        return $query->with('audit:id,user_type,user_id,audits.auditable_id,audits.auditable_type', 'audit.user:id,name');
    }

    public function shortAudit(): MorphOne
    {
        return $this->morphOne(config('audit.implementation', Audit::class), 'auditable')
            ->select('id', 'user_id', 'user_type', 'audits.auditable_id', 'audits.auditable_type')->oldestOfMany();
    }

    public function audit(): MorphOne
    {
        return $this->morphOne(config('audit.implementation', Audit::class), 'auditable')->oldestOfMany();
    }
}
