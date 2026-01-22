@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">
        {{ isset($diet) ? 'Edytuj Dietę: ' . $diet->name : 'Tworzenie Nowej Diety' }}
    </h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ isset($diet) ? route('supervisor.diets.update', $diet) : route('supervisor.diets.store') }}" method="POST">
            @csrf
            @if(isset($diet)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nazwa Diety</label>
                    <input type="text" name="name" value="{{ old('name', $diet->name ?? '') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Częstotliwość karmienia</label>
                    <input type="text" name="feeding_frequency" value="{{ old('feeding_frequency', $diet->feeding_frequency ?? '') }}" required placeholder="np. 2x dziennie"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <hr class="my-6">

            <h2 class="text-lg font-medium text-gray-900 mb-4">Składniki i proporcje</h2>
            
            <div id="ingredients-container">
                @php
                    $currentIngredients = old('ingredients', isset($diet) ? $diet->foods->map(fn($f) => ['food_id' => $f->id, 'amount' => $f->pivot->amount]) : []);
                @endphp

                @foreach($currentIngredients as $index => $ing)
                    <div class="ingredient-row flex gap-4 mb-4 items-end">
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500">Produkt</label>
                            <select name="ingredients[{{ $index }}][food_id]" class="w-full rounded-md border-gray-300 shadow-sm">
                                @foreach($foods as $food)
                                    <option value="{{ $food->id }}" {{ $food->id == $ing['food_id'] ? 'selected' : '' }}>
                                        {{ $food->name }} ({{ $food->unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-32">
                            <label class="block text-xs text-gray-500">Ilość</label>
                            <input type="number" step="0.01" name="ingredients[{{ $index }}][amount]" value="{{ $ing['amount'] }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 pb-2">Usuń</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addIngredient()" class="mt-2 text-sm text-green-600 hover:text-green-800 font-medium">
                + Dodaj kolejny składnik
            </button>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('supervisor.diets.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 pt-2">Anuluj</a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700">
                    Zapisz Dietę
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let ingredientIndex = {{ count($currentIngredients) > 0 ? count($currentIngredients) : 0 }};
    const foods = @json($foods);

    function addIngredient() {
        const container = document.getElementById('ingredients-container');
        let options = '';
        foods.forEach(food => {
            options += `<option value="${food.id}">${food.name} (${food.unit})</option>`;
        });

        const html = `
            <div class="ingredient-row flex gap-4 mb-4 items-end">
                <div class="flex-1">
                    <select name="ingredients[${ingredientIndex}][food_id]" class="w-full rounded-md border-gray-300 shadow-sm">
                        ${options}
                    </select>
                </div>
                <div class="w-32">
                    <input type="number" step="0.01" name="ingredients[${ingredientIndex}][amount]" placeholder="Ilość" class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700 pb-2">Usuń</button>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
        ingredientIndex++;
    }

    function removeRow(btn) {
        btn.closest('.ingredient-row').remove();
    }

    if(ingredientIndex === 0) addIngredient();
</script>
@endsection