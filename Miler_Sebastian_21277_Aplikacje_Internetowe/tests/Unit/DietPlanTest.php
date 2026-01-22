<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\DietPlan;
use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DietPlanTest extends TestCase
{
    use RefreshDatabase;
    public function test_diet_plan_can_have_foods_attached()
    {
        $diet = DietPlan::create([
            'name' => 'Dieta Mięsna',
            'feeding_frequency' => '1x dziennie'
        ]);

        $food = Food::create([
            'name' => 'Wołowina',
            'unit' => 'kg'
        ]);

        $diet->foods()->attach($food->id, ['amount' => 5.5]);

        $this->assertTrue($diet->foods->contains($food));
        $this->assertEquals(1, $diet->foods->count());
    }

    public function test_diet_plan_retrieves_correct_food_amount()
    {
        $diet = DietPlan::create([
            'name' => 'Dieta Lemurów', 
            'feeding_frequency' => '3x dziennie'
        ]);

        $food = Food::create([
            'name' => 'Banany', 
            'unit' => 'szt'
        ]);

        $diet->foods()->attach($food->id, ['amount' => 10]);
        $retrievedFood = $diet->foods->first();

        $this->assertEquals(10, $retrievedFood->pivot->amount);
    }
}