<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::when(request()->q, function ($departements) {
            $departements = $departements->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        return Inertia::render('Departement/Index', [
            'departements' => $departements,
        ]);
    }

    public function create()
    {
        return Inertia::render('Departement/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:departements,name'],
        ]);

        Departement::create([
            'name' => $request->name,
        ]);

        return redirect()->route('departements.index')->with('success', 'Departement created successfully.');
    }

    public function edit(Departement $departement)
    {
        return Inertia::render('Departement/Edit', [
            'departement' => $departement,
        ]);
    }

    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:departements,name,' . $departement->id],
        ]);

        $departement->update([
            'name' => $request->name,
        ]);

        return redirect()->route('departements.index')->with('success', 'Departement updated successfully.');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Departement deleted successfully.');
    }
}
