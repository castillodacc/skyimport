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

        /* user admin */
        DB::table('users')->insert([
            'name' => 'root',
            'last_name' => 'root',
            'email' => 'root@importadorasky.com',
            'password' => bcrypt('secret'),
            'role_id' => 1,
            'updated_at' => null,
        ]);

        /* Estados del consolidado */
        DB::table('cstates')->insert([
            'state' => 'Pendiente de formalización',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('cstates')->insert([
            'state' => 'Tiempo extendido',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('cstates')->insert([
            'state' => 'formalizado',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        /* Distribuidores o repartidores */
        DB::table('distributors')->insert([
            'name' => 'FedEx',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'DHL',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'Ups',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'LaserShip',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'USPS',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'Amazon',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'China post',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('distributors')->insert([
            'name' => 'EMS',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);

        /* estados de trackings */
        DB::table('tstates')->insert([
            'state' => 'Creado',
            'description' => 'Cuando el consolidado acaba de ser creado y no hemos notificado del recibido aun.',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('tstates')->insert([
            'state' => 'Recibido en bodega - Miami',
            'description' => 'Cuando se recibibe en Miami y está en espera de recibir el resto del consolidado para viajar.',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('tstates')->insert([
            'state' => 'Recibido en bodega - Colombia',
            'description' => 'Cuando el tracking es recibido en Colombia.',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
