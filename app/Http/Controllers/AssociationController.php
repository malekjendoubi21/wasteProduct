<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Association;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class AssociationController extends Controller
{
  
    public function index(Request $request): View
    {
        $query = Association::query();

        if ($request->filled('search')) {
            $query->byName(trim($request->input('search')));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $associations = $query->orderBy('name')->paginate(15);

        return view('BackOffice.associations.index', [
            'associations' => $associations,
            'query' => $request->input('search', '')
        ]);
    }

    public function frontIndex(): View
    {
        $associations = Association::active()->orderBy('name')->paginate(10);
        return view('FrontOffice.associations.index', compact('associations'));
    }

    public function frontShow(Association $association): View
    {
        if ($association->status !== 'active') {
            abort(404, 'Association non disponible.');
        }
        return view('FrontOffice.associations.show', compact('association'));
    }

    public function create(): View
    {
        return view('BackOffice.associations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:associations,contact_email',
            'contact_phone' => 'nullable|string|max:20',
            'domain' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Le nom est requis.',
            'contact_email.unique' => 'Cet email est déjà utilisé.',
            'status.in' => 'Le statut doit être actif ou inactif.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $association = Association::create($request->only([
            'name',
            'contact_email',
            'contact_phone',
            'domain',
            'address',
            'description',
            'status'
        ]));

        return redirect()->route('associations.show', $association)
            ->with('success', 'Association créée avec succès.');
    }

    public function show(Association $association): View
    {
        return view('BackOffice.associations.show', compact('association'));
    }

    public function edit(Association $association): View
    {
        return view('BackOffice.associations.edit', compact('association'));
    }

    public function update(Request $request, Association $association): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:associations,contact_email,' . $association->id,
            'contact_phone' => 'nullable|string|max:20',
            'domain' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Le nom est requis.',
            'contact_email.unique' => 'Cet email est déjà utilisé.',
            'status.in' => 'Le statut doit être actif ou inactif.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $association->update($request->only([
            'name',
            'contact_email',
            'contact_phone',
            'domain',
            'address',
            'description',
            'status'
        ]));

        return redirect()->route('associations.show', $association)
            ->with('success', 'Association mise à jour avec succès.');
    }

    public function destroy(Association $association): RedirectResponse
    {
        if ($association->donations()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des donations sont associées à cette association.');
        }

        $association->delete();
        return redirect()->route('associations.index')
            ->with('success', 'Association supprimée avec succès.');
    }
}
