<?php
require_once "../modelos/ConfigurarcuentaDocente.php";
$periodo_actual = $_SESSION['periodo_actual'];
$config = new Configuracion();
date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual = date('Y-m') . "-00";
$p1 = isset($_POST["p1"]) ? limpiarCadena($_POST["p1"]) : "";
$p2 = isset($_POST["p2"]) ? limpiarCadena($_POST["p2"]) : "";
$p3 = isset($_POST["p3"]) ? limpiarCadena($_POST["p3"]) : "";
$p4 = isset($_POST["p4"]) ? limpiarCadena($_POST["p4"]) : "";
$p5 = isset($_POST["p5"]) ? limpiarCadena($_POST["p5"]) : "";
$p6 = isset($_POST["p6"]) ? limpiarCadena($_POST["p6"]) : "";
$p7 = isset($_POST["p7"]) ? limpiarCadena($_POST["p7"]) : "";
$p8 = isset($_POST["p8"]) ? limpiarCadena($_POST["p8"]) : "";
$p9 = isset($_POST["p9"]) ? limpiarCadena($_POST["p9"]) : "";
$p10 = isset($_POST["p10"]) ? limpiarCadena($_POST["p10"]) : "";
$p11 = isset($_POST["p11"]) ? limpiarCadena($_POST["p11"]) : "";
$p12 = isset($_POST["p12"]) ? limpiarCadena($_POST["p12"]) : "";
$p13 = isset($_POST["p13"]) ? limpiarCadena($_POST["p13"]) : "";
$p14 = isset($_POST["p14"]) ? limpiarCadena($_POST["p14"]) : "";
$p15 = isset($_POST["p15"]) ? limpiarCadena($_POST["p15"]) : "";
$p16 = isset($_POST["p16"]) ? limpiarCadena($_POST["p16"]) : "";
$p17 = isset($_POST["p17"]) ? limpiarCadena($_POST["p17"]) : "";
$p18 = isset($_POST["p18"]) ? limpiarCadena($_POST["p18"]) : "";
$p19 = isset($_POST["p19"]) ? limpiarCadena($_POST["p19"]) : "";
$p20 = isset($_POST["p20"]) ? limpiarCadena($_POST["p20"]) : "";
$p21 = isset($_POST["p21"]) ? limpiarCadena($_POST["p21"]) : "";
$p22 = isset($_POST["p22"]) ? limpiarCadena($_POST["p22"]) : "";
$p23 = isset($_POST["p23"]) ? limpiarCadena($_POST["p23"]) : "";
$p24 = isset($_POST["p24"]) ? limpiarCadena($_POST["p24"]) : "";
$p25 = isset($_POST["p25"]) ? limpiarCadena($_POST["p25"]) : "";
$p26 = isset($_POST["p26"]) ? limpiarCadena($_POST["p26"]) : "";
$p27 = isset($_POST["p27"]) ? limpiarCadena($_POST["p27"]) : "";
$p28 = isset($_POST["p28"]) ? limpiarCadena($_POST["p28"]) : "";
$p29 = isset($_POST["p29"]) ? limpiarCadena($_POST["p29"]) : "";
$p30 = isset($_POST["p30"]) ? limpiarCadena($_POST["p30"]) : "";
$p31 = isset($_POST["p31"]) ? limpiarCadena($_POST["p31"]) : "";
$p32 = isset($_POST["p32"]) ? limpiarCadena($_POST["p32"]) : "";
$p33 = isset($_POST["p33"]) ? limpiarCadena($_POST["p33"]) : "";
$p34 = isset($_POST["p34"]) ? limpiarCadena($_POST["p34"]) : "";
$p35 = isset($_POST["p35"]) ? limpiarCadena($_POST["p35"]) : "";
$p36 = isset($_POST["p36"]) ? limpiarCadena($_POST["p36"]) : "";
$p37 = isset($_POST["p37"]) ? limpiarCadena($_POST["p37"]) : "";
$p38 = isset($_POST["p38"]) ? limpiarCadena($_POST["p38"]) : "";
$p39 = isset($_POST["p39"]) ? limpiarCadena($_POST["p39"]) : "";
$p40 = isset($_POST["p40"]) ? limpiarCadena($_POST["p40"]) : "";
$p41 = isset($_POST["p41"]) ? limpiarCadena($_POST["p41"]) : "";
$p42 = isset($_POST["p42"]) ? limpiarCadena($_POST["p42"]) : "";
$p43 = isset($_POST["p43"]) ? limpiarCadena($_POST["p43"]) : "";
$p44 = isset($_POST["p44"]) ? limpiarCadena($_POST["p44"]) : "";
$p45 = isset($_POST["p45"]) ? limpiarCadena($_POST["p45"]) : "";
$p46 = isset($_POST["p46"]) ? limpiarCadena($_POST["p46"]) : "";
$p47 = isset($_POST["p47"]) ? limpiarCadena($_POST["p47"]) : "";
$p48 = isset($_POST["p48"]) ? limpiarCadena($_POST["p48"]) : "";
$p49 = isset($_POST["p49"]) ? limpiarCadena($_POST["p49"]) : "";
$p50 = isset($_POST["p50"]) ? limpiarCadena($_POST["p50"]) : "";
switch ($_GET['op']) {
    case 'listarDatos':
        $datos = $config->listarDatos();
        if (file_exists("../files/docentes/" . $datos['usuario_identificacion'] . ".jpg")) {
            $url = "../files/docentes/" . $datos['usuario_identificacion'] . ".jpg";
        } else {
            $url = "../files/null.jpg";
        }
        $data['conte'] = '
            <div class="row">
                <div class="col-xl-3 col-12">
                    <div class="row ">
                        <div class="col-xl-4 col-4 text-center pt-2">
                            <div class="widget-user-image ">
                                <span>
                                    <span class="btn btn-warning btn-xs edit-nombre_imagen1 position-absolute" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar foto de perfil" onclick="document.getElementById(`nombre_imagen1`).click();" role="button"> 
                                        <i class="fas fa-edit "></i> 
                                    </span>
                                    <button class="btn btn-success d-none mt-2 rounded-0 btn_nombre_imagen1 guardar-nombre_imagen1" onclick="cambiarImagen(`nombre_imagen1`)"> Guardar </button>
                                    <button class="btn btn-danger d-none mt-2 rounded-0 btn_nombre_imagen1 cancel-nombre_imagen1" onclick="cancelar_input(`nombre_imagen1`)"> Cancelar </button>
                                </span>
                                <input type="hidden" id="documento_png">
                                <input class="form-control mb-3 d-none" onchange="comprimirImagen(`nombre_imagen1`)" type="file" id="nombre_imagen1" name="nombre_imagen1" accept="image/png, image/jpeg, image/jpg">
                                <input type="hidden" name="b_nombre_imagen1" id="b_nombre_imagen1">
                                <img class="img-circle elevation-2 img_user" style="width:70px; height:70px" src="' . $url . '?' . date("H:s:i") . '" id="preview_nombre_imagen1" >
                            </div>
                        </div>
                        <div class="col-xl-7 col-7">
                            <h2 class=" fs-18 font-weight-bolder">' . $datos['usuario_nombre'] . ' ' . $datos['usuario_nombre_2'] . '</h2>
                            <span class="fs-14">' . $datos['usuario_apellido'] . ' ' . $datos['usuario_apellido_2'] . '</span><br>
                            <span class="small">' . $datos['usuario_email_ciaf'] . '</span><br>
                            <a onclick=editarContrasena(' . $datos['id_usuario'] . ') class="btn btn-warning btn-xs ">
                                <i class="fas fa-user-lock"></i> Editar clave
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-12"><h2 class="fs-18">Certificados de competencias / Mis insignias digitales</h2></div>
                        <img src="../public/img/cultura-ciaf.webp" width="150px">
                        <img src="../public/img/ins-next-level.webp" width="150px">
                    </div>
                </div>
            </div>
        ';
        echo json_encode($data);
        break;
    case 'cambiarContra':
        $anterior = $_POST['anterior'];
        $id = $_POST['id'];
        $nueva = $_POST['nueva'];
        $confirma = $_POST['confirma'];
        if ($nueva == $confirma) {
            $config->cambiarContra($id, $anterior, $nueva);
        } else {
            $data['status'] = "Error, las contraseñas no coincide.";
            echo json_encode($data);
        }
        break;
    case 'editarDatos':
        $datos = $config->listarDatos();
        $data['conte'] = '
            <div class="row" id="conte1">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Primer nombre</label>
                    <input type="text" name="nombre1" value="' . $datos['usuario_nombre'] . '" class="form-control" required>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Segundo nombre</label>
                    <input type="text" name="nombre2" value="' . $datos['usuario_nombre_2'] . '" class="form-control" >
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Primer apellido</label>
                    <input type="text" name="apellido" value="' . $datos['usuario_apellido'] . '" class="form-control" required >
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Segundo apellido</label>
                    <input type="text" name="apellido2" value="' . $datos['usuario_apellido_2'] . '" class="form-control" >
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Celular</label>
                    <input type="number" name="celular" value="' . $datos['usuario_celular'] . '" class="form-control" required>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Fecha nacimiento</label>
                    <input type="date" name="fecha_n" value="' . $datos['usuario_fecha_nacimiento'] . '" class="form-control" required>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Departamento nacimiento</label>
                    <input type="text" name="depar_naci" value="' . $datos['usuario_departamento_nacimiento'] . '" class="form-control" required>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Ciudad nacimiento</label>
                    <input type="text" name="ciudad_naci" value="' . $datos['usuario_municipio_nacimiento'] . '" class="form-control" required>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <label for="exampleInputEmail1">Tipo de sangre</label>
                    <input type="text" name="tipo_sangre" value="' . $datos['usuario_tipo_sangre'] . '" class="form-control" required>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label for="exampleInputEmail1">Dirrección de residencia</label>
                    <input type="text" name="dirrecion" value="' . $datos['usuario_direccion'] . '" class="form-control" required>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <label for="exampleInputEmail1">Barrio de residencia</label>
                    <input type="text" name="barrio" value="' . $datos['usuario_barrio'] . '" class="form-control" required>
                </div>
            </div>
            <div id="buttuno" class="mt-3">
                <button type="submit" class="btn btn-success btn-block">Actualizar datos personales</button>
            </div>';
        echo json_encode($data);
        break;
    case 'cambiarImagen':
        $campo = isset($_POST["campo"]) ? $_POST["campo"] : "";
        $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
        //como no es un campo con el nombre tal cual tiene la carpeta, entonces se le remueve el ultimo digito agregado
        $campo = substr_replace($campo, "", -1);
        $estado = true;
        if (empty($valor) || is_null($valor)) {
            $msg_errors = "Debes .";
            die(json_encode(array("exito" => 0, "info" => $msg_errors)));
        } else {
            $rspta =  $config->base64_to_jpeg($valor, "../files/docentes/" . $_SESSION["usuario_imagen"] . ".jpg");
            if ($rspta) {
                $config->actualizarCampoBD($_SESSION['usuario_identificacion'] . ".jpg", $_SESSION["id_usuario"]);
                $data = array("exito" => 1, "info" => "! Todo se ha guardado con exito ¡");
            } else {
                $data = array("exito" => 0, "info" => "Error en el guardado");
            }
            echo json_encode($data);
        }
        break;
    case 'mostrarpuntos':
        $data = array();
        $data["perfil"] = "";
        $data["caracterizacion"] = "";
        $perfil = $config->validarpuntos("perfil", $periodo_actual);
        if ($perfil) {
            $data["perfil"] = "si";
        }
        $seres = $config->validarpuntos("caracterizacion", $periodo_actual);
        if ($seres) {
            $data["seres"] = "si";
        }
        $results = array($data);
        echo json_encode($results);
        break;
    case 'editarDatospersonales':
        $data = array();
        $data["estado"] = "";
        $data["puntos"] = "";
        $data["puntosotorgados"] = "";
        $nombre1 = isset($_POST['nombre1']) ? limpiarCadena($_POST['nombre1']) : "";
        @$nombre2 = $_POST['nombre2'];
        $apellido = $_POST['apellido'];
        @$apellido2 = $_POST['apellido2'];
        $fecha_n = $_POST['fecha_n'];
        $depar_naci = $_POST['depar_naci'];
        $ciudad_naci = $_POST['ciudad_naci'];
        $tipo_sangre = $_POST['tipo_sangre'];
        $dirrecion = $_POST['dirrecion'];
        $barrio = $_POST['barrio'];
        $celular = $_POST['celular'];
        $rspta = $config->editarDatospersonales($nombre1, $nombre2, $apellido, $apellido2, $fecha_n, $depar_naci, $ciudad_naci, $tipo_sangre, $dirrecion, $barrio, $celular, $fecha);
        $datos = $rspta ? "si" : "no";
        $data["estado"] = $datos;
        $punto_nombre = "perfil";
        $puntos_cantidad = 40;
        $validarpuntos = $config->validarpuntos($punto_nombre, $periodo_actual); // para validar si el punto de perfil fue otorgado
        if ($validarpuntos) {
            // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
        } else {
            // No se obtuvo ningún resultado no hay punto otorgado
            $insertarpunto = $config->insertarPunto($punto_nombre, $puntos_cantidad, $fecha, $hora, $periodo_actual);
            $totalpuntos = $config->verpuntos();
            $puntoscredencial = $totalpuntos["puntos"];
            $sumapuntos = $puntos_cantidad + $puntoscredencial;
            $config->actulizarValor($sumapuntos);
            $data["puntos"] = "si";
            $data["puntosotorgados"] = $puntos_cantidad;
        }
        $results = array($data);
        echo json_encode($results);
        break;
    case 'listarPreguntas':
        $data = array();
        $data["0"] = ""; //iniciamos el arreglo
        $pre = $config->listar();
        $data["0"] .= '';
        $data["0"] .= '<div class="row">';
        $data["0"] .= '
                <div class="col-12">
                    <h6 class="title">Información en caso de emergencia</h6>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p1"] . '" required class="form-control border-start-0" name="p1" id="p1" maxlength="50">
                            <label>¿Nombre persona de contacto en caso de emergencia?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="' . $pre["p2"] . '"  id="p2_val">
                                <select class="form-control border-start-0" name="p2" id="p2">
                                    <option value="">Seleccionar</option>
                                    <option value="Familia">Familia</option>
                                    <option value="Pareja">Pareja</option>
                                    <option value="Amigo">Amigo</option>
                                </select>
                                <label>¿Parentesco del contacto de emergencia?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email"  value="' . $pre["p3"] . '"  required class="form-control border-start-0" name="p3" id="p3" maxlength="50">
                            <label>Correo electrónico del contacto de emergencia</label>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="' . $pre["p4"] . '"  required class="form-control border-start-0" name="p4" id="p4" maxlength="10">
                            <label>Teléfono del contacto de emergencia</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h6 class="title">Información académica y familiar</h6>
                </div>';
        if ($pre["p5"] == "1") {
            $p5option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p5option = '
                    <option value="1">No</option>
                    <option value="2" selected >Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="p5" id="p5" >
                                ' . $p5option . '
                            </select>
                            <label>¿Actualmente te encuentras estudiando?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p6"] == 1) {
            $p6option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p6option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p6" id="p6" onchange="mostrarp6(this.value)">
                                ' . $p6option . '
                            </select>
                            <label>¿Tienes pareja actualmente?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp7">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="' . $pre["p7"] . '"  class="form-control border-start-0" name="p7" id="p7" maxlength="50">
                                <label>¿Nombre de tu pareja?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp8">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="' . $pre["p8"] . '" class="form-control border-start-0" name="p8" id="p8" maxlength="10">
                                <label>¿Número de celular de tu pareja?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        if ($pre["p9"] == 1) {
            $p9option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p9option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p9" id="p9" onchange="mostrarp9(this.value)">
                                ' . $p9option . '
                            </select>
                            <label>¿Tienes mascotas?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp10">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="' . $pre["p10"] . '"  class="form-control border-start-0" name="p10" id="p10" maxlength="50">
                                <label>¿Nombre de tu mascota?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp11">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="text"  value="' . $pre["p11"] . '" class="form-control border-start-0" name="p11" id="p11" maxlength="50">
                                <label>¿Tipo de mascota?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        if ($pre["p12"] == 1) {
            $p12option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p12option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p12" id="p12" onchange="mostrarp12(this.value)">
                                ' . $p12option . '
                            </select>
                            <label>¿Dominas un segundo idioma?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp13">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="' . $pre["p13"] . '"  id="p13_val">
                                <select class="form-control border-start-0" name="p13" id="p13">
                                    <option value="">Seleccionar</option>
                                    <option value="Ingles">Ingles</option>
                                    <option value="Frances">Frances</option>
                                    <option value="Italiano">Italiano</option>
                                    <option value="Mandarin">Mandarin</option>
                                    <option value="Portugues">Potugues</option>
                                </select>
                                <label>¿Cuál idioma?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp14">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="' . $pre["p14"] . '"  id="p14_val">
                                <select class="form-control border-start-0" name="p14" id="p14">
                                    <option value="">Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">Más de 4</option>
                                </select>
                                <label>¿Cuántas personas conviven en tu casa?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        if ($pre["p15"] == 1) {
            $p15option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p15option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp13">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <select class="form-control border-start-0" name="p15" id="p15">
                                    ' . $p15option . '
                                </select>
                                <label>¿Eres cabeza de familia ?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp16">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="' . $pre["p16"] . '"  id="p16_val">
                                <select class="form-control border-start-0" name="p16" id="p16">
                                    <option value="">Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">Más de 4</option>
                                </select>
                                <label>¿Numero de personas que tienes a tu cargo?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        if ($pre["p17"] == 1) {
            $p17option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p17option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="p17" id="p17" onchange="mostrarp17(this.value)">
                                ' . $p17option . '
                            </select>
                            <label>¿Tienes hijos?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp18">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="' . $pre["p18"] . '"  id="p18_val">
                                <select class="form-control border-start-0" name="p18" id="p18">
                                    <option value="">Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">Más de 3</option>
                                </select>
                                <label>¿Cuántos hijos tiene?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp19">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p19"] . '" required class="form-control border-start-0" name="p19" id="p19" maxlength="20">
                            <label>¿Edad de hijos? Ejemplo 7-12 </label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="hidden" value="' . $pre["p20"] . '"  id="p20_val">
                            <select required class="form-control border-start-0"  name="p20" id="p20">
                                <option value="">Seleccionar</option> 
                                <option value="Alquilada">Alquilada</option>
                                <option value="Propia">Propia</option>
                            </select>
                            <label>¿Tipo de vivienda?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="hidden" value="' . $pre["p21"] . '"  id="p21_val">
                            <select required class="form-control border-start-0"  name="p21" id="p21" >
                                <option value="">Seleccionar</option> 
                                <option value="Particular">Particular</option>
                                <option value="Publico">Transporte público</option>
                                <option value="Moto">Moto</option>
                                <option value="Carro">Carro</option>
                                <option value="Scooter">Scooter eléctrica</option>
                                <option value="Bicicleta">Bicicleta</option>
                            </select>
                            <label>¿Medio de transporte?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p22"] == 1) {
            $p22option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p22option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-12">
                    <h6 class="title">Información salud</h6>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p22" id="p22">
                                ' . $p22option . '
                            </select>
                            <label>¿Usas anteojos?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p23"] == 1) {
            $p23option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p23option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p23" id="p23">
                                ' . $p23option . '
                            </select>
                            <label>¿Tomas medicamentos?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p24"] == 1) {
            $p24option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p24option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p24" id="p24">
                                ' . $p24option . '
                            </select>
                            <label>¿Fumas y/o consumes bebidas alcohólicas?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p25"] == 1) {
            $p25option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p25option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p25" id="p25">
                                ' . $p25option . '
                            </select>
                            <label>¿Tienes un Diagnostico que  afecte tu estado de salud  físico?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p26"] == 1) {
            $p26option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p26option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p26" id="p26">
                                ' . $p26option . '
                            </select>
                            <label>¿Tienes un Diagnostico que afecte tu estado de salud mental?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="hidden" value="' . $pre["p27"] . '"  id="p27_val">
                            <select required class="form-control border-start-0" name="p27" id="p27">
                                <option value="">Seleccionar</option> 
                                <option value="SURA">SURA</option> 
                                <option value="SANITAS">SANITAS</option>
                                <option value="ASMETSALUD">ASMEDSALUD</option>
                                <option value="Saludtotal">Salud total</option>
                                <option value="Coomeva">Coomeva</option>
                                <option value="Medplus">Medplús</option>
                                <option value="Cornabis">Cornabis</option>
                                <option value="Confamiliar">Confamiliar</option>
                                <option value="Sos">S.O.S</option>
                                <option value="Medimas">Medimás</option>
                                <option value="Nuevaeps">Nueva EPS</option>
                                <option value="Cafesalud">Cafe Salud</option>
                                <option value="">Otra</option>
                            </select>
                            <label>¿Cuál es la EPS en la que te encuentra afiliado?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-12">
                    <h6 class="title">Información ocio, pasatiempos y gustos</h6>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p28"] . '" required class="form-control border-start-0" name="p28" id="p28" maxlength="50">
                            <label>¿Cuáles son tus hobbies?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p29"] == 1) {
            $p29option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p29option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p29" id="p29">
                                ' . $p29option . '
                            </select>
                            <label>¿Perteneces a un voluntariado?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p30"] . '" required class="form-control border-start-0" name="p30" id="p30" maxlength="50">
                            <label>¿Cuál es tu comida favorita?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p31"] . '" required class="form-control border-start-0" name="p31" id="p31" maxlength="50">
                            <label>¿Cuál es tu bebida favorita?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p32"] . '" required class="form-control border-start-0" name="p32" id="p32" maxlength="50">
                            <label>¿Tienes algún talento que quieras contarnos?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p33"] . '" required class="form-control border-start-0" name="p33" id="p33" maxlength="50">
                            <label>¿Cuando te sientes desanimado ¿qué te sube el ánimo?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p34"] . '" required class="form-control border-start-0" name="p34" id="p34" maxlength="50">
                            <label>¿Cuál es tu postre o torta favorita?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="hidden" value="' . $pre["p35"] . '"  id="p35_val">
                            <select required class="form-control border-start-0" name="p35" id="p35">
                                <option value="">Seleccionar</option> 
                                <option value="Amarillo">Amarillo</option>
                                <option value="Azul">Azul</option>
                                <option value="Rojo">Rojo</option>
                                <option value="Verde">Verde</option>
                                <option value="Morado">Morado</option>
                                <option value="Negro">Negro</option>
                                <option value="Blanco">Blanco</option>
                                <option value="Rosado">Rosado</option>
                                <option value="Naranja">Naranjado</option>
                                <option value="Marron">Marrón</option>
                                <option value="Gris">Gris</option>
                                <option value="Turquesa">Turquesa</option>
                                <option value="Salmon">Salmón</option>
                                <option value="Fuscia">Fucsia</option>
                            </select>
                            <label>¿Cuál es tu color favorito?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p36"] . '" required class="form-control border-start-0" name="p36" id="p36" maxlength="50">
                            <label>¿Quién es la persona más importante para ti?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12" id="mostrarp37">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="' . $pre["p37"] . '"  id="p37_val">
                                <select class="form-control border-start-0" name="p37" id="p37">
                                    <option value="">Seleccionar</option>
                                    <option value="Regalo">Regalo</option>
                                    <option value="Bonoregalo">Bono regalo</option>
                                    <option value="Ancheta">Ancheta</option>
                                </select>
                                <label>¿Cuándo te dan un detalle qué prefieres?</label>
                            </div>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p38"] . '" required class="form-control border-start-0" name="p38" id="p38" maxlength="50">
                            <label>¿Cual es la cualidad o valor que te define?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p39"] == 1) {
            $p39option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p39option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="p39" id="p39" onchange="mostrarp39(this.value)">
                                ' . $p39option . '
                            </select>
                            <label>¿Sientes que te destacas en algún tema diferente a tu profesión ?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-7 col-lg-6 col-md-6 col-12" id="mostrar40">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p40"] . '" class="form-control border-start-0" name="p40" id="p40" maxlength="50">
                            <label>¿Cual tema?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-12">
                    <h6 class="title">Información deportiva y física</h6>
                </div>';
        $data["0"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="hidden" value="' . $pre["p41"] . '"  id="p41_val">
                            <select required class="form-control border-start-0" name="p41" id="p41">
                                <option value="">Seleccionar</option>
                                <option value="1">No</option>
                                <option value="Futbol">Futbol</option> 
                                <option value="Volleyball">VolleyBall</option> 
                                <option value="Basketball">BasketBall</option> 
                                <option value="Microfutbol">MicroFutbol</option> 
                                <option value="TennisMesa">Tennis de Mesa</option> 
                                <option value="Tennis">Tennis</option> 
                                <option value="Golf">Golf</option> 
                                <option value="Natacion">Natación</option> 
                                <option value="BMX">BMX</option> 
                                <option value="Atletismo">Atletismo</option> 
                                <option value="Patinaje">Patinaje</option> 
                                <option value="Ciclismo">Ciclismo</option> 
                                <option value="Rugby">Rugby</option> 
                                <option value="Boxeo">Boxeo</option> 
                            </select>
                            <label>¿Realizas algun deporte?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-9 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="hidden" value="' . $pre["p42"] . '"  id="p42_val">
                            <select required class="form-control border-start-0" name="p42" id="p42" >
                                <option value="">Seleccionar</option>
                                <option value="0">Ninguna</option>
                                <option value="1">1 Vez</option> 
                                <option value="2">1 Veces</option>
                                <option value="3">3 Veces</option>
                                <option value="4">4 Veces</option>
                                <option value="5">5 Veces</option>
                                <option value="6">6 Veces</option>
                                <option value="7">7 Veces</option>
                            </select>
                            <label>¿Cuantas veces en la semana realizas actividad fisica ?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-12">
                    <h6 class="title">Información emprendimiento</h6>
                </div>';
        if ($pre["p43"] == 1) {
            $p43option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p43option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p43" id="p43">
                                ' . $p43option . '
                            </select>
                            <label>¿Tienes una empresa legalmente constituida?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p44"] == 1) {
            $p44option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p44option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p44" id="p44">
                                ' . $p44option . '
                            </select>
                            <label>¿Haces parte de algún tipo de agremiación, organización o proyecto?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p45"] == 1) {
            $p45option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p45option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p45" id="p45">
                                ' . $p45option . '
                            </select>
                            <label>¿Tienes una idea de negocio o emprendimiento?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p46"] == 1) {
            $p46option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p46option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p46" id="p46">
                                ' . $p46option . '
                            </select>
                            <label>¿Te interesa la doble titulación en algunos de los programas de CIAF?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p47"] . '" required class="form-control border-start-0" name="p47" id="p47" maxlength="50">
                            <label>¿En qué temas consideras qué podríamos capacitarte para mejorar tus habilidades?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p48"] . '" required class="form-control border-start-0" name="p48" id="p48" maxlength="50">
                            <label>¿Tienes algún empleo o labor adicional que te genere ingresos extra? ¿Qué tipo de labor?</label>
                        </div>
                    </div>
                </div>';
        if ($pre["p49"] == 1) {
            $p49option = '
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
        } else {
            $p49option = '
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
        }
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p49" id="p49">
                                ' . $p49option . '
                            </select>
                            <label>¿Alguien de tu grupo familiar actualmente estudia en CIAF?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="' . $pre["p50"] . '" required class="form-control border-start-0" name="p50" id="p50" maxlength="50">
                            <label>¿Cuál es tu principal proyecto o meta para este año?</label>
                        </div>
                    </div>
                </div>';
        $data["0"] .= '<div class="col-12 p-4 text-right"><button type="submit" class="btn btn-success">Guardar caracterización</button></div>';
        $data["0"] .= '</div>';
        $data["0"] .= '';
        $results = array($data);
        echo json_encode($data);
        break;
    case 'guardaryeditar':
        $data = array();
        $data["estado"] = "";
        $data["puntos"] = "";
        $data["puntosotorgados"] = "";
        $rspta = $config->editarDatos($p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20, $p21, $p22, $p23, $p24, $p25, $p26, $p27, $p28, $p29, $p30, $p31, $p32, $p33, $p34, $p35, $p36, $p37, $p38, $p39, $p40, $p41, $p42, $p43, $p44, $p45, $p46, $p47, $p48, $p49, $p50, $fecha);
        $datos = $rspta ? "si" : "no";
        $data["estado"] = $datos;
        $punto_nombre = "caracterizacion";
        $puntos_cantidad = 100;
        $validarpuntos = $config->validarpuntos($punto_nombre, $periodo_actual); // para validar si el punto de perfil fue otorgado
        if ($validarpuntos) {
            // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
        } else {
            // No se obtuvo ningún resultado no hay punto otorgado
            $insertarpunto = $config->insertarPunto($punto_nombre, $puntos_cantidad, $fecha, $hora, $periodo_actual);
            $totalpuntos = $config->verpuntos();
            $puntoscredencial = $totalpuntos["puntos"];
            $sumapuntos = $puntos_cantidad + $puntoscredencial;
            $config->actulizarValor($sumapuntos);
            $data["puntos"] = "si";
            $data["puntosotorgados"] = $puntos_cantidad;
        }
        $results = array($data);
        echo json_encode($results);
        break;
}
