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
        /* Roles */
        DB::table('roles')->insert([
            'rol' => 'Administrador',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('roles')->insert([
            'rol' => 'Cliente',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        /* Paises */
        DB::table('countries')->insert([
            'country' => 'Colombia',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('countries')->insert([
            'country' => 'Estados Unidos',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        /* Estados del consolidado */
        DB::table('cstates')->insert([
            'state' => 'Activo',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('cstates')->insert([
            'state' => 'Pendiente',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('cstates')->insert([
            'state' => 'Cerrado',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        // $this->call(UsersTableSeeder::class);
    }
}
