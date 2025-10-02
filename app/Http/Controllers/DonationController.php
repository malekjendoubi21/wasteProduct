<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DonationController extends Controller
{
    /**
     * Display the list of donations for the authenticated user (FrontOffice).
     */
    public function index(): View
    {
        $user = Auth::user();
        $donations = Donation::with(['association', 'items.product'])
            ->byUser($user->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('FrontOffice.donations.index', compact('donations'));
    }

     /**
     * Display the list of all donations for admins (BackOffice).
     */
    public function adminIndex(): View
    {
        // Restrict to admins only
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Action non autorisée.');
        }

        $donations = Donation::with(['association', 'items.product', 'user'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('BackOffice.donations.index', compact('donations'));
    }

    /**
     * Display the details of a specific donation for admins (BackOffice).
     */
    public function show(Donation $donation): View
    {
        // Restrict to admins only
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Action non autorisée.');
        }

        $donation->load(['association', 'user', 'items.product']);

        return view('BackOffice.donations.show', compact('donation'));
    }

    /**
     * Show the form to create a new donation for a product.
     */
    public function create(Product $product): View
    {
        $associations = Association::where('status', 'active')->orderBy('name')->get();
        return view('FrontOffice.donations.create', compact('product', 'associations'));
    }

    /**
     * Show the form to edit an existing donation.
     */
    public function edit(Donation $donation): View
    {
        // Check if the user owns the donation and it's pending
        if ($donation->user_id !== Auth::id() || $donation->status !== Donation::STATUS_PENDING) {
            abort(403, 'Action non autorisée.');
        }

        $associations = Association::where('status', 'active')->orderBy('name')->get();
        $donationItem = $donation->items->first(); // Assume one item per donation

        return view('FrontOffice.donations.edit', compact('donation', 'donationItem', 'associations'));
    }

    /**
     * Store a new donation.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'association_id' => 'required|exists:associations,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ], [
            'product_id.required' => 'Le produit est requis.',
            'product_id.exists' => 'Le produit sélectionné n\'existe pas.',
            'association_id.required' => 'L\'association est requise.',
            'association_id.exists' => 'L\'association sélectionnée n\'existe pas.',
            'quantity.required' => 'La quantité est requise.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'quantity.min' => 'La quantité doit être au moins 1.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Check if stock is sufficient
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock insuffisant pour ce produit.')->withInput();
        }

        // Create the donation within a transaction
        DB::transaction(function () use ($request, $product) {
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'association_id' => $request->association_id,
                'description' => $request->description,
                'date' => now(),
                'status' => Donation::STATUS_PENDING,
            ]);

            // Add donation item
            DonationItem::create([
                'donation_id' => $donation->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);

            // Decrease product stock
            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('donations.index')
            ->with('success', 'Don ajouté avec succès.');
    }

    /**
     * Update an existing donation.
     */
    public function update(Request $request, Donation $donation): RedirectResponse
    {
        // Check if the user owns the donation and it's pending
        if ($donation->user_id !== Auth::id() || $donation->status !== Donation::STATUS_PENDING) {
            abort(403, 'Action non autorisée.');
        }

        $validator = Validator::make($request->all(), [
            'association_id' => 'required|exists:associations,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ], [
            'association_id.required' => 'L\'association est requise.',
            'association_id.exists' => 'L\'association sélectionnée n\'existe pas.',
            'quantity.required' => 'La quantité est requise.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'quantity.min' => 'La quantité doit être au moins 1.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $donationItem = $donation->items->first(); // Assume one item per donation
        $product = $donationItem->product;
        $oldQuantity = $donationItem->quantity;

        // Check if stock is sufficient for the new quantity
        if ($product->stock + $oldQuantity < $request->quantity) {
            return back()->with('error', 'Stock insuffisant pour la nouvelle quantité.')->withInput();
        }

        // Update the donation within a transaction
        DB::transaction(function () use ($request, $donation, $donationItem, $product, $oldQuantity) {
            // Restore the old stock
            $product->increment('stock', $oldQuantity);

            // Update the donation
            $donation->update([
                'association_id' => $request->association_id,
                'description' => $request->description,
            ]);

            // Update the donation item (quantity)
            $donationItem->update([
                'quantity' => $request->quantity,
            ]);

            // Apply the new quantity (deduct from stock)
            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('donations.index')
            ->with('success', 'Don modifié avec succès.');
    }

    /**
     * Delete a donation and restore associated product stock.
     */
    public function destroy(Donation $donation): RedirectResponse
    {
        // Check if the user owns the donation
        if ($donation->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        // Check if the donation is pending
        if ($donation->status !== Donation::STATUS_PENDING) {
            return back()->with('error', 'Impossible de supprimer un don qui n\'est plus en attente.');
        }

        DB::transaction(function () use ($donation) {
            // Restore stock for each item
            foreach ($donation->items as $item) {
                $product = $item->product;
                $product->increment('stock', $item->quantity);
            }

            // Delete items and donation
            $donation->items()->delete();
            $donation->delete();
        });

        return redirect()->route('donations.index')
            ->with('success', 'Don supprimé avec succès.');
    }
}