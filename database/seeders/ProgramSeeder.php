<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = ['Ingeniería Industrial', 'Ingeniería electrónica', 'Ingeniería de sistemas'];
        foreach ($programs as $program) {
            Program::create([
                'name' => $program,
                'faculty_id' => 1,
            ]);
        }

    }
}
