<?php
session_start();
require_once "../modelos/PorRenovar.php";

$consulta = new PorRenovar();

switch ($_GET['op']) {


    case 'listarescuelas':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $data["mostrar"] .= '
            <div class="row">
                <div class="col-12 pl-4 pt-2">
                    <p class="titulo-2 fs-14">Buscar por:</p>
                </div>
                <div class="col-12 pl-4 mb-2">
                    <div class="row">';
                            
                    $traerescuelas = $consulta->listarescuelas();
                        for ($a = 0; $a < count($traerescuelas); $a++) {

                            
                            $escuela = $traerescuelas[$a]["escuelas"];
                            $color = $traerescuelas[$a]["color"];
                            $color_ingles = $traerescuelas[$a]["color_ingles"];
                            $nombre_corto = $traerescuelas[$a]["nombre_corto"];
                            $id_escuelas = $traerescuelas[$a]["id_escuelas"];

                            if( $id_escuelas==4){// excluir idiomas

                            }else{
                                
                                $data["mostrar"] .= '

                                <div style="width:170px">
                                    <a onclick="listar(' . $id_escuelas . ')" title="ver cifras" class="row pointer m-2">
                                        <div class="col-3 rounded bg-light-'.$color_ingles.'">
                                            <div class="text-red text-center pt-1">
                                                <i class="fa-regular fa-calendar-check fa-2x  text-'.$color_ingles.'" ></i>
                                            </div>
                                            
                                        </div>
                                        <div class="col-9 borde">
                                            <span>Escuela de</span><br>
                                            <span class="titulo-2 fs-12 line-height-16"> ' . $nombre_corto . '</span>
                                        </div>
                                    </a>
                                </div>';
                            }
                                
                        }

                    $data["mostrar"] .= '
                </div>
            </div>
        </div>

            
            ';
        echo json_encode($data);
    break;

    case 'listar':
        // Se toman las variables que vienen del get del datatable
        // $id_programa = $_GET['id_programa'];
        // $semestre=$_GET['semestre'];
        $id_escuela=$_GET['id_escuela'];
        // Se carga el periodo anterior que será el principal 
        // filtro de búsqueda de estudiantes a renovar
        $cargar_periodo = $consulta->cargarPeriodo();
        $periodo_anterior = $cargar_periodo['periodo_anterior'];
        $periodo_actual = $cargar_periodo['periodo_actual'];
        $periodo_pecuniario = $cargar_periodo['periodo_pecuniario'];
        // Se trae la información de la tabla estudiantes para 
        // verificar en las otras tablas según el filtroperro
        $listar_estudiantes = $consulta->listar($id_escuela,$periodo_anterior);
        $resultado = $listar_estudiantes;
        // Bucle para recorrer el resultado de la consulta listar()
        for ($i=0;$i<count($resultado);$i++){
    
            $nom_escuela=$consulta->traer_nom_escuela($resultado[$i]["escuela"]); 
            $nom_programa=$consulta->traer_nom_programa($resultado[$i]["programa"]); 

            $buscarjornada=$consulta->verificarjornada($resultado[$i]["jornada_e"]);

            if($resultado[$i]["escuela"]=='4' || ($resultado[$i]["nivel"] == 3 && $resultado[$i]["graduado"] == 0) || ($resultado[$i]["nivel"] == 7 && $resultado[$i]["graduado"] == 0)){//excluir idiomas

            }else{

                switch ($resultado[$i]["nivel"]) {
                    case 1:
                        $nivelTexto = "Técnico";
                        break;
                    case 2:
                        $nivelTexto = "Tecnólogo";
                        break;
                    case 3:
                        $nivelTexto = "Profesional";
                        break;
                    case 5:
                        $nivelTexto = "Nivelatorios";
                        break;
                    case 7:
                        $nivelTexto = "Laborales";
                        break;
                    default:
                        $nivelTexto = "Desconocido"; // Para valores no reconocidos
                        break;
                }

                $tareas = '<button class="btn bg-lightblue btn-sm" title="Ver seguimientos" data-toggle="modal" onclick="verHistorial(' . $resultado[$i]["id_credencial"] . ')" data-target="#verTareas"><i data-toggle="tooltip" class="fas fa-eye" data-original-title="Ver y Añadir Seguimientos"></i></button>';
                $anadir = '<button class="btn bg-purple btn-sm" title="Nuevo seguimiento o tarea" data-toggle="modal" onclick="agregarTareaSegui(' . $resultado[$i]["id_credencial"] . ', ' . $resultado[$i][$i]["id_persona"] . ')" data-target="#anadirTareas"><i data-toggle="tooltip" class="fa-solid fa-plus data-original-title="Añadir Seguimientos"></i></button>';
                $celular_estudiante = $consulta->traerCelularEstudiante($resultado[$i]["credencial_identificacion"]);
                $mensajes_no_vistos = 0;
                if (isset($celular_estudiante["celular"])) {
                    $estilo_whatsapp = 'btn-success';
                    $numero_celular = $celular_estudiante["celular"];
                    $registro_whatsapp = $consulta->obtenerRegistroWhastapp($numero_celular);
                    $mensajes_no_vistos = isset($registro_whatsapp["mensajes_no_vistos"]) ? $registro_whatsapp["mensajes_no_vistos"] : $mensajes_no_vistos;
                } else {
                    $estilo_whatsapp = 'btn-danger disabled';
                    $numero_celular = '';
                }
                $boton_whatsapp = '
                <button type="button" class="btn ' . $estilo_whatsapp . ' btn-sm position-relative" data-target="#modal_whatsapp" data-toggle="modal" onclick="listarDatos(57' . $numero_celular . ')"> 
                    <i class="fab fa-whatsapp"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        ' . $mensajes_no_vistos . '
                    </span>
                </button>';

                $estadotermino=$resultado[$i]["estado"] = ($resultado[$i]["graduado"] == 1) ? "Activo" : "Termino";
                

                if (isset($resultado[$i]["renovo_financiera"])) {
                    switch ($resultado[$i]["renovo_financiera"]) {
                        case 1:
                            $estadorenovo= "Pendiente";
                            break;
                        case 2:
                            $estadorenovo= "Renovo F";
                            break;
                        case 3:
                            $estadorenovo= "Renovo";
                            break;
                        default:
                        $estadorenovo= "Valor no reconocido";
                    }
                }

                    $datostablaestudiante = $consulta->peridoactivoestudiante($resultado[$i]["mi_id_estudiante"]);  
            
                    
                    $data[]=array(
                    "0"=>$tareas .  $anadir . $boton_whatsapp,
                    "1"=>$resultado[$i]["credencial_identificacion"],
                    "2"=>$resultado[$i]["credencial_apellido"] .' ' . $resultado[$i]["credencial_apellido_2"] .' ' . $resultado[$i]["credencial_nombre"] .' ' . $resultado[$i]["credencial_nombre_2"],
                    "3"=>$nom_programa["nombre"],
                    "4"=>$nivelTexto,
                    "5"=>$estadotermino,
                    "6"=>$resultado[$i]["jornada_e"],
                    "7"=>$resultado[$i]["semestre"],
                    "8"=>$estadorenovo,
                    "9"=>$resultado[$i]["renovo_academica"],
                    "10"=>$resultado[$i]["renovo_academica_semestre"],
                    "11"=>$resultado[$i]["email"],
                    "12"=>$resultado[$i]["celular"],
                    "13"=>$resultado[$i]["periodo"],
                    "14"=>$datostablaestudiante["periodo_activo"],
                    "15"=>'Esc '.@$nom_escuela["escuelas"]

                );

            }

            

        
                        
        }
        $data = isset($data)?$data:array();
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    }

    
?>