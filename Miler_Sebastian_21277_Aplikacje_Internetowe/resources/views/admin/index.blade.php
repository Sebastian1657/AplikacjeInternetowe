@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Panel Administratora</h1>
        
        <div class="flex items-center gap-2">
            <label class="font-medium text-gray-700">Edytuj tabelę:</label>
            <select onchange="window.location.href=this.value" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach($availableTables as $key => $tblConfig)
                    <option value="{{ route('admin.table.index', $key) }}" {{ $tableName == $key ? 'selected' : '' }}>
                        {{ $tblConfig['title'] }} ({{ $key }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">{{ $config['title'] }}</h2>
            <a href="{{ route('admin.table.create', $tableName) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-medium">
                + Dodaj nowy rekord
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        {{-- ZMIANA: Iterujemy po polach (fields) zdefiniowanych w modelu --}}
                        @foreach($config['fields'] as $field => $options)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $options['label'] }}
                            </th>
                        @endforeach
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($data as $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">#{{ $row->id }}</td>
                        
                        {{-- ZMIANA: Wyświetlanie danych na podstawie typu pola w konfiguracji --}}
                        @foreach($config['fields'] as $field => $options)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($options['type'] === 'relation')
                                    {{-- Logika dla relacji (np. species_id -> species->name) --}}
                                    @php
                                        // Zamieniamy np. 'species_id' na 'species' i formatujemy na camelCase (dla pewności)
                                        $relationName = \Illuminate\Support\Str::camel(str_replace('_id', '', $field));
                                        $displayField = $options['display'];
                                    @endphp

                                    @if($row->$relationName)
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            {{ $row->$relationName->$displayField }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                    
                                @elseif($options['type'] === 'date')
                                     {{ $row->$field }}
                                     
                                @else
                                     {{ \Illuminate\Support\Str::limit($row->$field, 30) }}
                                @endif
                            </td>
                        @endforeach

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.table.edit', [$tableName, $row->id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edytuj</a>
                            <form action="{{ route('admin.table.destroy', [$tableName, $row->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Czy na pewno usunąć?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-900">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100" class="px-6 py-4 text-center text-gray-500">Brak danych w tej tabeli.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection