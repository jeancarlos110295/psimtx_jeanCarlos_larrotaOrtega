<?php

namespace Database\Seeders;

use App\Models\Intereses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedIntereses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = array(
            "Yoga",
            "Cocinar",
            "Cantar",
            "Escribir",
            "Fotografía",
            "Bailar",
            "Carpintería"
        );
        
        DB::table("intereses")->delete();

        foreach($datos as $interes){
            Intereses::create([
                "interes" => $interes
            ]);
        }
    }
}
