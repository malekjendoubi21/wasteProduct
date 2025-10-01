<?php

namespace App\Http\Controllers;

use App\Models\Véhicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Véhicule::orderBy('created_at', 'desc')->paginate(15);
        return view('BackOffice.vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        return view('BackOffice.vehicules.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'immatriculation' => 'required|string|max:100|unique:vehicules,immatriculation',
            'type' => 'required|string|max:100',
            'capacite' => 'required|integer|min:1',
        ]);
        $validator->validate();

        $vehicule = Véhicule::create($request->only(['immatriculation','type','capacite']));
        return redirect()->route('vehicules.show', $vehicule)->with('success','Véhicule créé.');
    }

    public function show(Véhicule $vehicule)
    {
        $vehicule->load('trajets');
        return view('BackOffice.vehicules.show', compact('vehicule'));
    }

    public function edit(Véhicule $vehicule)
    {
        return view('BackOffice.vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Véhicule $vehicule)
    {
        $validator = Validator::make($request->all(), [
            'immatriculation' => 'required|string|max:100|unique:vehicules,immatriculation,' . $vehicule->id,
            'type' => 'required|string|max:100',
            'capacite' => 'required|integer|min:1',
        ]);
        $validator->validate();

        $vehicule->update($request->only(['immatriculation','type','capacite']));
        return redirect()->route('vehicules.show', $vehicule)->with('success','Véhicule mis à jour.');
    }

    public function destroy(Véhicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('vehicules.index')->with('success','Véhicule supprimé.');
    }
}
