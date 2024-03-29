<?php

return [
    'parametre' => [
        'acceder' => 'accès au menu parametre',
        'acces' => [
            'configuration' => 'accès à la configuration des sites',
            'utilisateur' => 'accès aux utilisateurs et permissions',
            'gabaris' => 'accès au gabaris de documents',
            'caisse' => 'accès aux parametres de la caisse',
            'application' => 'accès aux parametres de l\'application',
        ],
    ],
    'exploitation' => [
        'acceder' => 'accès au menu exploitation',
        'reception' => [
            'acceder' => 'accès au menu réception',
            'demande' => [
                'create' => 'création de demande',
                'acceder' => "accès aux demandes",
                'edit' => 'modifier une demande',
                'trash' => 'archiver une demande',
                'restore' => 'restorer une demande',
                'global' => 'toutes les demandes sont visibles',
                'own' => 'demandes visibles par leur créateur',
                'validate' => "valider une demande",
                'show' => "voir les détails d'une demande",
            ],
            'prospect' => [
                'create' => 'création de prospect',
                'acceder' => 'accès aux prospects',
                'edit' => 'modifier un prospect',
                'trash' => 'archiver un prospect',
                'restore' => 'restorer un prospect',
                'global' => 'tout les prospects sont visibles',
                'own' => 'prospect visibles par leur créateur',
                'show' => "voir les détails d'un propspect",
            ],
            'client' => [
                'acceder' => 'accès aux clients',
                'edit' => 'modifier un client',
                'trash' => 'archiver un client',
                'restore' => 'restorer un client',
                'global' => 'tout les clients sont visibles',
                'own' => 'client visibles par leur créateur',
                'show' => "voir les détails d'un client",
            ],
            'contrat' => [
                'acceder' => 'accès aux contrats',
                'global' => 'tout les contrats sont visibles',
                'own' => 'contrat visibles par leur créateur',
                'show' => "voir les détails d'un contrat",
            ],
        ],
        'ordonnancements' => [
            'acceder' => 'accès au menu ordonnancements',
            'ordonnancement' => [
                'create' => "création d'ordonnancement",
                'show' => "voir les détails d'un ordonnancement",
            ],
        ],
        'maintenance' => [
            'acceder' => 'accès au menu maintenance',
        ],
        'reparation' => [
            'acceder' => 'accès au menu réparation',
            'create' => 'créer une réparation',
            'trash' => 'archiver une réparation',
            'estimate' => 'attaché des dévis de réparation',
            'show' => "voir les détails d'une réparation",
            'validate' => 'valider une réparation',
            'global' => 'toutes les réparations sont visibles',
            'own' => 'réparations visibles par leur créateur',
        ],
        'technicien' => [
            'acceder' => 'accès au menu technicien',
            'create' => 'créer une technicien',
            'global' => 'tout les techniciens sont visibles',
            'own' => 'les techniciens sont visibles par leur créateur',
            'trash' => 'archiver un technicien',
            'show' => "voir les détails d'un technicien",
        ],
        'ordre' => [
            'acceder' => 'accès au menu ordre de réparation',
            'validate' => 'valider un ordre de réparation',
            'global' => 'tout les ordre de réparations sont visibles',
            'own' => 'ordre de réparations visibles par leur créateur',
        ],
    ],
    'finance' => [
        'acceder' => 'accès au menu finance et quittancement',
        'facturation' => [
            'acceder' => 'accès au menu facturation',
        ],
        'bordereaux' => [
            'acceder' => 'accès au menu bordereaux',
            'commerciaux' => [
                'acceder' => 'accès aux commerciaux',
                'create' => 'création des commerciaux',
                'global' => 'tout les commerciaux sont visibles',
                'own' => 'commerciaux visibles par leur créateur',
                'edit' => 'modifier un commercial',
                'trash' => 'archiver un commercial',
                'restore' => 'restorer un commercial',
                'show' => "voir les détails d'un commercial",
            ],
            'bordereau' => [
                'acceder' => 'accès à la liste des bordereau',
                'global' => 'tout les bordereaux sont visibles',
                'update' => 'modifier un bordereau',
                'own' => 'bordereaux visible par leur créateur',
                'show' => "voir les détails d'un bordereau",
            ],
            'collecte' => [
                'acceder' => 'accès à la collecte des emplacements',
                'create' => 'création de la collecte',
                'global' => 'tout les collectes sont visibles',
                'own' => 'collecte visibles par leur créateur',
            ],
        ],
        'caisse' => [
            'ouverture' => [
                'acceder' => "accès à l'ouverture de caisse",
                'create' => "création d'ouverture de caisse",
                'trash' => 'archiver une ouverture de caisse',
                'restore' => 'restorer une ouverture de caisse',
            ],
            'point' => [
                'acceder' => 'accès au point de caisse',
                'global' => 'tout les points de caisse sont visibles',
                'own' => 'points de caisse visibles par leur créateur',
            ],
            'encaissement' => [
                'acceder' => 'accès aux encaissements',
                'create' => "création d'encaissement",
                'closable' => 'fermer la caisse',
                'global' => 'tout les encaissements sont visibles',
                'own' => 'encaissements visibles par leur créateur',
            ],
        ],
    ],
];
