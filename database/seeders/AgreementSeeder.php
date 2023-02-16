<?php

namespace Database\Seeders;

use App\Models\Agreement;
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
        Agreement::create([
            'agreement_type_id' => 1,
            'status' => 'vigente',
            'information' => 'Información del convenio',
            'contact_info' => 'Para mas informes contact@ospinauniversity.edu.co',
            'university_id' => '1',
        ]);
    }
}
