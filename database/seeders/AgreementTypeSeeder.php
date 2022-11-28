<?php

namespace Database\Seeders;

use App\Models\AgreementType;
use Illuminate\Database\Seeder;

class AgreementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgreementType::create([
            'name' => 'Co-tutela doctoral'
        ]);
        AgreementType::create([
            'name' => 'Convenio marco'
        ]);
        AgreementType::create([
            'name' => 'Doble titulacion'
        ]);
        AgreementType::create([
            'name' => 'Especifico'
        ]);
        AgreementType::create([
            'name' => 'Intercambio'
        ]);
        AgreementType::create([
            'name' => 'Marco'
        ]);
        AgreementType::create([
            'name' => 'Otra'
        ]);
    }
}
