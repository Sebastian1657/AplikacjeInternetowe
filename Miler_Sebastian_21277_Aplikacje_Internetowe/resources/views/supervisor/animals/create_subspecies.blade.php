@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Dodaj Podgatunek dla: <span class="text-green-600">{{ $species->name }}</span></h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('supervisor.animals.subspecies.store') }}" method="POST">
            @csrf
            <input type="hidden" name="species_id" value="{{ $species->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nazwa polska (Common Name)</label>
                <input type="text" name="common_name" class="w-full rounded-md border-gray-300 shadow-sm" required placeholder="np. Tygrys Syberyjski">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nazwa łacińska (Scientific Name)</label>
                <input type="text" name="scientific_name" class="w-full rounded-md border-gray-300 shadow-sm italic" required placeholder="np. Panthera tigris altaica">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('supervisor.animals.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">Anuluj</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Zapisz</button>
            </div>
        </form>
    </div>
</div>
@endsection