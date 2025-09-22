<?php 
date_default_timezone_set('America/Bogota');
require ('../public/mail/sendMailPreinscrito.php');
require_once '../modelos/OnPanel.php';
session_start();
$oncenter = new OnPanel();


$fecha=date('Y-m-d');
$hora=date('H:i:s');
$estados_seguimiento[0] = "Validado";
$estados_seguimiento[1] = "No Validado";

$id_usuario=$_SESSION['id_usuario'];// sesión ACTIVA DEL USUARIO

/* variables para mover usuario*/
$id_estudiante_mover=isset($_POST["id_estudiante_mover"])? limpiarCadena($_POST["id_estudiante_mover"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";

/* ********************* */

/* variables para cambio de documento*/
$id_estudiante_documento=isset($_POST["id_estudiante_documento"])? limpiarCadena($_POST["id_estudiante_documento"]):"";
$modalidad_campana=isset($_POST["modalidad_campana"])? limpiarCadena($_POST["modalidad_campana"]):"";
/* ********************* */

switch ($_GET['op']) {
  

    case 'consulta':

        $dato = $_POST['dato'];
        $tipo = $_POST['tipo'];
        $data['conte'] = '';
        $data['conte2'] = '';
        $val = '';

        if ($tipo == "1") {
            $val = 'identificacion = '.$dato;
        }

        if ($tipo == "2") {
            $val = 'id_estudiante = '.$dato;
        }

        if ($tipo == "3") {
            $val = 'celular = '.$dato;
        }
        $datos = $oncenter->consulta($val);

        if ($datos) {

            if (file_exists('../files/oncenter/img_fotos/'.$datos[0]["identificacion"].'.jpg')) {
                $foto='<img src="../files/oncenter/img_fotos/'.$datos[0]["identificacion"].'.jpg" class="direct-chat-img" style="width:50px;height:50px">';
            }else{
                $foto='<i class="fa-solid fa-user-slash"></i>';
            }

            $data['conte2'] .= '
            <div class="row col-12 " >
                <div class="col-12 px-4 d-flex align-items-center">
                    <div class="row col-12 ">


                        <div class="col-12 px-2 pt-4 pb-2 " id="t-NC">
                            <div class="row align-items-center">
                                <div class="pl-4">
                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                        '.$foto.'
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">'.$datos[0]['nombre'].' '.$datos[0]['nombre_2'].'</span> <br>
                                    <span class="text-semibold fs-14">'.$datos[0]['apellidos'].' '.$datos[0]['apellidos_2'].'</span> 
                                </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2" id="t-Ce">
                            <div class="row align-items-center">
                                <div class="pl-4">
                                    <span class="rounded bg-light-red p-2 text-danger">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Correo electrónico</span> <br>
                                    <span class="text-semibold fs-14">'.$datos[0]['email'].'</span> 
                                </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-12 px-2 py-2" id="t-NT">
                            <div class="row align-items-center">
                                <div class="pl-4">
                                    <span class="rounded bg-light-green p-2 text-success">
                                        <i class="fa-solid fa-mobile-screen"></i>
                                    </span> 
                                
                                </div>
                                <div class="col-10">
                                <div class="col-10 fs-14 line-height-18"> 
                                    <span class="">Número celular</span> <br>
                                    <span class="text-semibold fs-14">'.$datos[0]['celular'].'</span> 
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
                

                                for ($i=0; $i < count($datos); $i++) { 
                                    $data['conte'] .= '
                                    <tr>
                                        <td>'.$datos[$i]['id_estudiante'].'</td>
                                        <td>'.$datos[$i]['fo_programa'].'</td>
                                        <td>'.$datos[$i]['jornada_e'].'</td>
                                        <td>'.$oncenter->fechaesp($datos[$i]['fecha_ingreso']).'</td>
                                        <td>'.$datos[$i]['medio'].'</td>
                                        <td>'.$datos[$i]['estado'].'</td>
                                        <td>'.$datos[$i]['periodo_campana'].'</td>
                                        <td><button class="btn btn-primary" onclick="detalles('.$datos[$i]['id_estudiante'].')" ><i class="fa fa-eye"></i></button></td>
                                    </tr>';
                                }

                                $data['conte'] .= '
                            </tbody>
                        </table>
                    </div>
                </div>';
        }else{
            $data['status'] = 'error';
        }

        echo json_encode($data);


    break;

    
    // inicio agregar tareas, seguimientos y ver historial
    case 'verHistorialTabla':

        $id_estudiante=$_GET["id_estudiante"];
    
        $rspta=$oncenter->verHistorialTabla($id_estudiante);
        //Vamos a declarar un array
        $data= Array();
        $reg=$rspta;
        
            for ($i=0;$i<count($reg);$i++){

                $datoasesor=$oncenter->datosAsesor($reg[$i]["id_usuario"]);
                $nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"];
                    
                $data[]=array(
                    
                    "0"=>$reg[$i]["id_estudiante"],
                    "1"=>$reg[$i]["motivo_seguimiento"],
                    "2"=>$reg[$i]["mensaje_seguimiento"],
                    "3"=>$oncenter->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],		
                    "4"=>$nombre_usuario
                );
                    
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);

    break;	
        
    case 'verHistorial':
        $id_estudiante = $_POST["id_estudiante"];
        $data = Array();//Vamos a declarar un array
        $data["0"] ="";//iniciamos el arreglo
        
        $datos = $oncenter->verHistorial($id_estudiante);// consulta para traer los interesados

        $nombre = $datos["nombre"];
        $nombre_2 = $datos["nombre_2"];
        $apellidos = $datos["apellidos"];
        $apellidos_2 = $datos["apellidos_2"];
        $programa = $datos["fo_programa"];
        $jornada = $datos["jornada_e"];
        $celular = $datos["celular"];
        $email = $datos["email"];
        $periodo_ingreso = $datos["periodo_ingreso"];
        $fecha_ingreso = $datos["fecha_ingreso"];
        $hora_ingreso = $datos["hora_ingreso"];
        $medio = $datos["medio"];
        $conocio = $datos["conocio"];
        $contacto = $datos["contacto"];
        $modalidad = $datos["nombre_modalidad"];
        $estado = $datos["estado"];
        $periodo_campana = $datos["periodo_campana"];
        $nivel_escolaridad=$datos["nivel_escolaridad"];
        $nombre_colegio=$datos["nombre_colegio"];
        $fecha_graduacion=$datos["fecha_graduacion"];
        $jornada_academico=$datos["jornada_academico"];
        $departamento_academico=$datos["departamento_academico"];
        $municipio_academico=$datos["municipio_academico"];
        $codigo_pruebas=$datos["codigo_pruebas"];
        $codigo_saber_pro=$datos["codigo_saber_pro"];
        $colegio_articulacion=$datos["colegio_articulacion"];
        $grado_articulacion=$datos["grado_articulacion"];
        
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
                                    <dd>'. $nombre . ' ' . $nombre_2 . ' ' . $apellidos . ' ' . $apellidos_2 . '</dd>
                                    <dt>Programa</dt>
                                    <dd>'.$programa.'</dd>
                                    <dt>Celular</dt>
                                    <dd>'.$celular.'</dd>
                                    <dt>Email</dt>
                                    <dd>'.$email.'</dd>
                                    <dt>Fecha de Ingreso</dt>
                                    <dd>'.$oncenter->fechaesp($fecha_ingreso).' a las '.$hora_ingreso.' del '.$periodo_ingreso.'</dd>
                                    <dt>Medio</dt>
                                    <dd>'.$medio.'</dd>
                                </div>
                                    <div class="col-xl-6">							
                                    <dt>Conocio</dt>
                                    <dd>'.$conocio.'</dd>
                                    <dt>Contacto</dt>
                                    <dd>'.$contacto.'</dd>
                                    <dt>Modalidad</dt>
                                    <dd>'.$modalidad.'</dd>
                                    <dt>Estado</dt>
                                    <dd>'.$estado.'</dd>
                                    <dt>Campaña</dt>
                                    <dd>'.$periodo_campana.'</dd>
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
                                        <dd>'. $nivel_escolaridad . '</dd>
                                        <dt>Nombre Colegio</dt>
                                        <dd>'.$nombre_colegio.'</dd>
                                        <dt>Fecha Graduacion</dt>
                                        <dd>'.$fecha_graduacion.'</dd>
                                        <dt>Jornada Academico</dt>
                                        <dd>'.$jornada_academico.'</dd>
                                        <dt>Departamento Academico</dt>
                                        <dd>'.$departamento_academico.'</dd>
                                        <dt>Municipio Academico</dt>
                                        <dd>'.$municipio_academico.'</dd>
                                    </dl>
                                </div>
                                <div class="col-xl-6">
                                    </dl>
                                        <dt>Codigo Pruebas</dt>
                                        <dd>'.$codigo_pruebas.'</dd>
                                        <dt>Codigo Saber Pro</dt>
                                        <dd>'.$codigo_saber_pro.'</dd>
                                        <dt>Colegio Articulacion</dt>
                                        <dd>'.$colegio_articulacion.'</dd>
                                        <dt>Grado Articulacion</dt>
                                        <dd>'.$grado_articulacion.'</dd>
                                        <dt>Campaña</dt>
                                        <dd>'.$periodo_campana.'</dd>
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

    case 'detalles':
        $id = $_POST['val'];
        $val = 'id_estudiante = '.$id;
        $datos = $oncenter->consulta($val);
		$data['conte'] = "";
        $data['conte2'] = "";

        //listo los programas 
        $mostrar_programas = $oncenter->select_onprogramas();
        //listo los estados
        $mostrar_estados = $oncenter->select_on_estado();	
        //listo los estados
        $mostrar_jornada = $oncenter->select_on_jornada();	
        //listo los estados
        $mostrar_periodo = $oncenter->select_on_periodo();	
       /* *********************** */

       $data['conte2'] .= ' 
    
            <div class="col-12  pt-4">
                <div class="row">
                    <div class="col-4 mnw-100 text-center pt-4" id="t2-Cas">
                        <i class="fa-solid fa-trophy avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2 fa-2x"></i>
                        <h4 class="titulo-2 fs-18 mb-0">'.$datos[0]['id_estudiante'].'</h4>
                        <p class="small text-secondary">Caso</p>
                    </div>
                    <div class="col-4 mnw-100 text-center pt-4" id="t2-Cam">
                        <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-green text-green rounded-circle mb-2 fa-2x"></i>
                        <h4 class="titulo-2 fs-18 mb-0">'.$datos[0]['periodo_campana'].'</h4>
                        <p class="small text-secondary">Campaña</p>
                    </div>
                    <div class="col-4 mnw-100 text-center pt-4" id="t2-EST">
                        <i class="fa-solid fa-user-check avatar avatar-50 bg-light-yellow text-yellow rounded-circle mb-2 fa-2x"></i>
                        <h4 class="titulo-2 fs-18 mb-0">'.$datos[0]['estado'].'</h4>
                        <p class="small text-secondary">Estado</p>
                    </div>
                </div>
            </div>
        ';
        
        $data['conte'] .= '
            <div class="col-12 text-right p-4">
                <button id="t2-Vp" class="btn btn-danger" onclick="volver()"><i class="fas fa-arrow-left"></i> Volver a programas</button>
            </div>

            <form name="estudiante" id="estudiante" method="POST" class="col-12 card">
                <div class="row">
                    <div class="col-6 px-2 py-3 tono-3">
                        <div class="row align-items-center">
                            <div class="pl-4">
                                <span class="rounded bg-light-green p-2 text-success ">
                                    <i class="fa-solid fa-table" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                            <div class="col-5 fs-14 line-height-18"> 
                                <span class="">Configurar</span> <br>
                                <span class="text-semibold fs-14">Proceso</span> 
                            </div> 
                            </div>
                        </div>
                    </div>
              

                    <div class="col-6 text-right pt-3 pr-4 tono-3">
                        <button  id="t2-Hi" type="button" onclick="verHistorial('.$datos[0]['id_estudiante'].')" class="btn btn-primary " title="historial"><i class="fa fa-eye text-white"></i> Ver seguimiento</button>	
                    </div>  
                    
                </div>

                <div class="row p-4">

                <input type="hidden" name="id_estudiante" id="id_estudiante" value="'.$datos[0]['id_estudiante'].'">

                <div class="col-12" id="t2-CP">
                    <h6 class="title">Datos Personales</h6>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0">
                            <div class="form-floating">
                                <input type="text"  value="' . $datos[0]['nombre'] . '"  class="form-control border-start-0" name="nombre" id="nombre" maxlength="100">
                                <label>Primer Nombre</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editarnombre(`'.$datos[0]['nombre'].'`)" class="btn btn-warning py-3 text-white editar-nombre"><i class="fa fa-edit"></i>Editar</button> 
                            <button onclick="guardarnombre(`'.$datos[0]['nombre'].'`)" class="btn btn-success py-3 text-white guardar-nombre d-none" type="button"><i class="fa fa-save"></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0">
                            <div class="form-floating">
                                <input type="text"  value="' . $datos[0]['nombre_2'] . '"  class="form-control border-start-0" name="nombre_2" id="nombre_2" maxlength="100">
                                <label>Segundo Nombre</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editarnombre_2(`'.$datos[0]['nombre_2'].'`)" class="btn btn-warning py-3 text-white editar-nombre_2"><i class="fa fa-edit"></i>Editar</button>         
                            <button type="button" onclick="guardoeditonombre_2(`'.$datos[0]['nombre_2'].'`)" class="btn btn-success py-3 text-white guardar-nombre_2 d-none"><i class="fa fa-save "></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0">
                            <div class="form-floating">
                                <input type="text"  value="'. $datos[0]['apellidos'].'"  class="form-control border-start-0" name="apellidos" id="apellidos" maxlength="100">
                                <label>Primer Apellido</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editarapellidos(`'.$datos[0]['apellidos'].'`)" class="btn btn-warning py-3 text-white editar-apellidos"><i class="fa fa-edit"></i>Editar</button>        
                            <button type="button" onclick="guardoeditoapellidos(`'.$datos[0]['apellidos'].'`)" class="btn btn-success py-3 text-white guardar-apellidos d-none" t><i class="fa fa-save "></i>Guardar</button>
                    </td> 
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0">
                            <div class="form-floating">
                                <input type="text"  value="'. $datos[0]['apellidos_2'].'"  class="form-control border-start-0" name="apellidos_2" id="apellidos_2" maxlength="100">
                                <label>Segundo Apellido</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editarapellidos_2(`'.$datos[0]['apellidos_2'].'`)" class="btn btn-warning py-3 text-white editar-apellidos_2"><i class="fa fa-edit"></i>Editar</button> 
                            <button type="button" onclick="guardoeditoapellidos_2(`'.$datos[0]['apellidos_2'].'`)" class="btn btn-success py-3 text-white guardar-apellidos_2 d-none" ><i class="fa fa-save "></i>Guardar</button>  
                    </td> 
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0">
                            <div class="form-floating">
                                <input type="number"  value="'. $datos[0]['identificacion'].'"  class="form-control border-start-0" name="identificacion" id="identificacion" maxlength="100">
                                <label>Número de identificación</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editaridentificacion(`'.$datos[0]['identificacion'].'`)" class="btn btn-warning py-3 text-white editar-identificacion"><i class="fa fa-edit"></i>Editar</button>       
                            <button type="button" onclick="guardoeditoidentificacion()" class="btn btn-success  guardar-identificacion d-none py-3 text-white"><i class="fa fa-save"></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0 col-8">
                            <div class="form-floating">
                                <input type="date"  value="'. $datos[0]['fecha_nacimiento'].'"  class="form-control border-start-0" name="fecha_nacimiento" id="fecha_nacimiento">
                                <label>Fecha de Nacimiento</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editarfechanacimiento(`'.$datos[0]['fecha_nacimiento'].'`)" class="btn btn-warning py-3 text-white editar-fechanacimiento"><i class="fa fa-edit"></i>Editar</button>          
                            <button type="button" onclick="guardoeditofechanacimiento(`'.$datos[0]['fecha_nacimiento'].'`)" class="btn btn-success py-3 text-white guardar-fechanacimiento d-none"><i class="fa fa-save"></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-12" id="t2-DC">
                    <h6 class="title">Datos de Contacto</h6>
                </div>

                <div class="col-xl-4 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0 col-9">
                            <div class="form-floating">
                                <input type="number"  name="celular" id="celular" value="'.$datos[0]['celular'].'"  class="form-control border-start-0" >
                                <label>Número celular</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editarcelular(`'.$datos[0]['celular'].'`)" class="btn btn-warning py-3 text-white editar-celular"><i class="fa fa-edit"></i>Editar</button>    
                            <button type="button" onclick="guardoeditocelular(`'.$datos[0]['celular'].'`)" class="btn btn-success py-3 text-white guardar-celular d-none"><i class="fa fa-save"></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0 col-9">
                            <div class="form-floating">
                                <input type="email" name="email" id="email" value="'.$datos[0]['email'].'"  class="form-control border-start-0" >
                                <label>Correo personal</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editaremail(`'.$datos[0]['email'].'`)" class="btn btn-warning py-3 text-white editar-email"><i class="fa fa-edit"></i>Editar</button> 
                            <button type="button" onclick="guardoeditoemailpersonal(`'.$datos[0]['email'].'`)" class="btn btn-success text-white guardar-email d-none"><i class="fa fa-save"></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-3 col-md-3 col-6">
                    <div class="row">
                        <div class="form-group mb-3 position-relative check-valid p-0 m-0 col-9">
                            <div class="form-floating">
                                <input type="email" name="email_ciaf" id="email_ciaf" value="'.$datos[0]['email_ciaf'].'" class="form-control border-start-0" >
                                <label>Correo CIAF</label>
                            </div>
                        </div>
                        <div class="col-auto m-0 p-0">
                            <button type="button" onclick="editaremailciaf(`'.$datos[0]['email_ciaf'].'`)" class="btn btn-warning py-3 text-white editar-email_ciaf"><i class="fa fa-edit"></i>Editar</button> 
                            <button type="button" onclick="guardoeditoemailciaf(`'.$datos[0]['email_ciaf'].'`)" class="btn btn-success py-3 text-white guardar-email_ciaf d-none"><i class="fa fa-save"></i>Guardar</button>
                        </div>
                            
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                </div>

                <div class="col-12" id="t2-DP">
                    <h6 class="title">Datos de Programa</h6>
                </div>

                <div class="col-xl-6 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                        <select onchange="guardoeditofoprorgama(this.value)" name="fo_programa" id="fo_programa" class="form-control border-start-0 ">';
                                        
                            for ($r = 0; $r < count($mostrar_programas); $r++){
                                if($datos[0]['fo_programa'] == $mostrar_programas[$r]["nombre"] ){
                                    $seleccionado = "selected";
                                }else{
                                    $seleccionado = "";
                                }
                                $data['conte'] .= "<option $seleccionado value='" . $mostrar_programas[$r]["nombre"]."'>" .$mostrar_programas[$r]["nombre"]. "</option>";
                            }

                            $data['conte'] .= '
                        
                        </select>
                        <label>Programa Matriculado</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-6 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                        <select onchange="guardoeditojornadae(this.value)" name="jornada_e" id="jornada_e" class="form-control border-start-0 ">';
                                        
                            for ($e = 0; $e < count($mostrar_jornada); $e++){
                                if($datos[0]['jornada_e'] == $mostrar_jornada[$e]["nombre"] ){
                                    $seleccionado = "selected";
                                }else{
                                    $seleccionado = "";
                                }
                                $data['conte'] .= "<option $seleccionado value='" . $mostrar_jornada[$e]["nombre"]."'>" .$mostrar_jornada[$e]["nombre"]. "</option>";
                            }

                            $data['conte'] .= '
                        
                        </select>
                        <label>Jornada estudio</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-12" id="t2-DA">
                    <h6 class="title">Datos Admisiones</h6>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                        <select onchange="guardoeditoestado(this.value)" name="estado" id="estado" class="form-control border-start-0 ">';
                                        
                            for ($r = 0; $r < count($mostrar_estados); $r++){
                                if($datos[0]['estado'] == $mostrar_estados[$r]["nombre_estado"] ){
                                    $seleccionado = "selected";
                                }else{
                                    $seleccionado = "";
                                }
                                $data['conte'] .= "<option $seleccionado value='" . $mostrar_estados[$r]["nombre_estado"]."'>" .$mostrar_estados[$r]["nombre_estado"]. "</option>";
                            }

                            $data['conte'] .= '
                        
                        </select>
                        <label>Estado Admisiones</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                        <select onchange="guardoeditoperiodocampana(this.value)" name="periodo_campana" id="periodo_campana" class="form-control border-start-0 ">';
                                        
                            for ($n = 0; $n < count($mostrar_periodo); $n++){
                                if($datos[0]['periodo_campana'] == $mostrar_periodo[$n]["periodo"] ){
                                    $seleccionado = "selected";
                                }else{
                                    $seleccionado = "";
                                }
                                $data['conte'] .= "<option $seleccionado value='" . $mostrar_periodo[$n]["periodo"]."'>" .$mostrar_periodo[$n]["periodo"]. "</option>";
                            }

                            $data['conte'] .= '
                        
                        </select>
                        <label>Periodo campaña</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>
                
                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                        <select onchange="guardoeditoformulario(this.value)" name="formulario" id="formulario"  class="form-control border-start-0 ">';
                                        
                            $data['conte'] .= "<option ".(($datos[0]['formulario'] == 0)?"selected":"")." value='0'>Validado </option>";
                            $data['conte'] .= "<option ".(($datos[0]['formulario'] == 1)?"selected":"")." value='1'>No Validado </option>";
                            $data['conte'] .='
                        
                        </select>
                        <label>Formulario Inscripción</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                            <select onchange="guardoeditoinscripcion(this.value)" name="inscripcion" id="inscripcion" class="form-control border-start-0 ">';
                                            
                                $data['conte'] .= "<option ".(($datos[0]['inscripcion'] == 0)?"selected":"")." value='0'>Validado </option>";
                                $data['conte'] .= "<option ".(($datos[0]['inscripcion'] == 1)?"selected":"")." value='1'>No Validado </option>";
                                $data['conte'] .='
                            
                            </select>
                        <label>Pago de Inscripción</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="form-group mb-3 position-relative check-valid p-0 m-0 ">
                        <div class="form-floating">
                            <select onchange="guardoeditodocumentos(this.value)" name="documentos" id="documentos" class="form-control border-start-0 ">';
                                            
                                $data['conte'] .= "<option ".(($datos[0]['documentos'] == 0)?"selected":"")." value='0'>Validado </option>";
                                $data['conte'] .= "<option ".(($datos[0]['documentos'] == 1)?"selected":"")." value='1'>No Validado </option>";
                                $data['conte'] .='
                            
                            </select>
                        <label>Documentos</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Please enter valid input</div>
                </div>
            </form>
        ';

        echo json_encode($data);
    break;

    case 'guardoeditonombre':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
        $edito_nombre=$oncenter->guardoeditonombre($id_estudiante, $nombre);
        echo json_encode('Nombre Modificado');
        
    break; 
    
    case 'guardoeditonombre_2':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $nombre_2=isset($_POST["nombre_2"])? limpiarCadena($_POST["nombre_2"]):"";
        $edito_nombre_2=$oncenter->guardoeditonombre_2($id_estudiante, $nombre_2);
       
        echo json_encode("Nombre 2 Modificado");
    break; 
    case 'guardoeditoapellidos':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $apellidos=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
        $edito_apellidos=$oncenter->guardoeditoapellidos($id_estudiante, $apellidos);
      
        echo json_encode("Apellido Modificado");
    break; 
    case 'guardoeditoapellidos_2':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $apellidos_2=isset($_POST["apellidos_2"])? limpiarCadena($_POST["apellidos_2"]):"";
        $edito_apellidos_2=$oncenter->guardoeditoapellidos_2($id_estudiante, $apellidos_2);
        
        echo json_encode("Apellidos 2 Modificado");
    break; 

    case 'guardoeditoidentificacion':
        //consulta base de datos para traer el identificador antes de modificarlo
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $identificacion_am = $datos_am["identificacion"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $identificacion = isset($_POST["identificacion"])? limpiarCadena($_POST["identificacion"]):"";
        $edito_identificacion = $oncenter->guardoeditoidentificacion($id_estudiante, $identificacion);
        if($edito_identificacion){
            if($identificacion_am != $identificacion ){
                $mensaje_seguimiento =  "Se ha modificado identificación de ".$identificacion_am." a ".$identificacion;
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }

            echo json_encode("Identificación Modificada"); 
            
        }else{
            
            echo json_encode("Identificación NO Modificada"); 
        } 
        
    break; 

    case 'guardoeditoestado':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $estado_am = $datos_am["estado"];
        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
        $edito_estado = $oncenter->guardoeditoestado($id_estudiante, $estado);
        if($edito_estado){
            if($estado_am != $estado ){
                $mensaje_seguimiento =  "Se ha modificado estado de ".$estado_am." a ".$estado;
                $periodo = $_SESSION["periodo_actual"];
                $oncenter->insertarestado($id_usuario, $id_estudiante, $estado, $fecha,$hora,$periodo);
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }
    
            echo json_encode("Estado Modificado"); 
        }else{
        
            echo json_encode("Estado NO Modificada"); 
        } 
        
    break; 

    case 'guardoeditofoprorgama':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $fo_programa_am = $datos_am["fo_programa"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $fo_programa = isset($_POST["fo_programa"])? limpiarCadena($_POST["fo_programa"]):"";
        $edito_programa = $oncenter->guardoeditofoprorgama($id_estudiante, $fo_programa);
        if($edito_programa){
            if($fo_programa_am != $fo_programa ){
                $mensaje_seguimiento =  "Se ha modificado Fo Programa de ".$fo_programa_am." a ".$fo_programa;
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }

            echo json_encode("Programa Modificada"); 
        }else{
            echo json_encode("Programa NO Modificada"); 
        } 
        

    break; 

    case 'guardoeditojornadae':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $jornada_e=isset($_POST["jornada_e"])? limpiarCadena($_POST["jornada_e"]):"";
        $edito_jornada=$oncenter->guardoeditojornadae($id_estudiante, $jornada_e);

        echo json_encode("Jornada E Modificada"); 
    break;

    case 'guardoeditofechanacimiento':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $fecha_nacimiento=isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):"";
        $edito_nacimiento=$oncenter->guardoeditofechanacimiento($id_estudiante, $fecha_nacimiento);

        echo json_encode("Fecha Nacimiento Modificada");
    break;

    case 'guardoeditocelular':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $celular_am = $datos_am["celular"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
        $edito_celular = $oncenter->guardoeditocelular($id_estudiante, $celular);
        if($edito_celular){
            if($celular_am != $celular ){
                $mensaje_seguimiento =  "Se ha modificado celular de ".$celular_am." a ".$celular;
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }

            echo json_encode("Celular Modificada");
        }else{
            echo json_encode("Celular NO Modificada");
        } 
        
    break;

    case 'guardoeditoemailpersonal':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $email_am = $datos_am["email"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
        $edito_email = $oncenter->guardoeditoemailpersonal($id_estudiante, $email);
        if($edito_email){
            if($email_am != $email ){
                $mensaje_seguimiento =  "Se ha modificado email de ".$email_am." a ".$email;
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }
            echo json_encode("Email Modificado");
        }else{
            echo json_encode("Email NO Modificada");
        } 
    break;

    case 'guardoeditoemailciaf':
        $id_estudiante=isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $email_ciaf=isset($_POST["email_ciaf"])? limpiarCadena($_POST["email_ciaf"]):"";
        $edito_emailciaf=$oncenter->guardoeditoemailciaf($id_estudiante, $email_ciaf);
        
        echo json_encode("Email Ciaf Modificado");
        
    break;

    case 'guardoeditoperiodocampana':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $periodo_campana_am = $datos_am["periodo_campana"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $periodo_campana=isset($_POST["periodo_campana"])? limpiarCadena($_POST["periodo_campana"]):"";
        $edito_periodo_campana = $oncenter->guardoeditoperiodocampana($id_estudiante, $periodo_campana);
        if($edito_periodo_campana){
            if($periodo_campana_am != $periodo_campana ){
                $mensaje_seguimiento =  "Se ha modificado periodo campana de ".$periodo_campana_am." a ".$periodo_campana;
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }
            
            echo json_encode("Periodo Campana Modificado");
        }else{
            echo json_encode("Periodo Campana NO Modificada");
        } 
        
    break;

    case 'guardoeditoformulario':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $formulario_am = $datos_am["formulario"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $formulario=isset($_POST["formulario"])? limpiarCadena($_POST["formulario"]):"";
        $formulario_campana = $oncenter->guardoeditoformulario($id_estudiante, $formulario);
        if($formulario_campana){
            if($formulario_am != $formulario ){
                $mensaje_seguimiento =  "Se ha modificado formulario de ".$estados_seguimiento[$formulario_am]." a ".$estados_seguimiento[$formulario];
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }


            echo json_encode("Formulario Modificado");
        }else{

            
            echo json_encode("Formulario NO Modificada");
        } 
        
    break;

    case 'guardoeditoinscripcion':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $inscripcion_am = $datos_am["inscripcion"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $inscripcion=isset($_POST["inscripcion"])? limpiarCadena($_POST["inscripcion"]):"";
        $edito_inscripcion=$oncenter->guardoeditoinscripcion($id_estudiante, $inscripcion);
        if($edito_inscripcion){
            if($inscripcion_am != $inscripcion ){
                $mensaje_seguimiento =  "Se ha modificado inscripción de ".$estados_seguimiento[$inscripcion_am]." a ".$estados_seguimiento[$inscripcion];
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }
            echo json_encode("Inscripción Modificado");
        }else{
            echo json_encode("Inscripción NO Modificada");
        } 
        
    break;

    case 'guardoeditoentrevista':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $entrevista_am = $datos_am["entrevista"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $entrevista=isset($_POST["entrevista"])? limpiarCadena($_POST["entrevista"]):"";
        $edito_entrevista=$oncenter->guardoeditoentrevista($id_estudiante, $entrevista);
        if($edito_entrevista){
            if($entrevista_am != $entrevista ){
                $mensaje_seguimiento =  "Se ha modificado entrevista de ".$estados_seguimiento[$entrevista_am]." a ".$estados_seguimiento[$entrevista];
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }

            echo json_encode("Entrevista Modificado");
        }else{
            echo json_encode("Entrevista NO Modificada");
        } 
        
    break;

    case 'guardoeditodocumentos':
        $datos_am = $oncenter->consulta_id($id_estudiante);
        $documentos_am = $datos_am["documentos"];

        $id_estudiante = isset($_POST["id_estudiante"])? limpiarCadena($_POST["id_estudiante"]):"";
        $documentos=isset($_POST["documentos"])? limpiarCadena($_POST["documentos"]):"";
        $edito_documentos=$oncenter->guardoeditodocumentos($id_estudiante, $documentos);
        if($edito_documentos){
            if($documentos_am != $documentos ){
                $mensaje_seguimiento =  "Se ha modificado documentos de ".$estados_seguimiento[$documentos_am]." a ".$estados_seguimiento[$documentos];
                $oncenter->insertarSeguimiento($id_usuario, $id_estudiante, 'Seguimiento', $mensaje_seguimiento, $fecha, $hora);
            }

            echo json_encode("Documentos Modificado");
        }else{
            echo json_encode("Documentos NO Modificada");
        } 
    break;
}

?>