<?php

namespace App\Models\Template;

class TermesContratEmplacement extends TermesContrat
{
    protected $table = 'termes_contrats';
    private const TYPE = 'contrat de bail';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->type = self::TYPE;
    }

    public function codeGenerate(): void
    {
        parent::generate('EMPL');
    }

    public function scopeIsEmplacement($query)
    {
        return $query->where('type', self::TYPE);
    }
}
