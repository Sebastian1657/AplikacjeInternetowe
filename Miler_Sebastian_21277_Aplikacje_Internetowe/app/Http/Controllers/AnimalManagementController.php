<?php

namespace App\Http\Controllers;

use App\Models\Species;
use App\Models\Subspecies;
use App\Models\Animal;
use App\Models\Enclosure;
use App\Models\DietPlan;
use Illuminate\Http\Request;

class AnimalManagementController extends Controller
{
    public function index()
    {
        $species = Species::with(['subspecies.animals'])->orderBy('name')->get();
        return view('supervisor.animals.index', compact('species'));
    }
    public function storeSpecies(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:species,name|max:255']);
        Species::create($request->only('name'));
        return back()->with('success', 'Gatunek został dodany.');
    }
    public function destroySpecies(Species $species)
    {
        if ($species->subspecies()->count() > 0) {
            return back()->with('error', 'Nie można usunąć gatunku, który posiada podgatunki. Usuń je najpierw.');
        }
        $species->delete();
        return back()->with('success', 'Gatunek usunięty.');
    }

    public function createSubspecies(Species $species)
    {
        return view('supervisor.animals.create_subspecies', compact('species'));
    }
    public function storeSubspecies(Request $request)
    {
        $request->validate([
            'species_id' => 'required|exists:species,id',
            'common_name' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
        ]);

        Subspecies::create($request->all());
        return redirect()->route('supervisor.animals.index')->with('success', 'Podgatunek dodany.');
    }
    public function destroySubspecies(Subspecies $subspecies)
    {
        if ($subspecies->animals()->count() > 0) {
            return back()->with('error', 'Nie można usunąć podgatunku, który ma przypisane zwierzęta.');
        }
        $subspecies->delete();
        return back()->with('success', 'Podgatunek usunięty.');
    }

    public function createAnimal(Subspecies $subspecies)
    {
        $enclosures = Enclosure::orderBy('name')->get();
        $diets = DietPlan::orderBy('name')->get();
        
        return view('supervisor.animals.create_animal', compact('subspecies', 'enclosures', 'diets'));
    }
    public function storeAnimal(Request $request)
    {
        $request->validate([
            'subspecies_id' => 'required|exists:subspecies,id',
            'name' => 'required|string|max:255',
            'sex' => 'required|in:Samiec,Samica,Nieznana',
            'birth_date' => 'required|date',
            'enclosure_id' => 'required|exists:enclosures,id',
            'diet_plan_id' => 'required|exists:diet_plans,id',
        ]);

        Animal::create($request->all());
        return redirect()->route('supervisor.animals.index')->with('success', 'Zwierzę dodane do systemu.');
    }
    public function destroyAnimal(Animal $animal)
    {
        $animal->delete();
        return back()->with('success', 'Zwierzę usunięte z systemu.');
    }
}
