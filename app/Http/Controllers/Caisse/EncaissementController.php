<?php

namespace App\Http\Controllers\Caisse;

use App\Events\EncaissementRegistred;
use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\EncaissementListeResource;
use App\Http\Resources\Caisse\EncaissementResource;
use App\Models\Caisse\Encaissement;
use App\Models\Caisse\Ouverture;
use App\Models\Finance\Cheque;
use App\Models\Finance\Espece;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EncaissementController extends Controller
{
    private static function storePayableEspece(Request $request): void
    {
        $request->validate(array_merge(Encaissement::RULES, Espece::RULES));
        $espece = new Espece($request->all());
        $espece->save();
        $encaissement = new Encaissement($request->all());
        $ouverture = Ouverture::using()->where('caissier_id', $request->caissier_id)->first();
        $encaissement->ouverture_id = $ouverture->id;
        $espece = Espece::find($espece->id);
        $encaissement->payable()->associate($espece);
        $encaissement->codeGenerate();
        $encaissement->save();
        EncaissementRegistred::dispatch($encaissement);
    }

    private static function storePayableCheque(Request $request): void
    {
        $request->validate(array_merge(Encaissement::RULES, Cheque::RULES));
        $cheque = new Cheque($request->all());
        $cheque->save();
        $encaissement = new Encaissement($request->all());
        $ouverture = Ouverture::using()->where('caissier_id', $request->caissier_id)->first();
        $encaissement->ouverture_id = $ouverture->id;
        $cheque = Cheque::find($cheque->id);
        $encaissement->payable()->associate($cheque);
        $encaissement->codeGenerate();
        $encaissement->save();
        EncaissementRegistred::dispatch($encaissement);
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Encaissement::class);
        $query = Encaissement::with('payable', 'caissier:id,user_id', 'caissier.user:id,name')->opened();
        $encaissements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['encaissements' => EncaissementListeResource::collection($encaissements)]);
    }

    /* 
      TODO: à la modification du bordereau mettre le loyer de l'emplacement dans les données à transmettre
    */
    public function show(int $id): JsonResponse
    {
        $encaissement = Encaissement::with(
            'payable',
            'caissier:id,user_id',
            'caissier.user:id,name',
            'ordonnancement:id,total,code',
            'ordonnancement.emplacement.type:type_emplacements.id,type_emplacements.nom',
            'ordonnancement.emplacement:emplacements.id,emplacements.code,type_emplacement_id',
            'ordonnancement.annexe:service_annexes.id,service_annexes.nom',
            'ordonnancement.contrat:contrats.id,ordonnancement_id,contrats.code,contrats.code_contrat',
            'ordonnancement.personne:personnes.id,personnes.nom,prenom,personnes.code,ville,adresse,contact,email',
            'ordonnancement.paiements.facture',
            'ouverture:id,guichet_id',
            'ouverture.guichet:id,nom',
            'bordereau:id,code,commercial_id',
            'bordereau.commercial.user:users.id,users.name'
        )->with([
            'bordereau' => function (BelongsTo $query): BelongsTo {
                return $query->select('id', 'code', 'commercial_id')->withSum('collectes as total', 'montant')->with('commercial.user:id,name', 'emplacements');
            }
        ])->find($id);
        $this->authorize('view', $encaissement);
        return response()->json(['encaissement' => EncaissementResource::make($encaissement)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Encaissement::class);
        $request->mode === 1 ? self::storePayableEspece($request) : self::storePayableCheque($request);
        return response()->json(['message' => "Encaissement enregistré avec succès."]);
    }
}
