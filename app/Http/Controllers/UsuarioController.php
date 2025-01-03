<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private static $conexion = 'sqlsrv';
    private static $conexionpsql = 'pgsql';


    public function login(Request $request)
    {
        $p_loging = $request['p_loging'] ? $request['p_loging'] : '';
        $p_passwd = $request['p_passwd'] ? $request['p_passwd'] : '';
        $p_apl_id = $request['p_apl_id'] ? $request['p_apl_id'] : '';

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM sistemas.spu_acceso_chk(?,?,?)', [$p_loging, $p_passwd, $p_apl_id]);
        return response()->json($results);
    }
}
