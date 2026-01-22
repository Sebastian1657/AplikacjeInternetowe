<?php

namespace Tests\Feature;

use Tests\TestCase;

class TicketTest extends TestCase
{
    public function test_checkout_aborts_if_group_tickets_less_than_ten()
    {
        $response = $this->post(route('tickets.checkout'), [
            'email' => 'klient@example.com',
            'visit_date' => '2026-05-01',
            'tickets' => [
                'group' => 5,
                'normal' => 1
            ]
        ]);

        $response->assertStatus(400);
    }

    public function test_checkout_passes_if_group_tickets_ten_or_more()
    {
        $response = $this->post(route('tickets.checkout'), [
            'email' => 'grupa@szkola.pl',
            'visit_date' => '2026-06-01',
            'tickets' => [
                'group' => 10
            ]
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('tickets.payment');
        
        $response->assertSee('grupa@szkola.pl');
    }
}