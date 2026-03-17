<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Liste des réservations du client connecté
     */
    public function index()
    {
        $reservations = Reservation::with('artisan.artisanProfile')
            ->where('client_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($reservations);
    }

    /**
     * Créer une réservation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'artisan_id' => 'required|exists:users,id',
            'date'       => 'required|date|after_or_equal:today',
            'heure'      => 'required|date_format:H:i',
        ]);

        // Empêcher de se réserver soi-même
        if ((int) $validated['artisan_id'] === Auth::id()) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        // Vérifier que le créneau n'est pas déjà pris pour cet artisan
        $conflit = Reservation::where('artisan_id', $validated['artisan_id'])
            ->where('date', $validated['date'])
            ->where('heure', $validated['heure'])
            ->whereIn('statut', ['en_attente', 'acceptee'])
            ->exists();

        if ($conflit) {
            return response()->json([
                'message' => 'Ce créneau est déjà réservé pour cet artisan.'
            ], 422);
        }

        $reservation = Reservation::create([
            'client_id'  => Auth::id(),
            'artisan_id' => $validated['artisan_id'],
            'date'       => $validated['date'],
            'heure'      => $validated['heure'],
            'statut'     => 'en_attente',
        ]);

        return response()->json($reservation->load('artisan.artisanProfile'), 201);
    }

    /**
     * Détail d'une réservation
     */
    public function show(Reservation $reservation)
    {
        abort_if($reservation->client_id !== Auth::id(), 403);

        return response()->json($reservation->load(['artisan.artisanProfile', 'avis']));
    }

    /**
     * Annuler une réservation
     */
    public function annuler(Reservation $reservation)
    {
        abort_if($reservation->client_id !== Auth::id(), 403);

        if (!in_array($reservation->statut, ['en_attente', 'acceptee'])) {
            return response()->json(['message' => 'Cette réservation ne peut pas être annulée.'], 422);
        }

        $reservation->update(['statut' => 'annulee']);

        return response()->json($reservation);
    }
}