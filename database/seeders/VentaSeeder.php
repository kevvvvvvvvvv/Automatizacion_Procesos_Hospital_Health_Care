<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venta;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $precioInsumo = 16.00;
        $precioServicio = 812.00;
        $subtotal = $precioInsumo + $precioServicio;
        $total = $subtotal; 

        
        $venta = Venta::create([
            'fecha'        => '2026-02-21 11:44:51',
            'subtotal'     => $subtotal,
            'total'        => $total,
            'descuento'    => 0,
            'estado'       => 'En espera de pago',
            'total_pagado' => 0,
            'estancia_id'  => 1,
            'user_id'      => 7,   
        ]);


        $venta->detalles()->create([
            'precio_unitario'           => 16.00,
            'cantidad'                  => 1,
            'subtotal'                 => 16.00,
            'descuento'                => 0,
            'estado'                   => 'completado',
            'iva_aplicado'             => 0, 
            'itemable_id'              => 774,
            'itemable_type'            => 'App\Models\ProductoServicio',
            'nombre_producto_servicio' => 'VENDA DE ALGODON 15 CM',
            'clave_producto_servicio'  => 'GENERAL', 
        ]);

        $venta->detalles()->create([
            'precio_unitario'           => 812.00,
            'cantidad'                  => 1,
            'subtotal'                 => 812.00,
            'descuento'                => 0,
            'estado'                   => 'completado',
            'iva_aplicado'             => 0, 
            'itemable_id'              => 55,
            'itemable_type'            => 'App\Models\ProductoServicio',
            'nombre_producto_servicio' => 'USO DE RAYOS X PORTATIL',
            'clave_producto_servicio'  => '85121808_22',
        ]);
    }
}
