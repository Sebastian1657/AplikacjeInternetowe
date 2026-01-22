<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Płatność - System ZOO</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white max-w-md w-full rounded-xl shadow-2xl p-8 text-center border-t-8 border-zoo-menu">
        
        <div class="w-20 h-20 bg-green-100 text-zoo-menu rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Bramka Płatności</h1>
        <p class="text-gray-500 mb-8">Placeholder na pośrednika sprzedaży</p>

        <div class="bg-gray-50 rounded-lg p-4 mb-8 text-left text-sm border border-gray-200">
            <p class="flex justify-between mb-1">
                <span class="text-gray-500">Email:</span>
                <span class="font-medium text-gray-800">{{ $data['email'] ?? 'brak' }}</span>
            </p>
            <p class="flex justify-between">
                <span class="text-gray-500">Data wizyty:</span>
                <span class="font-medium text-gray-800">{{ $data['visit_date'] ?? 'brak' }}</span>
            </p>
        </div>

        <form action="{{ route('tickets.finalize') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <input type="hidden" name="email" value="{{ $data['email'] }}">
            <input type="hidden" name="visit_date" value="{{ $data['visit_date'] }}">
            @foreach($data['tickets'] as $key => $val)
                <input type="hidden" name="tickets[{{ $key }}]" value="{{ $val }}">
            @endforeach

            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition-colors cursor-pointer flex items-center justify-center gap-2">
                <span>Zapłać i Pobierz Bilet (PDF)</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </button>
        </form>
    </div>

</body>
</html>