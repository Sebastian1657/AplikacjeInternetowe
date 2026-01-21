@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-green-100">
        <div>
            <h1 class="text-3xl font-bold text-zoo-footer">Zarządzanie Personelem</h1>
            <p class="text-gray-500">Lista pracowników i managerów ZOO.</p>
        </div>
        <a href="{{ route('supervisor.employees.create') }}" class="bg-zoo-menu hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Dodaj Pracownika
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-green-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-zoo-footer text-white">
                <tr>
                    <th class="p-4">Pracownik</th>
                    <th class="p-4">Rola</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 text-right">Akcje</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-green-50">
                @foreach($employees as $emp)
                    <tr class="hover:bg-green-50/50 transition-colors">
                        <td class="p-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-zoo-menu flex items-center justify-center font-bold">
                                {{ substr($emp->name, 0, 1) }}
                            </div>
                            <span class="font-semibold text-gray-700">{{ $emp->name }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $emp->role->name == 'manager' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $emp->role->name }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-600">{{ $emp->email }}</td>
                        <td class="p-4 text-right flex justify-end gap-2">
                            <a href="{{ route('supervisor.employees.edit', $emp) }}" class="text-blue-500 hover:text-blue-700 p-2 hover:bg-blue-50 rounded transition-colors" title="Edytuj">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="{{ route('supervisor.employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Czy na pewno usunąć tego pracownika?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded transition-colors" title="Usuń">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-4 border-t border-gray-100">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection