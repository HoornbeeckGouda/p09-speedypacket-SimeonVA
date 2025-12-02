<?php

namespace App\Http\Controllers;

use App\Models\Pakket;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PakketController extends Controller
{
    public function index(Request $request)
    {
        $query = Pakket::with(['ontvanger', 'product']);

        if ($request->search) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('naam', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->datum) {
            $query->whereDate('verwachte_leverdatum', $request->datum);
        }

        $pakketten = $query->latest()->paginate(15);
        return view('dashboard', compact('pakketten'));
    }

    public function create()
    {
        $ontvangers = User::all();
        $producten = Product::orderBy('naam')->get();
        return view('pakketten.create', compact('ontvangers', 'producten'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ontvanger_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:producten,id',
            'status' => 'required|in:besteld,verwerkt,onderweg,afgeleverd,geannuleerd',
            'verwachte_leverdatum' => 'nullable|date',
        ]);

        $qrCode = 'PKT-' . strtoupper(Str::random(8));
        $trackTrace = '3S' . strtoupper(Str::random(4)) . rand(1000000000, 9999999999);

        Pakket::create([
            'qr_code' => $qrCode,
            'track_and_trace' => $trackTrace,
            'ontvanger_id' => $validated['ontvanger_id'],
            'product_id' => $validated['product_id'],
            'status' => $validated['status'],
            'verwachte_leverdatum' => $validated['verwachte_leverdatum'],
        ]);

        return redirect()->route('pakketten.index')->with('success', 'Pakket aangemaakt!');
    }

    public function show(Pakket $pakket)
    {
        $pakket->load(['ontvanger', 'product']);
        return view('pakketten.show', compact('pakket'));
    }

    public function edit(Pakket $pakket)
    {
        $ontvangers = User::all();
        $producten = Product::orderBy('naam')->get();
        return view('pakketten.edit', compact('pakket', 'ontvangers', 'producten'));
    }

    public function update(Request $request, Pakket $pakket)
    {
        $validated = $request->validate([
            'ontvanger_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:producten,id',
            'status' => 'required|in:besteld,verwerkt,onderweg,afgeleverd,geannuleerd',
            'verwachte_leverdatum' => 'nullable|date',
        ]);

        $pakket->update($validated);
        return redirect()->route('pakketten.index')->with('success', 'Pakket bijgewerkt!');
    }

    public function destroy(Pakket $pakket)
    {
        $pakket->delete();
        return redirect()->route('pakketten.index')->with('success', 'Pakket verwijderd!');
    }
}