@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-2xl shadow-lg border border-green-200 p-8">
        <h2 class="text-2xl font-bold text-zoo-footer mb-6">Edytuj Pracownika</h2>

        <form action="{{ route('supervisor.employees.update', $employee) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Imię</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nazwisko</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm">
                    @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Stanowisko</label>
                <select name="role_id" id="role_id" required class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm">
                    <option value="" disabled>Wybierz stanowisko</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $employee->role_id == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nowe Hasło (zostaw puste, aby nie zmieniać)</label>
                <input type="password" name="password" id="password" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('supervisor.employees.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">Anuluj</a>
                <button type="submit" class="bg-zoo-menu hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-all">
                    Zapisz Zmiany
                </button>
            </div>
        </form>
    </div>
</div>
@endsection