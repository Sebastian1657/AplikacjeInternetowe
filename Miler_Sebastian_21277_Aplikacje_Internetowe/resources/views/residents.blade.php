@extends('layouts.app')

@section('content')
<div class="bg-zoo-bg py-12 border-b border-green-100">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-zoo-footer mb-4">Nasi Mieszkańcy</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Poznaj bliżej naszych podopiecznych!
        </p>
    </div>
</div>

<div class="w-full py-12 overflow-x-hidden space-y-12">
    @foreach ($subspecies as $species)
        @php
            $filename = Str::slug($species->common_name, '_') . '.jpg';
            $imagePath = asset('photos/' . $filename);
        @endphp

        <div class="relative w-full md:w-[85%] lg:w-[75%] h-64 md:h-72 
            {{ $loop->odd ? 'mr-auto rounded-r-full pr-8' : 'ml-auto rounded-l-full pl-8 flex-row-reverse' }} 
            flex items-center bg-white shadow-lg border-y border-green-100 group hover:bg-green-50 transition-colors duration-300">
            
            <div class="absolute inset-y-0 w-2 bg-zoo-menu 
                {{ $loop->odd ? 'left-0' : 'right-0' }}">
            </div>

            <div class="shrink-0 w-48 h-48 md:w-56 md:h-56 overflow-hidden rounded-full border-4 border-white shadow-md mx-4 md:mx-8 bg-gray-200">
                <img src="{{ $imagePath }}" 
                     alt="{{ $species->common_name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     onerror="this.src='https://placehold.co/400x400/e2e8f0/16a34a?text=Brak+Zdjęcia'"> 
                     </div>

            <div class="flex flex-col justify-center grow py-4 
                {{ $loop->odd ? 'text-left items-start' : 'text-right items-end' }}">
                
                <h2 class="text-3xl md:text-4xl font-bold text-zoo-text mb-1 group-hover:text-zoo-menu transition-colors">
                    {{ $species->common_name }}
                </h2>
                
                <span class="text-lg md:text-xl text-gray-500 italic font-serif mb-4 border-b border-green-200 pb-1 inline-block">
                    {{ $species->scientific_name }}
                </span>

                <div class="flex items-center gap-2 text-zoo-footer font-medium bg-green-100/50 px-4 py-2 rounded-full">
                    <span>
                        Liczba osobników: 
                        <span class="text-xl font-bold ml-1">{{ $species->animals_count }}</span>
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="container mx-auto px-6 py-8 pb-16">
    {{ $subspecies->links() }}
</div>
@endsection