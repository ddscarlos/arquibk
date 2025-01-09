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


class UbigeoController extends Controller
{
    private static $conexion = 'sqlsrv';
    private static $conexionpsql = 'pgsql';

    public function departamentosel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_ude_id = $request['p_ude_id'] ? $request['p_ude_id'] : 0;

            //VALIDACIONES
            if (is_null($p_ude_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_ude_id.'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM ubigeo.spu_ubigeodep_sel(?)',[$p_ude_id]
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
                //'error' => $e->getMessage()
            ], 500);
        }
    }
    public function provinciasel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_ude_id = $request['p_ude_id'] ? $request['p_ude_id'] : 0;
            $p_upr_id = $request['p_upr_id'] ? $request['p_upr_id'] : 0;

            //VALIDACIONES
            if (is_null($p_ude_id) || is_null($p_upr_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_ude_id, p_upr_id.'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM ubigeo.spu_ubigeopro_sel(?, ?)',[$p_ude_id, $p_upr_id]
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
    public function distritosel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_upr_id = $request['p_upr_id'] ? $request['p_upr_id'] : 0;
            $p_udi_id = $request['p_udi_id'] ? $request['p_udi_id'] : 0;

            //VALIDACIONES
            if (is_null($p_upr_id) || is_null($p_udi_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_upr_id, p_udi_id.'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM ubigeo.spu_ubigeodis_sel(?, ?)',[$p_upr_id, $p_udi_id]
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
