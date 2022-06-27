<?php

namespace App\Models\Template;

class TermesContratEmplacement extends TermesContrat
{
    private const TYPE = 'contrat de bail';

    public function codeGenerate(): void
    {
        parent::generate('EMPL');
    }

    public function getTypeAttribute()
    {
        return self::TYPE;
    }
}
