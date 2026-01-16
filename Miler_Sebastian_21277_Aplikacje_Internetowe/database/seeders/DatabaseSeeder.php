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
            'Pszenica' => 'g',
            'Słonecznik' => 'g',
            'Orzechy' => 'g',
            'Larwy mącznika' => 'g',
            'Granulat dla ryb' => 'g',
            'Banany' => 'kg',
        ];

        foreach ($foodList as $type => $unit) {
            $food = Food::factory()->create(['name' => $type, 'unit' => $unit]);
            $foods[$type] = $food;
        }

        $diets = [
            'carnivore' => [
                'name' => 'Dieta Mięsna - standard',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    $foods['Wołowina']->id => 20,
                    $foods['Kurczak']->id => 2,
                ]
            ],
            'piscivore' => [
                'name' => 'Dieta rybna - standard',
                'frequency' => '2x dziennie',
                'ingredients' => [
                    $foods['Śledź']->id => 2,
                    $foods['Makrela']->id => 2,
                ]
            ],
            'elephants' => [
                'name' => 'Dieta słoni',
                'frequency' => 'Cały dzień',
                'ingredients' => [
                    $foods['Siano']->id => 70,
                    $foods['Marchew']->id => 20,
                    $foods['Jabłka']->id => 20,
                ]
            ],
            'exotic_birds' => [
                'name' => 'Dieta ptaków egzotycznych',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    $foods['Słonecznik']->id => 100,
                    $foods['Orzechy']->id => 100,
                    $foods['Jabłka']->id => 0.3,
                ]
            ],
            'birds' => [
                'name' => 'Dieta ptaków',
                'frequency' => '2x dziennie',
                'ingredients' => [
                    $foods['Pszenica']->id => 200,
                ]
            ],
            'bamboo' => [
                'name' => 'Dieta bambusowa',
                'frequency' => '1x dziennie',
                'ingredients' => [
                    $foods['Bambus pędy']->id => 40,
                ]
            ],
            'herbivore' => [
                'name' => 'Dieta roślinna - standard',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    $foods['siano']->id => 40,
                    $foods['Marchew']->id => 10,
                    $foods['Jabłka']->id => 5,
                    $foods['Proso']->id => 8,
                ]
            ],
            'monkey' => [
                'name' => 'Dieta małp',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    $foods['Jabłka']->id => 0.5,
                    $foods['Sałata']->id => 1,
                    $foods['Banany']->id => 0.5,
                    $foods['Marchew']->id => 1,
                    $foods['Orzechy']->id => 0.5,
                ]  
            ],
            'insectivore' => [
                'name' => 'Dieta owadożerców',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    $foods['Larwy mącznika']->id => 20,
                    $foods['Sałata']->id => 0.5,
                ]
            ],
            'fish' => [
                'name' => 'Dieta ryb',
                'frequency' => '3x dziennie',
                'ingredients' => [
                    $foods['Larwy mącznika']->id => 20,
                    $foods['Granulat dla ryb']->id => 40,
                ]
            ],
            'piscivore'
                    

        ];

        $zooMap = [
            // OTWARTE
            [
                'enclosure' => ['name' => 'Bambusowy Las', 'type' => 'open_air', 'capacity' => 6],
                'species' => 'Niedźwiedziowate',
                'subspecies' => ['Panda Wielka'],
                'scientific_name' => ['Ailuropoda melanoleuca'],
                'diet' => 'bamboo'
            ],
            [
                'enclosure' => ['name' => 'Sawanna Słoni', 'type' => 'open_air', 'capacity' => 6],
                'species' => 'Słoniowate',
                'subspecies' => ['Słoń Afrykański'],
                'scientific_name' => ['Loxodonta africana'],
                'diet' => 'elephants'
            ],
            [
                'enclosure' => ['name' => 'Wybieg żyraf', 'type' => 'open_air', 'capacity' => 6],
                'species' => 'Żyrafowate',
                'subspecies' => ['Żyrafa Rothschilda'],
                'scientific_name' => ['Giraffa camelopardalis rothschildi'],
                'diet' => 'herbivore'
            ],
            [
                'enclosure' => ['name' => 'Wybieg niedźwiedzi', 'type' => 'open_air', 'capacity' => 6],
                'species' => 'Niedźwiedziowate',
                'subspecies' => ['Niedźwiedź Brunatny'],
                'scientific_name' => ['Ursus arctos'],
                'diet' => 'carnivore'
            ],

            // ZAMKNIĘTE
            [
                'enclosure' => ['name' => 'Małpi Gaj', 'type' => 'indoor_cage', 'capacity' => 15],
                'species' => 'Naczelne',
                'subspecies' => ['Kapucynka czubata', 'Sajmiri wiewiórcza'],
                'scientific_name' => ['Sapajus apella', 'Saimiri sciureus'],
                'diet' => 'monkey'
            ],
            [
                'enclosure' => ['name' => 'Pustynia', 'type' => 'indoor_cage', 'capacity' => 20],
                'species' => 'Mangustowate',
                'subspecies' => ['Surykatka'],
                'scientific_name' => ['Suricata suricatta'],
                'diet' => 'insectivore'
            ],

            // WOLIERY
            [
                'enclosure' => ['name' => 'Papugarnia', 'type' => 'aviary', 'capacity' => 30],
                'species' => 'Papugowate',
                'subspecies' => ['Ara ararauna', 'Żako większa', 'Kakadu palmowa'],
                'scientific_name' => ['Ara ararauna', 'Psittacus erithacus', 'Probosciger aterrimus'],
                'diet' => 'exotic_birds'
            ],
            [
                'enclosure' => ['name' => 'Gołębnik Egzotyczny', 'type' => 'aviary', 'capacity' => 40],
                'species' => 'Gołębiowate',
                'subspecies' => ['Koroniec Plamoczuby', 'Gołąb Nikobarski'],
                'scientific_name' => ['Goura victoria', 'Caloenas nicobarica'],
                'diet' => 'birds'
            ],
            [
                'enclosure' => ['name' => 'Dżungla Tukanów', 'type' => 'aviary', 'capacity' => 12],
                'species' => 'Tukanowate',
                'subspecies' => ['Tukan Wielki'],
                'scientific_name' => ['Ramphastos toco'],
                'diet' => 'exotic_birds' 
            ],

            // AKWARIUM
            [
                'enclosure' => ['name' => 'Oceanarium ryb drapieżnych', 'type' => 'aquarium', 'capacity' => 8],
                'species' => 'Ryby Chrzęstnoszkieletowe',
                'subspecies' => ['Żarłacz Czarnopłetwy', 'Murena brunatna'],
                'scientific_name' => ['Carcharhinus limbatus', 'Gymnothorax vicinus'],
                'diet' => 'piscivore'
            ],
            [
                'enclosure' => ['name' => 'Rafa Koralowa', 'type' => 'aquarium', 'capacity' => 40],
                'species' => 'Ryby Kostnoszkieletowe',
                'subspecies' => ['Błazenek', 'Pokolec Królewski'],
                'scientific_name' => ['Amphiprion percula', 'Paracanthurus hepatus'],
                'diet' => 'fish'
            ],

            // ZAMKNIĘTE Z BASENEM
            [
                'enclosure' => ['name' => 'Basen Fok', 'type' => 'pool_enclosure', 'capacity' => 8],
                'species' => 'Fokowate',
                'subspecies' => ['Foka Szara'],
                'scientific_name' => ['Halichoerus grypus'],
                'diet' => 'piscivore'
            ],
            [
                'enclosure' => ['name' => 'Zatoka Nerp', 'type' => 'pool_enclosure', 'capacity' => 6],
                'species' => 'Fokowate',
                'subspecies' => ['Nerpa Bajkalska'],
                'scientific_name' => ['Pusa sibirica'],
                'diet' => 'piscivore'
            ],

            // PINGWINY
            [
                'enclosure' => ['name' => 'Wybieg lodowy', 'type' => 'cooled_enclosure', 'capacity' => 20],
                'species' => 'Pingwiny',
                'subspecies' => ['Pingwin Cesarski', 'Pingwin Adeli'],
                'scientific_name' => ['Aptenodytes forsteri', 'Pygoscelis adeliae'],
                'diet' => 'piscivore'
            ],
        ];

        foreach ($zooMap as $config) {
            $enclosure = Enclosure::create($config['enclosure']);
            $species = Species::firstOrCreate(['name' => $config['species']]);
            $dietPlan = $diets[$config['diet']];

            foreach ($config['subspecies'] as $index => $subName) {
                $latinName = $config['scientific_name'][$index] ?? 'Lorem ipsum';
                $subspecies = Subspecies::firstOrCreate([
                    'species_id' => $species->id,
                    'common_name' => $subName
                ], [
                    'scientific_name' => $latinName,
                ]);

                $count = rand(2, $enclosure->capacity);
                
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