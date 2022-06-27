<?php

namespace App\Models\Template;

class TermesContratAnnexe extends TermesContrat
{

    private const TYPE = 'contrat annexe';

    public function codeGenerate(): void
    {
        parent::generate('ANEX');
    }

    public function getTypeAttribute()
    {
        return self::TYPE;
    }
}
