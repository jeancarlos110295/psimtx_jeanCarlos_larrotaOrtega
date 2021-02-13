<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->delete();

        $users = array(
            array( // 1
                'name' => "admin", 
                'email' => "admin@gmail.com", 
                'password' => User::encrypPassword("AdminJean"), 
                'rol' => User::ROL_ADMIN, 
                'bloqueado' => "false"
            ),

            array( // 2
                'name' => "user", 
                'email' => "user@gmail.com", 
                'password' => User::encrypPassword("UserJean"), 
                'rol' => User::ROL_USER, 
                'bloqueado' => "false"
            ),

            array( // 3
                'name' => "userario uno", 
                'email' => "user_1@gmail.com", 
                'password' => User::encrypPassword("usuario"), 
                'rol' => User::ROL_USER, 
                'bloqueado' => "false"
            ),

            array( // 4
                'name' => "userario dos", 
                'email' => "user_2@gmail.com", 
                'password' => User::encrypPassword("usuario"), 
                'rol' => User::ROL_USER, 
                'bloqueado' => "false"
            ),
        );

        foreach($users as $user){
            User::create([
                "name" => $user["name"],
                "email" => $user["email"],
                "password" => $user["password"],
                "rol" => $user["rol"],
                "bloqueado" => $user["bloqueado"]
            ]);
        }
    }
}
