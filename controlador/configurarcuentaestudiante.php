<?php
session_start();
require_once "../modelos/Configurarcuentaestudiante.php";
$config = new Configuracion();

$periodo_actual = $_SESSION['periodo_actual'];
$id_credencial = $_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');


$p1=isset($_POST["p1"])? limpiarCadena($_POST["p1"]):"";
$p2=isset($_POST["p2"])? limpiarCadena($_POST["p2"]):"";
$p3=isset($_POST["p3"])? limpiarCadena($_POST["p3"]):"";
$p4=isset($_POST["p4"])? limpiarCadena($_POST["p4"]):"";
$p5=isset($_POST["p5"])? limpiarCadena($_POST["p5"]):"";
$p6=isset($_POST["p6"])? limpiarCadena($_POST["p6"]):"";
$p7=isset($_POST["p7"])? limpiarCadena($_POST["p7"]):"";
$p8=isset($_POST["p8"])? limpiarCadena($_POST["p8"]):"";
$p9=isset($_POST["p9"])? limpiarCadena($_POST["p9"]):"";
$p10=isset($_POST["p10"])? limpiarCadena($_POST["p10"]):"";
$p11=isset($_POST["p11"])? limpiarCadena($_POST["p11"]):"";
$p12=isset($_POST["p12"])? limpiarCadena($_POST["p12"]):"";
$p13=isset($_POST["p13"])? limpiarCadena($_POST["p13"]):"";
$p14=isset($_POST["p14"])? limpiarCadena($_POST["p14"]):"";
$p15=isset($_POST["p15"])? limpiarCadena($_POST["p15"]):"";
$p16=isset($_POST["p16"])? limpiarCadena($_POST["p16"]):"";
$p17=isset($_POST["p17"])? limpiarCadena($_POST["p17"]):"";
$p18=isset($_POST["p18"])? limpiarCadena($_POST["p18"]):"";
$p19=isset($_POST["p19"])? limpiarCadena($_POST["p19"]):"";
$p20=isset($_POST["p20"])? limpiarCadena($_POST["p20"]):"";
$p21=isset($_POST["p21"])? limpiarCadena($_POST["p21"]):"";
$p22=isset($_POST["p22"])? limpiarCadena($_POST["p22"]):"";
$p23=isset($_POST["p23"])? limpiarCadena($_POST["p23"]):"";
$p24=isset($_POST["p24"])? limpiarCadena($_POST["p24"]):"";
$p25=isset($_POST["p25"])? limpiarCadena($_POST["p25"]):"";
$p26=isset($_POST["p26"])? limpiarCadena($_POST["p26"]):"";
$p27=isset($_POST["p27"])? limpiarCadena($_POST["p27"]):"";
$p28=isset($_POST["p28"])? limpiarCadena($_POST["p28"]):"";
$p29=isset($_POST["p29"])? limpiarCadena($_POST["p29"]):"";
$p30=isset($_POST["p30"])? limpiarCadena($_POST["p30"]):"";



$cp1=isset($_POST["cp1"])? limpiarCadena($_POST["cp1"]):"";
$cp2=isset($_POST["cp2"])? limpiarCadena($_POST["cp2"]):"";
$cp3=isset($_POST["cp3"])? limpiarCadena($_POST["cp3"]):"";
$cp4=isset($_POST["cp4"])? limpiarCadena($_POST["cp4"]):"";
$cp5=isset($_POST["cp5"])? limpiarCadena($_POST["cp5"]):"";
$cp6=isset($_POST["cp6"])? limpiarCadena($_POST["cp6"]):"";
$cp7=isset($_POST["cp7"])? limpiarCadena($_POST["cp7"]):"";
$cp8=isset($_POST["cp8"])? limpiarCadena($_POST["cp8"]):"";
$cp9=isset($_POST["cp9"])? limpiarCadena($_POST["cp9"]):"";
$cp10=isset($_POST["cp10"])? limpiarCadena($_POST["cp10"]):"";
$cp11=isset($_POST["cp11"])? limpiarCadena($_POST["cp11"]):"";
$cp12=isset($_POST["cp12"])? limpiarCadena($_POST["cp12"]):"";
$cp13=isset($_POST["cp13"])? limpiarCadena($_POST["cp13"]):"";
$cp14=isset($_POST["cp14"])? limpiarCadena($_POST["cp14"]):"";
$cp15=isset($_POST["cp15"])? limpiarCadena($_POST["cp15"]):"";
$cp16=isset($_POST["cp16"])? limpiarCadena($_POST["cp16"]):"";
$cp17=isset($_POST["cp17"])? limpiarCadena($_POST["cp17"]):"";
$cp18=isset($_POST["cp18"])? limpiarCadena($_POST["cp18"]):"";
$cp19=isset($_POST["cp19"])? limpiarCadena($_POST["cp19"]):"";

$dp1=isset($_POST["dp1"])? limpiarCadena($_POST["dp1"]):"";
$dp2=isset($_POST["dp2"])? limpiarCadena($_POST["dp2"]):"";
$dp3=isset($_POST["dp3"])? limpiarCadena($_POST["dp3"]):"";
$dp4=isset($_POST["dp4"])? limpiarCadena($_POST["dp4"]):"";
$dp5=isset($_POST["dp5"])? limpiarCadena($_POST["dp5"]):"";
$dp6=isset($_POST["dp6"])? limpiarCadena($_POST["dp6"]):"";


$ep1=isset($_POST["ep1"])? limpiarCadena($_POST["ep1"]):"";
$ep2=isset($_POST["ep2"])? limpiarCadena($_POST["ep2"]):"";
$ep3=isset($_POST["ep3"])? limpiarCadena($_POST["ep3"]):"";
$ep4=isset($_POST["ep4"])? limpiarCadena($_POST["ep4"]):"";
$ep5=isset($_POST["ep5"])? limpiarCadena($_POST["ep5"]):"";
$ep6=isset($_POST["ep6"])? limpiarCadena($_POST["ep6"]):"";
$ep7=isset($_POST["ep7"])? limpiarCadena($_POST["ep7"]):"";
$ep8=isset($_POST["ep8"])? limpiarCadena($_POST["ep8"]):"";
$ep9=isset($_POST["ep9"])? limpiarCadena($_POST["ep9"]):"";
$ep10=isset($_POST["ep10"])? limpiarCadena($_POST["ep10"]):"";

$fp1=isset($_POST["fp1"])? limpiarCadena($_POST["fp1"]):"";
$fp2=isset($_POST["fp2"])? limpiarCadena($_POST["fp2"]):"";
$fp3=isset($_POST["fp3"])? limpiarCadena($_POST["fp3"]):"";
$fp4=isset($_POST["fp4"])? limpiarCadena($_POST["fp4"]):"";
$fp5=isset($_POST["fp5"])? limpiarCadena($_POST["fp5"]):"";
$fp6=isset($_POST["fp6"])? limpiarCadena($_POST["fp6"]):"";
$fp7=isset($_POST["fp7"])? limpiarCadena($_POST["fp7"]):"";
$fp8=isset($_POST["fp8"])? limpiarCadena($_POST["fp8"]):"";
$fp9=isset($_POST["fp9"])? limpiarCadena($_POST["fp9"]):"";
$fp10=isset($_POST["fp10"])? limpiarCadena($_POST["fp10"]):"";
$fp11=isset($_POST["fp11"])? limpiarCadena($_POST["fp11"]):"";
$fp12=isset($_POST["fp12"])? limpiarCadena($_POST["fp12"]):"";
$fp13=isset($_POST["fp13"])? limpiarCadena($_POST["fp13"]):"";
$fp14=isset($_POST["fp14"])? limpiarCadena($_POST["fp14"]):"";
$fp15=isset($_POST["fp15"])? limpiarCadena($_POST["fp15"]):"";
$fp16=isset($_POST["fp16"])? limpiarCadena($_POST["fp16"]):"";
$fp17=isset($_POST["fp17"])? limpiarCadena($_POST["fp17"]):"";
$fp18=isset($_POST["fp18"])? limpiarCadena($_POST["fp18"]):"";
$fp19=isset($_POST["fp19"])? limpiarCadena($_POST["fp19"]):"";
$fp20=isset($_POST["fp20"])? limpiarCadena($_POST["fp20"]):"";
$fp21=isset($_POST["fp21"])? limpiarCadena($_POST["fp21"]):"";
$fp22=isset($_POST["fp22"])? limpiarCadena($_POST["fp22"]):"";
$fp23=isset($_POST["fp23"])? limpiarCadena($_POST["fp23"]):"";


