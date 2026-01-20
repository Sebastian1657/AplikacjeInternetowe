@extends('layouts.app')

@section('content')
@php
    // KONFIGURACJA POZYCJI NA MAPIE
    // Mapujemy nazwy z DatabaseSeeder.php na koordynaty % na mapie (Top, Left, Width, Height)
    // Układ: Góra - Sawanna/Las | Środek - Woda | Dół - Budynki/Woliery
    $mapPositions = [
        // STREFA PÓŁNOCNA (DUŻE WYBIEGI ZEWNĘTRZNE)
        'Sawanna Słoni' =>          ['t' => 5,  'l' => 5,  'w' => 25, 'h' => 25],
        'Wybieg żyraf' =>           ['t' => 5,  'l' => 32, 'w' => 18, 'h' => 25],
        'Bambusowy Las' =>          ['t' => 5,  'l' => 55, 'w' => 20, 'h' => 20], // Pandy
        'Wybieg niedźwiedzi' =>     ['t' => 5,  'l' => 77, 'w' => 18, 'h' => 20],

        // STREFA WODNA (ŚRODEK - PRZY JEZIORZE)
        'Basen Fok' =>              ['t' => 35, 'l' => 35, 'w' => 12, 'h' => 12],
        'Zatoka Nerp' =>            ['t' => 35, 'l' => 50, 'w' => 12, 'h' => 12],
        
        // STREFA WSCHODNIA (ZIMNA/WODNA)
        'Wybieg lodowy' =>          ['t' => 30, 'l' => 75, 'w' => 20, 'h' => 18], // Pingwiny
        'Oceanarium ryb drapieżnych'=> ['t' => 52, 'l' => 75, 'w' => 20, 'h' => 15],
        'Rafa Koralowa' =>          ['t' => 70, 'l' => 75, 'w' => 20, 'h' => 15],

        // STREFA POŁUDNIOWO-ZACHODNIA (WOLIERY I BUDYNKI)
        'Małpi Gaj' =>              ['t' => 40, 'l' => 5,  'w' => 18, 'h' => 18],
        'Pustynia' =>               ['t' => 62, 'l' => 5,  'w' => 18, 'h' => 15],
        
        // ALEJKA PTAKÓW (DÓŁ ŚRODEK)
        'Papugarnia' =>             ['t' => 60, 'l' => 30, 'w' => 12, 'h' => 12],
        'Dżungla Tukanów' =>        ['t' => 60, 'l' => 45, 'w' => 12, 'h' => 12],
        'Gołębnik Egzotyczny' =>    ['t' => 60, 'l' => 60, 'w' => 12, 'h' => 12],
    ];
@endphp

<div class="bg-zoo-bg py-6 border-b border-green-100">
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold text-zoo-footer flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-zoo-menu">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
            </svg>
            Mapa ZOO
        </h1>
        <p class="text-gray-600 ml-11">Nawiguj po terenie ogrodu. Kliknij wybieg, aby zobaczyć zwierzęta.</p>
    </div>
</div>

