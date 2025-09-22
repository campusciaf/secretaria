<?php
require_once "../modelos/MiCarnet.php";
require "../public/phpqrcode/qrlib.php";
$micarnet = new MiCarnet();
switch ($_GET['op']) {
   
case 'buscar':
    $programa_seleccionado = $_POST['programa_seleccionado'];
    $cc = $_SESSION['usuario_imagen'];
    $datos = $micarnet->buscar($cc);
    $periodo_carnet = $micarnet->PeriodoActualCarnet();
    $anio_carnet = explode("-", $periodo_carnet["periodo_actual"]);
    $periodo_actual_carnet = $anio_carnet[0];
    $cedula = $datos['credencial_identificacion'];

    $datosprograma = $micarnet->consultaprograma($programa_seleccionado);
    $programa_nombre = $datosprograma['nombre'];

    $url = file_exists("../files/estudiantes/" . $cedula . ".jpg")
        ? "../files/estudiantes/" . $cedula . ".jpg"
        : "../files/null.jpg";

    $tempDir = "../temp/";
    $fileName = $cc . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileName;
    $imageData = $pngAbsoluteFilePath;

    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($cc, $pngAbsoluteFilePath, QR_ECLEVEL_L, 9);
    }

    $data = [];

    if ($datos != false) {
        $data['status'] = "ok";

        // 🔷 CARNETS
        $data['carnets'] = '
        <div class="d-flex justify-content-start align-items-start mt-4 flex-wrap" style="gap: 40px;">
            <!-- CARNET FRONTAL -->
            <div class="mb-4" id="carnet_frontal" style="width: 204px; height: 324px; background-image: url(../public/img/carnet/fondo_frente.png); background-size: cover; padding: 10px; position: relative;">
                <div style="margin-top: 3px;">
                    <img src="../public/img/carnet/logo_actualizado.webp" width="80px">
                </div>
                <div style="position: absolute; top: 70px; left: 45px; width: 102px; height: 102px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                    <img src="' . $url . '" style="width: 102px; height: 102px; object-fit: cover;">
                </div>
                <div style="margin-top: 180px;" class="fuentecarnet text-center">
                    <div style="font-size: 14px; color: #132252;">' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . '</div>
                    <div style="font-size: 10px; font-weight: bold; color: #132252;">' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</div>
                    <div style="font-size: 10px; color: #132252;"><strong>' . $cedula . '</strong> RH ' . $datos['tipo_sangre'] . '</div>
                    <div style="font-size: 9px; color: #132252;">' . mb_strtoupper($programa_nombre, 'UTF-8') . '</div>
                </div>
            </div>

            <!-- CARNET TRASERO -->
            <div id="carnet_back" style="width: 204px; height: 324px; background-image: url(\'../public/img/carnet/back_carnet.png\'); background-size: cover; padding: 12px; color: #132252;">
                <div style="margin-bottom: 3px;">
                    <img src="../public/img/carnet/logo_actualizado.webp" width="90px">
                </div>
                <div style="font-size: 6px; text-align: right; padding-right: 20px;" class="fuentecarnet">
                    Si usted encontró este documento por favor notifíquelo
                </div>
                <div style="font-size: 6px; text-align: center;" class="fuentecarnet">inmediatamente.</div>
                <hr style="border-top: 1px solid #132252; width: 81%; margin: 5px auto;">
                <div style="text-align: center; margin: -5px 0;">
                    <img src="' . $imageData . '" width="130px">
                </div>
                <div style="font-size: 9px; text-align: center;" class="fuentecarnet">
                    Cra 6 N 24 - 56<br>
                    Cll 20 N 4-57<br>
                    Teléfono 3400 100<br>
                    <a>www.ciaf.edu.co</a>
                </div>
                <div style="font-size: 15px; text-align: center; font-weight: bold;" class="fuentecarnet">Pereira - Risaralda</div>
                <div class="text-center mt-1">
                    <img src="../public/img/carnet/vigilada_mineducacion.png" style="width:39px;">
                </div>
            </div>
        </div>';

        // 🔷 CONVENIOS SLIDER
        $data['convenios'] = '
        <div class="swiper" id="convenios-slider">
            <div class="swiper-wrapper">';

        $eventos = $micarnet->mostrarconvenios();
        $total = count($eventos);
        for ($i = 0; $i < $total; $i += 2) {
            $data['convenios'] .= '<div class="swiper-slide d-flex justify-content-between">';
            for ($j = 0; $j < 2; $j++) {
                $idx = $i + $j;
                if ($idx < $total) {
                    $conv = $eventos[$idx];
                    $img = '../public/web_convenios/' . $conv["imagen_convenio"];
                    $data['convenios'] .= '
                    <div class="card tarjeta-convenio mb-3 shadow-sm text-center"
                        style="width: 210px; height: 280px; display: flex; flex-direction: column; justify-content: flex-start; border-radius: 12px; overflow: hidden;">
                        <div style="padding: 12px; display: flex; justify-content: center; align-items: center; height: 120px;">
                            <img src="' . $img . '" alt="Convenio" style="max-width: 100%; max-height: 100px; object-fit: contain;">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-start align-items-center px-3 pt-1" style="flex-grow: 1;">
                            <h5 class="card-title text-center mb-1" style="font-size: 0.95rem; line-height: 1.1; height: 38px; overflow: hidden;">' . $conv["nombre_convenio"] . '</h5>
                            <p class="card-text text-center" style="font-size: 0.8rem; line-height: 1.2; height: 60px; overflow: hidden;">' . $conv["descripcion_convenio"] . '</p>
                        </div>
                    </div>';
                }
            }
            $data['convenios'] .= '</div>';
        }

        $data['convenios'] .= '</div></div>';
    } else {
        $data['status'] = "error";
    }

    echo json_encode($data);
    break;





// ...existing code...


    case "selectProgramaCarnet":

        $cc = $_SESSION['usuario_imagen'];
        $datos_estudiante = $micarnet->buscarprogramaestudiante($cc);
        echo "<option value=''>Nothing selected</option>";
        $seleccionar_primer = true;
        foreach ($datos_estudiante as $estudiante) {
            $id_programa_ac = $estudiante['id_programa_ac'];
            $datos_programa = $micarnet->consultaprograma($id_programa_ac);
            if ($datos_programa) { 
                $selected = $seleccionar_primer ? ' selected' : '';
                echo "<option value='" . htmlspecialchars($datos_programa["id_programa"], ENT_QUOTES, 'UTF-8') . "'" . $selected . ">" . htmlspecialchars($datos_programa["nombre"], ENT_QUOTES, 'UTF-8') . "</option>";
                $seleccionar_primer = false;
            }
        }
        break;

        
    case 'generarqr':
        $rst = $micarnet->consultaestudiante();
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
}
