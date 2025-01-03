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


class CalendarioController extends Controller
{
    private static $host = '172.17.1.56';
    private static $port = 22;
    private static $user = 'root';
    private static $pass = 'MdSmP*2023$';

    private static $conexion = 'sqlsrv';
    private static $conexionpsql = 'pgsql';


    public function login(Request $request)
    {
        $p_loging = $request['p_loging'];
        $p_passwd = $request['p_passwd'];
        $p_app_id = $request['p_app_id'];
        $results = DB::connection(self::$conexion)->select('select * from sistemas.spu_acceso_chk(?,?,?)', [$p_loging, $p_passwd, $p_app_id]);
        return response()->json($results);
    }

    public function ingresarUsuario(Request $request)
    {
        $p_loging = $request['p_loging'] ? $request['p_loging'] : '';
        $p_passwd = $request['p_passwd'] ? $request['p_passwd'] : '';
        $p_apl_id = $request['p_apl_id'] ? $request['p_apl_id'] : '';

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM sistemas.spu_acceso_chk(?,?,?)', [$p_loging, $p_passwd, $p_apl_id]);
        return response()->json($results);
    }

    public function listarUsuario(Request $request)
    {
        $p_usu_id = $request['p_usu_id'] ? $request['p_usu_id'] : 0;
        $p_usu_apepat = $request['p_usu_apepat'] ? $request['p_usu_apepat'] : '';
        $p_usu_apemat = $request['p_usu_apemat'] ? $request['p_usu_apemat'] : '';
        $p_usu_nombre = $request['p_usu_nombre'] ? $request['p_usu_nombre'] : '';
        $p_usu_loging = $request['p_usu_loging'] ? $request['p_usu_loging'] : '';
        $p_usu_activo = $request['p_usu_activo'] ? $request['p_usu_activo'] : 0;

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM sistemas.spu_usuario_sel(?,?,?,?,?,?)', [$p_usu_id, $p_usu_apepat, $p_usu_apemat, $p_usu_nombre, $p_usu_loging, $p_usu_activo]);
        return response()->json($results);
    }

    public function listarEventos(Request $request)
    {
        $p_eve_id = $request['p_eve_id'] ? $request['p_eve_id'] : 0;
        $p_ard_id = $request['p_ard_id'] ? $request['p_ard_id'] : 0;
        $p_eve_fecini = $request['p_eve_fecini'] ? $request['p_eve_fecini'] : '';
        $p_eve_fecfin = $request['p_eve_fecfin'] ? $request['p_eve_fecfin'] : '';
        $p_eve_aliasn = $request['p_eve_aliasn'] ? $request['p_eve_aliasn'] : '';
        $p_eve_activo = $request['p_eve_activo'] ? $request['p_eve_activo'] : 0;

        // return "SELECT * FROM eventos.spu_eventos_sel($p_eve_id,$p_ard_id,'$p_eve_fecini','$p_eve_fecfin','$p_eve_aliasn','$p_eve_activo')";

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM eventos.spu_eventos_sel(?,?,?,?,?,?)', [$p_eve_id, $p_ard_id, $p_eve_fecini, $p_eve_fecfin, $p_eve_aliasn, $p_eve_activo]);
        return response()->json($results);
    }

    public function anularEventos(Request $request)
    {
        $p_eve_id = $request['p_eve_id'] ? $request['p_eve_id'] : 0;
        $p_eve_chkmov = $request['p_eve_chkmov'] ? $request['p_eve_chkmov'] : 0;
        $p_ccv_usumov = $request['p_ccv_usumov'] ? $request['p_ccv_usumov'] : 0;

        // return "SELECT * FROM eventos.spu_eventos_anu($p_eve_id,$p_eve_chkmov,$p_ccv_usumov)";

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM eventos.spu_eventos_anu(?,?,?)', [$p_eve_id, $p_eve_chkmov, $p_ccv_usumov]);
        return response()->json($results);
    }

