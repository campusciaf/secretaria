<?php
session_start();
require_once "../modelos/Consultaporrenovar.php";
$consultaporrenovar = new Consultaporrenovar();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$rsptaperiodo = $consultaporrenovar->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$temporadaactual = $rsptaperiodo["temporada"];
$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";   
$temporadainactivos=$temporadaactual-2;
$id_usuario = $_SESSION['id_usuario'];

// trae el estado del egresado
$id_egresdado_est=isset($_POST["id_egresdado_est"])? limpiarCadena($_POST["id_egresdado_est"]):"";
$id_reingreso_estado=isset($_POST["id_reingreso_estado"])? limpiarCadena($_POST["id_reingreso_estado"]):"";

$nombre_estado=isset($_POST["nombre_estado"])? limpiarCadena($_POST["nombre_estado"]):"";




switch ($_GET['op']) {

    case 'listargeneral':
        $data= array();
        $data["total"]="";

        $data["total"].='
            <div class="col-xl-8" id="input_dato">
                <div class="row">

                    <div class="group col-xl-5 col-lg-6 col-md-12 col-12 m-0 p-0">    
                            <input type="text" name="dato" id="dato" required/>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Digitar Cédula:</label>
                    </div>
                    <div class="col-xl-2 p-0 m-0">
                            <input type="submit" value="Buscar" onclick="consulta_desercion()" class="btn btn-success btn-lg"  />
                    </div>
                </div>
            </div><br>';
		echo json_encode($data);
    break;




    case 'consulta_desercion':

            $cedula = $_GET['dato'];
            $rspta = $consultaporrenovar->consulta_id_credencial($cedula);
            $credencial_identificacion =  $rspta["credencial_identificacion"];
            $credencial_nombre =  $rspta["credencial_nombre"] ." ".$rspta["credencial_nombre_2"]." ".$rspta["credencial_apellido"]." ".$rspta["credencial_apellido_2"];
            $credencil_correo =  $rspta["credencial_login"];
            $id_credencial =  $rspta["id_credencial"];
            $celular =  $rspta["celular"];
            $email =  $rspta["email"];
            $periodo =  $rspta["periodo"];
            $periodo_activo =  $rspta["periodo_activo"];
            $consulta_estado = $consultaporrenovar->mostrar_estados($id_credencial);
            if (empty($consulta_estado)){
                $mostrar_estado = "";
                $mostrar_estado = $mostrar_estado==""?'Sin estado':''.$mostrar_estado.'';
            }else{
                
                $mostrar_estado = $consulta_estado["nombre_estado"];
            }
			
            $data[] = array(
				"0" => '<button onclick="agregar_mostrar_seguimiento('.$id_credencial.')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial('.$id_credencial.')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>',
				"1" => $credencial_identificacion,
				"2" =>$email,
				"3" =>$periodo,
				"4" =>'</span></div><div><button class=" btn-sm float-right btn btn-warning btn-xs ml-auto " onclick="mostrar_reingreso('.$id_credencial.')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button></div><div><span class="badge badge-primary p-1 mt-3 ">'.$mostrar_estado.'',
				"5" =>$periodo_activo
			);
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data,
			"credencial_nombre" => $credencial_nombre,
			"email" => $email,
			"celular" => $celular,
			"credencial_identificacion" => $credencial_identificacion,
		);
		echo json_encode($results);
		break;






    // case 'consulta_desercion':
    //     $cedula = $_POST['dato'];
    //     $data['conte'] = '';
    //     $data['conte2'] = '';
    //     $rspta = $consultaporrenovar->consulta_id_credencial($cedula);
       
        
            
    //     $data['conte2'] .=
    //         '		

    //     <div class="row">
    //         <div class="col-12 m-2 p-2">
    //         <table id="tabla_desertados" class="table table-bordered table-responsive-sm compact table-sm table-hover" style="width:100%">
    //             <thead>
    //                 <th>Acciones</th>
    //                 <th>Identificación</th>
    //                 <th>Nombre estudiante</th>
    //                 <th>Correo CIAF</th>
    //                 <th>Correo personal</th>
    //                 <th>Celular</th>
    //                 <th>Periodo Ingreso</th>
    //                 <th>Estado</th>
    //                 <th>Periodo Activo</th>
                
    //     </div> 

    //     </thead><tbody>';
            
    //         $credencial_identificacion =  $rspta["credencial_identificacion"];
    //         $credencial_nombre =  $rspta["credencial_nombre"] ." ".$rspta["credencial_nombre_2"]." ".$rspta["credencial_apellido"]." ".$rspta["credencial_apellido_2"];
    //         $credencil_correo =  $rspta["credencial_login"];
    //         $id_credencial =  $rspta["id_credencial"];

    //         $celular =  $rspta["celular"];
    //         $email =  $rspta["email"];
    //         $periodo =  $rspta["periodo"];
    //         $periodo_activo =  $rspta["periodo_activo"];
    //         $consulta_estado = $consultaporrenovar->mostrar_estados($id_credencial);

    //         if (empty($consulta_estado)){

    //             $mostrar_estado = "";
                
    //             $mostrar_estado = $mostrar_estado==""?'Sin estado':''.$mostrar_estado.'';
    //         }else{
                
    //             $mostrar_estado = $consulta_estado["nombre_estado"];
    //         }

    //         $data['conte2'] .= '
                                        
    //             <tr>
    //                 <td class="text-center">' . '<button onclick="agregar_mostrar_seguimiento('.$id_credencial.')" class="btn btn-primary btn-xs" title="Agregar seguimiento"><i class="fa fa-plus"></i> Seguimiento</button> <button onclick="seguimientoverHistorial('.$id_credencial.')" class="btn btn-primary btn-xs" title="historial"><i class="fa fa-eye" style="color:#fff"></i> Ver</button>' . '</td>

    //                 <td class="text-center">' . $credencial_identificacion . '</td>
                    
    //                 <td class="text-center">' . $credencial_nombre . '</td>
    //                 <td >' . $credencil_correo . '</td>
    //                 <td >' . $email . '</td>

    //                 <td >' . $celular . '</td>
    //                 <td >' . $periodo . '</td>
    //                 <td ></span></div><div><button class=" btn-sm float-right btn btn-warning btn-xs ml-auto " onclick="mostrar_reingreso('.$id_credencial.')" title="Editar Acción" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></button></div><div><span class="badge badge-primary p-1 mt-3 ">' . $mostrar_estado . '</td>
    //                 <td >' . $periodo_activo . '</td>
    //             </tr>';
            
    //         $data['conte2'] .= '</tbody></table>';

    //     echo json_encode($data);    
    // break;

    case 'seguimientoverHistorial':
        $data= array();//Vamos a declarar un array
        $data["0"] ="";//iniciamos el arreglo
        $id_credencial=$_POST["id_credencial"];
        $rspta=$consultaporrenovar->vernombreestudiantesinactivos($id_credencial);
        
        for ($a = 0; $a < count($rspta) ; $a++) { 

            $credencial_identificacion = $rspta[$a]["credencial_identificacion"];
            
            $nombre = $rspta[$a]["credencial_apellido"] .' ' . $rspta[$a]["credencial_apellido_2"] .' ' . $rspta[$a]["credencial_nombre"] .' ' . $rspta[$a]["credencial_nombre_2"];
            
        }
        $data["0"] .= '
        
        <div class="col-md-12">
                <div id="accordion">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="card-body">
                        
                        
                            <div class="row">
                                <div class="col-xl-6">

                                <dt>Nombre</dt>
                                <dd>'. $nombre. '</dd>
                                </div>
                                <div class="col-xl-6">							
                                <dt>Cédula</dt>
                                <dd>'. $credencial_identificacion. '</dd>
                                
                                
                                </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
            </div>
            </div>';
        $results = array($data);
        echo json_encode($results);
    break;

    case 'agregarSeguimiento':

        $id_usuario=$_SESSION['id_usuario'];
        $id_estudiante_agregar=isset($_POST["id_estudiante_agregar"])? limpiarCadena($_POST["id_estudiante_agregar"]):"";
        $motivo_seguimiento=isset($_POST["motivo_seguimiento"])? limpiarCadena($_POST["motivo_seguimiento"]):"";
        $mensaje_seguimiento=isset($_POST["mensaje_seguimiento"])? limpiarCadena($_POST["mensaje_seguimiento"]):"";
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');

        $rspta=$consultaporrenovar->vernombreestudiantesinactivos($id_estudiante_agregar);
        $id_estudiante_programa =0;
        for ($a = 0; $a < count($rspta) ; $a++) { 
            $id_estudiante_programa = $rspta[$a]["id_estudiante"];
        }
        $rspta=$consultaporrenovar->insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora,$id_estudiante_programa);
        echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
        
            
    break;

    case 'agregarTarea':
        $fecha_realizo=NULL;
        $hora_realizo=NULL;
        $fecha=date('Y-m-d');
        $periodo_actual=$_SESSION['periodo_actual'];
        $hora=date('H:i:s');
        $id_usuario=$_SESSION['id_usuario'];
        $id_estudiante_tarea=isset($_POST["id_estudiante_tarea"])? limpiarCadena($_POST["id_estudiante_tarea"]):"";
        $motivo_tarea=isset($_POST["motivo_tarea"])? limpiarCadena($_POST["motivo_tarea"]):"";
        $mensaje_tarea=isset($_POST["mensaje_tarea"])? limpiarCadena($_POST["mensaje_tarea"]):"";
        $fecha_programada=isset($_POST["fecha_programada"])? limpiarCadena($_POST["fecha_programada"]):"";
        $hora_programada=isset($_POST["hora_programada"])? limpiarCadena($_POST["hora_programada"]):"";

        $rspta=$consultaporrenovar->vernombreestudiantesinactivos($id_estudiante_tarea);
        $id_estudiante_programa =0;
        for ($a = 0; $a < count($rspta) ; $a++) { 
            $id_estudiante_programa = $rspta[$a]["id_estudiante"];
        }


        $rspta=$consultaporrenovar->insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha,$hora,$fecha_programada,$hora_programada,$fecha_realizo,$hora_realizo,$periodo_actual,$id_estudiante_programa);
        echo $rspta ? "Tarea Programada" : "Tarea no se pudo Programar";
    break;

    case 'agregar_mostrar_seguimiento':
        
        $data= array();//Vamos a declarar un array
        $data["0"] ="";//iniciamos el arreglo
        $id_credencial=$_POST["id_credencial"];
        $rspta=$consultaporrenovar->vernombreestudiantesinactivos($id_credencial);
        
        for ($a = 0; $a < count($rspta) ; $a++) { 

            $credencial_identificacion = $rspta[$a]["credencial_identificacion"];
            // $nombre_estado = $rspta[$a]["nombre_estado"];
            $id_estudiante_programa = $rspta[$a]["id_credencial"];
        
        $nombre = $rspta[$a]["credencial_apellido"] .' ' . $rspta[$a]["credencial_apellido_2"] .' ' . $rspta[$a]["credencial_nombre"] .' ' . $rspta[$a]["credencial_nombre_2"];

        
            
        }
        $data["0"] .= '
        
        <div class="col-md-12">
                <div id="accordion">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <div class="spinner-grow text-muted spinner-grow-sm"></div> Datos de contacto
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="card-body">
                        
                        
                            <div class="row">
                                <div class="col-xl-6">

                                <dt>Nombre</dt>
                                <dd>'. $nombre. '</dd>
                                
                                </div>
                                <div class="col-xl-6">							
                                <dt>Cédula</dt>
                                <dd>'. $credencial_identificacion. '</dd>
                                
                                
                                </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
            </div>
            </div>';
        $results = array($data);
        echo json_encode($results);
    break;

    case 'verHistorialTabla':
        $id_credencial=$_GET["id_credencial"];
    
        $rspta=$consultaporrenovar->verHistorialTabla($id_credencial);
        //Vamos a declarar un array
        $data= array();
        $reg=$rspta;
    
        for ($i=0;$i<count($reg);$i++){
            $datoasesor=$consultaporrenovar->datosAsesor($reg[$i]["id_usuario"]);
            $nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
            $data[]=array(
                "0"=>$reg[$i]["id_credencial"],
                "1"=>$reg[$i]["motivo_seguimiento"],
                "2"=>$reg[$i]["mensaje_seguimiento"],
                "3"=>$consultaporrenovar->fechaesp($reg[$i]["fecha_seguimiento"]) . ' a las ' . $reg[$i]["hora_seguimiento"],				
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

    case 'verHistorialTablaTareas':
        $id_credencial=$_GET["id_credencial"];
    
        $rspta=$consultaporrenovar->verHistorialTablaTareas($id_credencial);
        //Vamos a declarar un array
        $data= array();
        $reg=$rspta;
    
        for ($i=0;$i<count($reg);$i++){
        $datoasesor=$consultaporrenovar->datosAsesor($reg[$i]["id_usuario"]);
        $nombre_usuario=$datoasesor["usuario_nombre"] . " " . $datoasesor["usuario_apellido"] ;
        
        $data[]=array(
            "0"=>($reg[$i]["estado"]==1)?'Pendiente':'Realizada',
            "1"=>$reg[$i]["motivo_tarea"],
            "2"=>$reg[$i]["mensaje_tarea"],
            "3"=>$consultaporrenovar->fechaesp($reg[$i]["fecha_programada"]) .' a las '. $reg[$i]["hora_programada"],			
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

    case "selectEstadoEgresado":	
		$rspta = $consultaporrenovar->selectEstado();
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre_estado"] . "'>" . $rspta[$i]["nombre_estado"] . "</option>";
				}
	break;
    

    //se muestra la categoria para usarla en el boton de editar
	// case 'mostrar_estados':
	// 	$rspta = $consultaporrenovar->mostrar_estados($id_egresdado_est);
	// 	//Codificar el resultado utilizando json
	// 	echo json_encode($rspta);
	// break;

	//edita el estado del egresado
	case 'guardaryeditarreingreso':
        //traemos el id_estudiante
        $rspta=$consultaporrenovar->vernombreestudiantesinactivos($id_egresdado_est);
        $id_estudiante_programa =0;
        for ($a = 0; $a < count($rspta) ; $a++) { 
            $id_estudiante_programa = $rspta[$a]["id_estudiante"];
        }
        //consulta para validar si tiene un estado o no 
        $consulta_estado = $consultaporrenovar->mostrar_estados($id_egresdado_est);
        $id_estud = $consulta_estado["id_estudiante"];

        if (empty($id_estud)){

            $rspta = $consultaporrenovar->insertarEstadoEgresado($id_reingreso_estado, $id_egresdado_est, $id_estudiante_programa);
            echo $rspta ? "Estado registrado" : "Estado no se pudo registrar";
        }else{

            $rspta = $consultaporrenovar->editarreingreso($id_reingreso_estado, $id_egresdado_est, $id_estudiante_programa);
            echo $rspta ? "Estado actualizado" : "Estado no se pudo actualizar";
        }
	break;

}
?>