<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RelInteresesUser;
use Illuminate\Support\Facades\DB;

class SeedRelInteresesUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("rel_intereses_user")->delete();

        $relaciones = array(
            //user 2
            array(
                "id_usuario" => 2, 
                "id_interes" => 1
            ),
            array(
                "id_usuario" => 2, 
                "id_interes" => 4
            ),
            array(
                "id_usuario" => 2, 
                "id_interes" => 7
            ),

            /**
             * Resultado: Usuarios con intereses similares (3,4)
             *      Usuarios | Intereses
             *          3    |    1
             *          4    |    1
             *          4    |    4
             *          3    |    7
             *          4    |    7
             */

            //user 3
            array(
                "id_usuario" => 3, 
                "id_interes" => 3
            ),
            array(
                "id_usuario" => 3, 
                "id_interes" => 5
            ),
            array(
                "id_usuario" => 3, 
                "id_interes" => 1
            ),
            array(
                "id_usuario" => 3, 
                "id_interes" => 7
            ),

            /**
             * Resultado:
             *      Usuarios | Intereses
             *          4    |    3
             *          4    |    5
             *          2    |    1
             *          4    |    1
             *          2    |    7
             *          4    |    7
             */

            //user 4
            array(
                "id_usuario" => 4, 
                "id_interes" => 1
            ),
            array(
                "id_usuario" => 4, 
                "id_interes" => 4
            ),
            array(
                "id_usuario" => 4, 
                "id_interes" => 5
            ),
            array(
                "id_usuario" => 4, 
                "id_interes" => 7
            ),
            array(
                "id_usuario" => 4, 
                "id_interes" => 3
            ),

            /**
             * Resultado:
             *      Usuarios | Intereses
             *          2    |    1
             *          3    |    1
             *          2    |    4
             *          3    |    5
             *          2    |    7
             *          3    |    7
             *          2    |    3
             */
        );

        foreach($relaciones as $rel){
            RelInteresesUser::create([
                "id_usuario" => $rel["id_usuario"], 
                "id_interes" => $rel["id_interes"]
            ]);
        }
    }
}
