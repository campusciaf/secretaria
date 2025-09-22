<?php

require_once "../modelos/CargarFoto.php";
$CargarFoto = new CargarFoto();
$cedula = isset($_POST["cedula"]) ? limpiarCadena($_POST["cedula"]) : "";
$ubicacion = isset($_POST["ubicacion"]) ? limpiarCadena($_POST["ubicacion"]) : "";
$usuario_identificacion = isset($_POST["usuario_identificacion"]) ? limpiarCadena($_POST["usuario_identificacion"]) : "";
$archivo = isset($_POST["archivo"]) ? limpiarCadena($_POST["archivo"]) : "";
$imagenactual = isset($_POST["imagenactual"]) ? limpiarCadena($_POST["imagenactual"]) : "";
$usuario_imagen = isset($_POST["usuario_imagen"]) ? limpiarCadena($_POST["usuario_imagen"]) : "";
$nombre_imagen = isset($_POST["nombre_imagen"]) ? limpiarCadena($_POST["nombre_imagen"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$fecha = date('Y-m-d');

$ubicacion_masiva = isset($_POST["ubicacion_masiva"]) ? limpiarCadena($_POST["ubicacion_masiva"]) : "";
$carga_masiva_imagen = isset($_POST["carga_masiva_imagen"]) ? limpiarCadena($_POST["carga_masiva_imagen"]) : "";

switch ($_GET['op']) {

    case 'consultaBuscar':

        // consulta para buscar el tipo de usuario
        $rspta = $CargarFoto->consultaBuscar($cedula, $ubicacion);
        //si es = 1 selecciona los estudiantes
        if ($ubicacion == "1") {
            if ($rspta) {
                $datos = "

                <div class='form-group col-12'>
                    <div class='form-group mb-3 position-relative check-valid'>
                        <div class='form-floating'>
                            <input type='text' placeholder='' value='" . $rspta['credencial_nombre'] . ' ' . $rspta['credencial_nombre_2'] . ' ' . $rspta['credencial_apellido'] . ' ' . $rspta['credencial_apellido_2'] . "' class='form-control border-start-0' readonly>
                            <label>Nombre</label>
                        </div>
                    </div>
                    <div class='invalid-feedback'>Please enter valid input</div>
                </div>
                
                <div class='form-group col-12'>
                    <div class='form-group mb-3 position-relative check-valid'>
                        <div class='form-floating'>
                            <input type='text' placeholder='' value='" . $rspta['credencial_login'] . "' class='form-control border-start-0' readonly>
                            <label>Usuario</label>
                        </div>
                    </div>
                    <div class='invalid-feedback'>Please enter valid input</div>
                </div>
                <div class='form-group col-12'>
                    <img src='../files/estudiantes/$cedula.jpg' width='150px' height='120px' id='imagenmuestra'>
                </div>

                    ";

                echo $datos;
            } else {
                echo json_encode($rspta);
            }
        }
        //si es = 2 selecciona los Docentes
        if ($ubicacion == "2") {
            if ($rspta) {

                $datos = "
                
                <div class='form-group col-12'>
                    <div class='form-group mb-3 position-relative check-valid'>
                        <div class='form-floating'>
                            <input type='text' placeholder='' value='" . $rspta['usuario_nombre'] . ' ' . $rspta['usuario_nombre_2'] . ' ' . $rspta['usuario_apellido'] . ' ' . $rspta['usuario_apellido_2'] . "' pattern='[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' title='Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $' class='form-control border-start-0' readonly>
                            <label>Nombre</label>
                        </div>
                    </div>
                    <div class='invalid-feedback'>Please enter valid input</div>
                </div>
                    
                <div class='form-group col-12'>
                    <div class='form-group mb-3 position-relative check-valid'>
                        <div class='form-floating'>
                            <input type='text' placeholder='' value='" . $rspta['usuario_login'] . "' class='form-control border-start-0' readonly>
                            <label>Usuario</label>
                        </div>
                    </div>
                    <div class='invalid-feedback'>Please enter valid input</div>
                </div>

                <div class='form-group col-12'>
                    <img src='../files/docentes/$cedula.jpg' width='150px' height='120px' id='imagenmuestra'>
                </div>";
                echo $datos;
            } else {
                echo json_encode($rspta);
            }
        }
        //si es = 3 selecciona los Funcionarios
        if ($ubicacion == "3") {
            if ($rspta) {

                $datos = "
                    <div class='col-12 panel-body'>
                        <div class='form-group col-12'>
                            <div class='form-group mb-3 position-relative check-valid'>
                                <div class='form-floating'>
                                    <input type='text' placeholder='' value='" . $rspta['usuario_nombre'] . ' ' . $rspta['usuario_nombre_2'] . ' ' . $rspta['usuario_apellido'] . ' ' . $rspta['usuario_apellido_2'] . "' pattern='[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' title='Solo se permiten letras y números, estos caracteres no son permitidos < > = , ; * # $' class='form-control border-start-0' readonly>
                                    <label>Nombre</label>
                                </div>
                            </div>
                            <div class='invalid-feedback'>Please enter valid input</div>
                        </div>
                        <div class='form-group col-12'>
                            <div class='form-group mb-3 position-relative check-valid'>
                                <div class='form-floating'>
                                    <input type='text' placeholder='' value='" . $rspta['usuario_login'] . "' class='form-control border-start-0' readonly>
                                    <label>Usuario</label>
                                </div>
                            </div>
                            <div class='invalid-feedback'>Please enter valid input</div>
                        </div>

                        <div class='form-group col-12'>
                            <img src='../files/usuarios/$cedula.jpg' width='150px' height='120px' id='imagenmuestra'>
                        </div>
                    </div>
                
                ";

                echo $datos;
            } else {
                echo json_encode($rspta);
            }
        }

        break;

    case 'guardaryeditarfuncionario':

        //si es = 1 selecciona los estudiantes
        if ($ubicacion == "1") {

            $target_path = '../files/estudiantes/';
            $img1path = $target_path . "" . $cedula . ".jpg";


            if (move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $img1path)) {
                $usuario_imagen = $_FILES['usuario_imagen']['name'] ? $fecha : "";
                echo "imagen subida";
            } else {
                echo "error";
            }
        }

        //si es = 2 selecciona los Docentes
        if ($ubicacion == "2") {

            $target_path = '../files/docentes/';
            $img1path    = $target_path . "" . $cedula . ".jpg";

            if (move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $img1path)) {
                // $usuario_imagen =  $cedula . ".jpg" ;

                $usuario_imagen = $cedula . ".jpg";

                echo "imagen subida";
                $rspta = $CargarFoto->editardocente($cedula, $usuario_imagen);
            } else {
                echo "error";
            }
        }

        //si es = 3 selecciona los Funcionarios
        if ($ubicacion == "3") {

            $target_path = '../files/usuarios/';
            $img1path    = $target_path . "" . $cedula . ".jpg";

            if (move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $img1path)) {
                $usuario_imagen =  $cedula . ".jpg";

                echo "imagen subida";
            } else {
                echo "error";
            }

            $rspta = $CargarFoto->editar($cedula, $usuario_imagen);
        }
    break;


    case 'guardarfotomasiva':
        //si es = 1 selecciona los estudiantes
        if ($ubicacion_masiva == "1") {
            $target_path = '../files/estudiantes/';
            if (isset($_FILES['carga_masiva_imagen'])) {
                foreach ($_FILES['carga_masiva_imagen']['name'] as $key => $name) {
                    $cedula = pathinfo($name, PATHINFO_FILENAME);
                    $img1path = $target_path . $cedula . ".jpg";

                    // Se elimina la comprobación de si el archivo ya existe
                    if (move_uploaded_file($_FILES['carga_masiva_imagen']['tmp_name'][$key], $img1path)) {
                        $response[] = "Imagen subida o reemplazada: " . $img1path;
                    } else {
                        $response[] = "Error al subir: " . $name;
                    }
                }
            }

        }
        //si es = 2 selecciona los Docentes
        if ($ubicacion_masiva == "2") {
            $target_path = '../files/docentes/';
            // Verificar si el archivo tiene partes y procesar cada parte
            if (isset($_FILES['carga_masiva_imagen'])) {
                foreach ($_FILES['carga_masiva_imagen']['name'] as $key => $name) {
                    // Extraer la cédula del nombre del archivo (asumiendo que el nombre del archivo es la cédula)
                    $cedula = pathinfo($name, PATHINFO_FILENAME);
                    $img1path = $target_path . $cedula . ".jpg";
                    // Intentar mover el archivo subido al destino deseado, sobrescribirá el archivo si ya existe
                    if (move_uploaded_file($_FILES['carga_masiva_imagen']['tmp_name'][$key], $img1path)) {
                        echo "Imagen subida o reemplazada: " . $img1path . "<br>";
                        $carga_masiva_imagen = $cedula . ".jpg";
                    } else {
                        echo "Error al subir: " . $name . "<br>";
                    }
                }
            }

        }
        // //si es = 3 selecciona los Funcionarios
        if ($ubicacion_masiva == "3") {
            $target_path = '../files/usuarios/';
            if (isset($_FILES['carga_masiva_imagen'])) {
                foreach ($_FILES['carga_masiva_imagen']['name'] as $key => $name) {
                    $cedula = pathinfo($name, PATHINFO_FILENAME);
                    $img1path = $target_path . $cedula . ".jpg";
                    if (move_uploaded_file($_FILES['carga_masiva_imagen']['tmp_name'][$key], $img1path)) {
                        echo "Imagen subida o reemplazada: " . $img1path . "<br>";
                        $carga_masiva_imagen = $cedula . ".jpg";
                    } else {
                        echo "Error al subir: " . $name . "<br>";
                    }
                }
            }

        }
        echo json_encode($response);

        break;
}
