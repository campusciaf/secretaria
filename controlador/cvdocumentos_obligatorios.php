<?php

session_start();

require_once "../modelos/CvDocumentosObligatorios.php";
$documentosObligatorios = new CvDocumentosObligatorios();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die(json_encode(array("estatus" => 0, "valor" => "Tu sesión ha caducado, Reinicia la pagina")));
}
$id_documento = isset($_POST['id_documento']) ? $_POST['id_documento'] : "";
$documento_nombre = isset($_POST['documento_nombre']) ? $_POST['documento_nombre'] : "";
$documento_archivo = isset($_POST['documento_archivo']) ? $_POST['documento_archivo'] : "";
$documento_archivo_file = isset($_FILES['documento_archivo']) ? $_FILES['documento_archivo'] : "";
// post para subir el documento.
$id_usuario_cv_documento_obligatorio = isset($_POST['id_usuario_cv_documento_obligatorio']) ? $_POST['id_usuario_cv_documento_obligatorio'] : "";
$nombre_tipos_documentos = isset($_POST['nombre_tipos_documentos']) ? $_POST['nombre_tipos_documentos'] : "";

if ($_SESSION["usuario_cargo"] == 'Docente') {


    $cadena = $_SESSION["usuario_imagen"];
    $separador = ".";
    $separada = explode($separador, $cadena);
    $cedula = $separada[0];
    $rspta_usuario = $documentosObligatorios->cv_traerIdUsuario($cedula);
} else {
    $cedula = $_SESSION["usuario_identificacion"];
    $rspta_usuario = $documentosObligatorios->cv_traerIdUsuario($cedula);
}


