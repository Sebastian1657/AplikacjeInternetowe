<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subspecies;

class ResidentController extends Controller
{
    public function index()
    {
        $subspecies = Subspecies::withCount('animals')
        ->orderBy('common_name')
        ->paginate(10);

        return view('residents', compact('subspecies'));
    }
}
