<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(EmpresasTableSeeder::class);
         $this->call(TiposInsumosTableSeeder::class);
         $this->call(ClassesTableSeeder::class);
        //  $this->call(MarcasTableSeeder::class);
    }
}
