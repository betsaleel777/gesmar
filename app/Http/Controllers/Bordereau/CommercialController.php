<?php

namespace App\Http\Controllers\Bordereau;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignationRequest;
use App\Http\Resources\Bordereau\BordereauResource;
use App\Http\Resources\Bordereau\CommercialListResource;
use App\Http\Resources\Bordereau\CommercialResource;
use App\Http\Resources\Bordereau\CommercialSelectResource;
use App\Models\Bordereau\Bordereau;
use App\Models\Bordereau\Commercial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class CommercialController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Commercial::class);
        $query = Commercial::select('id', 'code', 'created_at', 'site_id', 'user_id')->with('site:id,nom', 'user:id,name');
        $commerciaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['commerciaux' => CommercialListResource::collection($commerciaux)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', Commercial::class);
        $query = Commercial::select('id', 'code', 'created_at', 'site_id', 'user_id')->with('site:id,nom', 'user:id,name');
        $commerciaux = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return CommercialListResource::collection($commerciaux);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', Commercial::class);
        $query = Commercial::select('id', 'code', 'created_at', 'site_id', 'user_id')->with('site:id,nom', 'user:id,name')
            ->whereRaw("DATE_FORMAT(commercials.created_at,'%d-%m-%Y') LIKE ?", "$search%")->orWhere('code', 'LIKE', "%$search%")
            ->orWhereHas('user', fn(Builder $query): Builder => $query->where('name', 'LIKE', "%$search%"));
        $commerciaux = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return CommercialListResource::collection($commerciaux);
    }

    public function getSelect(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Commercial::class);
        $query = Commercial::select('id', 'code', 'user_id')->with('user:id,name');
        $commerciaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['commerciaux' => CommercialSelectResource::collection($commerciaux)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Commercial::class);
        $request->validate(Commercial::RULES);
        $commercial = new Commercial($request->all());
        $commercial->codeGenerate();
        $commercial->save();
        return response()->json(['message' => "Le commercial: $commercial->code a été enregistré avec succès."]);
    }

    public function attribuer(AssignationRequest $request): JsonResponse
    {
        $commercial = Commercial::with('user:id,name')->find($request->commercial_id);
        $this->authorize('attribuate', $commercial);
        $bordereau = Bordereau::make($request->validated());
        $bordereau->codeGenerate();
        $bordereau->site_id = $commercial->site_id;
        $bordereau->save();
        $bordereau->emplacements()->attach($request->emplacements);
        return response()->json(['message' =>
            "Le bordereau $bordereau->code a été assigné avec succès au commercial " . str($commercial->user->name)->lower()]);
    }

    public function trash(int $id): JsonResponse
    {
        $commercial = Commercial::find($id);
        $this->authorize('delete', $commercial);
        $commercial->delete();
        $message = "Le commercial: $commercial->code a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $commercial = Commercial::withTrashed()->find($id);
        $this->authorize('restore', $commercial);
        $commercial->restore();
        $message = "Le commercial $commercial->code a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Commercial::class);
        $this->authorize('viewAny', Commercial::class);
        $query = Commercial::select('id', 'code', 'created_at', 'site_id', 'user_id')->with('site:id,nom', 'user:id,name')->onlyTrashed();
        $commerciaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['commerciaux' => $commerciaux]);
    }

    public function show(int $id): JsonResponse
    {
        $commercial = Commercial::with('user:id,name', 'site:id,nom')->find($id);
        $this->authorize('view', $commercial);
        return response()->json(['commercial' => CommercialResource::make($commercial)]);
    }

    public function getMonthBordereaux(Commercial $commercial): JsonResource
    {
        $response = Gate::inspect('viewAny', Bordereau::class);
        $query = $commercial->bordereaux()->whereYear('jour', now()->year)->whereMonth('jour', now()->month);
        $bordereaux = $response()->allowed() ? $query->get() : $query->owner()->get();
        return BordereauResource::collection($bordereaux);
    }
}
