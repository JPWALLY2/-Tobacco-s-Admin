<?php

use Illuminate\Database\Seeder;

class TiposInsumosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_insumos')->insert([
            'nome' => 'Inseticida'
        ]);
        DB::table('tipos_insumos')->insert([
            'nome' => 'Fertilizante'
        ]);
    }
}
