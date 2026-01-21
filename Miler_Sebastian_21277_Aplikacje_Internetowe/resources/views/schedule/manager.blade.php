@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-green-100">
        <div>
            <h1 class="text-3xl font-bold text-zoo-footer">Grafik Całego Zespołu</h1>
            <p class="text-gray-500">Zarządzanie grafikiem pracy opiekunów.</p>
        </div>

        <div class="flex items-center gap-4 mt-4 md:mt-0">
            <a href="{{ route('schedule.manager', ['week' => $prevWeek]) }}" class="p-2 rounded-full hover:bg-green-50 text-zoo-text transition-colors border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
            
            <div class="text-center px-4">
                <span class="block text-xs text-gray-400 uppercase tracking-wider">Wybrany Tydzień</span>
                <span class="text-lg font-bold text-zoo-menu">
                    {{ $weekDates[0]->format('d.m') }} - {{ $weekDates[6]->format('d.m.Y') }}
                </span>
            </div>
            
            <a href="{{ route('schedule.manager', ['week' => $nextWeek]) }}" class="p-2 rounded-full hover:bg-green-50 text-zoo-text transition-colors border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-green-200 overflow-hidden overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-1000px">
            <thead>
                <tr class="bg-zoo-footer text-white">
                    <th class="p-4 w-48 sticky left-0 bg-zoo-footer z-10 border-r border-green-800">Pracownik</th>
                    @foreach($weekDates as $day)
                        <th class="p-3 text-center border-l border-green-800/30 min-w-140px relative group">
                            <span class="block text-xs opacity-70 uppercase">{{ $day->translatedFormat('D') }}</span>
                            <span class="block font-bold text-lg">{{ $day->format('d.m') }}</span>
                            
                            <button onclick="openDayEditor('{{ $day->format('Y-m-d') }}')" 
                                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-1 bg-green-700 hover:bg-green-600 rounded text-white cursor-pointer"
                                    title="Edytuj ten dzień">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                    <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                </svg>
                            </button>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($employees as $employee)
                    <tr class="hover:bg-green-50/30 transition-colors">
                        <td class="p-4 sticky left-0 bg-white border-r border-gray-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.1)] z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-zoo-menu flex items-center justify-center text-xs font-bold">
                                    {{ substr($employee->name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm leading-tight">
                                        {{ $employee->last_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $employee->name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        @foreach($weekDates as $day)
                            @php
                                $dateKey = $day->format('Y-m-d');
                                $shifts = $schedule[$employee->id][$dateKey] ?? collect();
                                $shifts = $shifts->sortBy('shift');
                            @endphp

                            <td class="p-2 border-l border-gray-100 align-top h-24">
                                <div class="flex flex-col gap-1.5 h-full">
                                    @if($shifts->isEmpty())
                                        <div class="flex-1 flex items-center justify-center">
                                            <span class="text-gray-300 text-lg select-none">-</span>
                                        </div>
                                    @else
                                        @foreach($shifts as $care)
                                            @php
                                                $shiftColor = match($care->shift) {
                                                    1 => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    2 => 'bg-orange-100 text-orange-800 border-orange-200',
                                                    3 => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                                
                                                $shiftName = match($care->shift) {
                                                    1 => 'I',
                                                    2 => 'II',
                                                    3 => 'III',
                                                    default => '?'
                                                };
                                            @endphp
                                            
                                            <div class="flex items-center justify-between px-2 py-1 rounded border text-[10px] {{ $shiftColor }} shadow-sm">
                                                <span class="font-bold mr-1 truncate max-w-80px" title="{{ $care->subspecies->common_name }}">
                                                    {{ $care->subspecies->common_name }}
                                                </span>
                                                <span class="font-mono opacity-70 font-bold">{{ $shiftName }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<div id="dayEditorModal" class="fixed inset-0 z-200 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">
                
                <div class="bg-zoo-footer px-6 py-4 flex justify-between items-center border-b border-green-800">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-zoo-menu">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            Edycja Grafiku: <span id="editorDateDisplay" class="ml-2 font-mono text-green-300">...</span>
                        </h3>
                    </div>
                    
                    <div id="errorCounter" class="bg-red-500/20 text-red-200 px-3 py-1 rounded-full text-xs font-bold border border-red-500/50 hidden">
                        Nieobsadzone: <span id="unassignedCount">0</span>
                    </div>
                </div>

                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto bg-gray-50">
                    <div id="editorLoader" class="flex justify-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-zoo-menu"></div>
                    </div>

                    <form id="scheduleForm" class="hidden">
                        <table class="w-full text-sm border-collapse bg-white rounded-lg shadow-sm overflow-hidden">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="py-3 px-4 text-left w-1/4">Gatunek</th>
                                    <th class="py-3 px-2 text-center w-1/4">I Zmiana (Rano)</th>
                                    <th class="py-3 px-2 text-center w-1/4">II Zmiana (Popołudnie)</th>
                                    <th class="py-3 px-2 text-center w-1/4">III Zmiana (Noc)</th>
                                </tr>
                            </thead>
                            <tbody id="editorTableBody" class="divide-y divide-gray-100">
                                </tbody>
                        </table>
                    </form>
                </div>
                
                <div class="bg-white px-6 py-4 flex justify-between items-center border-t border-gray-100">
                    <button type="button" onclick="closeEditor()" class="text-gray-500 hover:text-gray-800 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                        Anuluj
                    </button>
                    <button type="button" onclick="saveSchedule()" id="saveBtn" class="bg-zoo-menu hover:bg-green-700 text-white font-bold py-2 px-8 rounded-lg shadow-md transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span>Zapisz Zmiany</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentEmployees = [];
    let currentDate = '';

    function openDayEditor(date) {
        currentDate = date;
        document.getElementById('editorDateDisplay').innerText = date;
        document.getElementById('dayEditorModal').classList.remove('hidden');
        document.getElementById('editorLoader').classList.remove('hidden');
        document.getElementById('scheduleForm').classList.add('hidden');

        fetch(`/api/schedule/day/${date}`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                currentEmployees = data.employees;
                renderEditorTable(data.subspecies, data.assignments);
                document.getElementById('editorLoader').classList.add('hidden');
                document.getElementById('scheduleForm').classList.remove('hidden');
                validateSchedule();
            })
            .catch(error => {
                console.error('Błąd pobierania danych:', error);
                alert('Wystąpił błąd podczas pobierania danych. Sprawdź konsolę.');
                closeEditor();
            });
    }

    function renderEditorTable(subspecies, assignments) {
        const tbody = document.getElementById('editorTableBody');
        tbody.innerHTML = '';

        subspecies.forEach(species => {
            const tr = document.createElement('tr');
            tr.className = "hover:bg-gray-50 transition-colors";
            tr.innerHTML = `<td class="py-3 px-4 font-bold text-gray-800 border-r border-gray-100">${species.common_name}</td>`;

            [1, 2, 3].forEach(shift => {
                const assigned = assignments.find(a => a.subspecies_id == species.id && a.shift == shift);
                const userId = assigned ? assigned.user_id : '';

                const td = document.createElement('td');
                td.className = "p-2 text-center";

                let selectClass = userId 
                    ? 'border-gray-300 bg-white text-gray-800 border-l-4 border-l-green-500' 
                    : 'border-red-300 bg-red-50 text-red-700';

                let selectHtml = `
                    <select name="shift_${species.id}_${shift}" 
                            class="schedule-select w-full border rounded px-2 py-1.5 text-xs focus:ring-2 focus:ring-zoo-menu outline-none transition-all cursor-pointer ${selectClass}"
                            onchange="handleSelectChange(this)">
                        <option value="" class="text-gray-400">- Wybierz -</option>
                `;

                currentEmployees.forEach(employee => {
                    const selected = employee.id == userId ? 'selected' : '';
                    const name = employee.name+' '+employee.last_name;
                    selectHtml += `<option value="${employee.id}" ${selected}>${name}</option>`
                });

                selectHtml += `</select>`;
                td.innerHTML = selectHtml;
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });
    }

    function handleSelectChange(select) {
        if (select.value) {
            select.classList.remove('border-red-300', 'bg-red-50', 'text-red-700');
            select.classList.add('border-gray-300', 'bg-white', 'text-gray-800', 'border-l-4', 'border-l-green-500');
        } else {
            select.classList.add('border-red-300', 'bg-red-50', 'text-red-700');
            select.classList.remove('border-gray-300', 'bg-white', 'text-gray-800', 'border-l-4', 'border-l-green-500');
        }
        
        validateSchedule();
    }

    function validateSchedule() {
        const selects = document.querySelectorAll('.schedule-select');
        let emptyCount = 0;
        
        selects.forEach(s => {
            if (!s.value) emptyCount++;
        });

        const counter = document.getElementById('unassignedCount');
        const counterBox = document.getElementById('errorCounter');
        
        if(counter) counter.innerText = emptyCount;
        
        if (emptyCount > 0) {
            counterBox.classList.remove('hidden');
            counterBox.classList.add('flex');
        } else {
            counterBox.classList.add('hidden');
            counterBox.classList.remove('flex');
        }
    }

    function saveSchedule() {
        const selects = document.querySelectorAll('.schedule-select');
        const shifts = [];

        selects.forEach(s => {
            const parts = s.name.split('_');
            const subspeciesId = parts[1];
            const shiftNum = parts[2];
            
            if (s.value) {
                shifts.push({
                    subspecies_id: subspeciesId,
                    shift: shiftNum, // debug
                    user_id: s.value
                });
            }
        });

        const btn = document.getElementById('saveBtn');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>Zapisywanie...</span>';

        fetch('/api/schedule/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                date: currentDate,
                shifts: shifts
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Błąd zapisu');
            return res.json();
        })
        .then(data => {
            window.location.reload();
        })
        .catch(err => {
            alert('Wystąpił błąd podczas zapisywania.');
            console.error(err);
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    function closeEditor() {
        document.getElementById('dayEditorModal').classList.add('hidden');
    }
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeEditor();
    });
</script>

@endsection