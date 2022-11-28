<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

           University::create([
                'name' => 'Universidad Pontificia Comillas',
                'web_site' => 'https://www.comillas.edu/',
               'country_id' => 199,
            ]);

    }
}
