<?php

use function Pest\Laravel\get;

test('niezalogowany użytkownik nie ma dostępu do panelu kierownika i jest przekierowany do logowania', function () {
    $response = get(route('supervisor.animals.index'));
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});