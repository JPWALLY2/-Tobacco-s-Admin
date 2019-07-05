<?php

use Illuminate\Database\Seeder;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'nome' => 'Minuano'
        ]);
        DB::table('empresas')->insert([
            'nome' => 'F.U.M.O.'
        ]);
    }
}
