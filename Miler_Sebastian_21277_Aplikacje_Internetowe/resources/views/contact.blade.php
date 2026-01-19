@extends('layouts.app')

@section('content')
<div class="bg-zoo-bg py-12 border-b border-green-100">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-zoo-footer mb-4">Skontaktuj się z nami</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Masz pytania dotyczące biletów, godzin otwarcia lub naszych podopiecznych? 
            Jesteśmy tutaj, aby Ci pomóc.
        </p>
    </div>
</div>

<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <div class="space-y-8">
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-green-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 right-0 w-24 h-24 bg-zoo-menu/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <h3 class="text-2xl font-bold text-zoo-menu mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    Adres ZOO
                </h3>
                <address class="not-italic text-gray-600 text-lg leading-relaxed">
                    <strong>Wrocławski Ogród Zoologiczny</strong><br>
                    ul. Zygmunta Wróblewskiego 1-5<br>
                    51-618 Wrocław<br>
                    Polska
                </address>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-green-100 relative overflow-hidden hover:shadow-md transition-shadow">
                <h3 class="text-2xl font-bold text-zoo-menu mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    Telefony i Email
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-gray-500">Sekretariat (8:00 - 16:00)</span>
                        <a href="tel:+48710000001" class="font-semibold text-zoo-text hover:text-zoo-menu transition-colors">+48 123 456 787</a>
                    </div>
                    
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-gray-500">Kasa Biletowa</span>
                        <a href="tel:+48710000002" class="font-semibold text-zoo-text hover:text-zoo-menu transition-colors">+48 123 456 788</a>
                    </div>

                    <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="text-gray-500">Fax</span>
                        <span class="font-semibold text-gray-700">+48 123 456 789</span>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-500">Email</span>
                        <a href="mailto:kontakt@zoo.wroclaw.pl" class="font-semibold text-zoo-menu hover:text-green-700 transition-colors">kontakt@zoo.wroclaw.pl</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="h-full min-h-100 bg-white p-2 rounded-2xl shadow-sm border border-green-100">
            <iframe 
                src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=Zoo wrocław&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" 
                class="w-full h-full rounded-xl grayscale-20 hover:grayscale-0 transition-all duration-500" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
@endsection
