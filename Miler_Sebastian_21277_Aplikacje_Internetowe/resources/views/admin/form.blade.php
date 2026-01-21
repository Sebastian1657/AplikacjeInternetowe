@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.table.index', $tableName) }}" class="text-indigo-600 hover:text-indigo-800">← Wróć do listy</a>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            {{ isset($item) ? 'Edycja rekordu' : 'Nowy rekord' }}
            <span class="text-gray-400 text-lg font-normal">({{ $config['title'] }})</span>
        </h1>

        <form action="{{ isset($item) ? route('admin.table.update', [$tableName, $item->id]) : route('admin.table.store', $tableName) }}" method="POST">
            @csrf
            @if(isset($item)) @method('PUT') @endif

            <div class="space-y-4">
                {{-- ITERACJA PO POLACH Z MODELU --}}
                @foreach($config['fields'] as $field => $options)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $options['label'] }}
                        </label>

                        @if($options['type'] === 'relation')
                            {{-- SELECT DLA RELACJI --}}
                            <select name="{{ $field }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Wybierz --</option>
                                @php 
                                    $displayField = $options['display'];
                                    // Pobieramy listę opcji z przekazanych danych
                                    $relatedItems = $relationsData[$field] ?? [];
                                    $currentValue = isset($item) ? $item->$field : old($field);
                                @endphp
                                
                                @foreach($relatedItems as $relItem)
                                    <option value="{{ $relItem->id }}" {{ $currentValue == $relItem->id ? 'selected' : '' }}>
                                        {{ $relItem->$displayField }}
                                    </option>
                                @endforeach
                            </select>

                        @elseif($options['type'] === 'date')
                             {{-- DATA --}}
                             <input type="date" name="{{ $field }}" value="{{ isset($item) ? $item->$field : old($field) }}" class="w-full rounded-md border-gray-300 shadow-sm">
                        
                        @else
                            {{-- ZWYKŁY TEKST --}}
                            <input type="text" name="{{ $field }}" value="{{ isset($item) ? $item->$field : old($field) }}" class="w-full rounded-md border-gray-300 shadow-sm">
                        @endif
                        
                        @error($field)
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 shadow-md">
                    Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
</div>
@endsection