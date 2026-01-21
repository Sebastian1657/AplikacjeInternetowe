<?php

namespace App\Http\Controllers;

use App\Models\DietPlan;
use App\Models\Food;
use App\Models\Subspecies;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DietController extends Controller
{
    public function index()
    {
        $diets = DietPlan::withCount('foods', 'animals')->paginate(10);
        return view('supervisor.diets.index', compact('diets'));
    }
    public function create()
    {
        $foods = Food::orderBy('name')->get();
        return view('supervisor.diets.form', compact('foods'));
    }
    public function store(Request $request)
    {
        $this->validateDiet($request);

        DB::transaction(function () use ($request) {
            $diet = DietPlan::create($request->only(['name', 'feeding_frequency']));
            $this->syncFoods($diet, $request->input('ingredients', []));
        });

        return redirect()->route('supervisor.diets.index')
            ->with('success', 'Dieta została utworzona.');
    }
    public function edit(DietPlan $diet)
    {
        $foods = Food::orderBy('name')->get();
        $diet->load('foods');
        return view('supervisor.diets.form', compact('diet', 'foods'));
    }
    public function update(Request $request, DietPlan $diet)
    {
        $this->validateDiet($request);

        DB::transaction(function () use ($request, $diet) {
            $diet->update($request->only(['name', 'feeding_frequency']));
            $this->syncFoods($diet, $request->input('ingredients', []));
        });

        return redirect()->route('supervisor.diets.index')
            ->with('success', 'Dieta została zaktualizowana.');
    }
    public function destroy(DietPlan $diet)
    {
        if ($diet->animals()->count() > 0) {
            return back()->with('error', 'Nie można usunąć diety, która jest przypisana do zwierząt.');
        }
        
        $diet->foods()->detach();
        $diet->delete();

        return redirect()->route('supervisor.diets.index')
            ->with('success', 'Dieta została usunięta.');
    }
    public function assignForm(DietPlan $diet)
    {
        $subspecies = Subspecies::orderBy('common_name')->get();
        return view('supervisor.diets.assign', compact('diet', 'subspecies'));
    }
    public function processAssign(Request $request, DietPlan $diet)
    {
        $request->validate([
            'subspecies_id' => 'required|exists:subspecies,id',
        ]);

        // Aktualizacja wszystkich zwierząt danego podgatunku
        $count = Animal::where('subspecies_id', $request->subspecies_id)
            ->update(['diet_plan_id' => $diet->id]);

        return redirect()->route('supervisor.diets.index')
            ->with('success', "Przypisano dietę '{$diet->name}' do {$count} zwierząt.");
    }
    private function validateDiet(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'feeding_frequency' => 'required|string|max:255',
            'ingredients' => 'array',
            'ingredients.*.food_id' => 'required|exists:foods,id',
            'ingredients.*.amount' => 'required|numeric|min:0.01',
        ]);
    }
    private function syncFoods(DietPlan $diet, array $ingredients)
    {
        $syncData = [];
        foreach ($ingredients as $item) {
            if (isset($item['food_id'])) {
                $syncData[$item['food_id']] = ['amount' => $item['amount']];
            }
        }
        $diet->foods()->sync($syncData);
    }
}
