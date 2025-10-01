<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Models\Véhicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrajetController extends Controller
{
    public function index()
    {
        $trajets = Trajet::with('vehicule')->orderByDesc('date')->paginate(15);
        return view('BackOffice.trajets.index', compact('trajets'));
    }

    public function create()
    {
        $vehicules = Véhicule::orderBy('immatriculation')->get();
        return view('BackOffice.trajets.create', compact('vehicules'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'point_depart' => 'required|string|max:255',
            'point_arrivee' => 'required|string|max:255',
            'id_vehicule' => 'required|exists:vehicules,id',
        ]);
        $validator->validate();

        $trajet = Trajet::create($request->only(['date','point_depart','point_arrivee','id_vehicule']));
        return redirect()->route('trajets.show', $trajet)->with('success','Trajet créé.');
    }

    public function show(Trajet $trajet)
    {
        $trajet->load('vehicule','livraisons');
        return view('BackOffice.trajets.show', compact('trajet'));
    }

    public function edit(Trajet $trajet)
    {
        $vehicules = Véhicule::orderBy('immatriculation')->get();
        return view('BackOffice.trajets.edit', compact('trajet','vehicules'));
    }

    public function update(Request $request, Trajet $trajet)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'point_depart' => 'required|string|max:255',
            'point_arrivee' => 'required|string|max:255',
            'id_vehicule' => 'required|exists:vehicules,id',
        ]);
        $validator->validate();

        $trajet->update($request->only(['date','point_depart','point_arrivee','id_vehicule']));
        return redirect()->route('trajets.show', $trajet)->with('success','Trajet mis à jour.');
    }

    public function destroy(Trajet $trajet)
    {
        $trajet->delete();
        return redirect()->route('trajets.index')->with('success','Trajet supprimé.');
    }
}
