<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Abonnement
 *
 * @property int $id
 * @property string $code
 * @property int $index_depart
 * @property int|null $index_fin
 * @property int $equipement_id
 * @property int $emplacement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $site_id
 * @property int|null $index_autre
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Emplacement $emplacement
 * @property-read \App\Models\Architecture\Equipement $equipement
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement indexError()
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement progressing()
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement stopped()
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereEmplacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereEquipementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereIndexAutre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereIndexDepart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereIndexFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement withoutError()
 * @mixin \Eloquent
 */
	class IdeHelperAbonnement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Emplacement
 *
 * @method disponibilite()
 * @method liaison()
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property int $superficie
 * @property int $loyer
 * @property int|null $pas_porte
 * @property int $type_emplacement_id
 * @property int $zone_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $caution
 * @property string $liaison
 * @property string $disponibilite
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Abonnement> $abonnements
 * @property-read int|null $abonnements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Abonnement> $abonnementsActuels
 * @property-read int|null $abonnements_actuels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Exploitation\Contrat|null $contratActuel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Contrat> $contrats
 * @property-read int|null $contrats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Equipement> $equipements
 * @property-read int|null $equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition> $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\StateHistory> $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\Architecture\TypeEmplacement $type
 * @property-read \App\Models\Architecture\Zone $zone
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isBusy()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isFree()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isLinked()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isUnlinked()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereDisponibilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereLiaison($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereLoyer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement wherePasPorte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereSuperficie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereTypeEmplacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement whereZoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement withoutSchedule()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperEmplacement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Equipement
 *
 * @method abonnement()
 * @method liaison()
 * @property int $id
 * @property string $nom
 * @property string $code
 * @property int $prix_unitaire
 * @property int $prix_fixe
 * @property int $frais_facture
 * @property int $index
 * @property int $type_equipement_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $site_id
 * @property int|null $emplacement_id
 * @property string $liaison
 * @property string $abonnement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Emplacement|null $emplacement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition> $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\StateHistory> $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\Architecture\TypeEquipement $type
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement linked()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement subscribed()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement unlinked()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement unsubscribed()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereAbonnement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereEmplacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereFraisFacture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereLiaison($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement wherePrixFixe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereTypeEquipementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperEquipement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Niveau
 *
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property int $pavillon_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Pavillon $pavillon
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Zone> $zones
 * @property-read int|null $zones_count
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau query()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau wherePavillonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperNiveau {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Pavillon
 *
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Niveau> $niveaux
 * @property-read int|null $niveaux_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperPavillon {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\ServiceAnnexe
 *
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property int $prix
 * @property string|null $description
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $mode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Contrat> $contrats
 * @property-read int|null $contrats_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperServiceAnnexe {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Site
 *
 * @property int $id
 * @property string $nom
 * @property string $commune
 * @property string $ville
 * @property string $pays
 * @property string|null $postale
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Abonnement> $abonnements
 * @property-read int|null $abonnements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Contrat> $contrats
 * @property-read int|null $contrats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Equipement> $equipements
 * @property-read int|null $equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Pavillon> $pavillons
 * @property-read int|null $pavillons_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Personne> $personnes
 * @property-read int|null $personnes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\ServiceAnnexe> $servicesAnnexes
 * @property-read int|null $services_annexes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCommune($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePostale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Site withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperSite {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\TypeEmplacement
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $site_id
 * @property string $code
 * @property string $prefix
 * @property bool $auto_valid
 * @property bool $equipable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Emplacement> $emplacements
 * @property-read int|null $emplacements_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement equipables()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereAutoValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereEquipable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTypeEmplacement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\TypeEquipement
 *
 * @property int $id
 * @property string $nom
 * @property int $frais_penalite
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $periode
 * @property int|null $caution_abonnement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Equipement> $equipements
 * @property-read int|null $equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Contrat> $propositions
 * @property-read int|null $propositions_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement inside(array $sites)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereCautionAbonnement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereFraisPenalite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTypeEquipement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\ValidationAbonnement
 *
 * @property int $id
 * @property string $raison
 * @property int $abonnement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Architecture\Abonnement $abonnement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement query()
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement rejected()
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement whereAbonnementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement whereRaison($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ValidationAbonnement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperValidationAbonnement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Zone
 *
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property int $niveau_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Emplacement> $emplacements
 * @property-read int|null $emplacements_count
 * @property-read \App\Models\Architecture\Niveau $niveau
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereNiveauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperZone {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Banque
 *
 * @property int $id
 * @property string $sigle
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $site_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|Banque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banque query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banque whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banque whereSigle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banque whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banque whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperBanque {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Caissier
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caisse\Guichet> $attributionsGuichet
 * @property-read int|null $attributions_guichet_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\Caisse\CaissierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caissier whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperCaissier {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Compte
 *
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|Compte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Compte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Compte query()
 * @method static \Illuminate\Database\Eloquent\Builder|Compte whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Compte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Compte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Compte whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Compte whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Compte whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCompte {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Encaissement
 *
 * @property int $id
 * @property int|null $ordonnancement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $payable_type
 * @property int $payable_id
 * @property int $caissier_id
 * @property int|null $ouverture_id
 * @property int|null $bordereau_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Caisse\Caissier $caissier
 * @property-read \App\Models\Exploitation\Ordonnancement|null $ordonnancement
 * @property-read \App\Models\Caisse\Ouverture|null $ouverture
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement closed()
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement opened()
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereBordereauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereCaissierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereOrdonnancementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereOuvertureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Encaissement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperEncaissement {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Fermeture
 *
 * @property int $id
 * @property string $code
 * @property int|null $ouverture_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Caisse\Ouverture|null $ouverture
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture whereOuvertureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fermeture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFermeture {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Guichet
 *
 * @property int $id
 * @property string $nom
 * @property string $code
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet closed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet opened()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guichet withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperGuichet {}
}

namespace App\Models\Caisse{
/**
 * App\Models\Caisse\Ouverture
 *
 * @property int $id
 * @property int $guichet_id
 * @property int $caissier_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $code
 * @property int|null $montant
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Caisse\Caissier $caissier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caisse\Encaissement> $encaissements
 * @property-read int|null $encaissements_count
 * @property-read \App\Models\Caisse\Guichet $guichet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture using()
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereCaissierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereGuichetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ouverture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperOuverture {}
}

namespace App\Models\Exploitation{
/**
 * App\Models\Exploitation\Contrat
 *
 * @property int $id
 * @property string $code
 * @property string $debut
 * @property string $fin
 * @property string|null $attachment
 * @property int $site_id
 * @property int $personne_id
 * @property int|null $emplacement_id
 * @property int|null $annexe_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $avance
 * @property bool $equipable
 * @property bool $auto_valid
 * @property string|null $code_contrat
 * @property-read \App\Models\Architecture\ServiceAnnexe|null $annexe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Emplacement|null $emplacement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\TypeEquipement> $equipements
 * @property-read int|null $equipements_count
 * @property-read \App\Models\Finance\Facture|null $factureAnnexe
 * @property-read \App\Models\Finance\Facture|null $factureInitiale
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Facture> $factures
 * @property-read int|null $factures_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Facture> $facturesEquipements
 * @property-read int|null $factures_equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Facture> $facturesLoyers
 * @property-read int|null $factures_loyers_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Exploitation\Personne $personne
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat aborted()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat enAttente()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat inProcess()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat isAnnexe()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat isBail()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat notAborted()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat notuptodate()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat onEndorsed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat onValidated()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat owner(?mixed $id)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat schedulable()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat uptodate()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat validated()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAnnexeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAutoValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereCodeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereEmplacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereEquipable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat wherePersonneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperContrat {}
}

namespace App\Models\Exploitation{
/**
 * App\Models\Exploitation\Ordonnancement
 *
 * @property int $id
 * @property int $total
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Paiement> $paiements
 * @property-read int|null $paiements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement unpaid()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonnancement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperOrdonnancement {}
}

namespace App\Models\Exploitation{
/**
 * App\Models\Exploitation\Paiement
 *
 * @property int $id
 * @property int $facture_id
 * @property int $ordonnancement_id
 * @property int $montant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Finance\Facture $facture
 * @property-read \App\Models\Exploitation\Ordonnancement $ordonnancement
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement whereFactureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement whereOrdonnancementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paiement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPaiement {}
}

namespace App\Models\Exploitation{
/**
 * App\Models\Exploitation\Personne
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $code
 * @property string $adresse
 * @property string $contact
 * @property string $email
 * @property string $ville
 * @property int $site_id
 * @property int|null $type_personne_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $nationalite
 * @property string|null $lieu_naissance
 * @property string|null $profession
 * @property string|null $numero_compte
 * @property string|null $banque
 * @property string|null $naissance
 * @property string|null $nom_complet_conjoint
 * @property string|null $naissance_conjoint
 * @property string|null $date_mariage
 * @property string|null $lieu_mariage
 * @property string|null $regime
 * @property string|null $nom_complet_pere
 * @property string|null $nom_complet_mere
 * @property string|null $profession_conjoint
 * @property string|null $situation_matrimoniale
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Contrat> $contrats
 * @property-read int|null $contrats_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Media|null $identite
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Media|null $photocopie
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @property-read \App\Models\Exploitation\TypePersonne|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Personne currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne isClient()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne isProspect()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne owner(int $id)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne query()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereBanque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereDateMariage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereLieuMariage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNaissanceConjoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNationalite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNomCompletConjoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNomCompletMere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNomCompletPere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNumeroCompte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereProfessionConjoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereSituationMatrimoniale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereTypePersonneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereVille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperPersonne {}
}

namespace App\Models\Exploitation{
/**
 * App\Models\Exploitation\Reparation
 *
 * @property int $id
 * @property string $code
 * @property string $titre
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media|null $first
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Media|null $second
 * @property int $emplacement_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Architecture\Emplacement $emplacement
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereEmplacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereSecond($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereTitre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reparation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperReparation {}
}

namespace App\Models\Exploitation{
/**
 * App\Models\Exploitation\TypePersonne
 *
 * @property int $id
 * @property string $nom
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Personne> $personnes
 * @property-read int|null $personnes_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTypePersonne {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Attribution
 *
 * @property int $id
 * @property int $commercial_id
 * @property int $emplacement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon $jour
 * @property int $bordereau_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Finance\Bordereau $bordereau
 * @property-read \App\Models\Finance\Collecte|null $collecte
 * @property-read \App\Models\Finance\Commercial $commercial
 * @property-read \App\Models\Architecture\Emplacement $emplacement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution cashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution uncashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereBordereauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereCommercialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereEmplacementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereJour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperAttribution {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Bordereau
 *
 * @property int $id
 * @property string $code
 * @property int $commercial_id
 * @property \Illuminate\Support\Carbon $date_attribution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $collected
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Attribution> $attributions
 * @property-read int|null $attributions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Finance\Commercial $commercial
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition> $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\StateHistory> $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau cashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau isCollected()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau notCashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau unCollected()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereCollected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereCommercialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereDateAttribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperBordereau {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Cheque
 *
 * @property int $id
 * @property string $numero
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $valeur
 * @property int $compte_id
 * @property int $banque_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Caisse\Banque $banque
 * @property-read \App\Models\Caisse\Encaissement|null $encaissement
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereBanqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereCompteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereValeur($value)
 * @mixin \Eloquent
 */
	class IdeHelperCheque {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Collecte
 *
 * @property int $id
 * @property int $nombre
 * @property int $montant
 * @property int $attribution_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $non_paye
 * @property-read \App\Models\Finance\Attribution $attribution
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereAttributionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereNonPaye($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCollecte {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Commercial
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $code
 * @property int|null $site_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Attribution> $attributions
 * @property-read int|null $attributions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Bordereau> $bordereaux
 * @property-read int|null $bordereaux_count
 * @property-read \App\Models\Architecture\Site|null $site
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperCommercial {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Espece
 *
 * @property int $id
 * @property int $montant
 * @property int $versement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Caisse\Encaissement|null $encaissement
 * @method static \Illuminate\Database\Eloquent\Builder|Espece newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Espece newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Espece query()
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Espece whereVersement($value)
 * @mixin \Eloquent
 */
	class IdeHelperEspece {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Facture
 *
 * @property int $id
 * @property string $code
 * @property string|null $periode
 * @property int|null $avance
 * @property int|null $caution
 * @property int|null $pas_porte
 * @property int|null $annexe_id
 * @property int|null $equipement_id
 * @property int $contrat_id
 * @property int|null $index_depart
 * @property int|null $index_fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Architecture\ServiceAnnexe|null $annexe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Exploitation\Contrat $contrat
 * @property-read \App\Models\Architecture\Equipement|null $equipement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Exploitation\Paiement> $paiements
 * @property-read int|null $paiements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\ModelStatus\Status> $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Facture currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isAnnexe()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isEquipement()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isFacture()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isInitiale()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isLoyer()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isPaid()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isProforma()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isSuperMarket()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture isUnpaid()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereAnnexeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereContratId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereEquipementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereIndexDepart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereIndexFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture wherePasPorte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperFacture {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\PaiementLigne
 *
 * @property int $id
 * @property string $fournisseur
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $montant
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Caisse\Encaissement|null $encaissement
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereFournisseur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPaiementLigne {}
}

namespace App\Models{
/**
 * App\Models\Societe
 *
 * @property int $id
 * @property string $nom
 * @property string $siege
 * @property int $capital
 * @property string $sigle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $smartphone
 * @property string $phone
 * @property string $email
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Media|null $logo
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|Societe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Societe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Societe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereSiege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereSigle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereSmartphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Societe whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSociete {}
}

namespace App\Models{
/**
 * App\Models\Status
 *
 * @property int $id
 * @property string $name
 * @property string|null $reason
 * @property string $model_type
 * @property int $model_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperStatus {}
}

namespace App\Models\Template{
/**
 * App\Models\Template\TermesContrat
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $contenu
 * @property int $user_id
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition> $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\StateHistory> $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat isNotUsed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat isUsed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTermesContrat {}
}

namespace App\Models\Template{
/**
 * App\Models\Template\TermesContratAnnexe
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $contenu
 * @property int $user_id
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition> $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\StateHistory> $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat isNotUsed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat isUsed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTermesContratAnnexe {}
}

namespace App\Models\Template{
/**
 * App\Models\Template\TermesContratEmplacement
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $contenu
 * @property int $user_id
 * @property int $site_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition> $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Asantibanez\LaravelEloquentStateMachines\Models\StateHistory> $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat isNotUsed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat isUsed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperTermesContratEmplacement {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $connected
 * @property string|null $adresse
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Media|null $avatar
 * @property-read \App\Models\Caisse\Caissier|null $caissier
 * @property-read \App\Models\Finance\Commercial|null $commercial
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Architecture\Site> $sites
 * @property-read int|null $sites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConnected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

