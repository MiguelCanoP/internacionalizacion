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
        Program::create([
            'name' => 'DOCTORADO EN INGENIERÍA',
            'faculty_id' => 1,
        ]);
    }
}
