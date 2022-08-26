<?php

namespace App\Enums;

enum StatusEquipement: string
{
    case LINKED = 'lié';
    case UNLINKED = 'non lié';
    case DAMAGED = 'abimé';
    case FIXED = 'réparé';
    case SUBSCRIBED = 'abonné';
    case UNSUBSCRIBED = 'non abonné';
}