// $rspta_usuario = $documentosObligatorios->cv_traerIdUsuario($_SESSION["usuario_identificacion"]);
$id_usuario_cv = $rspta_usuario["id_usuario_cv"];
switch ($_GET['op']) {
    case 'guardaryeditardocumentos_obligatorios':
        //revisar si el tipo de archivo es compatible con los que deseamos guardar en la base de datos 
        $file_type = $documento_archivo_file['type'];
        $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png", "application/pdf"); //archivos permitidos
        if (!in_array($file_type, $allowed)) {
            $inserto = array(
                "estatus" => 0,
                "valor" => "Formato de imagen no reconocido"
            );
            echo json_encode($inserto);
            exit();
        }
        if (strpos($nombre_tipos_documentos, '(') !== false && strpos($nombre_tipos_documentos, ')') !== false) {
            // Eliminar el texto dentro de los paréntesis y espacios adicionales
            $nombre_tipos_documentos = trim(preg_replace('/\s*\(.*?\)\s*/', '', $nombre_tipos_documentos));
        }
        $nombre_documento_limpio = $nombre_tipos_documentos;


        // if ($nombre_documento_limpio === "Registro Único Tributario" || $nombre_documento_limpio === "Tarjeta Profesional") {
        //     if ($documentosObligatorios->existeDocumentoUsuario($id_usuario_cv_documento_obligatorio, $nombre_documento_limpio)) {
        //         echo json_encode([
        //             "estatus" => 0,
        //             "valor" => "Este documento ya fue registrado."
        //         ]);
        //         exit();
        //     }

        //     $estado = 1;
        //     $rspta = $documentosObligatorios->InsertarDocumentosRutTarjetaProfesional($nombre_documento_limpio, $estado, $id_usuario_cv_documento_obligatorio);
        // } else {
        //     $rspta = $documentosObligatorios->insertarDocumentosO($id_usuario_cv_documento_obligatorio, $nombre_tipos_documentos);
        // }

        if ($nombre_documento_limpio === "Registro Único Tributario" || $nombre_documento_limpio === "Tarjeta Profesional") {
            // verificamos si ya existe.
            $id_existente = $documentosObligatorios->obtenerIdDocumentoUsuario($id_usuario_cv_documento_obligatorio,$nombre_documento_limpio);
            if ($id_existente) {
                //actualizamos el estado
                $estado = 1;
                // actualizamos el archivo
                $rsptaEstado = $documentosObligatorios->actualizarDocumentoEstado($id_existente, $estado);
                // $id_documento_final = $id_existente;
                // guardamos el id encontrado para utilizarlo despues 
                $rspta = $id_existente;
            } else {
                // se inserta en caso de que no encuentre el archivo y se actualiza el estado
                $estado = 1;
                $rspta = $documentosObligatorios->InsertarDocumentosRutTarjetaProfesional($nombre_documento_limpio,$estado,$id_usuario_cv_documento_obligatorio);
            }
        } else {
            // si el documento no es registro unico o tarjeta profesional los insertamos normal.
            $rspta = $documentosObligatorios->insertarDocumentosO($id_usuario_cv_documento_obligatorio,$nombre_tipos_documentos);
        }

        if ($rspta) {
            $carpeta_destino = '../cv/files/documentos/';
            if ($file_type == "application/pdf") {
                $img1path = $carpeta_destino . "documento_U" . $id_usuario_cv . "_O" . $rspta . ".pdf";
            } else {
                $img1path = $carpeta_destino . "documento_U" . $id_usuario_cv . "_O" . $rspta . ".jpg";
            }
            if (move_uploaded_file($_FILES['documento_archivo']['tmp_name'], $img1path)) {
                $rspta2 = $documentosObligatorios->cveditarDocumento($rspta, $img1path);
                if ($rspta2) {
                    $inserto = array(
                        "estatus" => 1,
                        "valor" => "Información Guardada",
                        "nombre_tipos_documentos" => $nombre_tipos_documentos,
                        "id_usuario_cv" => $id_usuario_cv
                    );
                }
                echo json_encode($inserto);
            }
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo Actualizar"
            );
            echo json_encode($inserto);
        }
        break;
    case 'mostrarDocumentosObligatorios':
        $data = [''];
        $data[0] = '


  
                <div class="table-responsive">
                    <table id="mostrardocumentosobligatorios" style="width:100%">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Tipo Archivo</th>
                        <th scope="col" class="text-center">Archivo Nombre</th>
                        <th scope="col" class="text-center">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                </div>';

        $tipos_documentos = [
            "Cédula de ciudadanía",
            "Certificación Bancaria",
            "Antecedentes Judiciales Policía",
            "Antecedentes Contraloría",
            "Antecedentes Procuraduría",
            "Referencias Laborales",
            "Certificado Afiliación EPS",
            "Certificado Afiliación AFP (Fondo de Pensión)",
            "Hoja de vida",
            "Registro Único Tributario (RUT)",
            "Tarjeta Profesional"
        ];
        $documentos_count = count($tipos_documentos);
        for ($i = 0; $i < $documentos_count; $i++) {
            $nombre_documentos = $tipos_documentos[$i];
            $nombre_documentos_filtrado = trim(preg_replace('/\s*\(.*?\)\s*/', '', $nombre_documentos));
            // Verificar si el usuario tiene el documento con su nombre actual
            $documentos_usuario = $documentosObligatorios->listarDocumentosObligatorios($id_usuario_cv, $nombre_documentos_filtrado);
            if (is_array($documentos_usuario) && count($documentos_usuario) > 0 && !empty($documentos_usuario[0]['documento_archivo'])) {
                $rutas_concatenadas = $documentos_usuario[0]['documento_archivo'];
                $ruta_documento_obligatorio = '<a href="' . $documentos_usuario[0]['documento_archivo'] . '" target="_blank">Abrir Archivo</a>';
                $crear_documento = '';
                $boton_eliminar = '<button class="btn btn-flat btn-danger btn-sm" onclick="eliminarDocumentoObligatorio(' . $id_usuario_cv . ',`' . $documentos_usuario[0]['documento_nombre'] . '`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar">  <i class="fas fa-trash"></i> </button>';
                $switch = '';
            } else {
                $ruta_documento_obligatorio = 'Falta Subir';
                $crear_documento = '<button class="btn btn-primary" onclick="CrearDocumentoObligatorio(' . $id_usuario_cv . ',`' . $nombre_documentos . '`)">Subir Archivo</button>';
                $boton_eliminar = '';
                $switch = '';

                if ($nombre_documentos === "Registro Único Tributario (RUT)" || $nombre_documentos === "Tarjeta Profesional") {
                    $crear_documento = '<button id="btnSubir_' . $i . '" class="btn btn-primary d-none" onclick="CrearDocumentoObligatorio(' . $id_usuario_cv . ',`' . $nombre_documentos . '`)">Subir Archivo</button>';
                    //boton si y no para rut y para tarjeta profesional
                    $switch = '
                    <div class="d-flex justify-content-center align-items-center mb-3" style="gap: 1rem;">
                        <div style="text-align: center !important;">
                            <label>
                            <span id="label_estado_' . $i . '" style="display: none;">No</span>
                            </label>

                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="toggle_' . $i . '" id="toggle_si_' . $i . '" onchange="toggleSubir(' . $i . ', true, ' . $id_usuario_cv . ',`' . $nombre_documentos . '` )">
                            <label for="toggle_si_' . $i . '" class="switch-label switch-label-off" >Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="toggle_' . $i . '" id="toggle_no_' . $i . '"  onchange="toggleSubir(' . $i . ', false, ' . $id_usuario_cv . ',`' . $nombre_documentos . '`)" checked>
                            <label for="toggle_no_' . $i . '" class="switch-label switch-label-on">No</label>
                            </div>
                        </div>
                        <br>
                        <div style="margin-left: 1rem;">
                            ' . $crear_documento . '
                        </div>
                    </div>';


                    
                }
            }
            // $mostrar_archivo = ($nombre_documentos === "Otros Estudios") ? '<button class="btn btn-success btn-sm" onclick="mostrarArchivo(`' . $nombre_documentos . '`)" title="Mostrar Archivo"><i class="fas fa-eye"></i> </button>' : '';
            $data[0] .= '
                       <tr>
                    <td>' . ($i + 1) . '</td>
                    <td>' . $nombre_documentos . '</td>
                    <td>' . (count($documentos_usuario) > 0 ? $ruta_documento_obligatorio : 'Falta Subir') . '</td>
                    <td class="text-center">
                        ' . $switch . ' ' . $crear_documento . ' ' . $boton_eliminar . '
                    </td>
                </tr>';
        }

        $data[0] .= '</tbody></table>';
        echo json_encode($data);
        break;





    // mostrar documentos anterior
    // case 'mostrarDocumentosObligatorios':
    //     if ($_SESSION["usuario_cargo"] == 'Docente'){
    //         $cadena = $_SESSION["usuario_imagen"];
    //         $separador = ".";
    //         $separada = explode($separador, $cadena);
    //         $cedula = $separada[0];
    //         $rspta_usuario = $documentosObligatorios->cv_traerIdUsuario($cedula);

    //     }else{
    //         $cedula = $_SESSION["usuario_identificacion"];
    //         $rspta_usuario = $documentosObligatorios->cv_traerIdUsuario($cedula);
    //     }

    //     $documentosO_stmt = $documentosObligatorios->cvlistarDocumentosObligatorios($cedula);
    //     if($documentosO_stmt->rowCount()>0){
    //         $documentosO_arr = array();
    //         while($documentosOrow_ = $documentosO_stmt->fetch(PDO::FETCH_ASSOC)){
    //             extract($documentosOrow_);
    //             $documentosO_arr[] = array(
    //                 'id_documento'=>$id_documentacion,
    //                 'documento_nombre'=>$documento_nombre,
    //                 'documento_archivo'=>$documento_archivo,
    //                 'id_usuario'=>$id_usuario,
    //             );
    //         }

    //     }
    //     else{
    //         $documentosO_arr[] = array(
    //                 'id_documento'=>"",
    //                 'documento_nombre'=>"",
    //                 'documento_archivo'=>"",
    //                 'id_usuario'=>"",
    //         );
    //     }
    //     echo(json_encode($documentosO_arr));
    // break;
    // case 'eliminarDocumentoObligatorio':
    //     $rspta = $documentosObligatorios->cvdocumentosOeliminar($id_documento);
    //     if ($rspta) {
    //         $inserto = array(
    //             "estatus" => 1,
    //             "valor" => "Información Elimanada"
    //         );
    //         echo json_encode($inserto);
    //     } else {
    //         $inserto = array(
    //             "estatus" => 0,
    //             "valor" => "La información no se pudo eliminar"
    //         );
    //         echo json_encode($inserto);
    //     }
    //     break;
    case 'eliminarDocumentoObligatorio':
        $id_usuario_cv = isset($_POST['id_usuario_cv']) ? $_POST['id_usuario_cv'] : "";
        $nombre_documentos = isset($_POST['nombre_documentos']) ? $_POST['nombre_documentos'] : "";
        $rspta = $documentosObligatorios->cvdocumentosOeliminar($id_usuario_cv, $nombre_documentos);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Documento eliminado: " . $nombre_documentos
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo eliminar"
            );
            echo json_encode($inserto);
        }
        break;



    case 'mostrarotrosestudios':
        $data = [];
        $data[0] = '
                <table id="mostrardocumentosootrosestudios" class="table">
                <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nombre Archivo</th>
                    <th scope="col" class="text-center">Ver Archivo</th>
                    <th scope="col" class="text-center">Opciones</th>
                </tr>
                </thead>
                <tbody>';

        // Obtener los documentos de "Otros Estudios"
        $documentos_usuario = $documentosObligatorios->listarDocumentosObligatoriosotrosestudios($id_usuario_cv);

        // Verificar si hay documentos y recorrerlos
        for ($i = 0; $i < count($documentos_usuario); $i++) {
            $nombre_archivo = basename($documentos_usuario[$i]['documento_archivo']);
            $nombre_documentos = isset($documentos_usuario[$i]['tipo_documento']) ? $documentos_usuario[$i]['tipo_documento'] : 'Sin Nombre';

            // Procesar la ruta del archivo
            $ruta_documento_obligatorio = !empty($documentos_usuario[$i]['documento_archivo'])
                ? '<a href="' . $documentos_usuario[0]['documento_archivo'] . '" target="_blank">Abrir Archivo</a>'
                : 'Falta Subir';

            // Generar las filas de la tabla
            $data[0] .= '
                    <tr>
                        <td class="text-center">' . ($i + 1) . '</td>
                        <td class="text-center">' . $nombre_archivo . '</td>
                        <td class="text-center">' . $ruta_documento_obligatorio . '</td>
                        <td class="text-center">
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarDocumentoObligatoriootrosestudios(' . $documentos_usuario[$i]['id_documentacion'] . ')" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> 
                                <i class="fas fa-trash"></i>  
                            </button>
                        </td>
                    </tr>';
        }

        $data[0] .= '</tbody></table>';
        echo json_encode($data);
        break;



    case 'eliminarDocumentoObligatoriootrosestudios':
        $id_documentacion = isset($_POST['id_documentacion']) ? $_POST['id_documentacion'] : "";
        $rspta = $documentosObligatorios->cvdocumentosOeliminarotrosestudios($id_documentacion);
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Documento eliminado: " . $nombre_documentos
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo eliminar"
            );
            echo json_encode($inserto);
        }
        break;



    case 'ActualizarEstadoRutTarjetaProfesional':
        //devuelve si o no en 1 si 0 no.
        $valorNumerico = isset($_POST['valorNumerico']) ? $_POST['valorNumerico'] : "";
        // id del usuario que lo subio.
        $id_usuario_cv = isset($_POST['id_usuario_cv']) ? $_POST['id_usuario_cv'] : "";
        // nombre del documento.
        $nombre_tipos_documentos = isset($_POST['nombre_documentos']) ? $_POST['nombre_documentos'] : "";

        if (strpos($nombre_tipos_documentos, '(') !== false && strpos($nombre_tipos_documentos, ')') !== false) {
            // Eliminar el texto dentro de los paréntesis y espacios adicionales
            $nombre_tipos_documentos = trim(preg_replace('/\s*\(.*?\)\s*/', '', $nombre_tipos_documentos));
        }
        $nombre_documento_limpio = $nombre_tipos_documentos;

        //configuramos el valor para que salga en numero ya que del jquery llega true y false.
        $estado = ($valorNumerico === "true" || $valorNumerico === 1 || $valorNumerico === "1") ? 1 : 0;

        // if ($documentosObligatorios->existeDocumentoUsuario($id_usuario_cv, $nombre_documento_limpio)) {
        //     echo json_encode([
        //         "estatus" => 0,
        //         "valor" => "Este documento ya fue registrado."
        //     ]);
        //     exit();
        // }
        // $rspta = $documentosObligatorios->InsertarDocumentosRutTarjetaProfesional($nombre_documento_limpio, $estado, $id_usuario_cv);

        if ($documentosObligatorios->existeDocumentoUsuario($id_usuario_cv, $nombre_documento_limpio)) {
            //en caso de que exista se actualiza el documento.
            $rspta = $documentosObligatorios->ActualizarEstadoRutTarjetaProfesional( $nombre_documento_limpio, $estado, $id_usuario_cv);
        } else {
            //si no existe se inserta.
            $rspta = $documentosObligatorios->InsertarDocumentosRutTarjetaProfesional( $nombre_documento_limpio, $estado, $id_usuario_cv
            );
        }
        if ($rspta) {
            $inserto = array(
                "estatus" => 1,
                "valor" => "Información Actualizada"
            );
            echo json_encode($inserto);
        } else {
            $inserto = array(
                "estatus" => 0,
                "valor" => "La información no se pudo Actualizar"
            );
            echo json_encode($inserto);
        }

        break;


        // actualizamos el porcentaje de avance para los documentos cuando le den en continuar
    case 'actualizar_porcentaje_avance':
        $cedula = $_SESSION["usuario_identificacion"];
        $rspta_usuario = $documentosObligatorios->cv_traerIdUsuario($cedula);
        $id_usuario_cv = $rspta_usuario["id_usuario_cv"];
        $porcentaje_actual = $rspta_usuario["porcentaje_avance"];
        $nuevo_porcentaje = $porcentaje_actual;
        $conteo = $documentosObligatorios->CuentoRegistros($id_usuario_cv);
        $totalRegistros = isset($conteo['total']) ? intval($conteo['total']) : 0;
        if ($porcentaje_actual < 80) {
            $nuevo_porcentaje = 80;
            $documentosObligatorios->actualizar_porcentaje_personal($nuevo_porcentaje, $id_usuario_cv);
        }
        $inserto = array(
            "estatus" => 1,
            "porcentaje" => $nuevo_porcentaje
        );
        echo json_encode($inserto);


        break;
}
