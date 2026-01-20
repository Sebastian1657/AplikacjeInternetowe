@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-green-100">
        <div>
            <h1 class="text-3xl font-bold text-zoo-footer">Mój Grafik</h1>
            <p class="text-gray-500">Plan pracy na <span class="text-zoo-menu font-semibold capitalize">{{ $date->translatedFormat('F Y') }}</span></p>
        </div>

        <div class="flex items-center gap-4 mt-4 md:mt-0">
            <a href="{{ route('schedule.index', ['month' => $prevMonth]) }}" class="p-2 rounded-full hover:bg-green-50 text-zoo-text transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
            
            <span class="text-xl font-bold min-w-150px text-center capitalize">{{ $date->translatedFormat('F Y') }}</span>
            
            <a href="{{ route('schedule.index', ['month' => $nextMonth]) }}" class="p-2 rounded-full hover:bg-green-50 text-zoo-text transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-green-200 overflow-hidden">
        
        <div class="grid grid-cols-7 bg-zoo-footer text-white text-center py-3 font-semibold text-sm uppercase tracking-wide">
            <div class="py-2">Pon</div>
            <div class="py-2">Wt</div>
            <div class="py-2">Śr</div>
            <div class="py-2">Czw</div>
            <div class="py-2">Pt</div>
            <div class="py-2 text-green-300">Sob</div>
            <div class="py-2 text-green-300">Nd</div>
        </div>

        <div class="grid grid-cols-7 border-l border-t border-gray-200">

            @for ($i = 1; $i < $startDayOfWeek; $i++)
                <div class="h-32 md:h-40 bg-gray-50/50 border-r border-b border-gray-200"></div>
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $dayCares = $cares->get($day);
                    $isToday = $day == now()->day && $date->isCurrentMonth();
                    $hasWork = $dayCares && $dayCares->count() > 0;
                @endphp

                <div class="relative h-32 md:h-40 border-r border-b border-gray-200 p-2 transition-colors hover:bg-green-50/30 flex flex-col gap-1 overflow-y-auto group
                    {{ $hasWork ? 'bg-green-50' : 'bg-white' }}">
                    
                    <span class="absolute top-2 right-3 text-sm font-bold 
                        {{ $isToday ? 'bg-zoo-menu text-white w-7 h-7 flex items-center justify-center rounded-full shadow-md' : 'text-gray-400' }}">
                        {{ $day }}
                    </span>

                    @if($hasWork)
                        <div class="mt-6 flex flex-col gap-2">
                            @foreach($dayCares as $care)
                                @php
                                    $shiftLabel = match($care->shift) {
                                        1 => 'I Zmiana',
                                        2 => 'II Zmiana',
                                        3 => 'III Zmiana',
                                        default => $care->shift
                                    };
                                    
                                    $shiftColor = match($care->shift) {
                                        1 => 'bg-yellow-300 text-yellow-800 border-yellow-500',
                                        2 => 'bg-orange-300 text-orange-800 border-orange-500',
                                        3 => 'bg-indigo-300 text-indigo-800 border-indigo-500',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp

                                <div class="flex flex-col rounded-lg border px-2 py-1.5 shadow-sm bg-white text-xs hover:scale-[1.02] transition-transform cursor-default relative overflow-hidden">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 {{ str_replace(['bg-', 'text-', 'border-'], 'bg-', $shiftColor) }}"></div>
                                    
                                    <span class="pl-2 font-bold text-gray-700 truncate">
                                        {{ $care->subspecies->common_name }}
                                    </span>
                                    <span class="pl-2 text-[10px] text-gray-500 uppercase tracking-wider">
                                        {{ $shiftLabel }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endfor

            @php
                $remainingCells = (7 - (($startDayOfWeek - 1 + $daysInMonth) % 7)) % 7;
            @endphp
            @for ($i = 0; $i < $remainingCells; $i++)
                <div class="h-32 md:h-40 bg-gray-50/50 border-r border-b border-gray-200"></div>
            @endfor

        </div>
    </div>
</div>
@endsection