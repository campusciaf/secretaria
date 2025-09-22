<?php 
require_once "../modelos/HeaderDocente.php";

$headerdocente = new HeaderDocente();


date_default_timezone_set("America/Bogota");    
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";
$fecha_anterior=date("Y-m-d",strtotime($fecha."- 1 days"));
$semana = date("Y-m-d",strtotime($fecha."- 1 week")); 

switch ($_GET["op"]){

    case 'listarTema':
        $datos = $headerdocente->listarTema();
        $modo_ui=$datos["modo_ui"];
    
        $data['conte'] = $modo_ui;
        echo json_encode($data);
    
    break;
    
    case 'generarqrdocente':
        

        $rst = $headerdocente->consultadocente();
    
        $tempDir = "../temp/";        
        $codeContents = base64_encode($rst['usuario_identificacion']);       
        // we need to generate filename somehow, 
        // with md5 or with database ID used to obtains $codeContents...
        $fileName = base64_encode($rst['usuario_identificacion']).'.png';
        
        $pngAbsoluteFilePath = $tempDir.$fileName;
        
        // generating
        if (!file_exists($pngAbsoluteFilePath)) {

            QRcode::png(
                $codeContents          // Contenido
                ,$pngAbsoluteFilePath   // Nombre del archivo
                ,QR_ECLEVEL_Q   // Indice de corrección de errores
                ,5              // Tamaño en pixeles de cada cuadro que conforma el QR
                ,1              // Margen en unidades "Tamaño".
            );
        }

        $logo = "../public/img/logo_qr.png";

        $originalQR=@imagecreatefrompng($pngAbsoluteFilePath);
        $logoYT=@imagecreatefrompng($logo);
        $dataQR=getimagesize($pngAbsoluteFilePath);
        $dataYT=getimagesize($logo);

        list($width, $height) = getimagesize($pngAbsoluteFilePath);
        list($ytwidth, $ytheight) = getimagesize($logo);

        $newQR = imagecreatetruecolor($width, $height);

        imagecopy(  $newQR // Pegar en
                    ,$originalQR // Pegar desde
                    ,0 // Destino X
                    ,0 // Destino Y
                    ,0 // X Origen (copiar desde esta coordenada)
                    ,0 // Y Origen (copiar desde esta coordenada)
                    ,$width // Ancho de la imagen que se va a pegar
                    ,$height // Alto de la imagen que se va a pegar
                );

        imagecopy(
            $newQR,
            $logoYT,
            (int)(($width / 2) - ($ytwidth / 2)),
            (int)(($height / 2) - ($ytheight / 2)),
            0,
            0,
            $ytwidth,
            $ytheight
        );

        imagepng($newQR,$pngAbsoluteFilePath,0);

        $data['status'] = "ok";
        $data['conte'] = '<img src="'.$pngAbsoluteFilePath.'" style="width:250px">';

        echo json_encode($data);

    break;
    case 'verificarInduccionPlataforma':
        $reg = $headerdocente->verificarInduccionPlataforma();
        if(is_array($reg) && count($reg) > 0){
            $data['exito'] = "1";
        } else{
            $data['exito'] = "0";
        }
        echo json_encode($data);
    break;
    case "listarPuntos":
        $rspta = $headerdocente->listarPuntos();
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

    case 'docenteDestacado':
        $reg = $headerdocente->docenteDestacado();
        $data['exito'] = $reg["ponderado"];
        $reg = $headerdocente->consultadocente();
        $data['influencer'] = $reg["influencer_mas"];
        
        echo json_encode($data);
    break;
}
?>
