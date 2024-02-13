<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class VerificarLogin extends Model
{
    use HasFactory;

    public static function verificar_solicitante($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='SOLICITANTE'");
        return $query;
    }

    public static function verificar_presupuesto($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='PRESUPUESTO'");
        return $query;
    }

    public static function verificar_daf($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='DAF'");
        return $query;
    }

    public static function verificar_bien($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='BIEN'");
        return $query;
    }

    public static function verificar_almacen($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='ALMACEN'");
        return $query;
    }

    public static function verificar_cotizador($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='COTIZADOR'");
        return $query;
    }

    public static function verificar_adquisicion($user_u){
        $query = DB::select("SELECT * FROM users WHERE alias='$user_u' AND tipo='ADQUISICION'");
        return $query;
    }
}
