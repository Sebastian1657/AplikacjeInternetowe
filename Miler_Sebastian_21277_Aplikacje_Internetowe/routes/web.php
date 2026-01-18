<?php

use Illuminate\Support\Facades\Route;
use App\Models\Animal; //
use App\Models\Species; //
use Carbon\Carbon;

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