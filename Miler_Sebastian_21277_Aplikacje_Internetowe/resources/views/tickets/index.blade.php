@extends('layouts.app')

@section('content')
<div class="bg-zoo-bg py-12 border-b border-green-100">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-zoo-footer mb-4">Kup Bilet</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Zaplanuj swoją wizytę już dziś. Wybierz dogodny termin i rodzaj biletów.
        </p>
    </div>
</div>

<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden border border-green-100">
        
        <form action="{{ route('tickets.checkout') }}" method="POST" target="_blank" class="p-8 md:p-12">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                
                <div>
                    <label for="visit_date" class="block text-sm font-semibold text-gray-700 mb-2">Data wizyty</label>
                    <input type="date" 
                           name="visit_date" 
                           id="visit_date" 
                           required
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-zoo-menu focus:ring-2 focus:ring-green-200 outline-none transition-all cursor-pointer">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adres Email (do wysyłki biletów)</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           required
                           placeholder="jan.kowalski@example.com"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-zoo-menu focus:ring-2 focus:ring-green-200 outline-none transition-all">
                </div>
            </div>

            <h3 class="text-xl font-bold text-zoo-text mb-6 border-b border-gray-100 pb-2">Rodzaj i ilość biletów</h3>
            
            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 text-sm uppercase tracking-wider">
                            <th class="py-4">Rodzaj Biletu</th>
                            <th class="py-4 text-right">Cena</th>
                            <th class="py-4 text-right w-32">Ilość</th>
                            <th class="py-4 text-right w-32">Suma</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($ticketTypes as $ticket)
                        <tr class="hover:bg-green-50/50 transition-colors group">
                            <td class="py-4 pr-4">
                                <div class="font-semibold text-gray-800">{{ $ticket['name'] }}</div>
                            </td>
                            <td class="py-4 text-right text-gray-600 font-mono">
                                {{ $ticket['price'] }} zł
                            </td>
                            <td class="py-4 text-right">
                                <input type="number" 
                                       name="tickets[{{ $ticket['id'] }}]" 
                                       min="0" 
                                       value="0" 
                                       data-price="{{ $ticket['price'] }}"
                                       class="ticket-qty w-20 px-3 py-2 text-right rounded border border-gray-300 focus:border-zoo-menu focus:ring-2 focus:ring-green-200 outline-none transition-all"
                                >
                            </td>
                            <td class="py-4 text-right font-bold text-zoo-menu w-32">
                                <span class="row-sum">0</span> zł
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-8 border-t border-gray-100 bg-gray-50 -mx-8 -mb-12 p-8">
                <div class="text-center md:text-left">
                    <span class="block text-sm text-gray-500 uppercase tracking-wide">Łącznie do zapłaty</span>
                    <span class="text-4xl font-bold text-zoo-footer" id="total-price">0</span>
                    <span class="text-2xl text-zoo-footer font-semibold">zł</span>
                </div>
                
                <button type="submit" class="w-full md:w-auto px-10 py-4 bg-zoo-menu hover:bg-green-700 text-white text-lg font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    Kupuję bilety
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.ticket-qty');
        const totalDisplay = document.getElementById('total-price');

        function calculateTotal() {
            let total = 0;
            inputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price);
                const rowSum = qty * price;
                
                const rowDisplay = input.closest('tr').querySelector('.row-sum');
                rowDisplay.textContent = rowSum;

                total += rowSum;
            });
            totalDisplay.textContent = total;
        }

        inputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500', 'focus:border-red-500', 'ring-red-200');
            });
        });

        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            const groupInput = document.querySelector('input[name="tickets[group]"]');
            
            if (groupInput) {
                const qty = parseInt(groupInput.value) || 0;

                if (qty > 0 && qty < 10) {
                    e.preventDefault();

                    alert('⚠️ Błąd: Dla biletów "Grupa zorganizowana" minimalna liczba osób to 10');
                    
                    groupInput.classList.add('border-red-500', 'focus:border-red-500', 'ring-red-200');
                    groupInput.focus();
                }
            }
        });
    });
</script>
@endsection