<?php
require_once "../modelos/Header.php";
$header = new Header();

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual = date('Y-m') . "-00";

$horai = date('H:i:s', strtotime('- 1 minutes'));
$horaf = date('H:i:s', strtotime('+ 1 minutes'));


$rsptaperiodo = $header->periodoactual();
$periodo_actual = $_SESSION['periodo_actual'];
$id_usuario = $_SESSION['id_usuario'];

$usuario_direccion = isset($_POST["usuario_direccion"]) ? limpiarCadena($_POST["usuario_direccion"]) : "";
$usuario_telefono = isset($_POST["usuario_telefono"]) ? limpiarCadena($_POST["usuario_telefono"]) : "";
$usuario_celular = isset($_POST["usuario_celular"]) ? limpiarCadena($_POST["usuario_celular"]) : "";
$usuario_email = isset($_POST["usuario_email"]) ? limpiarCadena($_POST["usuario_email"]) : "";

switch ($_GET["op"]) {

    case 'listarTema':
        $datos = $header->listarTema();
        $modo_ui = $datos["modo_ui"];

        $data['conte'] = $modo_ui;
        echo json_encode($data);

    break;

    case "listarPuntos":
        $rspta = $header->listarPuntos();
        if ($rspta) {
            $data["exito"] = $rspta["puntos"];
            
        } else {
            $data["exito"] = "error";
            
        }
        $data["nivel"] ='
        <div class="col-10 next-level p-4">
            <h2 class="fs-18 text-white">Nivel actual</h2>
            <div class="col-12 text-center"><i class="fas fa-star fa-4x text-primary"></i> <span class="text-white next-numero fs-32">'.$rspta["nivel"].'</span></div>
            <div class="col-12 py-2">
                <span class="text-white">Total: </span><img src="../public/img/coin.webp" alt="coin" class="img-fluid" style="width:18px;height:18px"> <span class="text-danger font-weight-bolder"> '.$rspta["puntos"].' pts</span>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="text-white small line-height-16">Siguiente nivel <span class="font-weight-bolder">10.000 pts</span></p>
                    </div>
                    <div class="col-4">
                        <i class="fas fa-star fa-3x text-warning"></i><span class="text-white next-numero fs-22">2</span>
                    </div>
                </div>
            </div>
        </div>';

        echo json_encode($data);
    break;


    case 'verperfilactualizado':
        $data = array();
        $data["estado"] = "";

        $semanas = date("Y-m-d", strtotime($fecha . "- 8 week"));

        $rsptafuncionario = $header->verPerfilActualizadofuncionario($id_usuario, $semanas);
        $rsptadocente = $header->verPerfilActualizadodocente($id_usuario, $semanas);
        if ($rsptafuncionario == true || $rsptadocente == true) {
            $data["estado"] = "1";
        } else {
            $data["estado"] = "2";
        }
        echo json_encode($data);

    break;

    case 'mostrar':
        $rspta = $header->mostrar($id_usuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'actualizarperfil':
        $data = array();
        $data["estado"] = "";
        $rspta = $header->actualizarperfil($id_usuario, $usuario_direccion, $usuario_telefono, $usuario_celular, $usuario_email, $fecha);
        $rspta ? "si" : "no";

        $data["estado"] = $rspta;

        echo json_encode($data);
    break;

    case 'generarqradminis':


        $rst = $header->consultaAdmin();

        $tempDir = "../temp/";
        $codeContents = base64_encode($rst['usuario_identificacion']);
        // we need to generate filename somehow, 
        // with md5 or with database ID used to obtains $codeContents...
        $fileName = base64_encode($rst['usuario_identificacion']) . '.png';

        $pngAbsoluteFilePath = $tempDir . $fileName;

        // generating
        if (!file_exists($pngAbsoluteFilePath)) {

            QRcode::png(
                $codeContents          // Contenido
                ,
                $pngAbsoluteFilePath   // Nombre del archivo
                ,
                QR_ECLEVEL_Q   // Indice de corrección de errores
                ,
                5              // Tamaño en pixeles de cada cuadro que conforma el QR
                ,
                1              // Margen en unidades "Tamaño".
            );
        }

        $logo = "../public/img/logo_qr.png";

        $originalQR = @imagecreatefrompng($pngAbsoluteFilePath);
        $logoYT = @imagecreatefrompng($logo);
        $dataQR = getimagesize($pngAbsoluteFilePath);
        $dataYT = getimagesize($logo);

        list($width, $height) = getimagesize($pngAbsoluteFilePath);
        list($ytwidth, $ytheight) = getimagesize($logo);

        $newQR = imagecreatetruecolor($width, $height);

        imagecopy(
            $newQR // Pegar en
            ,
            $originalQR // Pegar desde
            ,
            0 // Destino X
            ,
            0 // Destino Y
            ,
            0 // X Origen (copiar desde esta coordenada)
            ,
            0 // Y Origen (copiar desde esta coordenada)
            ,
            $width // Ancho de la imagen que se va a pegar
            ,
            $height // Alto de la imagen que se va a pegar
        );

        imagecopy(
            $newQR, // Pegar en
            $logoYT, // Pegar desde
            round(($width / 2) - ($ytwidth / 2)), // Destino X, redondeado
            round(($height / 2) - ($ytheight / 2)), // Destino Y, redondeado
            0,
            0,
            $ytwidth,
            $ytheight
        );

        imagepng($newQR, $pngAbsoluteFilePath, 0);


        $data['status'] = "ok";
        $data['conte'] = '<img src="' . $pngAbsoluteFilePath . '" style="width:220px">';

        echo json_encode($data);

    break;

    case 'datosCarnet':

        $cc = $_SESSION['usuario_imagen'];
        $sizeqr = "600";
        $datos = $header->consultaAdmin();
        // traer el periodo actual.
        $perido_carnet = $header->PeriodoActualCarnet();
        $anio_carnet =   explode("-", $perido_carnet["periodo_actual"]);
        $periodo_actual_carnet = $anio_carnet[0];



        $nombre = $datos['usuario_apellido'] . ' ' . $datos['usuario_apellido_2'] . '<div class="pl-4 ">Apellidos</div><br> ' . $datos['usuario_nombre'] . ' ' . $datos['usuario_nombre_2'] . '<br><small>Nombres</small>';
        $cedula = $datos['usuario_identificacion'];




        if (file_exists("../files/usuarios/" . $datos['usuario_identificacion'] . ".jpg")) {
            $url = "../files/usuarios/" . $datos['usuario_identificacion'] . ".jpg";
        } else {
            $url = "../files/null.jpg";
        }
        $data['conte'] = '';
        if ($datos != false) {
            $data['status'] = "ok";
            $data['conte'] .= '       
                <div class="d-flex justify-content-center">
                    <table  style="border: solid #c4c4c4 1px" class="m-0 p-0" width="480px">
                        <tr>
                            <td>
                            </td>
                            <td rowspan="4" valign="bottom" width="140px" align="center">
                                <img src="../public/img/logo_ciaf_carnet.svg" width="130px">
                                <img src="' . $url . '" width="90px">
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="pl-4"><b>' . $cedula . '</b> RH. ' . $datos['usuario_tipo_sangre'] . '</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="line-height:16px"> 
                                <div class="pl-4"><span style="font-weight:700; font-size:18px">' . strtoupper($datos['usuario_apellido']) . ' ' . strtoupper($datos['usuario_apellido_2']) . '</span><br><small>Apellidos</small></div>
                                <div class="pl-4"><span style="font-weight:700; font-size:18px">' . strtoupper($datos['usuario_nombre']) . ' ' . strtoupper($datos['usuario_nombre_2']) . '</span><br><small>Nombres</small></div>
                            </td> 
                        </tr>
                        <tr>
                            <td>
                                
                                <div class="pl-4"><span class="titulo-4" style="color:#000000;font-size:24px !important; font-weight:700"> ' . $datos['usuario_cargo'] . '</span></div>
                                <div class="pl-4"><small>Cargo</small></div>
                                
                            </td>
                        </tr>
                        

                        <tr>
                            <td align="right" colspan="2">
                                <span class="small">VENCE: 31/12/' . $periodo_actual_carnet . '</span>
                                <span class="small pr-4">VIGILADA MINEDUCACIÓN</span>
                                
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="row m-0 p-0">
                                    <div class="col-3 bg-primary" style="height:10px"></div>
                                    <div class="col-3 bg-danger" style="height:10px"></div>
                                    <div class="col-3 bg-warning" style="height:10px"></div>
                                    <div class="col-3 bg-success" style="height:10px"></div>
                                    <div class="col-12 text-white" style="height:40px; background-color: #132252; text-align:center; font-size:28px"> Administrativo CIAF</div>
                                </div>
                            </td>
                        </tr>
                    </table>                
                </div>';
        } else {
            $data['status'] = "error";
        }

        echo json_encode($data);

    break;

    case 'buscarPermiso':
        $datos = $header->buscarPermiso();
        $resultado = $datos["asesor"];

        $data['conte'] = $resultado;
        echo json_encode($data);

    break;

    case 'buscarTareas':
        
        $data['conte'] ='';
        $datos = $header->buscarTareas($fecha,$horai,$horaf);
        for ($i=0; $i < count($datos); $i++) {
            $data['conte'] .= '<span class="text-success"> Tienes una ' . $datos[$i]["motivo_tarea"] . '</span> <br>' . $datos[$i]["mensaje_tarea"];
            $header->recordatorioTarea($datos[$i]["id_tarea"]);
        }
        echo json_encode($data);
    break;

}
