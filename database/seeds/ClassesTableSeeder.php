<?php

use Illuminate\Database\Seeder;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            'nome' => 'BO1'
        ]);
        DB::table('classes')->insert([
            'nome' => 'CO1'
        ]);
        DB::table('classes')->insert([
            'nome' => 'TR1'
        ]);
        DB::table('classes')->insert([
            'nome' => 'XO1'
        ]);
        DB::table('classes')->insert([
            'nome' => 'BO2'
        ]);
        DB::table('classes')->insert([
            'nome' => 'CO2'
        ]);
        DB::table('classes')->insert([
            'nome' => 'TR2'
        ]);
        DB::table('classes')->insert([
            'nome' => 'XO2'
        ]);
        DB::table('classes')->insert([
            'nome' => 'BO3'
        ]);
        DB::table('classes')->insert([
            'nome' => 'CO3'
        ]);
        DB::table('classes')->insert([
            'nome' => 'TR3'
        ]);
        DB::table('classes')->insert([
            'nome' => 'XO3'
        ]);
    }
}
