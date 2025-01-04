<?php

namespace App\Http\Controllers;

// require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Dompdf\Dompdf;
use Dompdf\Option;
use Dompdf\Exception as DomException;
use Dompdf\Options;


class EmpresaController extends Controller
{
    private static $conexion = 'sqlsrv';
    private static $conexionpsql = 'pgsql';

    public function sel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA|
            $p_per_id = $request['p_per_id'] ? $request['p_per_id'] : '';
            $p_tdi_id = $request['p_tdi_id'] ? $request['p_tdi_id'] : '';
            $p_per_numdoi = $request['p_per_numdoi'] ? $request['p_per_numdoi'] : '';
            $p_per_nombre = $request['p_per_nombre'] ? $request['p_per_nombre'] : '';

            //VALIDACIONES
            if (is_null($p_per_id) ||
                is_null($p_tdi_id) ||
                is_null($p_per_numdoi) ||
                is_null($p_per_nombre)
                ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_per_id,p_tdi_id,p_per_numdoi,p_per_nombre'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM persona.spu_persona_selnomnum(?,?,?,?)',
                [(int)$p_per_id,(int)$p_tdi_id,$p_per_numdoi,$p_per_nombre]
            );
            //RETORNA RESPUESTA
            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        //ERROR AL EJECUTAR UNA MALA CONSULTA SQL
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al ejecutar la consulta en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        //ALCUN OTRO TIPO DE ERROR
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ins(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_tdi_id = $request['p_tdi_id'] ? $request['p_tdi_id'] : 0;
            $p_tdi_numero = $request['p_tdi_numero'] ? $request['p_tdi_numero'] : '';
            $p_per_apepat = $request['p_per_apepat'] ? $request['p_per_apepat'] : '';
            $p_per_apemat = $request['p_per_apemat'] ? $request['p_per_apemat'] : '';
            $p_per_nombre = $request['p_per_nombre'] ? $request['p_per_nombre'] : '';
            $p_pai_id = $request['p_pai_id'] ? $request['p_pai_id'] : 0;
            $p_tpe_id = $request['p_tpe_id'] ? $request['p_tpe_id'] : 0;

            //VALIDACIONES
            if (is_null($p_tdi_id) ||
                is_null($p_tdi_numero) ||
                is_null($p_per_apepat) ||
                is_null($p_per_apemat) ||
                is_null($p_per_nombre) ||
                is_null($p_pai_id) ||
                is_null($p_tpe_id)
                ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_tdi_id,p_tdi_numero,p_per_apepat,p_per_apemat,p_per_nombre,p_pai_id,p_tpe_id'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM persona.spu_persona_ins(?,?,?,?,?,?,?)',
                [(int)$p_tdi_id,$p_tdi_numero,$p_per_apepat,$p_per_apemat,$p_per_nombre,(int)$p_pai_id,(int)$p_tpe_id]
            );
            //RETORNA RESPUESTA
            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        //ERROR AL EJECUTAR UNA MALA CONSULTA SQL
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al ejecutar la consulta en la base de datos.',
                //'error' => $e->getMessage()
            ], 500);
        //ALCUN OTRO TIPO DE ERROR
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                //'error' => $e->getMessage()
            ], 500);
        }
    }

}
