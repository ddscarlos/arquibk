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


class GeneralController extends Controller
{
    private static $conexion = 'sqlsrv';
    private static $conexionpsql = 'pgsql';

    public function tipodocumentosel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_tdi_id = $request['p_tdi_id'] ? $request['p_tdi_id'] : 0;
            $p_tpe_id = $request['p_tpe_id'] ? $request['p_tpe_id'] : 0;

            //VALIDACIONES
            if (is_null($p_tdi_id) || is_null($p_tpe_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_loging, p_passwd, p_apl_id.'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM master.spu_tipodocide_sel(?, ?)',[$p_tdi_id, $p_tpe_id]
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

    public function redsocialsel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_rso_id = $request['p_rso_id'] ? $request['p_rso_id'] : 0;
            $p_rso_activo = $request['p_rso_activo'] ? $request['p_rso_activo'] : 0;

            //VALIDACIONES
            if (is_null($p_rso_id) || is_null($p_rso_activo)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_rso_id, p_rso_activo.'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM master.spu_redsocial_sel(?, ?)',[$p_rso_id, $p_rso_activo]
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

    public function estadossel(Request $request)
    {
        try {
            //PARAMETROS DE ENTRADA
            $p_est_id = $request['p_est_id'] ? $request['p_est_id'] : 0;
            $p_est_activo = $request['p_est_activo'] ? $request['p_est_activo'] : 0;

            //VALIDACIONES
            if (is_null($p_est_id) || is_null($p_est_activo)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todos los parámetros son obligatorios: p_est_id, p_est_activo.'
                ], 400);
            }
            //CONEXION
            $results = DB::connection(self::$conexionpsql)->select(
                'SELECT * FROM arquitracking.spu_estado_sel(?, ?)',[$p_est_id, $p_est_activo]
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
