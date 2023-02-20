<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <=50;$i++){
            Campus::create([
                'name' => 'Campus principal',
                'city' => 'Ciudad del campus',
                'university_id' => $i,
            ]);
        }


    }
}





