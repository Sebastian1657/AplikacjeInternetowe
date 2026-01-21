<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    private $modelMap = [
        'users'      => \App\Models\User::class,
        'animals'    => \App\Models\Animal::class,
        'species'    => \App\Models\Species::class,
        'subspecies' => \App\Models\Subspecies::class,
        'enclosures' => \App\Models\Enclosure::class,
        'foods'      => \App\Models\Food::class,
        'diets'      => \App\Models\DietPlan::class,
        'roles'      => \App\Models\Role::class,
    ];

    public function index($tableName)
    {
        $modelClass = $this->getModelClass($tableName);
        $config = $modelClass::getAdminConfig();
        $data = $modelClass::orderBy('id', 'desc')->paginate(15);

        $availableTables = $this->getAvailableTables();

        return view('admin.index', compact('data', 'config', 'tableName', 'availableTables'));
    }

    public function create($tableName)
    {
        $modelClass = $this->getModelClass($tableName);
        $config = $modelClass::getAdminConfig();
        $relationsData = $this->loadRelationsData($config);

        return view('admin.form', compact('config', 'tableName', 'relationsData'));
    }

    public function store(Request $request, $tableName)
    {
        $modelClass = $this->getModelClass($tableName);
        $config = $modelClass::getAdminConfig();

        $rules = [];
        foreach ($config['fields'] as $field => $options) {
            $rules[$field] = 'required';
        }
        $request->validate($rules);

        $modelClass::create($request->all());

        return redirect()->route('admin.table.index', $tableName)
            ->with('success', 'Rekord dodany.');
    }

    public function edit($tableName, $id)
    {
        $modelClass = $this->getModelClass($tableName);
        $config = $modelClass::getAdminConfig();
        $item = $modelClass::findOrFail($id);
        $relationsData = $this->loadRelationsData($config);

        return view('admin.form', compact('config', 'tableName', 'item', 'relationsData'));
    }

    public function update(Request $request, $tableName, $id)
    {
        $modelClass = $this->getModelClass($tableName);
        $config = $modelClass::getAdminConfig();
        $item = $modelClass::findOrFail($id);

        $rules = [];
        foreach ($config['fields'] as $field => $options) {
            $rules[$field] = 'required';
        }
        $request->validate($rules);

        $item->update($request->all());

        return redirect()->route('admin.table.index', $tableName)
            ->with('success', 'Rekord został zaktualizowany.');
    }

    public function destroy($tableName, $id)
    {
        $modelClass = $this->getModelClass($tableName);
        
        try {
            $modelClass::destroy($id);
            return back()->with('success', 'Rekord usunięty.');
        } catch (\Exception $e) {
            return back()->with('error', 'Nie można usunąć rekordu (prawdopodobnie jest powiązany z innymi danymi w systemie).');
        }
    }

    private function getModelClass($tableName)
    {
        if (!array_key_exists($tableName, $this->modelMap)) {
            abort(404);
        }
        return $this->modelMap[$tableName];
    }

    private function getAvailableTables()
    {
        $tables = [];
        foreach($this->modelMap as $key => $class) {
            if (method_exists($class, 'getAdminConfig')) {
                $tables[$key] = $class::getAdminConfig();
            }
        }
        return $tables;
    }

    private function loadRelationsData($config)
    {
        $data = [];
        foreach ($config['fields'] as $column => $options) {
            if ($options['type'] === 'relation') {
                $relatedModel = $options['model'];
                $display = $options['display'];
                $data[$column] = $relatedModel::orderBy($display)->get(['id', $display]);
            }
        }
        return $data;
    }
}