@extends('layouts.app')

@section('content')
<div class="relative w-full h-[calc(100vh-4rem)] overflow-hidden bg-black">
    
    <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-60">
        <source src="{{ asset('videos/' . $randomVideo) }}" type="video/mp4">
        Twoja przeglądarka nie obsługuje wideo.
    </video>

    <div class="absolute inset-0 bg-linear-to-t from-zoo-footer/90 via-zoo-footer/20 to-transparent"></div>

    <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4">
        
        <h1 class="text-5xl md:text-7xl font-bold text-white mb-4 tracking-tight drop-shadow-lg">
            Witaj w ZOO
        </h1>
        <p class="text-xl md:text-2xl text-green-100 max-w-2xl drop-shadow-md">
            Odkryj fascynujący świat dzikiej przyrody w sercu miasta.
        </p>

        <div class="mt-8 flex gap-4">
            <a href="{{ route('tickets.index') }}" class="px-8 py-3 bg-zoo-menu hover:bg-green-500 text-white font-semibold rounded-full transition-all shadow-lg hover:scale-105">
                Kup Bilet
            </a>
            <a href="{{ route('map') }}" class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-semibold rounded-full transition-all hover:scale-105">
                Zobacz Mapę
            </a>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 z-20 border-t border-white/10 bg-white/5 backdrop-blur-lg">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-white">
                
                <div class="flex flex-col items-center">
                    <span class="text-4xl font-bold text-zoo-menu mb-1">{{ $speciesCount }}</span>
                    <span class="text-sm uppercase tracking-widest text-green-100/80">Unikalnych Gatunków</span>
                </div>

                <div class="flex flex-col items-center md:border-l md:border-r border-white/10">
                    <span class="text-4xl font-bold text-zoo-menu mb-1">{{ $animalsCount }}</span>
                    <span class="text-sm uppercase tracking-widest text-green-100/80">Szczęśliwych Zwierząt</span>
                </div>

                <div class="flex flex-col items-center">
                    <span class="text-4xl font-bold text-zoo-menu mb-1">{{ $yearsOfOperation }}</span>
                    <span class="text-sm uppercase tracking-widest text-green-100/80">Lat z Wami</span>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container mx-auto px-6 py-16">
    <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold text-zoo-footer mb-4">Dlaczego warto nas odwiedzić?</h2>
        <p class="text-gray-600">
            Jesteśmy domem dla rzadkich gatunków i liderem w programach ochrony przyrody.
            Każdy bilet wspiera nasze działania na rzecz zwierząt.
        </p>
    </div>
</div>
@endsection