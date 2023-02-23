<?php

namespace Database\Seeders;

use App\Models\Agreement;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AgreementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $possiblePrograms = [
            [1],
            [1, 2],
            [1, 2, 3],
            [2],
            [3]
        ];
        for ($i = 1; $i <= 50; $i++) {
            $agreement = Agreement::create([
                'agreement_type_id' => random_int(1, 7),
                'status' => 'vigente',
                'information' => $faker->paragraph(5),
                'contact_info' => 'Para mas informes contact@ospinauniversity.edu.co',
                'university_id' => $i,
            ]);

            $agreement->programs()->sync($possiblePrograms[random_int(0, count($possiblePrograms) - 1)]);
        }
    }
}
