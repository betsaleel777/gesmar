<?php

namespace App\Models\Template;

class TermesContratAnnexe extends TermesContrat
{

    protected $table = 'termes_contrats';
    private const TYPE = 'contrat annexe';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->type = self::TYPE;
    }

    public function codeGenerate(): void
    {
        parent::generate('ANEX');
    }

    public function scopeIsAnnexe($query)
    {
        return $query->where('type', self::TYPE);
    }
}
