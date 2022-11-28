<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Faculty;
use App\Models\Role;
use Illuminate\Database\Seeder;

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
        (new CountrySeeder())->run();
        (new AgreementTypeSeeder())->run();
        (new UniversitySeeder())->run();
        (new CampusSeeder()) ->run();
        (new FacultySeeder())->run();
        (new ProgramSeeder())->run();
    }

}
