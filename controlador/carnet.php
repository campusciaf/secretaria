
<?php
// error_reporting(0);
require_once "../modelos/Carnet.php";
require "../public/phpqrcode/qrlib.php";

$carnet = new Carnet();
switch ($_GET['op']) {
    case 'buscar':
        $programaCarnetSeleccionado = $_POST['valorSeleccionado'];

        $cc = $_POST['cc'];
        $sizeqr = "600";
        $datos = $carnet->buscar($cc);
        $nombre = $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . ' ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'];
        $cedula = $datos['credencial_identificacion'];

        if (file_exists("../files/estudiantes/" . $datos['credencial_identificacion'] . ".jpg")) {
            $url = "../files/estudiantes/" . $datos['credencial_identificacion'] . ".jpg";
        } else {
            $url = "../files/null.jpg   ";
        }
        $programa = $carnet->consultaprograma($programaCarnetSeleccionado);
        $programa_nombre = @$programa['nombre'];
        $programa_original = @$programa['original'];
        $carnet = @$programa['carnet'];

        $data['cotenido_carnet'] = '';
        $data['conte2'] = '';
        $tempDir = "../temp/";
        $codeContents = $cc;
        // we need to generate filename somehow, 
        // with md5 or with database ID used to obtains $codeContents...
        $fileName = $codeContents . '.png';
        $pngAbsoluteFilePath = $tempDir . $fileName;
        $imageData = $pngAbsoluteFilePath;
        //generating
        //comentar para que funcione en el local
        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png($codeContents, $pngAbsoluteFilePath,QR_ECLEVEL_L, 9);
        } 

        //para que salga el codigo qr en el local
        // if (!file_exists($imageData)) {
        //     $imageData = "../public/img/carnet/qr_servidor.png";
        // }
        if ($datos != false) {
            $data['status'] = "ok";

            $data['cotenido_carnet'] .= ' 
            <div class="col-md-12 mt-4" id="carnet_frontal" style="width: 204px; height: 324px; background-image: url(../public/img/carnet/fondo_frente.png); background-size: cover; background-repeat: no-repeat; background-position: center; padding: 10px; box-sizing: border-box;">
                <div style="margin-top: 3px;">
                    <img src="../public/img/carnet/logo_actualizado.webp" width="80px">
                </div>

                <div style="position: absolute; top: 70px; left: 45px; width: 102px; height: 102px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                    <img src="' . $url . '" style="width: 102px; height: 102px; object-fit: cover; border-radius: 0 !important;">
                </div>

                <div style="margin-top: 180px;">
                    <div class="fuentecarnet">
                        <div class= "text-center" style="font-size: 14px; color: #132252;margin-bottom: -4px;">
                            ' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . '
                        </div>
                        <div class= "text-center" style="font-size: 10px; font-weight: bold; color: #132252; margin-bottom: 3px;">
                            ' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '
                        </div>
                        <div class="text-center" style="font-size: 10px; color: #132252;margin-bottom: 5px;">
                            <strong>' . $cedula . '</strong> RH ' . $datos['tipo_sangre'] . '
                        </div>

                        <div class="text-center" style="font-size: 9px;color: #132252;margin-top: -1px;margin-bottom: 5px;word-wrap: break-word;white-space: normal;">
                            ' . mb_strtoupper($programa_nombre, 'UTF-8') . '
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 13px;">
                <button class="btn btn-success" onclick="imprime()">Imprimir</button>
            </div>';
            $data['conte2'] .= '  
            <div class="col-md-12 mt-4" id="carnet_back" style="width: 204px; height: 324px;background-image: url(\'../public/img/carnet/back_carnet.png\');background-size: cover;background-repeat: no-repeat;background-position: center;padding: 12px;color: #132252;">
            <div style="margin-bottom: 3px;">
                <img src="../public/img/carnet/logo_actualizado.webp" width="90px">
            </div>
            <div style="font-size: 6px; text-align: right; padding-right: 20px;" class="fuentecarnet">
                Si usted encontró este documento por favor notifíquelo
            </div>
            <div style="top: 60px; left: 20px; font-size: 6px;" class="fuentecarnet text-center">
                inmediatamente.
            </div>
                <hr style="border: none; border-top: 1px solid #132252; width: 81%; margin: 5px auto;">
                <div style="text-align: center; margin: -5px 0;">
                    <img src="' . $imageData . '" width="130px" ">
                </div>
                <div style="font-size: 9px; text-align: center; line-height: 1.3;" class="fuentecarnet">
                    Cra 6 N 24 - 56<br>
                    Cll 20 N 4-57<br>
                    Teléfono 3400 100<br>
                    <a>www.ciaf.edu.co</a>
                </div>
                <div style="font-size: 15px; text-align: center; font-weight: bold; margin-top: 6px;" class="fuentecarnet">
                    Pereira - Risaralda
                </div>
                <div class="text-center" style="margin-top:2px;">
                    <img src="../public/img/carnet/vigilada_mineducacion.png" alt="Vigilada Mineducación" style="width:39px; height:auto;">
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 13px;">
                <button class="btn btn-success" onclick="imprime2()">Imprimir</button>
            </div>';
        } else {
            $data['status'] = "error";
        }
        echo json_encode($data);
        break;

    case 'generarqr':
        $rst = $carnet->consultaestudiante();
        $tempDir = "../temp/";
        $codeContents = base64_encode($rst['credencial_identificacion']);
        // we need to generate filename somehow, 
        // with md5 or with database ID used to obtains $codeContents...
        $fileName = base64_encode($rst['credencial_identificacion']) . '.png';
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
            $newQR // Pegar en
            ,
            $logoYT // Pegar desde
            ,
            ($width / 2) - ($ytwidth / 2),
            ($height / 2) - ($ytheight / 2),
            0,
            0,
            $ytwidth,
            $ytheight
        );
        imagepng($newQR, $pngAbsoluteFilePath, 0);
        $data['status'] = "ok";
        $data['conte'] = '<img src="' . $pngAbsoluteFilePath . '" width="100%">';
        echo json_encode($data);
        break;

    case 'generarqrdocente':
        $rst = $carnet->consultadocente();
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
            $newQR // Pegar en
            ,
            $logoYT // Pegar desde
            ,
            ($width / 2) - ($ytwidth / 2),
            ($height / 2) - ($ytheight / 2),
            0,
            0,
            $ytwidth,
            $ytheight
        );
        imagepng($newQR, $pngAbsoluteFilePath, 0);
        $data['status'] = "ok";
        $data['conte'] = '<img src="' . $pngAbsoluteFilePath . '" width="100%">';
        echo json_encode($data);

        break;


    case "selectProgramaCarnet":

        $cc = $_POST['cc'];

        $datos_estudiante = $carnet->buscarprogramaestudiante($cc);
        // Inicia sin seleccionar nada si deseas mantener la opción de "nada seleccionado"
        echo "<option value=''>Nothing selected</option>";
        // Variable para controlar el primer elemento
        $esPrimero = true;
        foreach ($datos_estudiante as $estudiante) {
            $id_programa_ac = $estudiante['id_programa_ac'];
            $datos_programa = $carnet->consultaprograma($id_programa_ac);

            if ($datos_programa) { // Verifica si hay datos del programa antes de intentar mostrarlos
                // Añade 'selected' solo si es el primer elemento
                $selected = $esPrimero ? ' selected' : '';
                echo "<option value='" . htmlspecialchars($datos_programa["id_programa"], ENT_QUOTES, 'UTF-8') . "'" . $selected . ">" . htmlspecialchars($datos_programa["nombre"], ENT_QUOTES, 'UTF-8') . "</option>";
                // Asegura que 'selected' solo se aplique al primer elemento
                $esPrimero = false;
            }
        }

        break;
}