    public function registrarEventos(Request $request)
    {
        $p_eve_id = $request['p_eve_id'] ? $request['p_eve_id'] : 0;
        $p_ard_id = $request['p_ard_id'] ? $request['p_ard_id'] : 0;
        $p_usu_id = $request['p_usu_id'] ? $request['p_usu_id'] : 0;
        $p_eve_fecini = $request['p_eve_fecini'] ? $request['p_eve_fecini'] : '';
        $p_eve_horini = $request['p_eve_horini'] ? $request['p_eve_horini'] : '';
        $p_eve_fecfin = $request['p_eve_fecfin'] ? $request['p_eve_fecfin'] : '';
        $p_eve_horfin = $request['p_eve_horfin'] ? $request['p_eve_horfin'] : '';
        $p_eve_nombre = $request['p_eve_nombre'] ? $request['p_eve_nombre'] : '';
        $p_eve_aliasn = $request['p_eve_aliasn'] ? $request['p_eve_aliasn'] : '';
        $p_eve_lugars = $request['p_eve_lugars'] ? $request['p_eve_lugars'] : '';
        $p_eve_observ = $request['p_eve_observ'] ? $request['p_eve_observ'] : '';
        $p_eve_reqrec = $request['p_eve_reqrec'] ? $request['p_eve_reqrec'] : '';
        $p_eve_monval = $request['p_eve_monval'] ? $request['p_eve_monval'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM eventos.spu_eventos_gra(?,?,?,?,?,?,?,?,?,?,?,?,?)', [
                $p_eve_id,
                $p_ard_id,
                $p_usu_id,
                $p_eve_fecini,
                $p_eve_horini,
                $p_eve_fecfin,
                $p_eve_horfin,
                $p_eve_nombre,
                $p_eve_aliasn,
                $p_eve_lugars,
                $p_eve_observ,
                $p_eve_reqrec,
                $p_eve_monval
            ]);