<div class="container mx-auto px-0 md:px-6 py-8">
    <div class="w-full overflow-x-auto rounded-3xl shadow-2xl border-4 border-[#3f6212] bg-[#ecfccb]">
        
        <div class="relative w-300 xl:w-full aspect-video bg-[#ecfccb]">

            <div class="absolute inset-0 pointer-events-none opacity-60">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30% 40% Q 50% 30% 70% 45% T 30% 40%" fill="#93c5fd" stroke="#60a5fa" stroke-width="2" />
                    
                    <path d="M50% 100% L 50% 80% Q 50% 50% 30% 50%" stroke="#d6d3d1" stroke-width="20" fill="none" stroke-linecap="round" />
                    <path d="M50% 80% Q 50% 50% 70% 50%" stroke="#d6d3d1" stroke-width="20" fill="none" stroke-linecap="round" />
                    
                    <path d="M20% 50% L 20% 10% L 80% 10% L 80% 50%" stroke="#d6d3d1" stroke-width="12" fill="none" />
                    
                    <rect x="45%" y="95%" width="10%" height="5%" fill="#78350f" />
                    <text x="50%" y="98%" font-size="14" font-weight="bold" fill="white" text-anchor="middle">WEJŚCIE</text>
                </svg>
            </div>

            @foreach($enclosures as $enclosure)
                @php
                    // Pobierz pozycję z konfiguracji lub ustaw domyślną (dla bezpieczeństwa)
                    $pos = $mapPositions[$enclosure->name] ?? ['t' => 80, 'l' => 45, 'w' => 10, 'h' => 10];
                    
                    // Kolory w zależności od typu
                    $colors = match($enclosure->type) {
                        'aquarium', 'pool_enclosure', 'cooled_enclosure' => 'bg-blue-100 border-blue-400 text-blue-800',
                        'aviary' => 'bg-yellow-100 border-yellow-400 text-yellow-800',
                        'indoor_cage' => 'bg-orange-100 border-orange-400 text-orange-800',
                        default => 'bg-green-200 border-green-600 text-green-900', // open_air
                    };

                    // Dane do modala
                    $uniqueSpecies = $enclosure->animals->unique('subspecies_id');
                    $modalData = $enclosure->animals->groupBy('subspecies_id')->map(function($group) {
                        $first = $group->first();
                        return [
                            'common_name' => $first->subspecies->common_name,
                            'scientific_name' => $first->subspecies->scientific_name,
                            'names' => $group->pluck('name')->toArray(),
                            'image' => asset('photos/' . Str::slug($first->subspecies->common_name, '_') . '.png')
                        ];
                    });
                @endphp

                <div onclick="openModal('{{ $enclosure->name }}', {{ json_encode($modalData) }})"
                     class="absolute rounded-xl border-2 shadow-md cursor-pointer hover:scale-105 hover:shadow-xl hover:z-50 transition-all duration-300 flex flex-col items-center justify-center p-2 text-center group {{ $colors }}"
                     style="top: {{ $pos['t'] }}%; left: {{ $pos['l'] }}%; width: {{ $pos['w'] }}%; height: {{ $pos['h'] }}%;">
                    
                    <span class="font-bold text-xs md:text-sm lg:text-base leading-tight">
                        {{ $enclosure->name }}
                    </span>

                    <div class="mt-1 md:mt-2 flex -space-x-2 overflow-hidden py-1">
                        @foreach($uniqueSpecies->take(3) as $animal)
                            <img src="{{ asset('photos/' . Str::slug($animal->subspecies->common_name, '_') . '.png') }}" 
                                 class="inline-block h-6 w-6 md:h-8 md:w-8 rounded-full ring-2 ring-white object-cover bg-white"
                                 title="{{ $animal->subspecies->common_name }}"
                                 onerror="this.style.display='none'">
                        @endforeach
                        @if($uniqueSpecies->count() > 3)
                            <span class="flex items-center justify-center h-6 w-6 md:h-8 md:w-8 rounded-full ring-2 ring-white bg-gray-200 text-[10px] font-bold text-gray-600">
                                +{{ $uniqueSpecies->count() - 3 }}
                            </span>
                        @endif
                    </div>

                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-[10px] px-2 py-0.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                        {{ $enclosure->type }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    
    <div class="mt-6 flex flex-wrap justify-center gap-6 text-sm text-gray-600">
        <div class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-green-200 border border-green-600"></span> Wybieg Otwarty</div>
        <div class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-blue-100 border border-blue-400"></span> Woda / Lód</div>
        <div class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-yellow-100 border border-yellow-400"></span> Ptaszarnia</div>
        <div class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-orange-100 border border-orange-400"></span> Pawilon Zamknięty</div>
    </div>
</div>

<div id="animalModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/60 transition-opacity backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-zoo-menu px-6 py-4 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white" id="modal-title">Nazwa Wybiegu</h3>
                    <button type="button" onclick="closeModal()" class="text-green-100 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto" id="modal-content"></div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end">
                    <button type="button" onclick="closeModal()" class="inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Zamknij</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Skrypt modala (bez zmian logicznych, tylko obsługa)
    const modal = document