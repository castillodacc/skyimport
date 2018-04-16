<?php

use Illuminate\Database\Seeder;
use skyimport\Models\Events;

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
        DB::table('shippingstates')->insert([
            'state' => 'Pendiente de formalización',
            'ref_id' => 1,
            'description' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('shippingstates')->insert([
            'state' => 'Tiempo extendido',
            'ref_id' => 1,
            'description' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('shippingstates')->insert([
            'state' => 'Formalizado',
            'ref_id' => 1,
            'description' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('shippingstates')->insert([
            'state' => 'Miami a BOG',
            'ref_id' => 1,
            'description' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('shippingstates')->insert([
            'state' => 'Finalizado',
            'ref_id' => 1,
            'description' => null,
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
        DB::table('shippingstates')->insert([
            'state' => 'Creado',
            'ref_id' => 2,
            'description' => 'Cuando acaba de ser creado y no se ha notificado del recibido aun.',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('shippingstates')->insert([
            'state' => 'Recibido en bodega - Miami',
            'ref_id' => 2,
            'description' => 'Cuando se recibibe en Miami y está en espera de recibir el resto del consolidado para viajar.',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('shippingstates')->insert([
            'state' => 'Recibido en bodega - Colombia',
            'ref_id' => 2,
            'description' => 'Cuando el tracking es recibido en Colombia.',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        $now = Carbon::now();
        /* Departamentos de colombia */
        DB::select("INSERT INTO states VALUES
            (1, 'Atlántico', 1, null, null, null),
            (2, 'Bogotá, D.C.', 1, null, null, null),
            (3, 'Bolívar', 1, null, null, null),
            (4, 'Boyacá', 1, null, null, null),
            (5, 'Caldas', 1, null, null, null),
            (6, 'Caquetá', 1, null, null, null),
            (7, 'Cauca', 1, null, null, null),
            (8, 'Cesar', 1, null, null, null),
            (9, 'Córdoba', 1, null, null, null),
            (10, 'Cundinamarca', 1, null, null, null),
            (11, 'Chocó', 1, null, null, null),
            (12, 'Huila', 1, null, null, null),
            (13, 'La guajira', 1, null, null, null),
            (14, 'Magdalena', 1, null, null, null),
            (15, 'Meta', 1, null, null, null),
            (16, 'Nariño', 1, null, null, null),
            (17, 'Norte de santander', 1, null, null, null),
            (18, 'Quindio', 1, null, null, null),
            (19, 'Risaralda', 1, null, null, null),
            (20, 'Santander', 1, null, null, null),
            (21, 'Sucre', 1, null, null, null),
            (22, 'Tolima', 1, null, null, null),
            (23, 'Valle del cauca', 1, null, null, null),
            (24, 'Arauca', 1, null, null, null),
            (25, 'Casanare', 1, null, null, null),
            (26, 'Putumayo', 1, null, null, null),
            (27, 'Archipiélago de san andrés, providencia y santa catalina', 1, null, null, null),
            (28, 'Amazonas', 1, null, null, null),
            (29, 'Guainía', 1, null, null, null),
            (30, 'Guaviare', 1, null, null, null),
            (31, 'Vaupés', 1, null, null, null),
            (32, 'Vichada', 1, null, null, null),

            (33, 'Alabama', 2, null, null, null),
            (34, 'Alaska', 2, null, null, null),
            (35, 'American Samoa', 2, null, null, null),
            (36, 'Arizona', 2, null, null, null),
            (37, 'Arkansas', 2, null, null, null),
            (38, 'California', 2, null, null, null),
            (39, 'Colorado', 2, null, null, null),
            (40, 'Connecticut', 2, null, null, null),
            (41, 'Delaware', 2, null, null, null),
            (42, 'District of Columbia', 2, null, null, null),
            (43, 'Federated States of Micronesia', 2, null, null, null),
            (44, 'Florida', 2, null, null, null),
            (45, 'Georgia', 2, null, null, null),
            (46, 'Guam', 2, null, null, null),
            (47, 'Hawaii', 2, null, null, null),
            (48, 'Idaho', 2, null, null, null),
            (49, 'Illinois', 2, null, null, null),
            (50, 'Indiana', 2, null, null, null),
            (51, 'Iowa', 2, null, null, null),
            (52, 'Kansas', 2, null, null, null),
            (53, 'Kentucky', 2, null, null, null),
            (54, 'Louisiana', 2, null, null, null),
            (55, 'Maine', 2, null, null, null),
            (56, 'Marshall Islands', 2, null, null, null),
            (57, 'Maryland', 2, null, null, null),
            (58, 'Massachusetts', 2, null, null, null),
            (59, 'Michigan', 2, null, null, null),
            (60, 'Minnesota', 2, null, null, null),
            (61, 'Mississippi', 2, null, null, null),
            (62, 'Missouri', 2, null, null, null),
            (63, 'Montana', 2, null, null, null),
            (64, 'Nebraska', 2, null, null, null),
            (65, 'Nevada', 2, null, null, null),
            (66, 'New Hampshire', 2, null, null, null),
            (67, 'New Jersey', 2, null, null, null),
            (68, 'New Mexico', 2, null, null, null),
            (69, 'New York', 2, null, null, null),
            (70, 'North Carolina', 2, null, null, null),
            (71, 'North Dakota', 2, null, null, null),
            (72, 'Northern Mariana Islands', 2, null, null, null),
            (73, 'Ohio', 2, null, null, null),
            (74, 'Oklahoma', 2, null, null, null),
            (75, 'Oregon', 2, null, null, null),
            (76, 'Palau', 2, null, null, null),
            (77, 'Pennsylvania', 2, null, null, null),
            (78, 'Puerto Rico', 2, null, null, null),
            (79, 'Rhode Island', 2, null, null, null),
            (80, 'South Carolina', 2, null, null, null),
            (81, 'South Dakota', 2, null, null, null),
            (82, 'Tennessee', 2, null, null, null),
            (83, 'Texas', 2, null, null, null),
            (84, 'Utah', 2, null, null, null),
            (85, 'Vermont', 2, null, null, null),
            (86, 'Virgin Islands', 2, null, null, null),
            (87, 'Virginia', 2, null, null, null),
            (88, 'Washington', 2, null, null, null),
            (89, 'West Virginia', 2, null, null, null),
            (90, 'Wisconsin', 2, null, null, null),
            (91, 'Wyoming', 2, null, null, null);");

        /**
         * Eventos 1) consolidateds - 2) trackings
         **/
        Events::create([
            'type' => 1,
            'event' => 'Nuevo Consolidado Creado.'
        ]);
        Events::create([
            'type' => 1,
            'event' => 'Tiempo extendido.'
        ]);
        Events::create([
            'type' => 1,
            'event' => 'formalizado.'
        ]);
        Events::create([
            'type' => 1,
            'event' => 'Salida de Miami a Bogotá.'
        ]);
        Events::create([
            'type' => 1,
            'event' => 'Facturar.'
        ]);
        Events::create([
            'type' => 1,
            'event' => '<span class="fa fa-check-square-o cye-lm-tag"></span> Facturado.'
        ]);

        Events::create([
            'type' => 2,
            'event' => 'Nuevo Tracking Creado.'
        ]);
        Events::create([
            'type' => 2,
            'event' => 'Recibido en bodega - Miami.'
        ]);
        Events::create([
            'type' => 2,
            'event' => 'Salida de Miami a Bogotá.'
        ]);
        Events::create([
            'type' => 2,
            'event' => 'En Aduana de Colombia.'
        ]);
        Events::create([
            'type' => 2,
            'event' => 'Recibido en bodega - Colombia.'
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
