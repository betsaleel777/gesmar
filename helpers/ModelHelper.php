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
 * @property-read \App\Models\Architecture\Emplacement $emplacement
 * @property-read \App\Models\Architecture\Equipement $equipement
 * @property-read string $status
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Abonnement indexError()
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
 */
	class IdeHelperAbonnement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Emplacement
 *
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Abonnement[] $abonnementActuels
 * @property-read int|null $abonnement_actuels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Abonnement[] $abonnements
 * @property-read int|null $abonnements_count
 * @property-read \App\Models\Exploitation\Contrat|null $contratActuel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Contrat[] $contrats
 * @property-read int|null $contrats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Equipement[] $equipements
 * @property-read int|null $equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition[] $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Asantibanez\LaravelEloquentStateMachines\Models\StateHistory[] $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\Architecture\TypeEmplacement $type
 * @property-read \App\Models\Architecture\Zone $zone
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isBusy()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isFree()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isLinked()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement isUnlinked()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement newQuery()
 * @method static \Illuminate\Database\Query\Builder|Emplacement onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|Emplacement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Emplacement withoutSchedule()
 * @method static \Illuminate\Database\Query\Builder|Emplacement withoutTrashed()
 */
	class IdeHelperEmplacement {}
}

namespace App\Models\Architecture{
/**
 * App\Models\Architecture\Equipement
 *
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
 * @property-read \App\Models\Architecture\Emplacement|null $emplacement
 * @property-read \Illuminate\Database\Eloquent\Collection|\Asantibanez\LaravelEloquentStateMachines\Models\PendingTransition[] $pendingTransitions
 * @property-read int|null $pending_transitions_count
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|\Asantibanez\LaravelEloquentStateMachines\Models\StateHistory[] $stateHistory
 * @property-read int|null $state_history_count
 * @property-read \App\Models\Architecture\TypeEquipement $type
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement linked()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipement newQuery()
 * @method static \Illuminate\Database\Query\Builder|Equipement onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|Equipement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Equipement withoutTrashed()
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
 * @property-read \App\Models\Architecture\Pavillon $pavillon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Zone[] $zones
 * @property-read int|null $zones_count
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau newQuery()
 * @method static \Illuminate\Database\Query\Builder|Niveau onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau query()
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau wherePavillonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Niveau whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Niveau withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Niveau withoutTrashed()
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Niveau[] $niveaux
 * @property-read int|null $niveaux_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon newQuery()
 * @method static \Illuminate\Database\Query\Builder|Pavillon onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pavillon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Pavillon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pavillon withoutTrashed()
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Contrat[] $contrats
 * @property-read int|null $contrats_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceAnnexe newQuery()
 * @method static \Illuminate\Database\Query\Builder|ServiceAnnexe onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|ServiceAnnexe withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ServiceAnnexe withoutTrashed()
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Abonnement[] $abonnements
 * @property-read int|null $abonnements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Contrat[] $contrats
 * @property-read int|null $contrats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Equipement[] $equipements
 * @property-read int|null $equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Pavillon[] $pavillons
 * @property-read int|null $pavillons_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Personne[] $personnes
 * @property-read int|null $personnes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\ServiceAnnexe[] $servicesAnnexes
 * @property-read int|null $services_annexes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Query\Builder|Site onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|Site withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Site withoutTrashed()
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Emplacement[] $emplacements
 * @property-read int|null $emplacements_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement equipables()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEmplacement newQuery()
 * @method static \Illuminate\Database\Query\Builder|TypeEmplacement onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|TypeEmplacement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TypeEmplacement withoutTrashed()
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Equipement[] $equipements
 * @property-read int|null $equipements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Contrat[] $propositions
 * @property-read int|null $propositions_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeEquipement newQuery()
 * @method static \Illuminate\Database\Query\Builder|TypeEquipement onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|TypeEquipement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TypeEquipement withoutTrashed()
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
 * @property-read string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\Emplacement[] $emplacements
 * @property-read int|null $emplacements_count
 * @property-read \App\Models\Architecture\Niveau $niveau
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newQuery()
 * @method static \Illuminate\Database\Query\Builder|Zone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereNiveauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Zone withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Zone withoutTrashed()
 */
	class IdeHelperZone {}
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
 * @property int $auto_valid
 * @property-read \App\Models\Architecture\ServiceAnnexe|null $annexe
 * @property-read \App\Models\Architecture\Emplacement|null $emplacement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Architecture\TypeEquipement[] $equipements
 * @property-read int|null $equipements_count
 * @property-read \App\Models\Finance\Facture|null $factureAnnexe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Facture[] $factureEquipement
 * @property-read int|null $facture_equipement_count
 * @property-read \App\Models\Finance\Facture|null $factureInitiale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Facture[] $factureLoyer
 * @property-read int|null $facture_loyer_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Facture[] $factures
 * @property-read int|null $factures_count
 * @property-read string $status
 * @property-read \App\Models\Exploitation\Personne $personne
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat aborted()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat enAttente()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat isAnnexe()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat isBail()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat isValidated()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat notAborted()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat onEndorsed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat onValidated()
 * @method static \Illuminate\Database\Query\Builder|Contrat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAnnexeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAutoValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereAvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contrat whereCode($value)
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
 * @method static \Illuminate\Database\Query\Builder|Contrat withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contrat withoutTrashed()
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
 * @property-read string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Paiement[] $paiements
 * @property-read int|null $paiements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
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
 * @property string|null $email
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Contrat[] $contrats
 * @property-read int|null $contrats_count
 * @property-read string $status
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @property-read \App\Models\Exploitation\TypePersonne|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Personne currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne isClient()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne isProspect()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne newQuery()
 * @method static \Illuminate\Database\Query\Builder|Personne onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Personne otherCurrentStatus(...$names)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereNumeroCompte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereTypePersonneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personne whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|Personne withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Personne withoutTrashed()
 */
	class IdeHelperPersonne {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Personne[] $personnes
 * @property-read int|null $personnes_count
 * @property-read \App\Models\Architecture\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne newQuery()
 * @method static \Illuminate\Database\Query\Builder|TypePersonne onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypePersonne whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TypePersonne withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TypePersonne withoutTrashed()
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
 * @property string $jour
 * @property-read \App\Models\Finance\Bordereau|null $bordereau
 * @property-read \App\Models\Finance\Collecte|null $collecte
 * @property-read \App\Models\Finance\Commercial $commercial
 * @property-read \App\Models\Architecture\Emplacement $emplacement
 * @property-read string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribution query()
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
 * @property string $date_attribution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Attribution[] $attributions
 * @property-read int|null $attributions_count
 * @property-read \App\Models\Finance\Commercial $commercial
 * @property-read string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau cashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau currentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau notCashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau otherCurrentStatus(...$names)
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bordereau whereCode($value)
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
 * @property string $banque
 * @property int $encaisse
 * @property int $versement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereBanque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereEncaisse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cheque whereVersementId($value)
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
 * @property-read \App\Models\Finance\Attribution $attribution
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereAttributionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collecte whereNombre($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Attribution[] $attributions
 * @property-read int|null $attributions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Bordereau[] $bordereaux
 * @property-read int|null $bordereaux_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial newQuery()
 * @method static \Illuminate\Database\Query\Builder|Commercial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Commercial whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Commercial withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Commercial withoutTrashed()
 * @mixin \Eloquent
 */
	class IdeHelperCommercial {}
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
 * @property-read \App\Models\Exploitation\Contrat $contrat
 * @property-read \App\Models\Architecture\Equipement|null $equipement
 * @property-read string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exploitation\Paiement[] $paiements
 * @property-read int|null $paiements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property-read int|null $statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Finance\Versement[] $versements
 * @property-read int|null $versements_count
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
 * @property int $versement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Finance\Versement $versement
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereFournisseur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaiementLigne whereVersementId($value)
 */
	class IdeHelperPaiementLigne {}
}

namespace App\Models\Finance{
/**
 * App\Models\Finance\Versement
 *
 * @property int $id
 * @property int|null $monnaie
 * @property int $montant
 * @property int|null $espece
 * @property int $facture_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Finance\Facture $facture
 * @method static \Illuminate\Database\Eloquent\Builder|Versement isAnnexe()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement isEquipement()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement isInitiale()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement isLoyer()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereEspece($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereFactureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereMonnaie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Versement whereUpdatedAt($value)
 */
	class IdeHelperVersement {}
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
 */
	class IdeHelperStatus {}
}

namespace App\Models\Template{
/**
 * App\Models\Template\TermesContrat
 *
 * @property int $id
 * @property string $code
 * @property string $contenu
 * @property int $user_id
 * @property int $site_id
 * @property string|null $date_using
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $type
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat newQuery()
 * @method static \Illuminate\Database\Query\Builder|TermesContrat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereDateUsing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContrat whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|TermesContrat withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TermesContrat withoutTrashed()
 */
	class IdeHelperTermesContrat {}
}

namespace App\Models\Template{
/**
 * App\Models\Template\TermesContratAnnexe
 *
 * @property int $id
 * @property string $code
 * @property string $contenu
 * @property int $user_id
 * @property int $site_id
 * @property string|null $date_using
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $type
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe isAnnexe()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe newQuery()
 * @method static \Illuminate\Database\Query\Builder|TermesContratAnnexe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereDateUsing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratAnnexe whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|TermesContratAnnexe withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TermesContratAnnexe withoutTrashed()
 */
	class IdeHelperTermesContratAnnexe {}
}

namespace App\Models\Template{
/**
 * App\Models\Template\TermesContratEmplacement
 *
 * @property int $id
 * @property string $code
 * @property string $contenu
 * @property int $user_id
 * @property int $site_id
 * @property string|null $date_using
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $type
 * @property-read \App\Models\Architecture\Site $site
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement isEmplacement()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement newQuery()
 * @method static \Illuminate\Database\Query\Builder|TermesContratEmplacement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereDateUsing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermesContratEmplacement whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|TermesContratEmplacement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TermesContratEmplacement withoutTrashed()
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
 * @property string $connected
 * @property string|null $adresse
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $avatar
 * @property-read \App\Models\Finance\Commercial|null $commercial
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
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
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class IdeHelperUser {}
}

