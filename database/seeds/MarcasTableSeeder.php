<?php

use Illuminate\Database\Seeder;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marcas')->insert([
            'nome' => 'Agro Bayer'
        ]);
        DB::table('marcas')->insert([
            'nome' => 'FMC'
        ]);
    }
}
