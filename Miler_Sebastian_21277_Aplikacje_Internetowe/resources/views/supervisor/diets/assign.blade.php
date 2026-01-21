@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Przypisz dietę: {{ $diet->name }}</h2>
        <p class="text-gray-600 mb-6">
            Ta akcja zaktualizuje dietę dla <strong>wszystkich</strong> zwierząt należących do wybranego gatunku.
        </p>

        <form action="{{ route('supervisor.diets.process_assign', $diet) }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Wybierz gatunek / podgatunek</label>
                <select name="subspecies_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg p-2">
                    @foreach($subspecies as $sub)
                        <option value="{{ $sub->id }}">
                            {{ $sub->common_name }} ({{ $sub->scientific_name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('supervisor.diets.index') }}" class="text-gray-500 hover:text-gray-700">Wróć</a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-bold" onclick="return confirm('Czy na pewno chcesz zmienić dietę dla wszystkich zwierząt tego gatunku?');">
                    Zastosuj zmianę
                </button>
            </div>
        </form>
    </div>
</div>
@endsection