@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Zarządzanie Zwierzętami</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-lg font-semibold mb-4">Dodaj nowy gatunek główny</h3>
        <form action="{{ route('supervisor.animals.species.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input aria-label="Wpisz nazwę nowego gatunku" type="text" name="name" placeholder="Nazwa gatunku (np. Kotowate)" class="flex-1 rounded-md border-gray-300 shadow-sm" required>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Dodaj</button>
        </form>
    </div>

    <div class="space-y-4">
        @foreach($species as $specie)
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">{{ $specie->name }}</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('supervisor.animals.subspecies.create', $specie) }}" class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200">+ Podgatunek</a>
                    
                    @if($specie->subspecies->count() == 0)
                    <form action="{{ route('supervisor.animals.species.destroy', $specie) }}" method="POST" onsubmit="return confirm('Usunąć ten gatunek?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="p-4 space-y-4">
                @forelse($specie->subspecies as $sub)
                    <details class="group bg-gray-50 rounded-md border border-gray-200">
                        <summary class="flex justify-between items-center p-4 cursor-pointer list-none">
                            <div class="flex items-center gap-2">
                                <span class="transition group-open:rotate-90">▶</span>
                                <span class="font-semibold text-lg">{{ $sub->common_name }}</span>
                                <span class="text-sm text-gray-500 italic">({{ $sub->scientific_name }})</span>
                                <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full ml-2">{{ $sub->animals->count() }} os.</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('supervisor.animals.create', $sub) }}" class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200">+ Zwierzę</a>
                                @if($sub->animals->count() == 0)
                                <form action="{{ route('supervisor.animals.subspecies.destroy', $sub) }}" method="POST" onsubmit="return confirm('Usunąć podgatunek?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 text-sm px-2">Usuń</button>
                                </form>
                                @endif
                            </div>
                        </summary>

                        <div class="p-4 pt-0 border-t border-gray-100 pl-10">
                            @if($sub->animals->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Imię</th>
                                        <th class="px-4 py-2 text-left">Płeć</th>
                                        <th class="px-4 py-2 text-left">Wiek (ur.)</th>
                                        <th class="px-4 py-2 text-left">Wybieg</th>
                                        <th class="px-4 py-2 text-right">Akcja</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($sub->animals as $animal)
                                    <tr>
                                        <td class="px-4 py-2 font-medium">{{ $animal->name }}</td>
                                        <td class="px-4 py-2">{{ $animal->sex }}</td>
                                        <td class="px-4 py-2">{{ $animal->birth_date }}</td>
                                        <td class="px-4 py-2">{{ $animal->enclosure->name ?? 'Brak' }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <form action="{{ route('supervisor.animals.destroy', $animal) }}" method="POST" onsubmit="return confirm('Usunąć zwierzę: {{ $animal->name }}?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:text-red-800">Usuń</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <p class="text-gray-500 text-sm italic py-2">Brak zwierząt w tym podgatunku.</p>
                            @endif
                        </div>
                    </details>
                @empty
                    <p class="text-gray-500 italic pl-4">Brak zdefiniowanych podgatunków.</p>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection