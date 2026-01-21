<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Enclosure;

class MapController extends Controller
{
    public function index()
    {
        $enclosures = Enclosure::with(['animals.subspecies.species'])->get();    
        return view('map', compact('enclosures'));
    }

    public function getEnclosure($id)
    {
        $enclosure = Enclosure::with(['animals.subspecies'])->findOrFail($id);

        $modalData = $enclosure->animals->groupBy('subspecies_id')->map(function($group) {
            $first = $group->first();
            return [
                'common_name' => $first->subspecies->common_name,
                'specie_name' => $first->subspecies->species->name,
                'scientific_name' => $first->subspecies->scientific_name,
                'names' => $group->pluck('name')->toArray(),
                'image' => asset('photos/' . Str::slug($first->subspecies->common_name, '_') . '.jpg')
            ];
        })->values();
        return response()->json([
            'name' => $enclosure->name,
            'animals' => $modalData
        ]);
    }
}
