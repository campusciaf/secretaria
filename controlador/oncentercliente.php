<?php
session_start();
require_once "../modelos/Oncentercliente.php";
require('../public/mail/sendMailPreinscrito.php');

date_default_timezone_set('America/Bogota');

$oncentercliente = new OncenterCliente();

$id_estudiante_mover = isset($_POST["id_estudiante_mover"]) ? limpiarCadena($_POST["id_estudiante_mover"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
$id_usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_estudiante = isset($_POST["id_estudiante"]) ? limpiarCadena($_POST["id_estudiante"]) : "";


switch ($_GET['op']) {

    case 'consultacliente':

        $dato = $_POST['dato'];
        $tipo = $_POST['tipo'];
        $data['conte'] = '';
        $data['conte2'] = '';
        $val = '';

        if ($tipo == "1") {
            $val = 'identificacion = ' . $dato;
        }

        if ($tipo == "2") {
            $val = 'id_estudiante = ' . $dato;
        }

        if ($tipo == "3") {
            $val = 'celular = ' . $dato;
        }
        $datos = $oncentercliente->consulta($val);

        if ($datos) {

            if (file_exists('../files/oncenter/img_fotos/' . $datos[0]["identificacion"] . '.jpg')) {
                $foto = '<img src="../files/oncenter/img_fotos/' . $datos[0]["identificacion"] . '.jpg" class="direct-chat-img" style="width:50px;height:50px">';
            } else {
                $foto = '<i class="fa-solid fa-user-slash"></i>';
            }

            $data['conte2'] .= '
            <div class="row col-12 " >
                <div class="col-12 px-4 d-flex align-items-center">
                    <div class="row col-12 ">


                        <div class="col-12 px-2 pt-4 pb-2 ">
                            <div class="row align-items-center" id="t-Nc">
                                <div class="pl-4">
                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                        ' . $foto . '
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">' . $datos[0]['nombre'] . ' ' . $datos[0]['nombre_2'] . '</span> <br>
                                    <span class="text-semibold fs-14">' . $datos[0]['apellidos'] . ' ' . $datos[0]['apellidos_2'] . '</span> 
                                </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2">
                            <div class="row align-items-center" id="t-Ce">
                                <div class="pl-4">
                                    <span class="rounded bg-light-red p-2 text-danger">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Correo electrónico</span> <br>
                                    <span class="text-semibold fs-14">' . $datos[0]['email'] . '</span> 
                                </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2">
                            <div class="row align-items-center" id="t-NT">
                                <div class="pl-4">
                                    <span class="rounded bg-light-green p-2 text-success">
                                        <i class="fa-solid fa-mobile-screen"></i>
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Número celular</span> <br>
                                    <span class="text-semibold fs-14">' . $datos[0]['celular'] . '</span> 
                                </div> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

			';

            $data['conte'] .= '
                <div class="row mt-4" id="t-TP">
                    <div class="col-12 px-2 py-3 tono-3">
                        <div class="row align-items-center">
                            <div class="pl-4">
                                <span class="rounded bg-light-blue p-2 text-primary ">
                                    <i class="fa-solid fa-table"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                            <div class="col-5 fs-14 line-height-18"> 
                                <span class="">Programas</span> <br>
                                <span class="text-semibold fs-14">Matriculados</span> 
                            </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-12 card p-4">
                    
                        <table class="table" id="tbl_datos">
                            <thead>
                            <tr>
                                <th id="t-Cs">Caso</th>
                                <th id="t-P">Programa</th>
                                <th id="t-Jr">Jornada</th>
                                <th id="t-FI">Fecha ingresa</th>
                                <th id="t-ME">Medio</th>
                                <th id="t-ES">Estado</th>
                                <th id="t-PC">Periodo campaña</th>
                                <th id="t-AC">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>';


            for ($i = 0; $i < count($datos); $i++) {
                $data['conte'] .= '
                                    <tr>
                                        <td>' . $datos[$i]['id_estudiante'] . '</td>
                                        <td>' . $datos[$i]['fo_programa'] . '</td>
                                        <td>' . $datos[$i]['jornada_e'] . '</td>
                                        <td>' . $oncentercliente->fechaesp($datos[$i]['fecha_ingreso']) . '</td>
                                        <td>' . $datos[$i]['medio'] . '</td>
                                        <td>' . $datos[$i]['estado'] . '</td>
                                        <td>' . $datos[$i]['periodo_campana'] . '</td>
                                        <td><button class="btn btn-primary" onclick="detalles(' . $datos[$i]['id_estudiante'] . ')" ><i class="fa fa-eye"></i></button></td>
                                    </tr>';
            }

            $data['conte'] .= '
                            </tbody>
                        </table>
                    </div>
                </div>';
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);


        break;


    case 'detalles':
        $id = $_POST['val'];
        $val = 'id_estudiante = ' . $id;
        $datos = $oncentercliente->consulta($val);
        $data['conte'] = "";
        $data['conte2'] = "";
        $numero_celular = $datos[0]["celular"];
        if (file_exists('../files/oncenter/img_fotos/' . $datos[0]["identificacion"] . '.jpg')) {
            $foto = '<img src=../files/oncenter/img_fotos/' . $datos[0]["identificacion"] . '.jpg class="img-circle elevation-2"> </br>';
            $estado_foto = 1;
        } else {
            $foto = '<img src=../files/null.jpg class="img-circle elevation-2" style="width:100px; height:100px"></br>';
            $estado_foto = 0;
        }

        /*   validar documento */
        if ($datos[0]['estado'] == 'Interesado') {
            $documento = '<button class="btn btn-warning btn-xs" onclick="validarDocumento(' . $datos[0]['id_estudiante'] . ',' . $datos[0]["identificacion"] . ')" ><i class="fas fa-check"></i> Validar</button>';
        } else {
            $documento = '<span class="badge bg-green"><i class="fas fa-check-double" title="Validado"></i> Validado</span>';
        }

        /* *********************** */



        /*   envio de mailing */
        if ($datos[0]['estado'] == 'Preinscrito' || $datos[0]['estado'] == 'Inscrito' || $datos[0]['estado'] == 'Seleccionado' || $datos[0]['estado'] == 'Admitido' || $datos[0]['estado'] == 'Matriculado') { // si esta en alguno de estos estados
            if ($datos[0]['mailing'] == 1) { //si el mailing no se a enviado
                $mail = '<button class="btn btn-warning btn-xs" onclick="correo(' . $datos[0]['id_estudiante'] . ')" ><i class="far fa-envelope-open"></i> Enviar</button>';
            } else {
                $mail = "<span class='badge bg-green'> <i class='fas fa-check-double'></i> Enviado </span>";
            }
        } else { // no se puede enviar porque el documento no esta validado
            $mail = "pendiente validar documento";
        }

        /* *********************** */

        /*   validar formulario inscripción */

        if ($datos[0]['mailing'] == 0) { // si el mailing se envio
            if ($datos[0]['formulario'] == 1) {
                $formulario = '<button class="btn btn-warning" onclick="validarFormularioInscripcion(' . $datos[0]['id_estudiante'] . ')" ><i class="fas fa-check"></i> Validar formulario</button>';
            } else {
                $formulario = '<span class="badge bg-green"><i class="fas fa-check-double" title="Validado"></i> Validado</span>';
            }
        } else {
            $formulario = "Pendiente envio de mailing";
        }
        /* *********************** */

        $ver_entrevista = $oncentercliente->entrevista($datos[0]['id_estudiante']);
        if ($ver_entrevista and $datos[0]['entrevista'] == 1) { //hay entrevista pero sin validar
            $entrevista = '<button class="btn btn-primary btn-xs" onclick="verEntrevista(' . $datos[0]['id_estudiante'] . ')" ><i class="fas fa-eye"></i> Ver entrevista</button> 
			<span class="badge bg-warning"> Sin validar</span>';
        } else if ($ver_entrevista and $datos[0]['entrevista'] == 0) { //hay entrevista validada
            $entrevista = '<button class="btn btn-primary btn-xs" onclick="verEntrevista(' . $datos[0]['id_estudiante'] . ')" ><i class="fas fa-eye"></i> Ver entrevista</button> 
			<span class="badge bg-success"><i class="fas fa-check-double" title="validada"></i> validado</span>';
        } else {
            $entrevista = "Sin entrevista";
        }


        //        $entrevista = ($datos[0]['entrevista'] == 1) ? '<button class="btn btn-primary btn-xs" onclick="verEntrevista('.$datos[0]['id_estudiante'].')" ><i class="fas fa-eye"></i> Ver entrevista</button>  <button class="btn btn-warning btn-xs" onclick="validarEntrevista('.$datos[0]['id_estudiante'].')" ><i class="fas fa-check"></i> Validar entrevista</button>' : '<span class="badge bg-green"><i class="fas fa-check-double" title="Validado"></i> Validado</span>';



        if ($datos[0]['documentos'] == 1) { // es porque no estan validados
            $soportes_digitales = '<button class="btn btn-primary btn-xs" onclick="verSoportes(' . $datos[0]['id_estudiante'] . ')"><i class="fas fa-eye"></i> Ver soportes</button><span class="badge bg-warning">Por validar</span>';
        } else {
            if ($datos[0]['documentos'] == 0) {
                $soportes_digitales = '<button class="btn btn-primary btn-xs" onclick="verSoportes(' . $datos[0]['id_estudiante'] . ')"><i class="fas fa-eye"></i> Ver soportes</button><span class="badge bg-success">Validados</span>';
            } else {
                $soportes_digitales = '<button class="btn btn-primary btn-xs" onclick="verSoportes(' . $datos[0]['id_estudiante'] . ')"><i class="fas fa-eye"></i> Ver soportes</button>';
            }
        }

        if ($datos[0]['estado'] == "Matriculado") {

            $pendiente = '<span class="badge bg-success"><i class="fas fa-check-double" title="validada"></i> validado</span>';
        } else {
            $pendiente = '<span class="badge bg-red"><i class="fas fa-ban"></i> Pendiente</span>';
        }






        $soporte_img = $oncentercliente->soporte_inscripcion($datos[0]['id_estudiante']);

        if ($soporte_img) {
            $soporte_pago = '<a href="../files/oncenter/img_inscripcion/' . $soporte_img['nombre_archivo'] . '" target="_blank" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i> ver soporte </a> 
			<button class="btn btn-danger btn-xs" onclick="eliminar_soporte_inscripcion(' . $datos[0]['id_estudiante'] . ')"><i class="far fa-trash-alt"></i></i> Eliminar soporte</button>';
            if ($datos[0]['inscripcion'] == 0) {
                $soporte_pago .= '<span class="badge bg-success"><i class="fas fa-check-double" title="validada"></i> validado</span>';
            }
        } else {
            $soporte_pago = '<button class="btn btn-danger btn-xs" onclick="soporte_inscripcion(' . $datos[0]['id_estudiante'] . ')"><i class="fas fa-arrow-up"></i> Subir soporte</button>';
        }


        $boton_foto = '';
        if ($estado_foto == 0) {
            $boton_foto = '<button id="t2-tf" class="btn btn-outline-primary btn-xs" onclick="abrirmodalwebcam(' . $datos[0]['identificacion'] . ')" ><i class="fas fa-camera"></i> Tomar foto</button>';
        }

        $data['conte2'] .= ' 
    
            <div class="col-12  pt-4">
                <div class="row">
                    <div class="col-4 mnw-100 text-center pt-4" id="t2-cas">
                        <i class="fa-solid fa-trophy avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x"></i>
                        <h4 class="titulo-2 fs-18 mb-0">' . $datos[0]['id_estudiante'] . '</h4>
                        <p class="small text-secondary">Caso</p>
                    </div>
                    <div class="col-4 mnw-100 text-center pt-4" id="t2-cam">
                        <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-green text-green rounded-circle mb-2 fa-2x"></i>
                        <h4 class="titulo-2 fs-18 mb-0">' . $datos[0]['periodo_campana'] . '</h4>
                        <p class="small text-secondary">Campaña</p>
                    </div>
                    <div class="col-4 mnw-100 text-center pt-4" id="t2-EST">
                        <i class="fa-solid fa-user-check avatar avatar-50 bg-light-yellow text-yellow rounded-circle mb-2 fa-2x"></i>
                        <h4 class="titulo-2 fs-18 mb-0">' . $datos[0]['estado'] . '</h4>
                        <p class="small text-secondary">Estado</p>
                    </div>
                </div>
            </div>
        ';

        $data['conte'] .= '
            <div class="row p-0 m-0 mt-4" id="t2-CP">
                <div class="card col-12 p-0 m-0">
            
                    <div class="row p-0 m-0">
                        <div class="col-10 tono-3 pt-3">
                            <div class="col-12 pb-3">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-solid fa-table"></i>
                                        </span> 
                                    
                                    </div>
                                    <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18"> 
                                        <span class="">Proceso de</span> <br>
                                        <span class="text-semibold fs-14">Admisiones </span> 
                                    </div> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 text-right tono-3 pt-3 pr-4"> 
                            <button class="btn btn-danger btn-xs" onclick="volver()"><i class="fas fa-arrow-left py-2"></i> Volver</button>
                        </div>

                        <div class="col-12  p-4">
                            
                            ' . $boton_foto . '
                            <button onclick="agregar(' . $datos[0]['id_estudiante'] . ')" id="t2-seg" class="btn btn-outline-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button>
                            <button onclick="verHistorial(' . $datos[0]['id_estudiante'] . ')" id="t2-vh" class="btn btn-outline-primary btn-xs" title="historial"><i class="fa fa-eye"></i> Ver historial</button>	
                            <button onclick="mover(' . $datos[0]['id_estudiante'] . ')" id="t2-cd" class="btn btn-outline-primary btn-xs" title="historial"><i class="fas fa-people-carry"></i> Cambiar de estado</button>		
                            <button onclick="verficha(' . $datos[0]['id_estudiante'] . ')" id="t2-vfc" class="btn btn btn-outline-primary btn-xs" title="ficha de matrícula"><i class="fa fa-eye"></i> Ver ficha completa</button>
                            <button onclick="listarDatos(57' . $numero_celular . ')" data-target="#modal_whatsapp" data-toggle="modal"  class="btn btn-outline-primary btn-xs" title="Whatsapp"> <i class="fab fa-whatsapp"></i> Chat Whatsapp</button>
                            <!--<button onclick="eliminar(' . $datos[0]['id_estudiante'] . ')" id="t2-el" class="btn btn-danger btn-xs" title="Eliminar"><i class="far fa-trash-alt"></i>Eliminar</button>-->
                        
                        </div>

                        <div class="col-12 px-4">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th id="t2-pro">Proceso</th>
                                        <th id="t2-st">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>' . $datos[0]['fo_programa'] . '</td>
                                        <td>' . $datos[0]['jornada_e'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Documento de identificación</td>
                                        <td>
                                            <span class="boton_icono">		
                                                    ' . $documento . '
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mensaje por correo electrónico</td>
                                        <td>
                                            <span class="boton_icono">		
                                                ' . $mail . '
                                            </span>			
                                        </td>
                                
                                    </tr>
                                    <tr>
                                        <td>Formulario inscripción</td>
                                        <td>
                                            <span class="boton_icono">		
                                                ' . $formulario . '
                                            </span>			
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Soporte pago inscripción</td>
                                        <td>
                                            <span class="boton_icono">
                                                ' . $soporte_pago . '
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Entrevista</td>
                                        <td>
                                            <span>
                                                ' . $entrevista . '			
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Soportes digitales</td>
                                        <td>
                                            <span class="boton_icono2">
                                                ' . $soportes_digitales . '
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Soporte pago matrícula</td>
                                        <td>
                                            ' . $pendiente . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Usuario CAMPUS</td>
                                        <td>
                                            ' . $pendiente . '
                                        </td>
                            
                                    </tr>
                                    
                                    <tr>
                                        <td>Materias matrículadas</td>
                                        <td>
                                            ' . $pendiente . '
                                        </td>
                                    
                                    </tr>
                                    
                                    <tr>
                                        <td>Correo CIAF</td>
                                        <td>
                                            ' . $pendiente . '
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Datos CAMPUS ingreso</td>
                                        <td>
                                            ' . $pendiente . '
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        
        ';



        echo json_encode($data);
        break;

    case 'cargar_imagen':
        $url = '../files/oncenter/img_fotos/' . $_POST['cc'] . '.jpg';

        $divi = explode(",", $_POST['url']);
        $dato = base64_decode($divi[1]);
        if (file_put_contents($url, $dato)) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);


        break;

    case 'mostrar_ficha':
        $id = $_POST['id'];

        $datos = $oncentercliente->consulta_id($id);
        $datos2 = $oncentercliente->entrevista($id);
        $datos3 = $oncentercliente->datos_personales($id);

        // $nombre = $datos['nombre'].' '.$datos['nombre_2'].' '.$datos['apellidos'].' '.$datos['apellidos_2'];

        $nombre = (!empty($datos['nombre']) ? $datos['nombre'] : '') . (!empty($datos['nombre_2']) ? ' ' . $datos['nombre_2'] : '') . (!empty($datos['apellidos']) ? ' ' . $datos['apellidos'] : '') . (!empty($datos['apellidos_2']) ? ' ' . $datos['apellidos_2'] : '');

        if (file_exists('../files/oncenter/img_fotos/' . $datos["identificacion"] . '.jpg')) {
            $foto = '<img src=../files/oncenter/img_fotos/' . $datos["identificacion"] . '.jpg class="img-circle elevation-2"> </br>';
        } else {
            $foto = '<img src=../files/null.jpg class="img-circle elevation-2">';
        }
        $referencia_familiar = $datos["ref_familiar"];
        $referencia_telefono = $datos["ref_telefono"];
        if (empty($referencia_familiar) && empty($referencia_telefono)) {

            $referencia_familiar = "";
            $referencia_telefono = "";
        } else {

            $referencia_familiar = $datos["ref_familiar"];
            $referencia_telefono = $datos["ref_telefono"];
        }
        $data['conte'] = '
        
        <div id="hoja">
            <table border="0" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <b>Ficha de Matrícula</b><br>
                            <b>Asesor:</b> Lina <br>
                            <b>Fecha y Hora del Reporte: </b> ' . date("d-m-Y H:m:s") . '
                        </td>
                        <td align="left">
                            <!-- Logo de la CIAF-->
                            <img id="logo" src="../public/img/logo_ciaf_web.png" width="300px" align="right">
                        </td>
                    </tr>		
                </tbody>
            </table>	
            <hr align="left" noshade="noshade" size="2" width="100%">
            <table border="0" width="100%">
                <tbody>
                    <tr>
                        <td align="left">
                            <!-- nombre del interesado -->
                            <h1>' . $nombre . '</h1>
                        </td>
                        <td align="right">
                            <!-- Foto del interesado-->
                            <div class="foto">
                                <center>
                                    ' . $foto . '<br>
                                </center>
                            </div>		
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Datos Personales del Interesados-->
            <hr align="left" noshade="noshade" size="2" width="100%">
            <h2>Datos Personales</h2>
            <hr align="left" noshade="noshade" size="2" width="100%">
            <table border="0" width="100%">
                <tbody>
                    <tr>
                        <td width="50%">
                            <b> Tipo de Documento: </b>
                            ' . $datos["tipo_documento"] . '<br>
                            <b> Número de Identificación: </b>
                            ' . $datos["identificacion"] . '<br>
                            <b> Fecha de Expedición: </b>
                            <br>
                            <b> Lugar de Expedición: </b>
                            <br>
                            <b> Fecha de Nacimiento: </b>
                            ' . $datos["fecha_nacimiento"] . '<br>
                            <b> Lugar de Nacimiento: </b>
                            <br>
                        </td>
                        <td width="50%">
                            <b> Sexo: </b>
                            <br>
                            <b> Estado Civil: </b>
                            <br>
                            <b> Grupo Étnico: </b>
                            <br>
                            <b> Pertenece a: </b>
                            <br>
                            <b> Desplazado por la violencia: </b>
                            <br>
                            <b> Víctima del Conflicto Armado: </b>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Datos Programa de Interés-->
            <hr align="left" noshade="noshade" size="2" width="100%">
            <h2>Programa de Interés</h2>
            <hr align="left" noshade="noshade" size="2" width="100%">
            <table border="0" width="100%">
                <tbody>
                    <tr width="100">
                        <td>
                            <p><b>Programa de Interés: </b>' . $datos["fo_programa"] . '</p>
                        </td>
                        <td>
                            <p><b>Jornada de Interés: </b> ' . $datos["jornada_e"] . '</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Datos de Contacto -->
            <hr align="left" noshade="noshade" size="2" width="100%">
            <h2>Datos de Contacto</h2>
            <hr align="left" noshade="noshade" size="2" width="100%">
            <table border="0" width="100%">
                <tbody>
                    <tr>
                        <td width="50%">
                            <b> Departamento de Residencia: </b>
                            <br>
                            <b> Municipio de Residencia: </b>
                            <br>
                            <b> Tipo de Residencia: </b>
                            <br>
                            <b> Zona de Residencia: </b>
                            <br>
                            <b> Dirección de Residencia: </b>
                            <br>
                            <b> Barrio de Residencia: </b>
                            <br>
                            <b> Sexo: </b>
                            <br>
                            <b> Estrato Socioeconómico: </b>
                            <br>
                            <b> Referencia Familiar: </b>
                            ' . $referencia_familiar . '<br>
                            <br>
                        </td>
                        <td width="50%">
                            <b> Teléfono de Residencia: </b>
                            ' . $datos["celular"] . '<br>
                            <b> Teléfono Celular: </b>
                            ' . $datos["celular"] . '<br>
                            <b> Teléfono WhatsApp: </b>
                            ' . $datos["celular"] . '<br>
                            <b> Correo Personal: </b>
                            ' . $datos["email"] . '<br>
                            <b> Correo CIAF: </b>
                            <br>
                            <b> Instagram: </b>
                            <br>
                            <b> Facebook: </b>
                            <br>
                            <b> Twitter: </b>
                            <br>
                            <b> Referencia Teléfono: </b>
                            ' . $referencia_telefono . '<br>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Datos Académicos-->
            <hr align="left" noshade="noshade" size="2" width="100%">
            <h2>Datos de Contacto</h2>
            <hr align="left" noshade="noshade" size="2" width="100%">
            <table border="0" width="100%">
                <tbody>
                    <tr>
                        <td width="50%">
                        <b> Nivel de Escolaridad: </b>
                        ' . (!empty($datos3["nivel_escolaridad"]) ? $datos3["nivel_escolaridad"] : "No tiene datos") . '<br>
                        <b> Nombre de Colegio: </b>
                        ' . (!empty($datos3["nombre_colegio"]) ? $datos3["nombre_colegio"] : "No tiene datos") . '<br>
                        <b> Fecha de Graduación: </b>
                        ' . (!empty($datos3["fecha_graduacion"]) ? $datos3["fecha_graduacion"] : "No tiene datos") . '<br>
                        <b> Jornada: </b>
                        ' . (!empty($datos3["jornada_academico"]) ? $datos3["jornada_academico"] : "No tiene datos") . '<br>
                        <b> Tipo de Institución: </b>
                        ' . (!empty($datos3["tipo_institucion"]) ? $datos3["tipo_institucion"] : "No tiene datos") . '<br>
                        <b> Departamente de Institución: </b>
                        ' . (!empty($datos3["departamento_academico"]) ? $datos3["departamento_academico"] : "No tiene datos") . '<br>
                        <b> Municipio de Institución: </b>
                        ' . (!empty($datos3["municipio_academico"]) ? $datos3["municipio_academico"] : "No tiene datos") . '<br>
                        <b> Código Pruebas Saber: </b>
                        ' . (!empty($datos3["codigo_pruebas"]) ? $datos3["codigo_pruebas"] : "No tiene datos") . '<br>
                        <b> Puntaje General Pruebas TIT: </b>
                        ' . (!empty($datos3["codigo_saber_pro"]) ? $datos3["codigo_saber_pro"] : "No tiene datos") . '<br>
                        <b> Razonamiento Cuantitativo Pruebas TIT: </b>
                        </td>
                        <td width="50%">
                            <b> Competencias Ciudadanas Pruebas TIT: </b>
                            <br>
                            <b> Comunicación Escrita Pruebas TIT: </b>
                            <br>
                            <b> Inglés Pruebas TIT: </b>
                            <br>
                            <b> Fecha Presentación Pruebas TIT: </b>
                            <br>
                            <b> Código Pruebas Saber PRO: </b>
                            <br>
                            <b> Puntaje General Pruebas Saber Pro: </b>
                            <br>
                            <b> Lectura Crítica Pruebas Saber Pro: </b>
                            <br>
                            <b> Razonamiento Cuantitativo Saber Pro: </b>
                            <br>
                            <b> Competencias Ciudadanas Pruebas Saber Pro: </b>
                            <br>
                            <b> Comunicación Escrita Pruebas Saber Pro: </b>
                            <br>
                            <b> Inglés Saber Pro: </b>
                            <br>
                            <b> Fecha Presentación Pruebas Saber Pro: </b>
                            <br>
                            <b> Segundo Idioma: </b>
                            Ninguno<br>
                            <b> Cuál idioma: </b>
                            <br>
                            <b> Nivel Segundo Idioma: </b>
                            <br>
                            <b> Conoce Plan de Estudios: </b>
                            <br>
                            <b> Colegio Articulación: </b>
                            <br>
                            <b> Grado de Articulación: </b>
                            0		
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Datos de la Entrevista-->
            <hr align="left" noshade="noshade" size="2" width="100%">
            <h2>Entrevista</h2>
            <hr align="left" noshade="noshade" size="2" width="100%">
            <table border="0" width="100%" id="entrevista">
                <tbody>
                    <tr>
                        <td width="0%">
                        <b> ¿Quién sostiene sus estudios?: </b>
                        ' . (!empty($datos2["sostiene"]) ? $datos2["sostiene"] : "No tiene datos") . '<br>
                        <b> ¿Laboras actualmente?: </b>
                        ' . (!empty($datos2["labora"]) ? $datos2["labora"] : "No tiene datos") . '<br>
                        <b> ¿empresa?: </b>
                        ' . (!empty($datos2["donde_labora"]) ? $datos2["donde_labora"] : "No tiene datos") . '
                        <b> ¿Cargo?: </b>
                        ' . (!empty($datos2["cargo"]) ? $datos2["cargo"] : "No tiene datos") . '
                        </td>
                        <td width="50%">
                        <b> ¿Conoces el plan de estudios del programa?: </b>
                        ' . (!empty($datos2["conoce_plan"]) ? $datos2["conoce_plan"] : "No tiene datos") . '<br>
                        <b> ¿Qué te motivó a estudiar este programa?: </b>
                        ' . (!empty($datos2["motiva"]) ? $datos2["motiva"] : "No tiene datos") . '<br>
                        <b> ¿Qué curso te gustaría tomar adicional?: </b>
                        ' . (!empty($datos2["curso_ad"]) ? $datos2["curso_ad"] : "No tiene datos") . '<br>
                        <b> ¿Cuál crees que es tu mejor talento o habilidad?: </b>
                        ' . (!empty($datos2["talento"]) ? $datos2["talento"] : "No tiene datos") . '<br>
                        <b> ¿Te gustaría referir a personas para que inicien su proceso de formación en CIAF?: </b>
                        ' . (!empty($datos2["referir"]) ? $datos2["referir"] : "No tiene datos") . '<br>
                        <b> ¿Cuál sería el motivo o razón para que dejes de estudiar?: </b>
                        ' . (!empty($datos2["dejar"]) ? $datos2["dejar"] : "No tiene datos") . '<br>
                        <b> Fecha de la entrevista: </b>
                        ' . (!empty($datos2["fecha"]) ? $datos2["fecha"] : "No tiene datos") . '		
                        </td>
                    </tr>
                </tbody>
            </table>
        
            <hr align="left" noshade="noshade" size="2" width="100%">
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <hr align="left" noshade="noshade" size="2" width="30%">
            <p><b>Firma del Estudiante</b></p>
            ' . $nombre . '
        </div>
        <hr align="left" noshade="noshade" size="2" width="100%">
        <button type="button" class="btn btn-danger" onclick="imprimir();">Imprimir</button>
        
        ';

        echo json_encode($data);


        break;

        // inicio agregar tareas, seguimientos y ver historial

    case 'verHistorialTabla':
        $id_estudiante = $_GET["id_estudiante"];

        $rspta = $oncentercliente->verHistorialTabla($id_estudiante);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;

        for ($i = 0; $i < count($reg); $i++) {


            $datoasesor = $oncentercliente->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_asesor = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

            $data[] = array(
                "0" => $reg[$i]["id_estudiante"],
                "1" => $reg[$i]["motivo_seguimiento"],
                "2" => $reg[$i]["mensaje_seguimiento"],
                "3" => $oncentercliente->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],
                "4" => $nombre_asesor

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'verHistorialTablaTareas':
        $id_estudiante = $_GET["id_estudiante"];

        $rspta = $oncentercliente->verHistorialTablaTareas($id_estudiante);
        //Vamos a declarar un array
        $data = array();
        $reg = $rspta;


        for ($i = 0; $i < count($reg); $i++) {
            $datoasesor = $oncentercliente->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_usuario = $datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];

            $data[] = array(
                "0" => ($reg[$i]["estado"] == 1) ? 'Pendiente' : 'Realizada',
                "1" => $reg[$i]["motivo_tarea"],
                "2" => $reg[$i]["mensaje_tarea"],
                "3" => $oncentercliente->fechaesp($reg[$i]["fecha_programada"]) . ' a las ' . $reg[$i]["hora_programada"],
                "4" => $nombre_usuario

            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;







    case 'verHistorial':
        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo

        $datos = $oncentercliente->verHistorial($id_estudiante); // consulta para traer los interesados


        $nombre = $datos["nombre"] ?? '';
        $nombre_2 = $datos["nombre_2"] ?? '';
        $apellidos = $datos["apellidos"] ?? '';
        $apellidos_2 = $datos["apellidos_2"] ?? '';
        $programa = $datos["fo_programa"] ?? 'No asignado';
        $jornada = $datos["jornada_e"] ?? 'No asignado';
        $celular = $datos["celular"] ?? 'No disponible';
        $email = $datos["email"] ?? 'No disponible';
        $periodo_ingreso = $datos["periodo_ingreso"] ?? 'No definido';
        $fecha_ingreso = $datos["fecha_ingreso"] ?? 'No definida';
        $hora_ingreso = $datos["hora_ingreso"] ?? 'No definida';
        $medio = $datos["medio"] ?? 'No informado';
        $conocio = $datos["conocio"] ?? 'Desconocido';
        $contacto = $datos["contacto"] ?? 'No disponible';
        $modalidad = $datos["nombre_modalidad"] ?? 'No definida';
        $estado = $datos["estado"] ?? 'No definido';
        $periodo_campana = $datos["periodo_campana"] ?? 'No definido';
        $nivel_escolaridad = $datos["nivel_escolaridad"] ?? 'No definido';
        $nombre_colegio = $datos["nombre_colegio"] ?? 'No informado';
        $fecha_graduacion = $datos["fecha_graduacion"] ?? 'No definida';
        $jornada_academico = $datos["jornada_academico"] ?? 'No definida';
        $departamento_academico = $datos["departamento_academico"] ?? 'No definido';
        $municipio_academico = $datos["municipio_academico"] ?? 'No definido';
        $codigo_pruebas = $datos["codigo_pruebas"] ?? 'No disponible';
        $codigo_saber_pro = $datos["codigo_saber_pro"] ?? 'No disponible';
        $colegio_articulacion = $datos["colegio_articulacion"] ?? 'No aplicable';
        $grado_articulacion = $datos["grado_articulacion"] ?? 'No aplicable';

        $ref_familiar = $datos["ref_familiar"] ?? 'No aplicable';
        $ref_telefono = $datos["ref_telefono"] ?? 'No aplicable';


        $data["0"] .= '

            <div class="row">
            
                <div class="col-12" id="accordion">
                    <div class="card-header tono-4">
                        <h4 class="card-title w-100">
                        <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                            <i class="fa-regular fa-address-card bg-light-blue text-primary p-2"></i>
                            Datos de Contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="collapse in" data-parent="#accordion" style="">
                        <div class="card-body tono-3">
                            <div class="row">
                                <div class="col-xl-6">
                                    <dt>Nombre</dt>
                                    <dd>' . $nombre . ' ' . $nombre_2 . ' ' . $apellidos . ' ' . $apellidos_2 . '</dd>
                                    <dt>Programa</dt>
                                    <dd>' . $programa . '</dd>
                                    <dt>Celular</dt>
                                    <dd>' . $celular . '</dd>
                                    <dt>Email</dt>
                                    <dd>' . $email . '</dd>
                                    <dt>Fecha de Ingreso</dt>
                                    <dd>' . $oncentercliente->fechaesp($fecha_ingreso) . ' a las ' . $hora_ingreso . ' del ' . $periodo_ingreso . '</dd>
                                    <dt>Medio</dt>
                                    <dd>' . $medio . '</dd>
                                </div>
                                    <div class="col-xl-6">							
                                    <dt>Conocio</dt>
                                    <dd>' . $conocio . '</dd>
                                    <dt>Contacto</dt>
                                    <dd>' . $contacto . '</dd>
                                    <dt>Modalidad</dt>
                                    <dd>' . $modalidad . '</dd>
                                    <dt>Estado</dt>
                                    <dd>' . $estado . '</dd>
                                    <dt>Campaña</dt>
                                    <dd>' . $periodo_campana . '</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-header tono-4">
                        <h4 class="card-title w-100">
                        <a class="d-block w-100 titulo-2 fs-14" data-toggle="collapse" href="#collapseTwo">
                            <i class="fa-solid fa-school bg-light-blue p-2 text-primary"></i>
                            Datos Academicos
                        </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body tono-3">

                            <div class="row">
                                <div class="col-xl-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nivel de Escolaridad</dt>
                                        <dd>' . $nivel_escolaridad . '</dd>
                                        <dt>Nombre Colegio</dt>
                                        <dd>' . $nombre_colegio . '</dd>
                                        <dt>Fecha Graduacion</dt>
                                        <dd>' . $fecha_graduacion . '</dd>
                                        <dt>Jornada Academico</dt>
                                        <dd>' . $jornada_academico . '</dd>
                                        <dt>Departamento Academico</dt>
                                        <dd>' . $departamento_academico . '</dd>
                                        <dt>Municipio Academico</dt>
                                        <dd>' . $municipio_academico . '</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-6">
                                    </dl>
                                        <dt>Codigo Pruebas</dt>
                                        <dd>' . $codigo_pruebas . '</dd>
                                        <dt>Codigo Saber Pro</dt>
                                        <dd>' . $codigo_saber_pro . '</dd>
                                        <dt>Colegio Articulacion</dt>
                                        <dd>' . $colegio_articulacion . '</dd>
                                        <dt>Grado Articulacion</dt>
                                        <dd>' . $grado_articulacion . '</dd>
                                        <dt>Campaña</dt>
                                        <dd>' . $periodo_campana . '</dd>
                                    </dl>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        
        ';

        $results = array($data);
        echo json_encode($results);
        break;

        // fin agregar tareas, seguimientos y ver historial

    case 'correo':

        $id_estudiante = $_POST["id_estudiante"];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_cargo = $_SESSION['usuario_cargo'];
        $data = array(); //Vamos a declarar un array
        $data["resultado"] = ""; //iniciamos el arreglo

        $rspta = $oncentercliente->actualizarMailing($id_estudiante);
        $data["resultado"] .= $rspta ? "1" : "0";

        $motivo = "Seguimiento";
        $mensaje_seguimiento = "Envio de mailing, usuario y clave";

        $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

        $actualizarcamposegui = $oncentercliente->actualizarSegui($id_estudiante);

        $correo = $oncentercliente->VerHistorial($id_estudiante);
        $destino = $correo["email"];
        $programa = $correo["fo_programa"];
        $identificacion = $correo["identificacion"];
        $clave = $correo["id_estudiante"];


        $asunto = "Bienvenido a CIAF";
        $mensaje = "

		<div style='background-color: #f2f2f2'>
			<div style='width:90%; padding:2%; margin:auto'>
				<table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>
					<tr>	
						<td align='right'>
							<br><br>
							<a href='https://www.facebook.com/ComunidadCIAF' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_face.png'>
							</a>
							<a href='https://twitter.com/ComunidadCIAF' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_twitter.png'>
							</a>
							<a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_youtube.png'>
							</a>
							<a href='https://www.ciaf.edu.co' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_www.png'>
							</a>

						</td>
					</tr>
				</table>						
				<br>		
				<table width='96%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
					<tr>
						<td>
							<table width='100%' border='0' >
								<tr>
									<td>
										<center><br>
										<img src='https://www.ciaf.digital/public/img/oncenter/logo_mailing.png'><br>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
					<tr>
						<td>
							<table width='100%' border='0' >
								<tr>
									<td>
										<center><br>

										<img src='https://www.ciaf.digital/public/img/oncenter/programa1.jpg' width='100%'>	

									</td>
								</tr>
							</table>
						</td>
					</tr>

				</table>	
				<table width='96%' cellpadding='10' cellspacing='0' align='center' border='0' bgcolor='#fff'>
					<tr>
						<td width='60px'>
							<font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Programa</b></font>
						</td>
						<td>
							$programa
						</td>
						<td>
							<img src='https://www.ciaf.edu.co/mercadeo/imagenes/aceptado_peque.png'>
						</td>
					</tr>
					<tr>
						<td width='60px'>
							<font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Usuario</b></font>
						</td>
						<td>
							$identificacion
						</td>
						<td>
							<img src='https://www.ciaf.edu.co/mercadeo/imagenes/aceptado_peque.png'>
						</td>
					</tr>

					<tr>
						<td width='60px'>
							<font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Clave</b></font>
						</td>
						<td>
							$clave
						</td>
						<td>
							<img src='https://www.ciaf.edu.co/mercadeo/imagenes/aceptado_peque.png'>
						</td>
					</tr>		
					<tr>
						<td colspan='3'>
							<div style='border-radius:10px; background-color: #05abc6; width: 60%; padding: 5px; margin: auto'>
								<center><a href='https://ciaf.edu.co/mercadeo/inscripcion.php' target='_blank' style='text-decoration: none; color: #fff; font-size: 18px; font-family: tahoma'>Link de acceso</a></center>
							</div><br><br>
						</td>
					</tr>
				</table>		
				<table width='100%' border='0' cellpadding='10' cellspacing='0' align='center' bgcolor='#fff'>
					<tr bgcolor='#2b7fbb'>
						<td>
						<font size='4px' color='#fff'>CONTACTO</font>
						</td>
					</tr>
						<td>
							<font size='3px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'><b>Si requiere información adicional comuníquese con:</b></font>
						</td>
					</tr>
					<tr>
						<td>
							<font size='3px' color='#064789' face='Arial, Helvetica, sans-serif'><b>Área de Información y Comunicaciones CIAF</b></font><br>
							<font color='#7f7f7f' face='Arial, Helvetica, sans-serif'> 
							<img src='https://www.ciaf.digital/public/img/oncenter/tel.png'> Teléfono: (57+6) 3400100<br>
							<img src='https://www.ciaf.digital/public/img/oncenter/r_www.png'><a href='https://www.ciaf.edu.co' target='_blank' style='color: #0868CA'><b> www.ciaf.edu.co</b></a><br>
							<img src='https://www.ciaf.digital/public/img/oncenter/street.png'> Carrera 14 No. 12-42 Pereira, Colombia
							</font><br>
						</td>

					</tr>
					<tr>
						<td bgcolor='#e6e6e6'>
							<font size='2px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'>
								Usted ha recibido este mensaje porque está inscrito en la base de datos de contactos de la Universidad CIAF o porque ha solicitado que se le envíe información de la Institución. Si desea darse de baja o actualizar sus datos puede escribir a 
								<a href='#'><font size='2px' color='#064789'><b>datospersonales@ciaf.edu.co</b></font></a>
							</font>
						</td>
					</tr>
				</table>

				<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff' >
					<tr bgcolor='#064789'>	
						<td>
							<center><br><br>
								<a href='https://www.facebook.com/ComunidadCIAF' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_face.png'>
							</a>
							<a href='https://twitter.com/ComunidadCIAF' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_twitter.png'>
							</a>
							<a href='https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_youtube.png'>
							</a>
							<a href='https://www.ciaf.edu.co' target='_blank'>
								<img src='https://www.ciaf.digital/public/img/oncenter/r_www.png'>
							</a>
							</center><br>
						</td>
					</tr>
					<tr>
						<td colspan='2' align='center'>
							<br><font size='5px' color='#7f7f7f' face='Arial, Helvetica, sans-serif'><b>Emprendimiento e Innovación</b> | </font> Aprobados por el MINEDUCACIÓN<br><br>
						</td>
					</tr>
				</table>	


			</div>
		</div>";

        enviar_correo($destino, $asunto, $mensaje);


        echo json_encode($data);
        break;

    case 'validarDocumentos':

        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["resultado"] = ""; //iniciamos el arreglo
        $data["estado"] = ""; //iniciamos el arreglo
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_cargo = $_SESSION['usuario_cargo'];
        $rspta = $oncentercliente->actualizarDocumentos($id_estudiante);
        $data["resultado"] .= $rspta ? "1" : "0";

        $motivo = "Seguimiento";
        $mensaje_seguimiento = "Validación Documentos";

        $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);


        $rspta2 = $oncentercliente->verDatosEstudiante($id_estudiante);
        $documentos = $rspta2["documentos"];
        $matricula = $rspta2["matricula"];
        if ($documentos == 0 and $matricula == 0) {

            $rspta3 = $oncentercliente->cambioEstadoAdmitido($id_estudiante);

            $motivo2 = "Seguimiento";
            $mensaje_seguimiento2 = "Cambio de estado a Admitido";
            $ressegui2 = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo2, $mensaje_seguimiento2, $fecha, $hora);


            $data["estado"] .= '1';
        } else {
            $data["estado"] .= '0';
        }


        echo json_encode($data);

        break;

    case 'validarFormularioInscripcion':

        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["resultado"] = ""; //iniciamos el arreglo
        $data["estado"] = ""; //iniciamos el arreglo
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_cargo = $_SESSION['usuario_cargo'];
        $rspta = $oncentercliente->actualizarFormularioInscripcion($id_estudiante);
        $data["resultado"] .= $rspta ? "1" : "0";

        $motivo = "Seguimiento";
        $mensaje_seguimiento = "Validación Formulario de Inscripción cliente";

        $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

        $rspta2 = $oncentercliente->verDatosEstudiante($id_estudiante);
        $formulario = $rspta2["formulario"];
        $inscripcion = $rspta2["inscripcion"];
        if ($formulario == 0 and $inscripcion == 0) {

            $rspta3 = $oncentercliente->cambioEstadoInscrito($id_estudiante);

            $motivo2 = "Seguimiento";
            $mensaje_seguimiento2 = "Cambio de estado a Inscrito cliente";
            $ressegui2 = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo2, $mensaje_seguimiento2, $fecha, $hora);
            $registrarestado = $oncentercliente->registrarestado($id_usuario, $id_estudiante, 'Inscrito', $fecha, $hora, $periodo_campana);

            $data["estado"] .= '1';
        } else {
            $data["estado"] .= '0';
        }


        echo json_encode($data);

        break;

    case 'validarInscripcion':

        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["resultado"] = ""; //iniciamos el arreglo
        $data["estado"] = ""; //iniciamos el arreglo
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_cargo = $_SESSION['usuario_cargo'];
        $rspta = $oncentercliente->actualizarInscripcion($id_estudiante);
        $data["resultado"] .= $rspta ? "1" : "0";

        $motivo = "Seguimiento";
        $mensaje_seguimiento = "Validación Recibo de Inscripción";

        $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

        $rspta2 = $oncentercliente->verDatosEstudiante($id_estudiante);
        $formulario = $rspta2["formulario"];
        $inscripcion = $rspta2["inscripcion"];
        if ($formulario == 0 and $inscripcion == 0) {

            $rspta3 = $oncentercliente->cambioEstadoAdmitido($id_estudiante);

            $motivo2 = "Seguimiento";
            $mensaje_seguimiento2 = "Cambio de estado a Inscrito";
            $ressegui2 = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo2, $mensaje_seguimiento2, $fecha, $hora);

            $registrarestado = $oncentercliente->registrarestado($id_usuario, $id_estudiante, 'Inscrito', $fecha, $hora, $periodo_campana);

            $data["estado"] .= '1';
        } else {
            $data["estado"] .= '0';
        }


        echo json_encode($data);

        break;

    case 'verEntrevista':
        $id_estudiante = $_POST["id_estudiante"];
        $rspta = $oncentercliente->verEntrevista($id_estudiante);
        echo json_encode($rspta);
    break;

    case 'editarEntrevistaAsesor':
        $data = [
            "id_estudiante" => $_POST['id_estudiante'],
            "salud_fisica" => $_POST['salud_fisica'],
            "salud_mental" => $_POST['salud_mental'],
            "condicion_especial" => $_POST['condicion_especial'],
            "nombre_condicion_especial" => $_POST['nombre_condicion_especial'],
            "estres_reciente" => $_POST['estres_reciente'],
            "desea_apoyo_mental" => $_POST['desea_apoyo_mental'],
            "costea_estudios" => $_POST['costea_estudios'],
            "labora_actualmente" => $_POST['labora_actualmente'],
            "donde_labora" => $_POST['donde_labora'],
            "tiempo_laborando" => $_POST['tiempo_laborando'],
            "desea_beca" => $_POST['desea_beca'],
            "responsabilidades_familiares" => $_POST['responsabilidades_familiares'],
            "seguridad_carrera" => $_POST['seguridad_carrera'],
            "penso_abandonar" => $_POST['penso_abandonar'],
            "desea_referir" => $_POST['desea_referir'],
            "rendimiento_prev" => $_POST['rendimiento_prev'],
            "necesita_apoyo_academico" => $_POST['necesita_apoyo_academico'],
            "nombre_materia" => $_POST['nombre_materia'],
            "tiene_habilidades_organizativas" => $_POST['tiene_habilidades_organizativas'],
            "comodidad_herramientas_digitales" => $_POST['comodidad_herramientas_digitales'],
            "acceso_internet" => $_POST['acceso_internet'],
            "acceso_computador" => $_POST['acceso_computador'],
            "estrato" => $_POST['estrato'],
            "municipio_residencia" => $_POST['municipio_residencia'],
            "direccion_residencia" => $_POST['direccion_residencia'],
            "nombre_referencia_familiar" => $_POST['nombre_referencia_familiar'],
            "telefono_referencia_familiar" => $_POST['telefono_referencia_familiar'],
            "parentesco_referencia_familiar" => $_POST['parentesco_referencia_familiar']
        ];

        $resultado = $oncentercliente->actualizarEntrevistaAsesor($data);
        echo json_encode(["success" => $resultado]);
    break;

    case 'validarEntrevista':

        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["resultado"] = ""; //iniciamos el arreglo
        $data["estado"] = ""; //iniciamos el arreglo
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_cargo = $_SESSION['usuario_cargo'];
        $rspta = $oncentercliente->actualizarEntrevista($id_estudiante);
        $data["resultado"] .= $rspta ? "1" : "0";

        $motivo = "Seguimiento";
        $mensaje_seguimiento = "Validación Entrevista, Cambio a Seleccionado";

        $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);



        echo json_encode($data);

        break;

    case 'ver_soportes':

        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["cedula"] = ""; //iniciamos el arreglo
        $data["diploma"] = ""; //iniciamos el arreglo
        $data["acta"] = ""; //iniciamos el arreglo
        $data["salud"] = ""; //iniciamos el arreglo
        $data["prueba"] = ""; //iniciamos el arreglo
        $data["compromiso"] = ""; //iniciamos el arreglo
        $data["aceptardatos"] = ""; //iniciamos el arreglo
        $data["ingles"] = ""; //iniciamos el arreglo

        // consulta cedula
        $rspta = $oncentercliente->soporteCedula($id_estudiante);
        $rspta ? "1" : "0";
        if ($rspta) {
            $data["cedula"] .= "
					<div class='card'>
						<h5>Soporte identificación</h5>
						<div class='btn-group'>	
							<a href='../files/oncenter/img_cedula/" . $rspta["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte Cédula</a>";
            if ($rspta["validado"] == 1) {
                $data["cedula"] .= "<span class='badge bg-warning'>Por validar</span> 
							<button type='button' onclick='eliminar_soporte_cc(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";
                //	$data["cedula"] .= "<a class='btn btn-warning' onclick='validar(".$id_estudiante.",1)'> Validar</a> <button type='button' onclick='eliminar_soporte_cc(".$id_estudiante.")' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["cedula"] .= "<span class='btn btn-success btn-xs'><i class='fas fa-check-double'></i> Ok.</span>";
            }

            $data["cedula"] .= "</div></div>";
        } else {
            $data["cedula"] .= '
						<div class="form-group">
							<label for="exampleFormControlFile1">Soporte cedula</label>
							<input type="hidden" name="id" value="' . $id_estudiante . '">
							<input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
						</div>
						<button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                ';
        }
        /* ********************** */

        // consulta diploma
        $rspta2 = $oncentercliente->soporteDiploma($id_estudiante);
        $rspta2 ? "1" : "0";
        if ($rspta2) {
            $data["diploma"] .= "
					
					<div class='card'>
						<h5>Soporte diploma</h5>
						<div class='btn-group'>						
						<a href='../files/oncenter/img_diploma/" . $rspta2["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte Diploma</a>";
            if ($rspta2["validado"] == 1) {
                //$data["diploma"] .= "<a class='btn btn-warning' onclick='validar(".$id_estudiante.",2)'> Validar</a> <button type='button' onclick='eliminar_soporte_diploma(".$id_estudiante.")' class='btn btn-danger'><i class='far fa-trash-alt'></i></button> ";
                $data["diploma"] .= "<span class='badge bg-warning'>Por Validar</span> 
						<button type='button' onclick='eliminar_soporte_diploma(" . $id_estudiante . ")' class='btn btn-danger btn-xs' title='Eliminar soporte'><i class='far fa-trash-alt'></i></button> ";
            } else {
                $data["diploma"] .= "<span class='btn btn-success btn-xs'><i class='fas fa-check-double'></i> Ok.</span>";
            }

            $data["diploma"] .= "</div></div>";
        } else {
            $data["diploma"] .= '
						<div class="form-group">
							<label for="exampleFormControlFile1">Soporte diploma</label>
							<input type="hidden" name="id" value="' . $id_estudiante . '">
							<input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
						</div>
						<button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */

        // consulta acta
        $rspta3 = $oncentercliente->soporteActa($id_estudiante);
        $rspta3 ? "1" : "0";
        if ($rspta3) {
            $data["acta"] .= "
					<div class='card'>
						<h5>Soporte Acta de Grado</h5>
						<div class='btn-group'>	
						<a href='../files/oncenter/img_acta/" . $rspta3["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte acta</a>";
            if ($rspta3["validado"] == 1) {
                $data["acta"] .= "<span class='badge bg-warning btn-xs'>Por validar</span> 
						<button type='button' onclick='eliminar_soporte_acta(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt' title='Eliminar acta'></i></button>";
            } else {
                $data["acta"] .= "<span class='btn btn-success'><i class='fas fa-check-double'></i> Ok.</span>";
            }

            $data["acta"] .= "</div></div>";
        } else {
            $data["acta"] .= '
                        <div class="form-group">
                        <label for="exampleFormControlFile1">Soporte acta</label>
                        <input type="hidden" name="id" value="' . $id_estudiante . '">
                        <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
                    </div>
                    <button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */

        // consulta salud
        $rspta4 = $oncentercliente->soporteSalud($id_estudiante);
        $rspta4 ? "1" : "0";
        if ($rspta4) {
            $data["salud"] .= "
					<div class='card'>
						<h5>Soporte Salud</h5>
						<div class='btn-group'>	
						<a href='../files/oncenter/img_salud/" . $rspta4["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte salud .....</a>";
            if ($rspta4["validado"] == 1) {

                $data["salud"] .= "<span class='badge bg-warning btn-xs'>Por validar</span> 
						<button type='button' onclick='eliminar_soporte_salud(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";

                //$data["salud"] .= "<a class='btn btn-warning' onclick='validar(".$id_estudiante.",4)'> Validar</a> <button type='button' onclick='eliminar_soporte_salud(".$id_estudiante.")' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["salud"] .= "<span class='btn btn-success'><i class='fas fa-check-double'></i> Ok.</span>";
            }

            $data["salud"] .= "</div></div>";
        } else {
            $data["salud"] .= '
                <div class="form-group">
                <label for="exampleFormControlFile1">Soporte salud</label>
                <input type="hidden" name="id" value="' . $id_estudiante . '">
                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */
        // consulta pruebas
        $rspta5 = $oncentercliente->soportePrueba($id_estudiante);
        $rspta5 ? "1" : "0";
        if ($rspta5) {
            $data["prueba"] .= "
					<div class='card'>
						<h5>Soporte Pruebas</h5>
						<div class='btn-group'>	
						<a href='../files/oncenter/img_prueba/" . $rspta5["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte prueba ..</a>";
            if ($rspta5["validado"] == 1) {
                $data["prueba"] .= "<span class='badge bg-warning'>Por validar</span> 
						<button type='button' onclick='eliminar_soporte_prueba(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";
                //$data["prueba"] .= "<a class='btn btn-warning' onclick='validar(".$id_estudiante.",5)'> Validar</a> <button type='button' onclick='eliminar_soporte_prueba(".$id_estudiante.")' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["prueba"] .= "<span class='btn btn-success'><i class='fas fa-check-double btn-xs'></i> Ok.</span>";
            }

            $data["prueba"] .= "</div></div>";
        } else {
            $data["prueba"] .= '
                <div class="form-group">
                <label for="exampleFormControlFile1">Soporte pruebas</label>
                <input type="hidden" name="id" value="' . $id_estudiante . '">
                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */

        /* ********************** */
        // consulta compromiso
        $compromiso = $oncentercliente->soporteCompromiso($id_estudiante);
        $compromiso ? "1" : "0";
        if ($compromiso) {
            $data["compromiso"] .= "
					<div class='card'>
						<h5>Soporte Compromiso</h5>
						<div class='btn-group'>	
						<a href='../files/oncenter/img_compromiso/" . $compromiso["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte compromiso ..</a>";
            if ($compromiso["validado"] == 1) {
                $data["compromiso"] .= "<span class='badge bg-warning'>Por validar</span> 
						<button type='button' onclick='eliminar_soporte_compromiso(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";
                //$data["compromiso"] .= "<a class='btn btn-warning' onclick='validar(".$id_estudiante.",5)'> Validar</a> <button type='button' onclick='eliminar_soporte_compromiso(".$id_estudiante.")' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["compromiso"] .= "<span class='btn btn-success'><i class='fas fa-check-double btn-xs'></i> Ok.</span>";
            }

            $data["compromiso"] .= "</div></div>";
        } else {
            $data["compromiso"] .= '
                <div class="form-group">
                <label for="exampleFormControlFile1">Soporte Compromiso</label>
                <input type="hidden" name="id" value="' . $id_estudiante . '">
                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */
        /* ********************** */
        // consulta proteccion_datos
        $aceptardatos = $oncentercliente->misoporteProteccionDatos($id_estudiante);
        $aceptardatos ? "1" : "0";
        if ($aceptardatos) {
            $data["aceptardatos"] .= "
					<div class='card'>
						<h5>Soporte proteccion data</h5>
						<div class='btn-group'>	
						<a href='../files/oncenter/img_proteccion_datos/" . $aceptardatos["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte proteccion_datosdatos ..</a>";
            if ($aceptardatos["validado"] == 1) {
                $data["aceptardatos"] .= "<span class='badge bg-warning'>Por validar</span> 
						<button type='button' onclick='eliminar_soporte_proteccion_datos(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";
                //$data["compromiso"] .= "<a class='btn btn-warning' onclick='validar(".$id_estudiante.",5)'> Validar</a> <button type='button' onclick='eliminar_soporte_compromiso(".$id_estudiante.")' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["aceptardatos"] .= "<span class='btn btn-success'><i class='fas fa-check-double btn-xs'></i> Ok.</span>";
            }

            $data["aceptardatos"] .= "</div></div>";
        } else {
            $data["aceptardatos"] .= '
                <div class="form-group">
                <label for="exampleFormControlFile1">Soporte proteccion datos</label>
                <input type="hidden" name="id" value="' . $id_estudiante . '">
                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */

        // consulta compromiso ingles
        $ingles = $oncentercliente->misoporteIngles($id_estudiante);
        $ingles ? "1" : "0";
        if ($ingles) {
            $data["ingles"] .= "
					<div class='card'>
						<h5>Soporte Ingles</h5>
						<div class='btn-group'>	
						<a href='../files/oncenter/img_ingles/" . $ingles["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte proteccion_datosdatos ..</a>";
            if ($ingles["validado"] == 1) {
                $data["ingles"] .= "<span class='badge bg-warning'>Por validar</span> 
						<button type='button' onclick='eliminar_soporte_ingles(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["ingles"] .= "<span class='btn btn-success'><i class='fas fa-check-double btn-xs'></i> Ok.</span>";
            }

            $data["ingles"] .= "</div></div>";
        } else {
            $data["ingles"] .= '
                <div class="form-group">
                <label for="exampleFormControlFile1">Compromiso Ingles</label>
                <input type="hidden" name="id" value="' . $id_estudiante . '">
                <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Guardar</button>
                ';
        }

        /* ********************** */

        echo json_encode($data);

        break;


    case 'validar':
        $id_estudiante = $_POST["id_estudiante"];
        $soporte = $_POST["soporte"];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $usuario_cargo = $_SESSION['usuario_cargo'];
        $rspta = $oncentercliente->validar($id_estudiante, $soporte, $fecha, $hora, $usuario_cargo);
        echo $rspta ? "1" : "0";

        break;

    case 'soporte_inscripcion':
        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);


        $target_path = '../files/oncenter/img_inscripcion/';
        $img1path = $target_path . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $guardarsoporte = $oncentercliente->agregar_soporte_inscripcion($id, $evidencia, $fecha, $hora, $id_usuario);

                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte inscripción cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

        break;

    case 'soporte_digitales1':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];
        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);


        $target_path = '../files/oncenter/img_cedula/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_digitales1($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte documento identificación cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

        break;

    case 'soporte_digitales2':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];


        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);


        $target_path = '../files/oncenter/img_diploma/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];
        $megas = 2 * 1048576;
        //
        if (in_array($extension[1], $allowedExts) && $_FILES['soporte']['size'] <= $megas && $_FILES['soporte']['error'] == 0) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];

                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_digitales2($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte diploma cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente o el archivo que se ha intentado subir sobrepasa el límite de tamaño permitido.';
            echo json_encode($data);
        }

        break;

    case 'soporte_digitales3':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];

        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);


        $target_path = '../files/oncenter/img_acta/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_digitales3($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte acta de grado cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

        break;

    case 'soporte_digitales4':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];

        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);


        $target_path = '../files/oncenter/img_salud/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_digitales4($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte salud cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

        break;

    case 'soporte_digitales5':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];
        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);


        $target_path = '../files/oncenter/img_prueba/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_digitales5($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte pruebas cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

        break;

    case 'verCompromiso':

        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["cedula"] = ""; //iniciamos el arreglo
        $data["diploma"] = ""; //iniciamos el arreglo
        $data["acta"] = ""; //iniciamos el arreglo
        $data["salud"] = ""; //iniciamos el arreglo
        $data["prueba"] = ""; //iniciamos el arreglo

        // consulta cedula
        $rspta = $oncentercliente->soporteCedula($id_estudiante);
        $rspta ? "1" : "0";
        if ($rspta) {
            $data["cedula"] .= "
					<div class='card'>
						<h5>Soporte identificación</h5>
						<div class='btn-group'>	
							<a href='../files/oncenter/img_compromiso/" . $rspta["nombre_archivo"] . "' class='btn btn-primary btn-xs' target='_blank'>Ver soporte Compromiso</a>";
            if ($rspta["validado"] == 1) {
                $data["cedula"] .= "<span class='badge bg-warning'>Por validar</span> 
							<button type='button' onclick='eliminar_soporte_cc(" . $id_estudiante . ")' class='btn btn-danger btn-xs'><i class='far fa-trash-alt'></i></button>";
            } else {
                $data["cedula"] .= "<span class='btn btn-success btn-xs'><i class='fas fa-check-double'></i> Ok.</span>";
            }

            $data["cedula"] .= "</div></div>";
        } else {
            $data["cedula"] .= '
						<div class="form-group">
							<label for="exampleFormControlFile1">Soporte cedula</label>
							<input type="hidden" name="id" value="' . $id_estudiante . '">
							<input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1" required>
						</div>
						<button type="submit" id="btnGuardarsoporte_digital" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                ';
        }
        /* ********************** */

        break;

    case 'soporte_compromiso':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];
        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);

        $target_path = '../files/oncenter/img_compromiso/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_compromiso($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte compromiso identificación cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

        break;

    case 'soporte_proteccion_datos':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];
        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);

        $target_path = '../files/oncenter/img_proteccion_datos/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_proteccion_datos($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte proteccion_datos data cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

    break;

    case 'soporte_ingles':
        $id = $_POST['id'];
        $datos_personales = $oncentercliente->datos_personales_interesados($id);
        $cedula = $datos_personales["identificacion"];
        $id = $_POST['id'];
        $allowedExts = array("pdf", "PDF", "PNG", "png", "jpg", "JPG", "jpeg", "JPEG");
        $extension = explode(".", $_FILES["soporte"]["name"]);

        $target_path = '../files/oncenter/img_ingles/';
        $img1path = $target_path . '' . $cedula . ' ' . $_FILES['soporte']['name'];

        if (in_array($extension[1], $allowedExts)) {
            if (move_uploaded_file($_FILES['soporte']['tmp_name'], $img1path)) {
                $evidencia = '' . $cedula . ' ' . $_FILES['soporte']['name'];
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $id_usuario = $_SESSION['id_usuario'];
                $oncentercliente->agregar_soporte_ingles($id, $evidencia, $fecha, $hora, $id_usuario);
                $motivo = "Seguimiento";
                $mensaje_seguimiento = "Soporte compromiso_ingles cargado al sistema cliente";
                $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);
            }
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error, Extencion de evidencia invalido verifica y intenta nuevamente';
            echo json_encode($data);
        }

    break;

    case 'eliminar_soporte_inscripcion':
        $id_estudiante = $_POST['id'];
        $soporte = $oncentercliente->soporte_inscripcion($id_estudiante);
        $consulta = $oncentercliente->eliminar_soporte_inscripcion($soporte['id_inscripcion'], $id_estudiante);
        if ($consulta) {
            unlink('../files/oncenter/img_inscripcion/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte de inscripción cliente";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);


        break;

    case 'eliminar_soporte_compromiso':
        $id_estudiante = $_POST['id'];
        $soporte = $oncentercliente->soporteCompromiso($id_estudiante);
        $consulta = $oncentercliente->eliminar_soporte_compromiso($soporte['id_compromiso'], $id_estudiante);
        if ($consulta) {
            unlink('../files/oncenter/img_compromiso/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte de inscripción cliente";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);


        break;


    case 'eliminar_soporte_proteccion_datos':
        $id_estudiante = $_POST['id'];
        $soporte = $oncentercliente->misoporteProtecciondatos($id_estudiante);
        $consulta = $oncentercliente->eliminar_soporte_proteccion_datos($soporte['id_proteccion_datos']);
        if ($consulta) {
            unlink('../files/oncenter/img_proteccion_datos/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte de proteccion_datos data";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);


    break;

    case 'eliminar_soporte_cc':
        $id = $_POST['id'];
        $soporte = $oncentercliente->soporteCedula($id);
        $consulta = $oncentercliente->eliminar_soporte_cc($soporte['id_cedula'], $id);
        if ($consulta) {
            unlink('../files/oncenter/img_cedula/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte del documento de identificación";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);
        break;

    case 'eliminar_soporte_diploma':
        $id = $_POST['id'];
        $soporte = $oncentercliente->soporteDiploma($id);
        $consulta = $oncentercliente->eliminar_soporte_diploma($soporte['id_diploma'], $id);
        if ($consulta) {
            unlink('../files/oncenter/img_diploma/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte del diploma";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);
    break;

    case 'eliminar_soporte_acta':
        $id = $_POST['id'];
        $soporte = $oncentercliente->soporteActa($id);
        $consulta = $oncentercliente->eliminar_soporte_acta($soporte['id_acta'], $id);
        if ($consulta) {
            unlink('../files/oncenter/img_acta/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte del acta";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);
        break;

    case 'eliminar_soporte_salud':
        $id = $_POST['id'];
        $soporte = $oncentercliente->soporteSalud($id);
        $consulta = $oncentercliente->eliminar_soporte_salud($soporte['id_salud'], $id);
        if ($consulta) {
            unlink('../files/oncenter/img_salud/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte de salud";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);
        break;

    case 'eliminar_soporte_prueba':
        $id = $_POST['id'];
        $soporte = $oncentercliente->soportePrueba($id);
        $consulta = $oncentercliente->eliminar_soporte_prueba($soporte['id_prueba'], $id);
        if ($consulta) {
            unlink('../files/oncenter/img_prueba/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina soporte de las pruebas";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);
    break;

    case 'eliminar_soporte_ingles':
        $id_estudiante = $_POST['id'];
        $soporte = $oncentercliente->misoporteIngles($id_estudiante);
        $consulta = $oncentercliente->eliminar_soporte_ingles($soporte['id_ingles']);
        if ($consulta) {
            unlink('../files/oncenter/img_ingles/' . $soporte['nombre_archivo']);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $usuario_cargo = $_SESSION['usuario_cargo'];
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Se elimina compromiso_ingles";

            $ressegui = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $data['status'] = 'ok';
            $data['msj'] = 'Soporte eliminado con exito.';
        } else {
            $data['status'] = 'error';
            $data['msj'] = 'Error al eliminar el soporte.';
        }

        echo json_encode($data);


    break;

    case "selectEstado":
        $rspta = $oncentercliente->selectEstado();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
        }
        break;

    case 'moverUsuario':

        // $id_estudiante_mover=$_GET["id_estudiante"];

        $data = array(); //Vamos a declarar un array



        $rspta = $oncentercliente->moverUsuario($id_estudiante_mover, $estado);
        echo $rspta ? "Usuario Actualizado" : "Usuario no se pudo mover";

        if ($rspta == "Usuario Actualizado") { // se puede insertar un  seguimiento
            $motivo_seguimiento = "Seguimiento";
            $mensaje_seguimiento = "Cambio de estado a: " . $estado;
            $rspta2 = $oncentercliente->insertarSeguimiento($id_usuario, $id_estudiante_mover, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora);
        }

        break;

    case "selectModalidadCampana":
        $rspta = $oncentercliente->selectModalidadCampana();
        echo '<option value="">Seleccionar</option>';
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["id_modalidad_campana"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
        break;


    case 'verificarDocumento':

        $data = array();
        $data["estado"] = ""; //iniciamos el arreglo
        $data["coincidencia"] = ""; //iniciamos el arreglo

        $nuevodocumento = $_GET["nuevodocumento"];
        $rspta = $oncentercliente->nuevoDocumento($nuevodocumento);
        @$id_estudiante = $rspta["id_estudiante"];

        if ($id_estudiante == "") { // quiere decir que el documento no existe
            $data["estado"] .= "0"; // quiere decir que no existe documento

            // actualizar documento y cambio de estado a preinscrito y se actualiza el seguimiento a 1
            $actualizar = $oncentercliente->actualizarDocumento($id_estudiante_documento, $nuevodocumento, $modalidad_campana);
            /* ******************************** */
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Validación de documento, desde cliente";

            $regseguimiento = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante_documento, $motivo, $mensaje_seguimiento, $fecha, $hora);




            $registrarestado = $oncentercliente->registrarestado($id_usuario, $id_estudiante_documento, 'Preinscrito', $fecha, $hora, $periodo_campana);
        } else {
            $data["coincidencia"] .= $id_estudiante;
            $data["estado"] .= "1"; // quiere decir que existe documento

            //actualizar documento y cambio de estado a preinscrito y se actualiza el seguimiento a 1
            $actualizar = $oncentercliente->actualizarDocumentoIdentificacion($id_estudiante_documento, $nuevodocumento, $modalidad_campana);
            /* ******************************** */
            $motivo = "Seguimiento";
            $mensaje_seguimiento = "Validación de documento desde cliente";

            $regseguimiento = $oncentercliente->registrarSeguimiento($id_usuario, $id_estudiante_documento, $motivo, $mensaje_seguimiento, $fecha, $hora);

            $registrarestado = $oncentercliente->registrarestado($id_usuario, $id_estudiante, 'Preinscrito', $fecha, $hora, $periodo_campana);
            $data["estado"] .= $registrarestado;
        }


        echo json_encode($data);

        break;
}
