<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Enclosure;
use App\Models\Animal;
use App\Models\Species;
use App\Models\Subspecies;
use App\Models\DietPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnclosureTest extends TestCase
{
    use RefreshDatabase;

    private function createAnimalDependencies()
    {
        $species = Species::create([
            'name' => 'Test Species',
            'description' => 'Test Description'
        ]);

        $subspecies = Subspecies::create([
            'species_id' => $species->id,
            'common_name' => 'Test Subspecies',
            'scientific_name' => 'Testus Testus'
        ]);

        $diet = DietPlan::create([
            'name' => 'Test Diet',
            'feeding_frequency' => '2x dziennie'
        ]);

        return [$subspecies, $diet];
    }
    public function test_enclosure_is_not_full_when_under_capacity()
    {
        [$subspecies, $diet] = $this->createAnimalDependencies();

        $enclosure = Enclosure::create([
            'name' => 'Duży Wybieg',
            'type' => 'open_air',
            'capacity' => 5
        ]);
        
        Animal::factory()->count(3)->create([
            'enclosure_id' => $enclosure->id,
            'subspecies_id' => $subspecies->id,
            'diet_plan_id' => $diet->id
        ]);

        $this->assertFalse($enclosure->isFull());
    }
    public function test_enclosure_is_full_when_capacity_reached()
    {
        [$subspecies, $diet] = $this->createAnimalDependencies();

        $enclosure = Enclosure::create([
            'name' => 'Mała Klatka',
            'type' => 'indoor_cage',
            'capacity' => 2
        ]);
        
        Animal::factory()->count(2)->create([
            'enclosure_id' => $enclosure->id,
            'subspecies_id' => $subspecies->id,
            'diet_plan_id' => $diet->id
        ]);

        $this->assertTrue($enclosure->isFull());
    }
}