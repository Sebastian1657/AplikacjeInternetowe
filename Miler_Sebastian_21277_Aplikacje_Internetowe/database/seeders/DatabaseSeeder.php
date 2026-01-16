<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Species;
use App\Models\Subspecies;
use App\Models\Enclosure;
use App\Models\Food;
use App\Models\DietPlan;
use App\Models\Animal;
use App\Models\Care;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Rola systemowa: Użytkownik'
        ]);
        Role::create([
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'Rola systemowa: Manager'
        ]);
        Role::create([
            'name' => 'supervisor',
            'display_name' => 'Supervisor',
            'description' => 'Rola systemowa: Supervisor'
        ]);
        Role::create([
            'name' => 'employee',
            'display_name' => 'Pracownik',
            'description' => 'Rola systemowa: Pracownik'
        ]);
        
        User::factory()->create([
            'name' => 'Admin',
            'last_name' => 'Systemowy',
            'email' => 'admin@zoo.pl',
            'role_id' => 1,
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Jan',
            'last_name' => 'Manager',
            'email' => 'manager@zoo.pl',
            'role_id' => 2,
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Krzysztof',
            'last_name' => 'Kierownik',
            'email' => 'kierownik@zoo.pl',
            'role_id' => 3,
            'password' => Hash::make('password'),
        ]);

        $employees = User::factory(10)->create([
            'role_id' => 4,
        ]);

        $foodList = [
            'Wołowina' => 'kg',
            'Kurczak' => 'szt',
            'Mysz mrożona' => 'szt',
            'Śledź' => 'kg',
            'Makrela' => 'kg',
            'Siano' => 'kg',
            'Marchew' => 'kg',
            'Jabłka' => 'kg',
            'Sałata' => 'szt',
            'Bambus pędy' => 'kg',
            'Proso' => 'g',
            'Słonecznik' => 'g',
            'Orzechy' => 'g',
            'Larwy mącznika' => 'g',
        ];

        foreach ($foodList as $type => $unit) {
            $food = Food::factory()->create(['name' => $type, 'unit' => $unit]);
            $foods[$type] = $food;
        }

        $diets = [
            'carnivore' => [
                'name' => 'Dieta Mięsna',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    'Wołowina' => 20, 
                    'Kurczak' => 2
                ]
            ],
        ];

        $diets['carnivore'] = DietPlan::create(['name' => 'Dieta Mięsna', 'feeding_frequency' => '2x dziennie']);
        $diets['carnivore']->foods()->attach([$foods['Wołowina']->id, $foods['Kurczak']->id], ['amount' => 2000]);

        $diets['piscivore'] = DietPlan::create(['name' => 'Dieta Rybna', 'feeding_frequency' => '2x dziennie']);
        $diets['piscivore']->foods()->attach([$foods['Śledź']->id, $foods['Makrela']->id], ['amount' => 1000]);

        $diets['herbivore'] = DietPlan::create(['name' => 'Dieta Roślinna', 'feeding_frequency' => 'Cały dzień']);
        $diets['herbivore']->foods()->attach([$foods['Siano']->id, $foods['Marchew']->id, $foods['Jabłka']->id], ['amount' => 5000]);

        $diets['bamboo'] = DietPlan::create(['name' => 'Bambus', 'feeding_frequency' => '1x dziennie']);
        $diets['bamboo']->foods()->attach([$foods['Bambus pędy']->id], ['amount' => 10000]);

        $diets['bird_seeds'] = DietPlan::create(['name' => 'Dieta Ziarnista', 'feeding_frequency' => '2x dziennie']);
        $diets['bird_seeds']->foods()->attach([$foods['Proso']->id, $foods['Słonecznik']->id], ['amount' => 200]);

        $diets['bird_meat'] = DietPlan::create(['name' => 'Ptaki Drapieżne', 'feeding_frequency' => '1x dziennie']);
        $diets['bird_meat']->foods()->attach([$foods['Mysz mrożona']->id], ['amount' => 300]);

        $zooMap = [
            // OTWARTE
            [
                'enclosure' => ['name' => 'Bambusowy Las', 'type' => 'open_air', 'capacity' => 5],
                'species' => 'Niedźwiedziowate',
                'subspecies' => ['Panda Wielka'],
                'diet' => 'bamboo'
            ],
            [
                'enclosure' => ['name' => 'Sawanna Słoni', 'type' => 'open_air', 'capacity' => 6],
                'species' => 'Słoniowate',
                'subspecies' => ['Słoń Afrykański'],
                'diet' => 'herbivore'
            ],
            [
                'enclosure' => ['name' => 'Wysokie Drzewa', 'type' => 'open_air', 'capacity' => 8],
                'species' => 'Żyrafowate',
                'subspecies' => ['Żyrafa Rothschilda'],
                'diet' => 'herbivore'
            ],
            [
                'enclosure' => ['name' => 'Gawra Niedźwiedzia', 'type' => 'open_air', 'capacity' => 4],
                'species' => 'Niedźwiedziowate', // Ten sam gatunek co Panda, ale inny podgatunek i dieta!
                'subspecies' => ['Niedźwiedź Brunatny'],
                'diet' => 'carnivore' // Niedźwiedzie są wszystkożerne, ale tu uprośćmy do mięsnej/mix
            ],

            // ZAMKNIĘTE
            [
                'enclosure' => ['name' => 'Małpi Gaj', 'type' => 'indoor_cage', 'capacity' => 15],
                'species' => 'Naczelne',
                'subspecies' => ['Makak Japoński', 'Muflon Śródziemnomorski'], // Muflon to kopytne, ale user chciał razem
                'diet' => 'herbivore' // Uproszczenie: owoce/warzywa
            ],
            [
                'enclosure' => ['name' => 'Pustynna Nora', 'type' => 'indoor_cage', 'capacity' => 20],
                'species' => 'Mangustowate',
                'subspecies' => ['Surykatka'],
                'diet' => 'carnivore' // Robaki/mięso
            ],

            // WOLIERY
            [
                'enclosure' => ['name' => 'Papugarnia', 'type' => 'aviary', 'capacity' => 30],
                'species' => 'Papugowate',
                'subspecies' => ['Ara Ararauna', 'Żako', 'Kakadu'],
                'diet' => 'bird_seeds'
            ],
            [
                'enclosure' => ['name' => 'Gołębnik Egzotyczny', 'type' => 'aviary', 'capacity' => 40],
                'species' => 'Gołębiowate',
                'subspecies' => ['Koroniec Plamisty', 'Gołąb Nikobarski'],
                'diet' => 'bird_seeds'
            ],
            [
                'enclosure' => ['name' => 'Dżungla Tukanów', 'type' => 'aviary', 'capacity' => 10],
                'species' => 'Tukanowate',
                'subspecies' => ['Tukan Wielki'],
                'diet' => 'herbivore' 
            ],

            // AKWARIUM
            [
                'enclosure' => ['name' => 'Oceanarium Drapieżne', 'type' => 'aquarium', 'capacity' => 5],
                'species' => 'Ryby Chrzęstnoszkieletowe',
                'subspecies' => ['Żarłacz Czarnopłetwy', 'Murena'],
                'diet' => 'piscivore'
            ],
            [
                'enclosure' => ['name' => 'Rafa Koralowa', 'type' => 'aquarium', 'capacity' => 50],
                'species' => 'Ryby Kostnoszkieletowe',
                'subspecies' => ['Błazenek', 'Pokolec Królewski'],
                'diet' => 'herbivore'
            ],

            // ZAMKNIĘTE Z BASENEM
            [
                'enclosure' => ['name' => 'Basen Fok', 'type' => 'pool_enclosure', 'capacity' => 8],
                'species' => 'Fokowate',
                'subspecies' => ['Foka Szara'],
                'diet' => 'piscivore'
            ],
            [
                'enclosure' => ['name' => 'Zatoka Nerp', 'type' => 'pool_enclosure', 'capacity' => 6],
                'species' => 'Fokowate',
                'subspecies' => ['Nerpa Bajkalska'],
                'diet' => 'piscivore'
            ],

            // PINGWINY
            [
                'enclosure' => ['name' => 'Lodowa Kraina', 'type' => 'cooled_enclosure', 'capacity' => 20],
                'species' => 'Pingwiny',
                'subspecies' => ['Pingwin Cesarski', 'Pingwin Adeli'],
                'diet' => 'piscivore'
            ],
        ];

        foreach ($zooMap as $config) {
            $enclosure = Enclosure::create($config['enclosure']);
            $species = Species::firstOrCreate(['name' => $config['species']]);
            $dietPlan = $diets[$config['diet']];

            foreach ($config['subspecies'] as $subName) {
                $subspecies = Subspecies::firstOrCreate([
                    'species_id' => $species->id,
                    'common_name' => $subName
                ], [
                    'scientific_name' => 'Latin Name Placeholder'
                ]);

                $count = rand(2, 5);
                
                Animal::factory($count)->create([
                    'subspecies_id' => $subspecies->id,
                    'enclosure_id' => $enclosure->id,
                    'diet_plan_id' => $dietPlan->id,
                ]);
            }
        }
        
        $allAnimals = Animal::all();
        $allAnimals = Animal::all();
        
        Care::factory(60)->create([
            'user_id' => $employees->random()->id,
            'animal_id' => $allAnimals->random()->id,
        ]);
    }


}