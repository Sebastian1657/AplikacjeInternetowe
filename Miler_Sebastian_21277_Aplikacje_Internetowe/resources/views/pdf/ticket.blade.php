<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bilet ZOO</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; } /* DejaVu obsługuje polskie znaki w PDF */
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #16a34a; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">🦁 ZOO Wrocław</div>
        <p>Potwierdzenie Rezerwacji</p>
    </div>

    <p><strong>Data wizyty:</strong> {{ $data['visit_date'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>

    <table>
        <thead>
            <tr>
                <th>Rodzaj biletu</th>
                <th>Ilość</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['tickets'] as $type => $qty)
                @if($qty > 0)
                <tr>
                    <td>
                        {{-- Proste mapowanie nazw, można to przenieść do modelu --}}
                        @switch($type)
                            @case('normal') Bilet Normalny @break
                            @case('student') Ulgowy (Student/Uczeń) @break
                            @case('child') Dziecko do 3 lat @break
                            @case('senior') Emeryt @break
                            @case('disabled') Os. Niepełnosprawna @break
                            @case('group') Grupa zorganizowana @break
                            @default {{ $type }}
                        @endswitch
                    </td>
                    <td>{{ $qty }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dziękujemy za zakup! Prosimy o okazanie tego dokumentu przy wejściu.<br>
        Wygenerowano automatycznie: {{ date('Y-m-d H:i') }}
    </div>
</body>
</html>