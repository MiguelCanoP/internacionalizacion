<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'user',
            'customId' => 1
        ]);
        Role::create([
            'name' => 'admin',
            'customId' => 3
        ]);
        User::create([
            'name' => 'Sebastian Ospina',
            'email' => 'juan.ospina@unibague.edu.co',
            'password' => Hash::make('sdlhadlkasedkjshace'),
            'role_id' => 2
        ]);
        (new CountrySeeder())->run();
        (new AgreementTypeSeeder())->run();

        (new FacultySeeder())->run();
        (new ProgramSeeder())->run();
        (new UniversitySeeder())->run();
        (new CampusSeeder())->run();
        (new AgreementSeeder())->run();
    }

}
