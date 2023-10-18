<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect([
            ['name' => 'accès au menu parametre'],
            ['name' => 'accès à la configuration des sites'],
            ['name' => 'accès aux utilisateurs et permissions'],
            ['name' => 'accès au gabaris de documents'],
            ['name' => 'accès aux parametres de la caisse'],
            ['name' => 'accès aux parametres de l\'application'],
            ['name' => 'accès au menu exploitation'],
            ['name' => 'accès au menu réception'],
            ['name' => 'création de demande'],
            ['name' => "accès aux demandes"],
            ['name' => 'modifier une demande'],
            ['name' => 'archiver une demande'],
            ['name' => 'restorer une demande'],
            ['name' => 'toutes les demandes sont visibles'],
            ['name' => 'demandes visibles par leur créateur'],
            ['name' => "valider une demande"],
            ['name' => "voir les détails d'une demande"],
            ['name' => 'création de prospect'],
            ['name' => 'accès aux prospects'],
            ['name' => 'modifier un prospect'],
            ['name' => 'archiver un prospect'],
            ['name' => 'restorer un prospect'],
            ['name' => 'tout les prospects sont visibles'],
            ['name' => 'prospect visibles par leur créateur'],
            ['name' => "voir les détails d'un propspect"],
            ['name' => 'accès aux clients'],
            ['name' => 'modifier un client'],
            ['name' => 'archiver un client'],
            ['name' => 'restorer un client'],
            ['name' => 'tout les clients sont visibles'],
            ['name' => 'client visibles par leur créateur'],
            ['name' => "voir les détails d'un client"],
            ['name' => 'accès aux contrats'],
            ['name' => 'tout les contrats sont visibles'],
            ['name' => 'contrat visibles par leur créateur'],
            ['name' => "voir les détails d'un contrat"],
            ['name' => 'accès au menu ordonnancements'],
            ['name' => "création d'ordonnancement"],
            ['name' => "voir les détails d'un ordonnancement"],
            ['name' => 'accès au menu maintenance'],
            ['name' => 'accès au menu finance et quittancement'],
            ['name' => 'accès au menu facturation'],
            ['name' => 'accès au menu bordereaux'],
            ['name' => 'accès aux commerciaux'],
            ['name' => 'création des commerciaux'],
            ['name' => 'tout les commerciaux sont visibles'],
            ['name' => 'commerciaux visibles par leur créateur'],
            ['name' => 'modifier un commercial'],
            ['name' => 'archiver un commercial'],
            ['name' => 'restorer un commercial'],
            ['name' => "voir les détails d'un commercial"],
            ['name' => 'accès à la liste des bordereau'],
            ['name' => 'tout les bordereaux sont visibles'],
            ['name' => 'bordereaux visible par leur créateur'],
            ['name' => "voir les détails d'un bordereau"],
            ['name' => 'accès à la collecte des emplacements'],
            ['name' => 'création de la collecte'],
            ['name' => 'tout les collectes sont visibles'],
            ['name' => 'collecte visibles par leur créateur'],
            ['name' => "accès à l'ouverture de caisse"],
            ['name' => "création d'ouverture de caisse"],
            ['name' => 'archiver une ouverture de caisse'],
            ['name' => 'restorer une ouverture de caisse'],
            ['name' => 'accès au point de caisse'],
            ['name' => 'tout les points de caisse sont visibles'],
            ['name' => 'points de caisse visibles par leur créateur'],
            ['name' => 'accès aux encaissements'],
            ['name' => "création d'encaissement"],
            ['name' => 'fermer la caisse'],
            ['name' => 'tout les encaissements sont visibles'],
            ['name' => 'encaissements visibles par leur créateur'],
            ['name' => 'accès au menu réparation'],
            ['name' => 'créer une réparation'],
            ['name' => 'archiver une réparation'],
            ['name' => 'attaché des dévis de réparation'],
            ['name' => 'voir les détails d\'une réparation'],
            ['name' => 'valider la réparation'],
            ['name' => 'accès au menu ordre de réparation'],
            ['name' => 'valider un ordre de réparation'],
            ['name' => 'accès au menu technicien'],
            ['name' => 'créer une technicien'],
            ['name' => 'archiver un technicien'],
            ['name' => "voir les détails d'un technicien"],
            ['name' => 'tout les techniciens sont visibles'],
            ['name' => 'les techniciens sont visibles par leur créateur'],
        ]);
        $permissions->each(fn($permission) => Permission::create($permission));
    }
}
