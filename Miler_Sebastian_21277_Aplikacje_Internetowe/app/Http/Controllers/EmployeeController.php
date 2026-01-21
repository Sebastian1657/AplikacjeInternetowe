<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::whereHas('role', function($q) {
            $q->whereIn('name', ['employee', 'manager']);
        })->with('role')->orderBy('last_name')->paginate(20);

        return view('supervisor.employees.index', compact('employees'));
    }
    public function create()
    {
        $roles = Role::whereIn('name', ['employee', 'manager'])->get();
        return view('supervisor.employees.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('supervisor.employees.index')
            ->with('success', 'Pracownik został dodany pomyślnie.');
    }
    public function edit(User $employee)
    {
        if ($employee->isSupervisor()) {
            abort(403);
        }

        $roles = Role::whereIn('name', ['employee', 'manager'])->get();
        return view('supervisor.employees.edit', compact('employee', 'roles'));
    }
    public function update(Request $request, User $employee)
    {
        if ($employee->isSupervisor()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        $employee->update([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ]);

        if ($request->filled('password')) {
            $employee->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('supervisor.employees.index')
            ->with('success', 'Dane pracownika zaktualizowane.');
    }
    public function destroy(User $employee)
    {
        if ($employee->isSupervisor()) {
            abort(403);
        }

        $employee->delete();

        return redirect()->route('supervisor.employees.index')
            ->with('success', 'Pracownik został usunięty.');
    }
}
