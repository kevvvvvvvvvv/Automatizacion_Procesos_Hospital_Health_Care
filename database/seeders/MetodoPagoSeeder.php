<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodos = [
            [
                'nombre' => 'Efectivo',
                'tipo_ajuste' => 'descuento',
                'valor_ajuste' => 0.00, 
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tarjeta de débito',
                'tipo_ajuste' => 'ninguno',
                'valor_ajuste' => 0.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tarjeta de crédito',
                'tipo_ajuste' => 'recargo',
                'valor_ajuste' => 0.00, 
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Transferencia bancaria',
                'tipo_ajuste' => 'ninguno',
                'valor_ajuste' => 0.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('metodo_pagos')->insert($metodos);        
    }
}
