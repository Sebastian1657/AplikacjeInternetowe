@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Zarządzanie Dietami</h1>
        <a href="{{ route('supervisor.diets.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Nowa Dieta
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nazwa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Częstotliwość</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Składniki</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Przypisane zwierzęta</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($diets as $diet)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $diet->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $diet->feeding_frequency }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $diet->foods_count }} produktów
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $diet->animals_count }}
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                        <a href="{{ route('supervisor.diets.assign', $diet) }}" class="text-indigo-600 hover:text-indigo-900">Przypisz</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('supervisor.diets.edit', $diet) }}" class="text-yellow-600 hover:text-yellow-900">Edytuj</a>
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('supervisor.diets.destroy', $diet) }}" method="POST" class="inline-block" onsubmit="return confirm('Czy na pewno usunąć tę dietę?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Usuń</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $diets->links() }}
        </div>
    </div>
</div>
@endsection