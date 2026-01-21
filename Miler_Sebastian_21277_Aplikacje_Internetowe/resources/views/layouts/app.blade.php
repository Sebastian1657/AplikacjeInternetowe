<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System ZOO</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zoo-bg text-zoo-text font-sans antialiased flex flex-col min-h-screen">
    <x-preloader />

    <header class="bg-white shadow-sm sticky top-0 z-100 h-16 flex items-center px-4 justify-between border-b border-green-100">
        <div class="flex items-center gap-4">
            <button id="menu-toggle" class="p-2 rounded-md hover:bg-green-50 text-zoo-menu cursor-pointer transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            
            <div class="text-2xl font-bold tracking-wider text-zoo-menu">
                <a href="/">
                    🦁 ZOO <span class="text-gray-400 text-sm font-normal">System</span>
                </a>
            </div>
        </div>

        <div class="text-sm text-gray-500 hidden sm:block">
            {{ now()->format('d.m.Y') }}
        </div>
    </header>

    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity opacity-0"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-zoo-menu text-white transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
        
        <div class="h-16 flex items-center justify-between px-6 border-b border-green-600/50">
            <span class="font-bold text-lg">Nawigacja</span>
            <button id="menu-close" class="hover:bg-green-700/50 p-1 rounded cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('tickets.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-600/50 rounded-lg text-green-100 transition-colors group {{ request()->routeIs('tickets.index') ? 'bg-green-700/50 text-white' : '' }}"}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 group-hover:scale-110 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v4.086c0 .705.328 1.374.887 1.81.559.435.887 1.105.887 1.81v4.086c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-4.086c0-.705.328-1.374.887-1.81.559-.435.887-1.105.887-1.81V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
                Kup Bilet
            </a>
            
            <a href="{{ route('map') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-600/50 rounded-lg text-green-100 transition-colors group {{ request()->routeIs('map') ? 'bg-green-700/50 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 group-hover:scale-110 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                </svg>
                Mapa ZOO
            </a>

            <a href="{{ route('residents') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-600/50 rounded-lg text-green-100 transition-colors group {{ request()->routeIs('residents') ? 'bg-green-700/50 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 group-hover:scale-110 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                </svg>
                Nasi Mieszkańcy
            </a>

            @auth
                @can('is-employee')
                <a href="{{ route('schedule.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 transition-colors group {{ request()->routeIs('schedule.*') ? 'bg-green-700/50 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 group-hover:scale-110 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Mój Grafik
                </a>
                @endcan
                
                @can('is-manager')
                <a href="{{ route('schedule.manager') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-600/50 rounded-lg text-green-100 transition-colors group {{ request()->routeIs('schedule.manager') ? 'bg-green-700/50 text-white' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 group-hover:scale-110 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Zarządzanie Grafikami
                </a>
                @endcan
                
                <div class="border-t border-green-600/30 my-2 mx-4"></div>
            @endauth

            <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-green-600/50 rounded-lg text-green-100 transition-colors group {{ request()->routeIs('contact') ? 'bg-green-700/50 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 group-hover:scale-110 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                Kontakt
            </a>
        </nav>
        <div class="p-4 border-t border-green-600/50 bg-green-800/30">
            @auth
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold tracking-widest border border-green-400/30 shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}{{ substr(Auth::user()->last_name ?? '', 0, 1) }}
                    </div>
                    
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-semibold truncate text-white" title="{{ Auth::user()->name }} {{ Auth::user()->last_name }}">
                            {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                        </span>
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-green-200 hover:text-white transition-colors flex items-center gap-1 mt-0.5 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                </svg>
                                Wyloguj
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </aside>

    <main class="grow w-full">
        @yield('content')
    </main>

    <footer class="bg-zoo-footer text-green-100/60 py-4 text-center text-sm mt-auto">
        &copy; {{ date('Y') }} Sebastian Miler 21277 - Projekt Aplikacje Internetowe - ZOO
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggleBtn = document.getElementById('menu-toggle');
            const closeBtn = document.getElementById('menu-close');

            function toggleMenu() {
                const isClosed = sidebar.classList.contains('-translate-x-full');
                if (isClosed) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                    setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('opacity-0');
                    setTimeout(() => backdrop.classList.add('hidden'), 300);
                }
            }

            toggleBtn.addEventListener('click', toggleMenu);
            closeBtn.addEventListener('click', toggleMenu);
            backdrop.addEventListener('click', toggleMenu);
        });
    </script>
</body>
</html>