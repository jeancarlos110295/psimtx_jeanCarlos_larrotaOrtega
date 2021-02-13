<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelInteresesUser extends Model
{
    use HasFactory;
    protected $table = "rel_intereses_user";

    protected $fillable = ["id_usuario" , "id_interes"];
}
