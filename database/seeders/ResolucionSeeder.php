<?php

namespace Database\Seeders;

use App\Models\Configuracion\Resolucion;
use Illuminate\Database\Seeder;

class ResolucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['prefijo' => 'PRUE', 'consecutivo' => 1],
        ];

        Resolucion::insert($data);
    }
}
