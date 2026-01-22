@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Dodaj zwierzę: <span class="text-green-600">{{ $subspecies->common_name }}</span></h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('supervisor.animals.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="subspecies_id" value="{{ $subspecies->id }}">

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Imię</label>
                    <input type="text" name="name" class="w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Płeć</label>
                    <select name="sex" class="w-full rounded-md border-gray-300 shadow-sm">
                        <option value="" disabled selected>Wybierz płeć</option>
                        <option value="Samiec">Samiec</option>
                        <option value="Samica">Samica</option>
                        <option value="Nieznana">Nieznana</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Data urodzenia</label>
                <input type="date" name="birth_date" class="w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Przypisz do wybiegu</label>
                <select name="enclosure_id" class="w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="" disabled selected>Wybierz wybieg</option>
                    @foreach($enclosures as $enc)
                        <option value="{{ $enc->id }}">{{ $enc->name }} ({{ $enc->type }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Przypisz dietę</label>
                <select name="diet_plan_id" class="w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="" disabled selected>Wybierz dietę</option>
                    @foreach($diets as $diet)
                        <option value="{{ $diet->id }}">{{ $diet->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('supervisor.animals.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">Anuluj</a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Dodaj Zwierzę</button>
            </div>
        </form>
    </div>
</div>
@endsection
