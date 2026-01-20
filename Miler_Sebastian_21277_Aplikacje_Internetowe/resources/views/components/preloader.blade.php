<div id="page-loader" class="fixed inset-0 z-9999 bg-zoo-bg flex flex-col items-center justify-center transition-opacity duration-700 ease-in-out">
    
    <div class="relative mb-4">
        <div class="absolute inset-0 bg-green-200 rounded-full animate-ping opacity-75"></div>
        <div class="relative bg-white p-4 rounded-full shadow-lg border-2 border-zoo-menu">
            <span class="text-4xl">🦁</span>
        </div>
    </div>

    <div class="w-48 h-2 bg-green-200 rounded-full overflow-hidden relative mt-2">
        <div class="absolute top-0 left-0 h-full bg-zoo-menu animate-[loading_1.5s_ease-in-out_infinite] w-1/2 rounded-full"></div>
    </div>

    <p class="mt-4 text-zoo-menu font-semibold tracking-widest text-sm animate-pulse">
        ŁADOWANIE ZOO...
    </p>
</div>

<style>
    body.loading { overflow: hidden; }
    
    @keyframes loading {
        0% { left: -50%; }
        50% { left: 100%; }
        100% { left: -50%; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.body.classList.add('loading');
    });

    window.addEventListener('load', function() {
        const loader = document.getElementById('page-loader');
        
        setTimeout(() => {
            loader.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('loading');

            setTimeout(() => {
                loader.remove();
            }, 700);
            
        }, 500); 
    });
</script>