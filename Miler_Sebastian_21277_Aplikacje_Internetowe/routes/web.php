<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Animal;
use App\Models\Enclosure;
use App\Models\Species;
use App\Models\Subspecies;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    $animalsCount = Animal::count();
    $speciesCount = Species::count();
    
    $foundedDate = Carbon::create(2006, 7, 3);
    $yearsOfOperation = (int) $foundedDate->diffInYears(now());

    $videoPath = public_path('videos');
    $randomVideo = 'seal.mp4';

    if (File::exists($videoPath)) {
        $files = File::files($videoPath);
        
        $videos = array_filter($files, function ($file) {
            return in_array(strtolower($file->getExtension()), ['mp4', 'webm', 'mov']);
        });

        if (!empty($videos)) {
            $randomFile = $videos[array_rand($videos)];
            $randomVideo = $randomFile->getFilename();
        }
    }

    return view('welcome', compact('animalsCount', 'speciesCount', 'yearsOfOperation', 'randomVideo'));
});

Route::get('/bilety', function () {
    $ticketTypes = [
        ['id' => 'normal', 'name' => 'Bilet Normalny', 'price' => 60],
        ['id' => 'student', 'name' => 'Ulgowy (Uczeń / Student)', 'price' => 40],
        ['id' => 'child', 'name' => 'Dziecko do 3 r.ż.', 'price' => 0],
        ['id' => 'senior', 'name' => 'Emeryt', 'price' => 30],
        ['id' => 'disabled', 'name' => 'Os. Niepełnosprawna', 'price' => 30],
        ['id' => 'group', 'name' => 'Grupa zorganizowana (min. 10 osób)', 'price' => 25],
    ];

    return view('tickets.index', compact('ticketTypes'));
})->name('tickets.index');

Route::post('/bilety/platnosc', function (Request $request) {
    $data = $request->all();
    $groupTickets = intval($data['tickets']['group'] ?? 0);
    if ($groupTickets > 0 && $groupTickets < 10) {
        abort(400, 'Błąd: Grupa zorganizowana musi liczyć minimum 10 osób.');
    }
    return view('tickets.payment', compact('data'));
})->name('tickets.checkout');

Route::post('/bilety/finalizacja', function (Request $request) {
    $data = $request->all();
    $pdf = Pdf::loadView('pdf.ticket', compact('data'));
    return $pdf->download('Bilet_ZOO_' . $data['visit_date'] . '.pdf');
})->name('tickets.finalize');

Route::get('/mapa', function () {
    $enclosures = Enclosure::with(['animals.subspecies'])->get();
    
    return view('map', compact('enclosures'));
})->name('map');

Route::get('/mieszkancy', function () {
    $subspecies = Subspecies::withCount('animals')
        ->orderBy('common_name')
        ->paginate(10);

    return view('residents', compact('subspecies'));
})->name('residents');

Route::get('/kontakt', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');