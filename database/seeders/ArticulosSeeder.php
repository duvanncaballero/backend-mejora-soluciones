<?php

namespace Database\Seeders;

use App\Models\Factura\Articulo;
use Illuminate\Database\Seeder;

class ArticulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => '101', 'descripcion' => strtoupper('Cuadernos grapados'),          'valor' => 1000,    'tipo_impuesto' => 1, 'impuesto' => 19],
            ['id' => '102', 'descripcion' => strtoupper('Folder tamaño carta'),         'valor' => 1500,    'tipo_impuesto' => 1, 'impuesto' => 5 ],
            ['id' => '103', 'descripcion' => strtoupper('Cuadernos argollados'),        'valor' => 2000,    'tipo_impuesto' => 1, 'impuesto' => 19],
            ['id' => '104', 'descripcion' => strtoupper('Tizas para tablero'),          'valor' => 500,     'tipo_impuesto' => 1, 'impuesto' => 19],
            ['id' => '105', 'descripcion' => strtoupper('Papel carta para impresora'),  'valor' => 20000,   'tipo_impuesto' => 1, 'impuesto' => 5 ],
        ];

        Articulo::insert($data);
    }
}
