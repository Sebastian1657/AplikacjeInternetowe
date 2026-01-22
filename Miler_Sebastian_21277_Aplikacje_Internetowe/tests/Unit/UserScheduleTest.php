<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Care;
use App\Models\Role;
use App\Models\Species;
use App\Models\Subspecies;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB; // Potrzebne do korekty danych
use Carbon\Carbon;

class UserScheduleTest extends TestCase
{
    use RefreshDatabase;
    private function createDependencies()
    {
        $species = Species::create(['name' => 'Test Species']);
        $subspecies = Subspecies::create([
            'species_id' => $species->id,
            'common_name' => 'Test Subspecies',
            'scientific_name' => 'Testus'
        ]);

        $role = Role::create(['name' => 'employee', 'display_name' => 'Pracownik']);
        $user = User::factory()->create(['role_id' => $role->id]);

        return [$user, $subspecies];
    }

    public function test_today_schedule_returns_only_tasks_for_today()
    {
        [$user, $subspecies] = $this->createDependencies();

        $care = Care::factory()->create([
            'user_id' => $user->id,
            'subspecies_id' => $subspecies->id,
            'care_date' => Carbon::today()->toDateString(), 
            'shift' => 1 
        ]);

        DB::table('cares')
            ->where('id', $care->id)
            ->update(['care_date' => Carbon::today()->toDateString()]);

        Care::factory()->create([
            'user_id' => $user->id,
            'subspecies_id' => $subspecies->id,
            'care_date' => Carbon::tomorrow()->toDateString(),
            'shift' => 1
        ]);

        $todaysCares = $user->todaySchedule()->get();

        $this->assertCount(1, $todaysCares);
        $this->assertEquals($care->id, $todaysCares->first()->id);
    }
    public function test_today_schedule_is_empty_if_no_tasks_today()
    {
        [$user, $subspecies] = $this->createDependencies();

        Care::factory()->create([
            'user_id' => $user->id,
            'subspecies_id' => $subspecies->id,
            'care_date' => Carbon::yesterday()->toDateString(),
            'shift' => 1
        ]);

        $todaysCares = $user->todaySchedule()->get();

        $this->assertCount(0, $todaysCares);
    }
}