<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie - System ZOO</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-900 antialiased h-screen overflow-hidden flex relative">

    <div class="absolute top-4 right-4 z-50 flex items-center gap-2">
        <div class="hidden md:flex items-center bg-white/90 backdrop-blur rounded-lg p-1 border border-gray-200 shadow-sm" role="group" aria-label="Zmień rozmiar tekstu">
            <button id="font-decrease" type="button" class="px-3 py-1 text-sm font-bold text-gray-700 hover:bg-gray-100 rounded transition-colors" title="Mniejszy tekst" aria-label="Zmniejsz tekst">-A</button>
            <button id="font-reset" type="button" class="px-3 py-1 text-sm font-bold text-gray-700 hover:bg-gray-100 rounded border-x border-gray-200 transition-colors" title="Domyślny tekst" aria-label="Przywróć domyślny rozmiar tekstu">A</button>
            <button id="font-increase" type="button" class="px-3 py-1 text-lg font-bold text-gray-700 hover:bg-gray-100 rounded transition-colors" title="Większy tekst" aria-label="Powiększ tekst">+A</button>
        </div>

        <button id="contrast-toggle" type="button" class="p-2 bg-white/90 backdrop-blur rounded-full hover:bg-gray-100 text-gray-600 shadow-sm border border-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-zoo-menu" title="Przełącz wysoki kontrast" aria-label="Przełącz wysoki kontrast" aria-pressed="false">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
        </button>
    </div>

    <div class="hidden lg:flex w-1/2 relative bg-gray-900 items-center justify-center overflow-hidden">
        <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?q=80&w=2059&auto=format&fit=crop" 
             alt="Zdjęcie przedstawiające lwa" 
             class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-linear-to-t from-zoo-footer/90 to-transparent"></div>
    </div>

    <div class="w-full lg:w-1/2 h-full flex items-center justify-center p-8 bg-zoo-bg/30 overflow-y-auto">
        <div class="max-w-md w-full">
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-zoo-menu mb-4 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-zoo-footer">Panel Pracownika</h1>
                <p class="text-gray-500 mt-2">Zaloguj się, aby uzyskać dostęp.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm border border-red-200">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adres Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" required autocomplete="email" placeholder="jan.kowalski@zoo.pl" value="{{ old('email') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-zoo-menu focus:border-zoo-menu transition-colors outline-none text-gray-800 placeholder-gray-400 shadow-sm">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Hasło</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-zoo-menu focus:border-zoo-menu transition-colors outline-none text-gray-800 placeholder-gray-400 shadow-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" 
                            class="h-4 w-4 text-zoo-menu focus:ring-zoo-menu border-gray-300 rounded cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                            Zapamiętaj mnie
                        </label>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-zoo-menu hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-[1.02]">
                    Zaloguj się
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-zoo-text flex items-center justify-center gap-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Wróć do strony głównej
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const contrastBtn = document.getElementById('contrast-toggle');
            
            if (localStorage.getItem('high-contrast') === 'true') {
                body.classList.add('high-contrast');
                if(contrastBtn) {
                    contrastBtn.setAttribute('aria-pressed', 'true');
                    contrastBtn.classList.add('bg-gray-200', 'text-black');
                }
            }

            if(contrastBtn) {
                contrastBtn.addEventListener('click', () => {
                    if (body.classList.contains('high-contrast')) {
                        body.classList.remove('high-contrast');
                        contrastBtn.setAttribute('aria-pressed', 'false');
                        contrastBtn.classList.remove('bg-gray-200', 'text-black');
                        localStorage.setItem('high-contrast', 'false');
                    } else {
                        body.classList.add('high-contrast');
                        contrastBtn.setAttribute('aria-pressed', 'true');
                        contrastBtn.classList.add('bg-gray-200', 'text-black');
                        localStorage.setItem('high-contrast', 'true');
                    }
                });
            }

            const htmlRoot = document.documentElement;
            const btnDecrease = document.getElementById('font-decrease');
            const btnReset = document.getElementById('font-reset');
            const btnIncrease = document.getElementById('font-increase');
            
            let currentSize = parseInt(localStorage.getItem('font-size-percent')) || 100;
            
            function setSize(size) {
                if (size < 80) size = 80;
                if (size > 150) size = 150;
                
                htmlRoot.style.fontSize = `${size}%`;
                localStorage.setItem('font-size-percent', size);
                currentSize = size;
            }
            
            setSize(currentSize);

            if(btnDecrease) btnDecrease.addEventListener('click', () => setSize(currentSize - 10));
            if(btnReset) btnReset.addEventListener('click', () => setSize(100));
            if(btnIncrease) btnIncrease.addEventListener('click', () => setSize(currentSize + 10));
        });
    </script>
</body>
</html>