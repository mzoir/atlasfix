<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Laisser un avis après une réservation terminée
     */
    public function store(Request $request, Reservation $reservation)
    {
        // Seul le client de la réservation peut laisser un avis
        abort_if($reservation->client_id !== Auth::id(), 403);

        // La réservation doit être terminée
        if ($reservation->statut !== 'terminee') {
            return response()->json([
                'message' => 'Vous ne pouvez laisser un avis que pour une réservation terminée.'
            ], 422);
        }

        // Un seul avis par réservation
        if ($reservation->avis()->exists()) {
            return response()->json([
                'message' => 'Vous avez déjà laissé un avis pour cette réservation.'
            ], 422);
        }

        $validated = $request->validate([
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $avis = Avis::create([
            'client_id'      => Auth::id(),
            'artisan_id'     => $reservation->artisan_id,
            'reservation_id' => $reservation->id,
            'note'           => $validated['note'],
            'commentaire'    => $validated['commentaire'] ?? null,
        ]);

        return response()->json($avis->load('client', 'artisan'), 201);
    }

    /**
     * Liste des avis d'un artisan (public)
     */
    public function indexArtisan(int $artisanId)
    {
        $avis = Avis::with('client:id,name')
            ->where('artisan_id', $artisanId)
            ->latest()
            ->get();

        $moyenneNote = $avis->avg('note');

        return response()->json([
            'avis'         => $avis,
            'moyenne_note' => round($moyenneNote, 1),
            'total'        => $avis->count(),
        ]);
    }

    /**
     * Supprimer son propre avis
     */
    public function destroy(Avis $avi)
    {
        abort_if($avi->client_id !== Auth::id(), 403);

        $avi->delete();

        return response()->json(['message' => 'Avis supprimé.']);
    }
}