            $numid = $results[0]->numid;
            $sftpHost = self::$host;
            $sftpPort = self::$port;
            $sftpUsername = self::$user;
            $sftpPassword = self::$pass;
            $remoteFolderPath = '/mdsmp/files/eventos/' . $numid . '/';
            $conexion = ssh2_connect($sftpHost, $sftpPort);
            if (ssh2_auth_password($conexion, $sftpUsername, $sftpPassword)) {
                $sftp = ssh2_sftp($conexion);
                $remoteDir = "ssh2.sftp://$sftp$remoteFolderPath";
                if (!file_exists($remoteDir)) {
                    if (!ssh2_sftp_mkdir($sftp, $remoteFolderPath, 0777, true)) {
                        $data = [
                            "p_error" => -4,
                            "p_mensa" => "Error al crear la carpeta en el servidor.",
                        ];
                        return json_encode($data);
                    }
                }
                $data = $results;
                ssh2_disconnect($conexion);
            } else {
                $data = [
                    "p_error" => -2,
                    "p_mensa" => "Error de autenticación SFTP",
                ];
            }
            return response()->json($data);
        }
    }

    public function listarMenu(Request $request)
    {

        $p_usu_id = ($request['p_usu_id']) ? $request['p_usu_id'] : 0;
        $p_apl_id = ($request['p_apl_id']) ? $request['p_apl_id'] : 0;

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM sistemas.spu_permisousuario_obj(?,?)', [
            $p_usu_id,
            $p_apl_id
        ]);


        $menuItems = self::generarMenu($results);

        return $menuItems;
    }

    function generarMenu($flatMenuItems, $parentId = null)
    {
        $menuItems = array();

        foreach ($flatMenuItems as $item) {

            if ($item->obj_idpadr === $parentId) {
                $menuItem = array(
                    'apf_id' => $item->apf_id,
                    'obj_id' => $item->obj_id,
                    'obj_descri' => $item->obj_descri,
                    'obj_enlace' => $item->obj_enlace,
                    'obj_chkmen' => $item->obj_chkmen,
                    'obj_chkpin' => $item->obj_chkpin,
                    'obj_idpadr' => $item->obj_idpadr,
                );

                $children = self::generarMenu($flatMenuItems, $item->obj_id);
                if (!empty($children)) {
                    $menuItem['sub_menu'] = $children;
                }

                $menuItems[] = $menuItem;
            }
        }

        return $menuItems;
    }

    public function archivosSel(Request $request)
    {
        $p_eve_id = $request['p_eve_id'] ? $request['p_eve_id'] : 0;
        $p_epf_activo = $request['p_epf_activo'] ? $request['p_epf_activo'] : 0;

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM eventos.spu_eventospdf_sel(?,?)', [$p_eve_id, $p_epf_activo]);
        return response()->json($results);
    }

    public function uploadFilesArchivos(Request $request)
    {
        $eve_id = $request['eve_id'];
        $p_usu_id = $request['p_usu_id'];
        $i = 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sftpHost = self::$host;
            $sftpPort = self::$port;
            $sftpUsername = self::$user;
            $sftpPassword = self::$pass;
            $remoteFolderPath = '/mdsmp/files/eventos/' . $eve_id . '/';
            $results = []; // Inicializa results

            if (isset($_FILES['files_archivos']) && !empty($_FILES['files_archivos']['name'][0])) {
                $conexion = ssh2_connect($sftpHost, $sftpPort);
                if (ssh2_auth_password($conexion, $sftpUsername, $sftpPassword)) {
                    foreach ($_FILES['files_archivos']['tmp_name'] as $key => $tmpName) {
                        $nombreOriginal = $_FILES['files_archivos']['name'][$key];
                        $rutaRemota = $remoteFolderPath . $nombreOriginal;

                        if (ssh2_scp_send($conexion, $tmpName, $rutaRemota, 0777)) {
                            $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM eventos.spu_eventospdf_reg(?,?,?)', [$eve_id, $nombreOriginal, $p_usu_id]);
                            if (isset($results[0]->error) && $results[0]->error < 0) {
                                return response()->json($results);
                            } else {
                                ssh2_disconnect($conexion);
                                return response()->json($results);
                            }
                        } else {
                            ssh2_disconnect($conexion);
                            return response()->json(['error' => 'Error al subir el archivo.']);
                        }
                    }
                    ssh2_disconnect($conexion);
                } else {
                    return response()->json(['error' => 'Error en la autenticación SFTP.']);
                }
            } else {
                return response()->json(['error' => 'No se han enviado archivos.']);
            }
            return response()->json($results);
        }
        return response()->json(['error' => 'Método de solicitud no permitido.']);
    }

    public function eliminararchivos(Request $request)
    {
        $p_epf_id = $request['p_epf_id'];
        $ruta = $request['ruta'];

        $this->deletefile($ruta);

        $results = DB::connection(self::$conexionpsql)->select('SELECT * FROM eventos.spu_eventospdf_del(?)', [$p_epf_id]);
        return response()->json($results);
    }

    public function deletefile($ruta)
    {
        $rutaRemota = $ruta;
        $sftpHost = self::$host;
        $sftpPort = self::$port;
        $sftpUsername = self::$user;
        $sftpPassword = self::$pass;
        $conexion = ssh2_connect($sftpHost, $sftpPort);

        if (ssh2_auth_password($conexion, $sftpUsername, $sftpPassword)) {
            $sftp = ssh2_sftp($conexion);
            $rutaRemotaCompleta = "ssh2.sftp://$sftp" . $rutaRemota;

            if (ssh2_sftp_unlink($sftp, $rutaRemota)) {
                $data = [
                    "p_error" => 0,
                    "p_mensa" => "Archivo eliminado exitosamente.",
                ];
            } else {
                $data = [
                    "p_error" => -1,
                    "p_mensa" => "Error al eliminar el archivo remoto.",
                ];
            }
            ssh2_disconnect($conexion);
        } else {
            $data = [
                "p_error" => -2,
                "p_mensa" => "Error al autenticar la conexión SFTP."
            ];
        }
        return json_encode($data);
    }

    public function getvisualizarArchivos(Request $request)
    {
        $rutaLocal = '/var/www/html/calendariobackend/public/' . $request['nombre'];
        $rutaRemota = $request['ruta'];

        $sftpHost = self::$host;
        $sftpPort = self::$port;
        $sftpUsername = self::$user;
        $sftpPassword = self::$pass;
        $conexion = ssh2_connect($sftpHost, $sftpPort);

        if (ssh2_auth_password($conexion, $sftpUsername, $sftpPassword)) {
            $rutaRemotaCompleta = $rutaRemota;
            if (ssh2_scp_recv($conexion, $rutaRemotaCompleta, $rutaLocal)) {
                $data = [
                    "p_error" => 0,
                    "p_mensa" => 'https://webapp.mdsmp.gob.pe/calendariobackend/public/' . $request['nombre'],
                ];
            } else {
                $data = [
                    "p_error" => -1,
                    "p_mensa" => "Error al recibir el archivo remoto.",
                ];
            }
            ssh2_disconnect($conexion);
        } else {
            $data = [
                "p_error" => -2,
                "p_mensa" => "Error al recibir el archivo remoto."
            ];
        }
        return json_encode($data);
    }
}
