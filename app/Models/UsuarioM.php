<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioM extends Model
{
    use HasFactory;

    public static function login($where){
        $tabla = DB::table('cat_users');
        
        if( count($where) > 0 ) $query = $tabla->where($where);

        $query = $tabla->get()->toArray();

        return $query;
    }

    public static function actualizarUsuario($where, $update){
        try {
            $tabla = DB::table('cat_users');
    
            if( count($where) > 0 ) $query = $tabla->where($where);
            if( count($update) > 0 ) $query = $tabla->update($update);

            return 1;
        } catch (Exception $exp) {
            return -1;
        }
    }
}
