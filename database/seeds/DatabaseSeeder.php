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
    	DB::table('roles')->insert([
    		'rol' => 'Administrador',
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    	]);
    	DB::table('roles')->insert([
    		'rol' => 'Cliente',
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    	]);

    	DB::table('countries')->insert([
    		'country' => 'Colombia',
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    	]);
    	DB::table('countries')->insert([
    		'country' => 'Estados Unidos',
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now(),
    	]);

        // $this->call(UsersTableSeeder::class);
    }
}
