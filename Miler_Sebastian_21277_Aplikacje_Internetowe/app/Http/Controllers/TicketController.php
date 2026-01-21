<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    private function GetTicketTypes(){
        return [
            ['id' => 'normal', 'name' => 'Bilet Normalny', 'price' => 60],
            ['id' => 'student', 'name' => 'Ulgowy (Uczeń / Student)', 'price' => 40],
            ['id' => 'child', 'name' => 'Dziecko do 3 r.ż.', 'price' => 0],
            ['id' => 'senior', 'name' => 'Emeryt', 'price' => 30],
            ['id' => 'disabled', 'name' => 'Os. Niepełnosprawna', 'price' => 30],
            ['id' => 'group', 'name' => 'Grupa zorganizowana (min. 10 osób)', 'price' => 25],
        ];
    }
    public function index()
    {
        $ticketTypes = $this->GetTicketTypes();
        return view('tickets.index', compact('ticketTypes'));
    }

    public function checkout(Request $request){
        $data = $request->all();
        
        $groupTickets = intval($data['tickets']['group'] ?? 0);
        if ($groupTickets > 0 && $groupTickets < 10) {
            abort(400, 'Błąd: Grupa zorganizowana musi liczyć minimum 10 osób.');
        }

        return view('tickets.payment', compact('data'));
    }

    public function finalize(Request $request){
        $data = $request->all();
        $pdf = Pdf::loadView('pdf.ticket', compact('data'));
        return $pdf->download('Bilet_ZOO_' . $data['visit_date'] . '.pdf');
    }
    
}
