<?php
namespace App\Http\Controllers;

use App\Models\Fanzine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FanzineController extends Controller
{
    // Liste de tous les fanzines
    public function index() {
        return response()->json(Fanzine::all());
    }

    // Vue d'un fanzine spécifique
    public function show($id) {
        return response()->json(Fanzine::findOrFail($id));
    }

    // Acheter (Ajouter au panier/liste)
    public function buy(Request $request, $id) {
        $user = Auth::user();
        $user->fanzines()->syncWithoutDetaching([$id => ['status' => 'unpaid']]);
        return response()->json(['message' => 'Fanzine ajouté à vos achats en attente.']);
    }

    // Payer (Valider l'achat)
    public function pay(Request $request, $id) {
        $user = Auth::user();
        $user->fanzines()->updateExistingPivot($id, [
            'status' => 'paid',
            'purchased_at' => now()
        ]);
        return response()->json(['message' => 'Paiement validé.']);
    }

    // Télécharger (Sécurisé)
    public function download($id) {
        $user = Auth::user();
        $fanzine = $user->fanzines()->where('fanzine_id', $id)->where('status', 'paid')->first();

        if (!$fanzine) {
            return response()->json(['error' => 'Accès refusé ou non payé.'], 403);
        }

        return response()->download(storage_path("app/public/{$fanzine->pdf_path}"));
    }
}