switch ($_GET['op']) {

    case 'listarDatos':
        $data['conte'] = "";
        $datos = $config->listarDatos();
        if (file_exists("../files/estudiantes/" . $datos['credencial_identificacion'] . ".jpg")) {
            $url = "../files/estudiantes/" . $datos['credencial_identificacion'] . ".jpg";
        } else {
            $url = "../files/null.jpg";
        }
        $data['conte'] .= '
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
                            <h2 class=" fs-18 font-weight-bolder">' . $datos['credencial_nombre'] . ' ' . $datos['credencial_nombre_2'] . '</h2>
                            <span class="fs-14">' . $datos['credencial_apellido'] . ' ' . $datos['credencial_apellido_2'] . '</span><br>
                            <span class="small">'.$datos['credencial_login'].'</span><br>
                            <a onclick=editarContrasena(' . $datos['id_credencial'] . ') class="btn btn-warning btn-xs ">
                                <i class="fas fa-user-lock"></i> Editar clave
                            </a>
                        </div>
                    </div>
                </div>

                


                <div class="col-xl-9 col-12 my-xl-0 my-4 pt-xl-0 pt-4">
                    <div class="row">
                        <div class="col-12"><h2 class="fs-18">Certificados de competencias / Mis insignias digitales</h2></div>
                    </div>
                    <div class="academico row">
                        <div class="col-2"><img src="../public/img/ins1.webp" class="img-fluid" alt="..."></div>
                        <div class="col-2"><img src="../public/img/ins2.webp" class="img-fluid" alt="..."></div>
                        <div class="col-2"><img src="../public/img/ins3.webp" class="img-fluid" alt="..."></div>
                        <div class="col-2"><img src="../public/img/ins4.webp" class="img-fluid" alt="..."></div>
                        <div class="col-2"><img src="../public/img/ins5.webp" class="img-fluid" alt="..."></div>
                        <div class="col-2"><img src="../public/img/ins6.webp" class="img-fluid" alt="..."></div>
                        <div class="col-2"><img src="../public/img/ins4.webp" class="img-fluid" alt="..."></div>
                    </div>
                    
                    
                </div>

        </div>
        ';
        echo json_encode($data);
    break;

    case 'cambiarContra':
        $anterior = $_POST['anterior'];
        $nueva = $_POST['nueva'];
        $confirma = $_POST['confirma'];
        if ($nueva == $confirma) {
            $config->cambiarContra($anterior, $nueva);
        } else {
            $data['status'] = "Error, las contraseñas no coincide.";
            echo json_encode($data);
        }
    break;

    case 'editarDatos':

        $datos = $config->listarDatos();
        $nom_et = $datos['nombre_etnico'];
        //$cond = ($datos['genero'] == "Femenino") ? 'required' : '';
        $data['conte'] = '
        <div class="row" id="conte1">
            <form class="guardarDatosPersonales" id="form" method="POST"> 

                <div class="col-12">
                    <h6 class="title">Información personal</h6>
                </div>

                
                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                        <select name="grupo_etnico" onChange=mostrar(this.value); class="form-control grupo_etnico" required></select>
                            <label>Grupo étnico</label>
                            <input type="hidden" value="' . $nom_et . '" class="form-control nom_et" >
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                        <select name="nombre_etnico" class="form-control nombre_etnico" ></select>
                            <label>Nombre étnico</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                        <select name="tipo_sangre" class="form-control tipo_sangre" required></select>
                            <label>Tipo de sangre</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-12">
                    <h6 class="title">Información de contacto</h6>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="number" name="celular" value="' . $datos['celular'] . '" class="form-control" required>
                            <label>Número celular</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email" name="correo_p" value="' . $datos['email'] . '" class="form-control" required>
                            <label>Correo personal</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" name="whatsapp" value="' . $datos['whatsapp'] . '" class="form-control">
                            <label>Whatsapp (Solo si tiene)</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" name="instagram" value="' . $datos['instagram'] . '" class="form-control">
                            <label>Instagram (Solo si tiene)</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" name="facebook" value="' . $datos['facebook'] . '" class="form-control">
                            <label>Facebook (Solo si tiene)</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" name="linkedin" value="' . $datos['linkedin'] . '" class="form-control">
                            <label>Linkedin (Solo si tiene)</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" name="twiter" value="' . $datos['twiter'] . '" class="form-control">
                            <label>Cuenta de X (Solo si tiene)</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-12">
                    <h6 class="title">Información ubicación geografíca</h6>
                </div>
                

                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                        <select name="depar_residencia" data-live-search="true" onChange=mostrarmuni_residen(this.value); class="form-control depa_reside border"  required></select>
                            <label>Departamento de residencia</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                        <select name="muni_residencia" class="form-control muni_reside" ></select>
                            <label>Municipio de residencia</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select name="estrato" class="form-control estra" required>
                                <option value="" selected disabled>- Estrato -</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                            <label>Estrato Socioeconómico</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" name="dirrecion" value="' . $datos['direccion'] . '" class="form-control" required>
                            <label>Dirección residencia</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                        <input type="text" name="barrio" value="' . $datos['barrio'] . '" class="form-control" required>
                            <label>Barrio residencia</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>


                <div class="col-12 py-4">
                    <button type="submit" class="btn btn-success">Guardar datos de contacto</button>
                </div>

            </form> 
        </div>

        <div id="buttdos">
            
        </div>';
        $data['grupo'] = $datos['grupo_etnico'];
        $data['nom'] = $datos['nombre_etnico'];
        $data['depar_residencia'] = $datos['depar_residencia'];
        $data['muni_residencia'] = $datos['muni_residencia'];
        $data['estrato'] = $datos['estrato'];
        $data['sangre'] = $datos['tipo_sangre'];
        echo json_encode($data);
    break;

    case 'mostrarpuntos':
        $data = array();
        $data["perfil"] = "";
        $data["seres"] = "";
        $data["empleo"] = "";
        $data["ingresos"] = "";
        $data["academica"] = "";

		$perfil=$config->validarpuntos("perfil",$periodo_actual);
        if ($perfil) {$data["perfil"] = "si";}

        $seres=$config->validarpuntos("seres",$periodo_actual);
        if ($seres) {$data["seres"] = "si";}

        $empleo=$config->validarpuntos("empleo",$periodo_actual);
        if ($empleo) {$data["empleo"] = "si";}

        $ingresos=$config->validarpuntos("ingresos",$periodo_actual);
        if ($ingresos) {$data["ingresos"] = "si";}

        $academica=$config->validarpuntos("academica",$periodo_actual);
        if ($academica) {$data["academica"] = "si";}

        $bienestar=$config->validarpuntos("bienestar",$periodo_actual);
        if ($bienestar) {$data["bienestar"] = "si";}

        $results = array($data);
 		echo json_encode($results);

	break;

    case 'editarDatospersonales':

        $data = array();
		$data["datos"] = "";
        $data["puntos"] = "";
        $data["puntosotorgados"] = "";

   
        $direcion=isset($_POST['dirrecion'])? limpiarCadena($_POST['dirrecion']):"";
        $barrio=isset($_POST['barrio'])? limpiarCadena($_POST['barrio']):"";
        $celular=isset($_POST['celular'])? limpiarCadena($_POST['celular']):"";
        $grupo_etnico=isset($_POST['grupo_etnico'])? limpiarCadena($_POST['grupo_etnico']):"";
        $nombre_etnico=isset($_POST['nombre_etnico'])? limpiarCadena($_POST['nombre_etnico']):"";
        $estrato=isset($_POST['estrato'])? limpiarCadena($_POST['estrato']):"";
        $tipo_sangre=isset($_POST['tipo_sangre'])? limpiarCadena($_POST['tipo_sangre']):"";
        $instagram=isset($_POST['instagram'])? limpiarCadena($_POST['instagram']):"";
        $correo_p=isset($_POST['correo_p'])? limpiarCadena($_POST['correo_p']):"";
        $whatsapp=isset($_POST['whatsapp'])? limpiarCadena($_POST['whatsapp']):"";
        $facebook=isset($_POST['facebook'])? limpiarCadena($_POST['facebook']):"";
        $twiter=isset($_POST['twiter'])? limpiarCadena($_POST['twiter']):"";
        $linkedin=isset($_POST['linkedin'])? limpiarCadena($_POST['linkedin']):"";
        $depar_residencia=isset($_POST['depar_residencia'])? limpiarCadena($_POST['depar_residencia']):"";
        $muni_residencia=isset($_POST['muni_residencia'])? limpiarCadena($_POST['muni_residencia']):"";

        $editardatos=$config->editarDatospersonales($direcion, $celular, $grupo_etnico, $nombre_etnico, $estrato, $tipo_sangre, $instagram, $correo_p, $whatsapp, $facebook, $twiter, $linkedin, $barrio, $depar_residencia, $muni_residencia);
        
        $resultado=$editardatos? 'si':'no';

        $data["datos"] =$resultado;

            $punto_nombre="perfil";
            $puntos_cantidad=40;
            $validarpuntos=$config->validarpuntos($punto_nombre,$periodo_actual);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$config->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$config->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $config->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;

            }


		$results = array($data);
 		echo json_encode($results);

    
    break;



    case 'cambiarImagen':
        $campo = isset($_POST["campo"]) ? $_POST["campo"] : "";
        $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
        //como no es un campo con el nombre tal cual tiene la carpeta, entonces se le remueve el ultimo digito agregado
        $campo = substr_replace($campo, "", -1);
        $estado = true;
        if (empty($valor) || is_null($valor)) {
            $msg_errors = "Debes realizar la firma de tu contrato para continuar.";
            die(json_encode(array("exito" => 0, "info" => $msg_errors)));
        } else {
            $rspta =  $config->base64_to_jpeg($valor, "../files/estudiantes/" . $_SESSION["usuario_imagen"] . ".jpg");
            if ($rspta) {
                $data = array("exito" => 1, "info" => "! Todo se ha guardado con exito ¡");
            } else {
                $data = array("exito" => 0, "info" => "Error en el guardado");
            }
            echo json_encode($data);
        }
    break;

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$config->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información básica</h6>
                </div>';
                
                if($pre["genero"]=="Femenino"){ // estas embarazada

                    if($pre["p1"]==1){
                        $p1option='
                            <option value="1" selected>No</option>
                            <option value="2">Si</option>
                        ';
                    }else{
                        $p1option='
                        <option value="1" >No</option>
                        <option value="2" selected>Si</option>
                        ';
                    }

                    $data["datos"] .= '
                    <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select required class="form-control border-start-0"  name="p1" id="p1" onchange="mostrarp1(this.value)">
                                    '.$p1option.'
                                </select>
                                <label>¿Estás embarazada?</label>
                            </div>
                        </div>
                    </div>';

                    $data["datos"] .= '
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="mostrarp2">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <div class="form-floating">
                                    <input type="hidden" value="'.$pre["p2"].'"  id="p2_val">
                                    <select class="form-control border-start-0" name="p2" id="p2">
                                        <option value="">Seleccionar</option>
                                        <option value="1">1 Mes</option>
                                        <option value="2">2 Meses</option>
                                        <option value="3">3 Meses</option>
                                        <option value="4">4 Meses</option>
                                        <option value="5">5 Meses</option>
                                        <option value="6">6 Meses</option>
                                        <option value="7">7 Meses</option>
                                        <option value="8">8 Meses</option>
                                        <option value="9">9 Meses</option>
                                    </select>
                                    <label>¿Cuántos meses de embarazo tienes?</label>
                                </div>
                            </div>
                        </div>
                    </div>';
                }

                
                if($pre["p3"]==1){
                    $p3option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p3option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p3" id="p3" onchange="mostrarp3(this.value)">
                                '.$p3option.'
                            </select>
                            <label>¿Eres desplazado(a) por la violencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="mostrarp4">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p4"].'"  id="p4_val">
                                <select class="form-control border-start-0" name="p4" id="p4">
                                    <option value="">Seleccionar</option>
                                    <option value="Conflicto armado">Conflicto armado</option>
                                    <option value="Social">Social</option>
                                    <option value="Económico">Económico</option>
                                </select>
                                <label>¿qué tipo de desplazamiento has experimentado?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p5"].'"  id="p5_val">
                                <select class="form-control border-start-0" name="p5" id="p5">
                                    <option value="">Seleccionar</option>
                                    <option value="Adulto mayor">Adulto mayor</option>
                                    <option value="Ciudadano Rural">Ciudadano Rural</option>
                                    <option value="Comunidad Negra, Afrocolombiano, Palenquero, Raizal">Comunidad Negra, Afrocolombiano, Palenquero, Raizal</option>
                                    <option value="Desplazado">Desplazado</option>
                                    <option value="Indígena">Indígena</option>
                                    <option value="Madre cabeza de familia">Madre cabeza de familia</option>
                                    <option value="Madre comunitaria">Madre comunitaria</option>
                                    <option value="Mujer embarazada">Mujer embarazada</option>
                                    <option value="Ninguna de las anteriores">Ninguna de las anteriores</option>
                                    <option value="Otras entidades">Otras entidades</option>
                                    <option value="Persona en condición con discapacidad">Persona en condición con discapacidad</option>
                                    <option value="Personas en situación de pobreza extrema (Sisben 1)">Personas en situación de pobreza extrema (Sisben 1)</option>
                                    <option value="Víctima de la violencia">Víctima de la violencia</option>
                                </select>
                                <label>¿A qué grupo poblacional perteneces?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["p6"]==1){
                    $p6option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p6option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="p6" id="p6" onchange="mostrarp6(this.value)">
                                '.$p6option.'
                            </select>
                            <label>¿Perteneces a la comunidad LGBTIQ+?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp7">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p7"].'"  id="p7_val">
                                <select class="form-control border-start-0" name="p7" id="p7">
                                    <option value="">Seleccionar</option>
                                    <option value="Lesbiana">Lesbiana</option>
                                    <option value="gay">gay</option>
                                    <option value="bisexual">bisexual</option>
                                    <option value="transgenero">transgenero</option>
                                    <option value="Intersexual">Intersexual</option>
                                    <option value="Queer">Queer</option>
                                    <option value="No Binario">No Binario</option>
                                </select>
                                <label>¿Cúal comunidad LGBTIQ</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                    <div class="col-12">
                        <h6 class="title">Información básica de contactos de emergencia</h6>
                    </div>
                ';

                
                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["p8"].'" required class="form-control border-start-0" name="p8" id="p8" maxlength="50">
                            <label>¿Cuál es el nombre completo de tu primer contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p9"].'"  id="p9_val">
                                <select class="form-control border-start-0" name="p9" id="p9">
                                    <option value="">Seleccionar</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Hermano (a)">Hermano (a)</option>
                                    <option value="Abuelo (a)">Abuelo (a)</option>
                                    <option value="Tío (a)">Tío (a)</option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Primo (a)">Primo (a)</option>
                                    <option value="Amigo (a)">Amigo (a)</option>
                                </select>
                                <label>¿Cuál es tu relación o parentesco con esta persona?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email"  value="'.$pre["p10"].'"  required class="form-control border-start-0" name="p10" id="p10" maxlength="50">
                            <label>¿Cuál es el correo electrónico de este contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["p11"].'"  required class="form-control border-start-0" name="p11" id="p11" maxlength="10">
                            <label>Teléfono del contacto de emergencia</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["p12"].'" class="form-control border-start-0" name="p12" id="p12" maxlength="50">
                            <label>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p13"].'"  id="p13_val">
                                <select class="form-control border-start-0" name="p13" id="p13">
                                    <option value="">Seleccionar</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Hermano (a)">Hermano (a)</option>
                                    <option value="Abuelo (a)">Abuelo (a)</option>
                                    <option value="Tío (a)">Tío (a)</option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Primo (a)">Primo (a)</option>
                                    <option value="Amigo (a)">Amigo (a)</option>
                                </select>
                                <label>¿Cuál es tu relación o parentesco con esta persona?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="email"  value="'.$pre["p14"].'" class="form-control border-start-0" name="p14" id="p14" maxlength="50">
                            <label>¿Cuál es el correo electrónico de este contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["p15"].'" class="form-control border-start-0" name="p15" id="p15" maxlength="10">
                            <label>Teléfono del contacto de emergencia</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-12">
                    <h6 class="title">Información de conectividad</h6>
                </div>
                ';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p16"].'"  id="p16_val" required>
                                <select class="form-control border-start-0" name="p16" id="p16" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Computador portatil">Computador portatil</option>
                                    <option value="Computador de mesa">Computador de mesa</option>
                                    <option value="Tablet">Tablet </option>
                                    <option value="No cuento con computador">No cuento con computador </option>
                                </select>
                                <label>¿Tienes un computador o tablet?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p17"].'"  id="p17_val">
                                <select class="form-control border-start-0" name="p17" id="p17" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No cuento con internet">No cuento con internet</option>
                                    <option value="Con velocidad menos a 10mb">Con velocidad menos a 10mb</option>
                                    <option value="Con velocidad entre 10mb y 40mb">Con velocidad entre 10mb y 40mb</option>
                                    <option value="Con velocidad entre 40mb y 80mb">Con velocidad entre 40mb y 80mb </option>
                                    <option value="Con velocidad entre 80mb y 120 mb">Con velocidad entre 80mb y 120 mb</option>
                                    <option value="Con velocidad entre 120mb y 200mb">Con velocidad entre 120mb y 200mb</option>
                                    <option value="Con velocidad entre 200mb y 280mb">Con velocidad entre 200mb y 280mb</option>
                                    <option value="Con velocidad entre 280mb y 350mb">Con velocidad entre 280mb y 350mb</option>
                                    <option value="Con velocidad mayor a 350mb">Con velocidad mayor a 350mb</option>
                                </select>
                                <label>¿Tienes conexión a internet en casa?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp5">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["p18"].'"  id="p18_val">
                                <select class="form-control border-start-0" name="p18" id="p18" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Tienes planes de datos en tu celular?</label>
                            </div>
                        </div>
                    </div>
                </div>';



                    
                $data["datos"] .= '<div class="col-12 py-4" style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos personales</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'listarPreguntas3':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$config->listar3($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información de ocupación</h6>
                </div>';
                


                if($pre["ep1"]==1){
                    $p1option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p1option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="cp1" id="cp1" onchange="cmostrarp1(this.value)">
                                '.$p1option.'
                            </select>
                            <label>¿Trabajas actualmente?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep2"].'"  class="form-control border-start-0" name="cp2" id="cp2" maxlength="50">
                            <label>¿Nombre de la empresa en la que trabajas ?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ep3"].'"  id="cp3_val">
                                <select class="form-control border-start-0" name="cp3" id="cp3">
                                    <option value="">Seleccionar</option>
                                    <option value="cpública">Pública</option>
                                    <option value="cprivada">Privada</option>
                                </select>
                                <label>¿Tipo de sector de la empresa en la que trabajas?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep4"].'"  class="form-control border-start-0" name="cp4" id="cp4" maxlength="100">
                            <label>¿Dirección de la empresa donde trabaja?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep5"].'"  class="form-control border-start-0" name="cp5" id="cp5" maxlength="11">
                            <label>¿Teléfono de la empresa donde trabaja?</label>
                        </div>
                    </div>
                </div>';

                
                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ep6"].'"  id="cp6_val">
                                <select class="form-control border-start-0" name="cp6" id="cp6">
                                    <option value="">Seleccionar</option>
                                    <option value="Diurno">Diurno</option>
                                    <option value="Nocturno">Nocturno</option>
                                    <option value="Rotativo">Rotativo</option>
                                </select>
                                <label>¿Jornada laboral?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-12 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep7"].'" class="form-control border-start-0" name="cp7" id="cp7" maxlength="100">
                            <label>¿Qué incentivos genera tu empresa para tu proceso de formación?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ep8"]==1){
                    $p8option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p8option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="cp8" id="cp8" onchange="cmostrarp8(this.value)">
                                '.$p8option.'
                            </select>
                            <label>¿Alguien de tu trabajo actual o anteriores, te inspiró a estudiar?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["ep9"].'"   class="form-control border-start-0" name="cp9" id="cp9" maxlength="80">
                            <label>¿Nombre completo ?</label>
                        </div>
                    </div>
                </div>';

                
                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="number"  value="'.$pre["ep10"].'"   class="form-control border-start-0" name="cp10" id="cp10" maxlength="50">
                            <label>¿teléfono de contacto?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                    <div class="col-12">
                        <h6 class="title">Información de tu empresa/emprendimiento </h6>
                    </div>
                ';

                if($pre["ep11"]==1){
                    $p11option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p11option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="cp11" id="cp11" onchange="cmostrarp11(this.value)">
                                '.$p11option.'
                            </select>
                            <label>¿Tienes una empresa legalmente constituida?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["ep12"].'"   class="form-control border-start-0" name="cp12" id="cp12" maxlength="80">
                            <label>¿Nombre y razón social de la empresa?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ep13"]==1){
                    $p13option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p13option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="cp13" id="cp13" onchange="cmostrarp13(this.value)">
                                '.$p13option.'
                            </select>
                            <label>¿Tienes una idea de negocio o emprendimiento?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["ep14"].'"   class="form-control border-start-0" name="cp14" id="cp14" maxlength="80">
                            <label>¿Nombre de la empresa, emprendimiento o idea de negocio?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["ep15"].'" id="cp15_val" >
                                <select class="form-control border-start-0" name="cp15" id="cp15" >
                                    <option value="">Seleccionar</option>
                                    <option value="Agricultura; plantaciones, otros sectores rurales">Agricultura; plantaciones, otros sectores rurales</option>
                                    <option value="Comercio">Comercio</option>
                                    <option value="Construcción">Construcción</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Hotelería, restauración, turísmo">Hotelería, restauración, turísmo</option>
                                    <option value="Ingeniería mecánica y eléctrica">Ingeniería mecánica y eléctrica</option>
                                    <option value="Servicios de correos y telecomunicaciones">Servicios de correos y telecomunicaciones</option>
                                    <option value="Servicios de salud">Servicios de salud</option>
                                    <option value="Servicios financieros">Servicios financieros</option>
                                    <option value="Textiles; vestidos; cuero; calzado">Textiles; vestidos; cuero; calzado</option>
                                    <option value="Software">Software</option>
                                    <option value="Tecnología e Innovación">Tecnología e Innovación</option>
                                    <option value="Salud y Bienestar">Salud y Bienestar</option>
                                    <option value="Educación y Desarrollo Académico">Educación y Desarrollo Académico</option>
                                    <option value="Finanzas y Servicios Financieros">Finanzas y Servicios Financieros</option>
                                    <option value="Arte, Entretenimiento y Creatividad">Arte, Entretenimiento y Creatividad</option>
                                    <option value="Construcción e Ingeniería Civil">Construcción e Ingeniería Civil</option>
                                    <option value="Agricultura y Agroindustria">Agricultura y Agroindustria</option>
                                    <option value="Transporte, Logística y Distribución">Transporte, Logística y Distribución</option>
                                    <option value="Energía y Recursos Naturales">Energía y Recursos Naturales</option>
                                    <option value="Turismo, Hospitalidad y Viajes">Turismo, Hospitalidad y Viajes</option>

                                </select>
                                <label>¿Sector de la empresa, emprendimiento o idea de negocio?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep16"].'" class="form-control border-start-0" name="cp16" id="cp16" maxlength="100">
                            <label>¿Cuál fue tu principal motivación para emprender?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                $data["datos"] .= '
                <div class="col-xl-12 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep17"].'" class="form-control border-start-0" name="cp17" id="cp17" maxlength="100">
                            <label>¿Qué recursos o apoyo necesitarías para desarrollar tu emprendimiento?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12"></div>';

                if($pre["ep18"]==1){
                    $p18option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p18option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="cp18" id="cp18" onchange="cmostrarp18(this.value)">
                                '.$p18option.'
                            </select>
                            <label>¿Has realizado algún curso o capacitación relacionada con emprendimiento?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["ep19"].'"  class="form-control border-start-0" name="cp19" id="cp19" maxlength="50">
                            <label>¿Cuál curso o capacitación?</label>
                        </div>
                    </div>
                </div>';

                    
                $data["datos"] .= '<div class="col-12 py-4" style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos de empleabilidad</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'listarPreguntas4':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$config->listar4($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información básica</h6>
                </div>';
                
      


                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="dmostrarp1">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop1"].'"  id="dp1_val">
                                <select class="form-control border-start-0" name="dp1" id="dp1" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Menos 1 SMLV">Menos 1 SMLV</option>
                                    <option value="1-3 SMLV">1-3 SMLV</option>
                                    <option value="3-5 SMLV">3-5 SMLV</option>
                                    <option value="5-7 SMLV">5-7 SMLV</option>
                                    <option value="7-10 SMLV">7-10 SMLV</option>
                                    <option value="MÁS DE 10 SMLV">MÁS DE 10 SMLV</option>
                                    <option value="No genero ingresos">No genero ingresos</option>
                                </select>
                                <label>¿Cuáles son tus ingresos mensuales? (en pesos colombianos)</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="dmostrarp2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop2"].'"  id="dp2_val">
                                <select class="form-control border-start-0" name="dp2" id="dp2" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Recursos propios">Recursos propios</option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Papá">Papá</option>
                                    <option value="Mamá">Mamá</option>
                                    <option value="Empresa">Empresa</option>
                                    <option value="Beca">Beca</option>
                                </select>
                                <label>¿Quién paga tu matrícula?</label>
                            </div>
                        </div>
                    </div>
                </div>';
              
                $data["datos"] .= '
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="dmostrarp3">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <div class="form-floating">
                                    <input type="hidden" value="'.$pre["cop3"].'"  id="dp3_val">
                                    <select class="form-control border-start-0" name="dp3" id="dp3" required>
                                        <option value="">Seleccionar</option>
                                        <option value="No">No</option>
                                        <option value="Si">Si</option>
                                    </select>
                                    <label>¿Cuentas con algún apoyo financiero?</label>
                                </div>
                            </div>
                        </div>
                    </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="dmostrarp4">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop4"].'"  id="dp4_val">
                                <select class="form-control border-start-0" name="dp4" id="dp4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿En la actualidad recibes prima y/o cesantías?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["cop5"]==1){
                    $p5option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p5option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="dp5" id="dp5" onchange="dmostrarp6(this.value)">
                                '.$p5option.'
                            </select>
                            <label>¿Cuentas con obligaciones financieras?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="dmostrarp6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop6"].'"  id="dp6_val">
                                <select class="form-control border-start-0" name="dp6" id="dp6">
                                    <option value="">Seleccionar</option>
                                    <option value="Vivienda">Vivienda</option>
                                    <option value="Educativa">Educativa</option>
                                    <option value="Vehículo">Vehículo</option>
                                    <option value="Personales">Personales</option>
                                    
                                </select>
                                <label>¿De qué tipo?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '<div class="col-12 py-4 " style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'listarPreguntas5':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$config->listar5($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información básica</h6>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="emostrarp1">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap1"].'"  id="ep1_val">
                                <select class="form-control border-start-0" name="ep1" id="ep1" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Interés y pasión por el aprendizaje">Interés y pasión por el aprendizaje</option>
                                    <option value="Mejoras laborales y profesionales">Mejoras laborales y profesionales</option>
                                    <option value="Influencia y apoyo de figuras cercanas">Influencia y apoyo de figuras cercanas</option>
                                    <option value="Búsqueda de estabilidad y seguridad">Búsqueda de estabilidad y seguridad</option>
                                    <option value="Desarrollo personal y crecimiento">Desarrollo personal y crecimiento</option>
                                    <option value="Necesidades académicas y profesionales">Necesidades académicas y profesionales</option>
                                    <option value="Exploración y descubrimiento de nuevas áreas">Exploración y descubrimiento de nuevas áreas</option>
                                    <option value="Superación y desafío personal">Superación y desafío personal</option>
                                    <option value="Necesidades económicas y financieras">Necesidades económicas y financieras</option>
                                    <option value="Contribución a la sociedad y comunidad">Contribución a la sociedad y comunidad</option>
                                </select>
                                <label>¿Qué te motivó a estudiar</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="emostrarp2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap2"].'"  id="ep2_val">
                                <select class="form-control border-start-0" name="ep2" id="ep2" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Visitó nuestra sede">Visitó nuestra sede</option>
                                    <option value="Redes sociales">Redes sociales</option>
                                    <option value="Página web">Página web</option>
                                    <option value="Lo refirió un amigo y/o familia">Lo refirió un amigo y/o familia </option>
                                    <option value="Publicidad">Publicidad</option>
                                </select>
                                <label>¿Cómo te enteraste de CIAF?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="emostrarp3">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap3"].'"  id="ep3_val">
                                <select class="form-control border-start-0" name="ep3" id="ep3" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Herramientas digitales">Herramientas digitales</option>
                                    <option value="Matemáticas">Matemáticas</option>
                                    <option value="Inteligencia Artificial">Inteligencia Artificial</option>
                                    <option value="Marketing Digital">Marketing Digital</option>
                                    <option value="Liderazgo">Liderazgo</option>
                                    <option value="Lecto-escritura">Lecto-escritura</option>
                                    <option value="Matemáticas y analítica">Matemáticas y analítica</option>
                                    <option value="Oratoria">Oratoria</option>
                                    <option value="Relaciones sociales">Relaciones sociales</option>
                                    <option value="Programación y Desarrollo de Software">Programación y Desarrollo de Software</option>
                                    <option value="Gestión de Proyectos">Gestión de Proyectos</option>
                                    <option value="Análisis de Datos">Análisis de Datos</option>
                                    <option value="Creación de Contenido Digital">Creación de Contenido Digital</option>
                                    <option value="Planificación Estratégica">Planificación Estratégica</option>
                                    <option value="Emprendimiento y Startups">Emprendimiento y Startups</option>
                                    <option value="Ninguna">Ninguna</option>
                                </select>
                                <label>¿Cuál de las siguientes áreas es de tu preferencia?</label>
                            </div>
                        </div>
                    </div>
                </div>';
             

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="emostrarp4">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap4"].'"  id="ep4_val">
                                <select class="form-control border-start-0" name="ep4" id="ep4">
                                    <option value="">Seleccionar</option>
                                    <option value="Haciendo">Haciendo</option>
                                    <option value="Viendo">Viendo</option>
                                    <option value="Escuchando">Escuchando</option>
                                    <option value="Leyendo">Leyendo</option>
                                    <option value="Escribiendo">Escribiendo</option>
                                </select>
                                <label>¿De qué manera aprendes más fácil?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["eap5"]==1){
                    $p5option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p5option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0"  name="ep5" id="ep5" onchange="emostrarp5(this.value)">
                                '.$p5option.'
                            </select>
                            <label>¿Te gustaría realizar una doble titulación en nuestros programas?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" id="emostrarp6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap6"].'" id="ep6_val">
                                <select class="form-control border-start-0" name="ep6" id="ep6">
                                    <option value="">Seleccionar</option>
                                    <option value="Administración de empresas">Administración de empresas</option>
                                    <option value="Contaduría pública">Contaduría pública</option>
                                    <option value="Ingeniería de software">Ingeniería de software</option>
                                    <option value="Ingeniería industrial">Ingeniería industrial</option>
                                    <option value="Seguridad y salud en el trabajo">Seguridad y salud en el trabajo</option>
                                    <option value="Técnico laboral en auxiliar de enfermería">Técnico laboral en auxiliar de enfermería</option>
                                    <option value="Técnico laboral administrativo en salud">Técnico laboral administrativo en salud</option>
                                    <option value="Técnico laboral por competencias en mecánica de motos">Técnico laboral por competencias en mecánica de motos</option>
                                    <option value="Técnico laboral en auxiliar de veterinaria y cuidado de mascotas">Técnico laboral en auxiliar de veterinaria y cuidado de mascotas</option>
                                    <option value="Diplomado Marketing Digital para Pymes">Diplomado Marketing Digital para Pymes</option>
                                    <option value="Curso Video Pitch-Vende tu proyecto en 3 minutos">Curso Video Pitch-Vende tu proyecto en 3 minutos</option>
                                    <option value="Diplomado en Barismo">Diplomado en Barismo</option>
                                    <option value="Diplomado en Formulación de Proyectos">Diplomado en Formulación de Proyectos</option>
                                    <option value="Curso de Diseño de Producto y Experiencias Turísticas">Curso de Diseño de Producto y Experiencias Turísticas</option>
                                    <option value="Curso De Piloto Profesional De Dron">Curso De Piloto Profesional De Dron</option>
                                    <option value="Seminario taller en Declaración Renta Persona Natural">Seminario taller en Declaración Renta Persona Natural</option>
                                    <option value="Diplomado de Excel">Diplomado de Excel</option>
                                    <option value="Diplomado en Docencia Universitaria">Diplomado en Docencia Universitaria</option>

                                </select>
                                <label>¿Qué programa te interesaría?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["eap7"]==1){
                    $p7option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p7option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="ep7" id="ep7" onchange="emostrarp7(this.value)">
                                '.$p7option.'
                            </select>
                            <label>¿Dominas un segundo idioma?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="emostrarp8">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap8"].'" id="ep8_val">
                                <select class="form-control border-start-0" name="ep8" id="ep8">
                                    <option value="">Seleccionar</option>
                                    <option value="Mandarín">Mandarín</option>
                                    <option value="Español">Español</option>
                                    <option value="Francés">Francés</option>
                                    <option value="Árabe">Árabe</option>
                                    <option value="Alemán">Alemán</option>
                                    <option value="Japonés">Japonés</option>
                                    <option value="Ruso">Ruso</option>
                                    <option value="Portugués">Portugués</option>
                                    <option value="Italiano">Italiano</option>
                                    <option value="Inglés">Inglés</option>
                                    <option value="Hindi>Hindi</option>
                                    <option value="Coreano">Coreano</option>
                                    <option value="Holandés">Holandés</option>
                                    <option value="Sueco">Sueco</option>
                                    <option value="Turco">Turco</option>
                                    <option value="Polaco">Polaco</option>
                                    <option value="Danés">Danés</option>
                                    <option value="Griego">Griego</option>
                                    <option value="Hebreo">Hebreo</option>
                                    <option value="Swahili">Swahili</option>
                                    <option value="Tailandés">Tailandés</option>
                                    <option value="Latín">Latín</option>

                                </select>
                                <label>¿Qué idioma?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="emostrarp9">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["eap9"].'"  id="ep9_val">
                                <select class="form-control border-start-0" name="ep9" id="ep9">
                                    <option value="">Seleccionar</option>
                                    <option value="Básico">Básico</option>
                                    <option value="Intermedio">Intermedio</option>
                                    <option value="Avanzado">Avanzado</option>

                                </select>
                                <label>¿En qué nivel te encuentras?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["eap10"].'" class="form-control border-start-0" name="ep10" id="ep10" maxlength="100" required>
                            <label>¿Cuál es el nombre completo de tu segundo contacto de emergencia?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '<div class="col-12 py-4" style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'listarPreguntas6':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$config->listar6($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información de salud física y mental</h6>
                </div>';
                


                if($pre["bp1"]==1){
                    $p1option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p1option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="fp1" id="fp1" onchange="fmostrarp1(this.value)">
                                '.$p1option.'
                            </select>
                            <label>¿Tienes alguna enfermedad física?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp2"].'"  id="fp2_val">
                                <select class="form-control border-start-0" name="fp2" id="fp2">
                                    <option value="">Seleccionar</option>
                                    <option value="Artritis">Artritis</option>
                                    <option value="Asma">Asma</option>
                                    <option value="Bronquitis">Bronquitis</option>
                                    <option value="Cáncer">Cáncer</option>
                                    <option value="Colesterol-triglicéridos">Colesterol-triglicéridos</option>
                                    <option value="Diabetes">Diabetes</option>
                                    <option value="Enfermedades cardiacas">Enfermedades cardiacas</option>
                                    <option value="Epilepsia">Epilepsia</option>
                                    <option value="Hipertensión arterial">Hipertensión arterial</option>
                                    <option value="Hipoglucemia">Hipoglucemia</option>
                                    <option value="Trastorno tiroideo">Trastorno tiroideo</option>
                                    <option value="Vértigo">Vértigo</option>
                                    <option value="Anemia">Anemia</option>
                                    <option value="Artritis reumatoide">Artritis reumatoide</option>
                                    <option value="Aspergilosis">Aspergilosis</option>
                                    <option value="Celiaquía">Celiaquía</option>
                                    <option value="Cistitis">Cistitis</option>
                                    <option value="Colitis ulcerosa">Colitis ulcerosa</option>
                                    <option value="Dermatitis">Dermatitis</option>
                                    <option value="Esclerosis múltiple">Esclerosis múltiple</option>
                                    <option value="Faringitis">Faringitis</option>
                                    <option value="Fibromialgia">Fibromialgia</option>
                                    <option value="Gastritis">Gastritis</option>
                                    <option value="Gota">Gota</option>
                                    <option value="Hepatitis">Hepatitis</option>
                                    <option value="Infección urinaria">Infección urinaria</option>
                                    <option value="Insuficiencia renal">Insuficiencia renal</option>
                                    <option value="Lupus">Lupus</option>
                                    <option value="Migraña">Migraña</option>
                                    <option value="Neumonía">Neumonía</option>
                                    <option value="Obesidad">Obesidad</option>
                                    <option value="Osteoporosis">Osteoporosis</option>
                                    <option value="Parkinson">Parkinson</option>
                                    <option value="Psoriasis">Psoriasis</option>
                                    <option value="Reflujo gastroesofágico">Reflujo gastroesofágico</option>
                                    <option value="Síndrome del intestino irritable">Síndrome del intestino irritable</option>
                                    <option value="Sinusitis">Sinusitis</option>
                                    <option value="Tendinitis">Tendinitis</option>
                                    <option value="Tuberculosis">Tuberculosis</option>
                                    <option value="Úlcera péptica">Úlcera péptica</option>
                                </select>
                                <label>¿Qué enfermedad física?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp3"].'"  id="fp3_val">
                                <select class="form-control border-start-0" name="fp3" id="fp3">
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Recibes algún tratamiento para esta enfermedad que padeces?</label>
                            </div>
                        </div>
                    </div>
                </div>';


                
                if($pre["bp4"]==1){
                    $p4option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p4option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="fp4" id="fp4" onchange="fmostrarp4(this.value)">
                                '.$p4option.'
                            </select>
                            <label>¿Has sido diagnosticado con algún trastorno mental?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp5"].'"  id="fp5_val">
                                <select class="form-control border-start-0" name="fp5" id="fp5">
                                    <option value="">Seleccionar</option>
                                    <option value="Depresión">Depresión</option>
                                    <option value="Ansiedad">Ansiedad</option>
                                    <option value="Trastorno de ansiedad generalizada (TAG)">Trastorno de ansiedad generalizada (TAG)</option>
                                    <option value="Trastorno de pánico">Trastorno de pánico</option>
                                    <option value="Trastorno obsesivo-compulsivo (TOC)">Trastorno obsesivo-compulsivo (TOC)</option>
                                    <option value="Trastorno de estrés postraumático (TEPT)">Trastorno de estrés postraumático (TEPT)</option>
                                    <option value="Trastorno bipolar">Trastorno bipolar</option>
                                    <option value="Esquizofrenia">Esquizofrenia</option>
                                    <option value="Trastorno de personalidad límite (TPL)">Trastorno de personalidad límite (TPL)</option>
                                    <option value="Trastorno de la conducta alimentaria (anorexia, bulimia)">Trastorno de la conducta alimentaria (anorexia, bulimia)</option>
                                    <option value="Trastorno por déficit de atención e hiperactividad (TDAH)">Trastorno por déficit de atención e hiperactividad (TDAH)</option>
                                    <option value="Trastorno del espectro autista (TEA)">Trastorno del espectro autista (TEA)</option>
                                    <option value="Trastorno de la conducta">Trastorno de la conducta</option>
                                    <option value="Trastorno de la conducta disruptiva no especificado">Trastorno de la conducta disruptiva no especificado</option>
                                    <option value="Trastorno de conducta alimentaria no especificado">Trastorno de conducta alimentaria no especificado</option>
                                </select>
                                <label>¿Qué trastorno mental?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp6"].'"  id="fp6_val">
                                <select class="form-control border-start-0" name="fp6" id="fp6">
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Recibes tratamiento médico del trastorno mental que presentas?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-7 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp7"].'"  class="form-control border-start-0" name="fp7" id="fp7" maxlength="100" required>
                            <label>¿Hay algún aspecto específico que desees compartir sobre tu bienestar emocional o psicológico?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp8"].'"  id="fp8_val">
                                <select class="form-control border-start-0" name="fp8" id="fp8" required>
                                    <option value="">Seleccionar</option>
                                    <option value="EPS SURA">EPS SURA</option>
                                    <option value="Sanitas">Sanitas</option>
                                    <option value="Coomeva EPS">Coomeva EPS</option>
                                    <option value="Nueva EPS">Nueva EPS</option>
                                    <option value="Salud Total EPS">Salud Total EPS</option>
                                    <option value="EPS Famisanar">EPS Famisanar</option>
                                    <option value="Aliansalud EPS">Aliansalud EPS</option>
                                    <option value="Compensar EPS">Compensar EPS</option>
                                    <option value="Medimás EPS">Medimás EPS</option>
                                    <option value="Cruz Blanca EPS">Cruz Blanca EPS</option>
                                    <option value="FOMAG">Fondo Nacional de Prestaciones Sociales FOMAG</option>
                                    <option value="S.O.S">S.O.S</option>
                                    <option value="Sanidad">SANIDAD</option>
                                </select>
                                <label>¿A cuál EPS está afiliado actualmente?</label>
                            </div>
                        </div>
                    </div>
                </div>';



                if($pre["bp9"]==1){
                    $p9option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p9option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0" name="fp9" id="fp9" onchange="fmostrarp9(this.value)">
                                '.$p9option.'
                            </select>
                            <label>¿Consumes algún medicamento de manera permanente?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["bp10"].'" class="form-control border-start-0" name="fp10" id="fp10" maxlength="80">
                            <label>¿Qué medicamentos?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                    <div class="col-12">
                        <h6 class="title">Información aptitudinal</h6>
                    </div>
                ';

                if($pre["bp11"]==1){
                    $p11option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p11option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="fp11" id="fp11" onchange="fmostrarp11(this.value)">
                                '.$p11option.'
                            </select>
                            <label>¿Tienes alguna habilidad especial o talento que te gustaría mencionar?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text"  value="'.$pre["bp12"].'"   class="form-control border-start-0" name="fp12" id="fp12" maxlength="80">
                            <label>¿Cual habilidad?</label>
                        </div>
                    </div>
                </div>';


               $data["datos"] .= '
                <div class="col-xl-12 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp13"].'" id="fp13_val">
                                <select class="form-control border-start-0" name="fp13" id="fp13" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Participas en actividades extracurriculares relacionadas con tus habilidades o talentos?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-12 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp14"].'" id="fp14_val">
                                <select class="form-control border-start-0" name="fp14" id="fp14" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿Has recibido algún tipo de reconocimiento o premio por tus habilidades o talentos?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp15"].'" class="form-control border-start-0" name="fp15" id="fp15" maxlength="100" required>
                            <label>¿Cómo integras tus habilidades o talentos en tu vida universitaria y cotidiana?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp16"].'" id="fp16_val" >
                                <select class="form-control border-start-0" name="fp16" id="fp16" >
                                    <option value="">Seleccionar</option>
                                    <option value="Deportes">Deportes</option>
                                    <option value="Cultura">Cultura</option>
                                    <option value="Salud">Salud</option>
                                    <option value="Desarrollo humano">Desarrollo humano</option>
                                    <option value="Medio Ambiente">Medio Ambiente</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Economía">Economía</option>
                                    <option value="Política">Política</option>
                                    <option value="Arte y Creatividad">Arte y Creatividad</option>
                                    <option value="Tercera Edad">Tercera Edad</option>
                                    <option value="Migración y Diversidad Cultural">Migración y Diversidad Cultural</option>
                                    <option value="Género y Diversidad Sexual">Género y Diversidad Sexual</option>
                                </select>
                                <label>¿Cuáles son las actividades de tu interés?</label>
                            </div>
                        </div>
                    </div>
                </div>';


                if($pre["bp17"]==1){
                    $p17option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p17option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select  class="form-control border-start-0"  name="fp17" id="fp17" onchange="fmostrarp17(this.value)">
                                '.$p17option.'
                            </select>
                            <label>¿Pertenece a algún tipo de voluntariado?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp18"].'"  class="form-control border-start-0" name="fp18" id="fp18" maxlength="50">
                            <label>¿cuál voluntariado?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp19"].'" id="fp19_val" >
                                <select class="form-control border-start-0" name="fp19" id="fp19" >
                                    <option value="">Seleccionar</option>
                                    <option value="Monitor">Monitor</option>
                                    <option value="Líder estudiantil">Líder estudiantil</option>
                                    <option value="Participante de las actividades de Bienestar">Participante de las actividades de Bienestar</option>
                                </select>
                                <label>¿Desearía participar en CIAF cómo?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp20"].'" id="fp20_val" >
                                <select class="form-control border-start-0" name="fp20" id="fp20" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Salud mental">Salud mental</option>
                                    <option value="Violencia de género">Violencia de género</option>
                                    <option value="Meditación">Meditación</option>
                                    <option value="Técnicas de estudio">Técnicas de estudio</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Inteligencia artificial">Inteligencia artificial</option>
                                    <option value="Nutrición y alimentación saludable">Nutrición y alimentación saludable</option>
                                    <option value="Ejercicio físico y entrenamiento deportivo">Ejercicio físico y entrenamiento deportivo</option>
                                    <option value="Prevención de enfermedades">Prevención de enfermedades</option>
                                    <option value="Gestión del estrés">Gestión del estrés</option>
                                    <option value="Relaciones interpersonales y habilidades sociales">Relaciones interpersonales y habilidades sociales</option>
                                    <option value="Desarrollo personal y autoayuda">Desarrollo personal y autoayuda</option>
                                    <option value="Emprendimiento y desarrollo empresarial">Emprendimiento y desarrollo empresarial</option>
                                    <option value="Innovación y creatividad">Innovación y creatividad</option>
                                    <option value="Filosofía y ética">Filosofía y ética</option>
                                    <option value="Historia y patrimonio cultural">Historia y patrimonio cultural</option>
                                    <option value="Ciencia y tecnología espaciales">Ciencia y tecnología espaciales</option>
                                    <option value="Desarrollo sostenible y responsabilidad ambiental">Desarrollo sostenible y responsabilidad ambiental</option>
                                    <option value="Justicia social y equidad">Justicia social y equidad</option>
                                    <option value="Derechos humanos y activismo">Derechos humanos y activismo</option>
                                </select>
                                <label>¿Seleccione los temas de tu interés ?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-5 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp21"].'" id="fp21_val" >
                                <select class="form-control border-start-0" name="fp21" id="fp21" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Clásica">Clásica</option>
                                    <option value="Parrandera">Parrandera</option>
                                    <option value="Rock">Rock</option>
                                    <option value="Vallenato">Vallenato</option>
                                    <option value="Salsa">Salsa</option>
                                    <option value="Romantica">Romantica</option>
                                    <option value="Pop">Pop</option>
                                    <option value="Metal">Metal</option>
                                    <option value="Andina">Andina</option>
                                    <option value="Reggaeton">Reggaeton</option>
                                    <option value="Despecho">Despecho</option>
                                    <option value="Boleros">Boleros</option>
                                    <option value="Tangos">Tangos</option>
                                    <option value="Hip-hop">Hip-hop</option>
                                    <option value="Rap">Rap</option>
                                    <option value="R&B (Rhythm and Blues)">R&B (Rhythm and Blues)</option>
                                    <option value="Jazz">Jazz</option>
                                    <option value="Blues">Blues</option>
                                    <option value="Reggae">Reggae</option>
                                    <option value="Electrónica">Electrónica</option>
                                    <option value="Folk">Folk</option>
                                    <option value="Country">Country</option>
                                    <option value="Punk">Punk</option>
                                    <option value="Indie">Indie</option>
                                    <option value="Funk">Funk</option>
                                    <option value="Soul">Soul</option>
                                    <option value="Gospel">Gospel</option>
                                    <option value="Dance">Dance</option>
                                    <option value="EDM (Electronic Dance Music)">EDM (Electronic Dance Music)</option>
                                    <option value="Ska">Ska</option>
                                    <option value="Flamenco">Flamenco</option>
                                    <option value="Merengue">Merengue</option>
                                    <option value="Cumbia">Cumbia</option>
                                    <option value="Tecno cumbia">Tecno cumbia</option>
                                    <option value="Bossa Nova">Bossa Nova</option>
                                    <option value="Trance">Trance</option>
                                    <option value="House">House</option>
                                    <option value="Techno">Techno</option>
                                    <option value="Ambient">Ambient</option>
                                    <option value="Dubstep">Dubstep</option>
                                    <option value="Soca">Soca</option>
                                    <option value="Mariachi">Mariachi</option>
                                    <option value="J-pop (Pop japonés)">J-pop (Pop japonés)</option>
                                    <option value="K-pop (Pop coreano)">K-pop (Pop coreano)</option>
                                    <option value="Bollywood">Bollywood</option>
                                    <option value="Banda">Banda</option>
                                    <option value="Grunge">Grunge</option>
                                </select>
                                <label>¿Música de tu preferencia ?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-7 col-lg-6 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <input type="text" value="'.$pre["bp22"].'"  class="form-control border-start-0" name="fp22" id="fp22" maxlength="100" required>
                            <label>¿Qué habilidades o talentos te gustaría desarrollar durante tu tiempo en la universidad?</label>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-6 col-lg-6 col-md-6 col-12" >
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["bp23"].'" id="fp23_val" >
                                <select class="form-control border-start-0" name="fp23" id="fp23" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Fútbol">Fútbol</option>
                                    <option value="Baloncesto">Baloncesto</option>
                                    <option value="Voleibol">Voleibol</option>
                                    <option value="Natación">Natación</option>
                                    <option value="Boxeo">Boxeo</option>
                                    <option value="Tenis">Tenis</option>
                                    <option value="Tenis de mesa">Tenis de mesa</option>
                                    <option value="Ajedrez">Ajedrez</option>
                                </select>
                                <label>¿Cuál es tu deporte de interés?</label>
                            </div>
                        </div>
                    </div>
                </div>';





                $data["datos"] .= '<div class="col-12 py-4" style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'validar':
        $validar = $_POST['valida'];
        $config->validar($validar);
    break;

    case 'mostarDepar':
        $config->mostarDepar();
    break;

    case 'mostarMuni':
        $depa = $_POST['depa'];
        $config->mostarMuni($depa);
    break; 

    case 'tiposangre':
        $config->tiposangre();
    break;

    case 'consultaestado':
        $config->consultaestado();
    break;

    case 'guardaryeditar':

		$data= Array();
		$data["estado"] ="";

        $data["puntos"] = "";
        $data["puntosotorgados"] = "";


			$rspta=$config->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$p13,$p14,$p15,$p16,$p17,$p18,$fecha);
			$datos=$rspta ? "si" : "no";	
		    $data["estado"] = $datos;

            $punto_nombre="seres";
            $puntos_cantidad=30;

            $validarpuntos=$config->validarpuntos($punto_nombre,$periodo_actual);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$config->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$config->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $config->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;

            }

        $results = array($data);
 		echo json_encode($results);

	break;

    
    case 'guardaryeditar3':

		$data= Array();
		$data["estado"] ="";

        $data["puntos"] = "";
        $data["puntosotorgados"] = "";

			$rspta=$config->editarDatos3($id_credencial,$cp1,$cp2,$cp3,$cp4,$cp5,$cp6,$cp7,$cp8,$cp9,$cp10,$cp11,$cp12,$cp13,$cp14,$cp15,$cp16,$cp17,$cp18,$cp19,$fecha);
			$datos=$rspta ? "si" : "no";	
		    $data["estado"] = $datos;

            $punto_nombre="empleo";
            $puntos_cantidad=30;

            $validarpuntos=$config->validarpuntos($punto_nombre,$periodo_actual);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$config->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$config->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $config->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;
            }

        $results = array($data);
 		echo json_encode($results);
    
	break;

    case 'guardaryeditar4':

		$data= Array();
		$data["estado"] ="";

        $data["puntos"] = "";
        $data["puntosotorgados"] = "";


			$rspta=$config->editarDatos4($id_credencial,$dp1,$dp2,$dp3,$dp4,$dp5,$dp6,$fecha);
			$datos=$rspta ? "si" : "no";	
            $data["estado"] = $datos;

            $punto_nombre="ingresos";
            $puntos_cantidad=30;

            $validarpuntos=$config->validarpuntos($punto_nombre,$periodo_actual);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$config->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$config->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $config->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;
            }

        $results = array($data);
 		echo json_encode($results);

	break;

    case 'guardaryeditar5':

		$data= Array();
		$data["estado"] ="";

        $data["puntos"] = "";
        $data["puntosotorgados"] = "";

			$rspta=$config->editarDatos5($id_credencial,$ep1,$ep2,$ep3,$ep4,$ep5,$ep6,$ep7,$ep8,$ep9,$ep10,$fecha);
			$datos=$rspta ? "si" : "no";	
            $data["estado"] = $datos;

            $punto_nombre="academica";
            $puntos_cantidad=30;

            $validarpuntos=$config->validarpuntos($punto_nombre,$periodo_actual);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$config->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$config->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $config->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;
            }

        $results = array($data);
 		echo json_encode($results);
	break;

    case 'guardaryeditar6':

		$data= Array();
		$data["estado"] ="";

        $data["puntos"] = "";
        $data["puntosotorgados"] = "";


			$rspta=$config->editarDatos6($id_credencial,$fp1,$fp2,$fp3,$fp4,$fp5,$fp6,$fp7,$fp8,$fp9,$fp10,$fp11,$fp12,$fp13,$fp14,$fp15,$fp16,$fp17,$fp18,$fp19,$fp20,$fp21,$fp22,$fp23,$fecha);
			$datos=$rspta ? "si" : "no";	
		            $data["estado"] = $datos;

            $punto_nombre="bienestar";
            $puntos_cantidad=40;

            $validarpuntos=$config->validarpuntos($punto_nombre,$periodo_actual);// para validar si el punto de perfil fue otorgado
            if ($validarpuntos) {
                // Sí se obtuvo un resultado (al menos una fila) quiere decir que el punto fue otorgado
                
            } else {
                // No se obtuvo ningún resultado no hay punto otorgado
                $insertarpunto=$config->insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$fecha,$hora,$periodo_actual);

                $totalpuntos=$config->verpuntos();
                $puntoscredencial=$totalpuntos["puntos"];
                $sumapuntos=$puntos_cantidad+$puntoscredencial;
                $config->actulizarValor($sumapuntos);
                $data["puntos"] = "si";
                $data["puntosotorgados"] = $puntos_cantidad;
            }

        $results = array($data);
 		echo json_encode($results);
	break;




}