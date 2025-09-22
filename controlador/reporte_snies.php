<?php
session_start();
require_once "../modelos/ReporteSnies.php";
date_default_timezone_set("America/Bogota");

$year=date('Y');

$reporte_snies = new ReporteSnies();
$op = (isset($_GET['op']))?$_GET['op']:'mostrar';

$estrato_arr = ["No informa", "Bajo-bajo", "Bajo", "Medio-bajo", "Medio", "Medio-alto", "Alto", "Sin estrato"];
switch ($op) {
    case 'generarReporte':
        // Cargar los datos del periodo actual
        $opcion = $_GET['opcion'];
        $cargarDatosPeriodo = $reporte_snies->cargarDatosPeriodo();
        $datosPeriodo = $cargarDatosPeriodo;
        $periodo_actual = $datosPeriodo['periodo_actual'];
        $semestre_actual = $datosPeriodo['semestre_actual'];
        $id_tipo_documento = "";
        $sexo_biologico = "";
        $id_estado_civil = "";
        $nombre_etnico = "";
        $nombre_etnico_negros = "";	
        $nombre_etnico_indigena	= "";
        $id_grupo_etnico = "";
        $categoria = "";
        $id_zona_residencia = "";
        $data= Array();
        
        // Si la opción seleccionada en el select es inscritos, relación inscritos
        if ($opcion == "Inscritos - Relación de Inscritos") {
            $cargarRelacionInscritos = $reporte_snies->cargarRelacionInscritos($periodo_actual);
            $datosEstudiante = $cargarRelacionInscritos;
            for ($i=0; $i < count($datosEstudiante) ; $i++) { 
                $id_credencial = $datosEstudiante[$i]['id_credencial'];
                $programa = $datosEstudiante[$i]['fo_programa'];
                $jornada = $datosEstudiante[$i]['jornada_e'];
                $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                // Cargar datos de la credencial del estudiante
                $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_nombre' => '','credencial_nombre_2' => '','credencial_apellido' => '' ,'credencial_apellido_2' => '', 'credencial_identificacion' => '');
                $nombre_1 = $datosCredencial['credencial_nombre'];
                $nombre_1 = strtoupper($nombre_1);
                $nombre_2 = $datosCredencial['credencial_nombre_2'];
                $nombre_2 = strtoupper($nombre_2);
                $apellido_1 = $datosCredencial['credencial_apellido'];
                $apellido_1 = strtoupper($apellido_1);
                $apellido_2 = $datosCredencial['credencial_apellido_2'];
                $apellido_2  = strtoupper($apellido_2);
                $documento = $datosCredencial['credencial_identificacion'];

                // Cargar los datos personales del estudiante
                $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '','genero' => '');
                
                // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                $tipo_documento = $datosPersonales['tipo_documento'];
                if ($tipo_documento == "Cédula de Ciudadanía") {
                    $id_tipo_documento = "CC";
                } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                    $id_tipo_documento = "DE";
                } elseif ($tipo_documento == "Cédula de Extranjería") {
                    $id_tipo_documento = "CE";
                } elseif ($tipo_documento == "Tarjeta de Identidad") {
                    $id_tipo_documento = "TI";
                } elseif ($tipo_documento == "Pasaporte") {
                    $id_tipo_documento = "PS";
                } elseif ($tipo_documento == "Certificado cabildo") {
                    $id_tipo_documento = "CA";
                } else {
                    $id_tipo_documento = "";
                }

                // Cargamos el género y establecemos el código para el reporte según corresponda
                $genero = $datosPersonales['genero'];
                if ($genero == "Masculino") {
                    $sexo_biologico = 1;
                } else if ($genero == "Femenino") {
                    $sexo_biologico = 2;
                } 

                // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                $data[]=array(
                    "0"=>'',
                    "1"=>$year,
                    "2"=>$semestre_actual,
                    "3"=>$id_tipo_documento,
                    "4"=>$documento,
                    "5"=>$nombre_1,
                    "6"=>$nombre_2,
                    "7"=>$apellido_1,
                    "8"=>$apellido_2,
                    "9"=>$sexo_biologico,
                    "10"=>$programa,
                    "11"=>$jornada,
                    "12"=>$semestre_estudiante
                    );
                // Vaciamos las variables a definir con condicional
                $sexo_biologico = '';
                $id_tipo_documento = '';
            }
            $data = isset($data)?$data:array();
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        } elseif ($opcion == "Inscrito Programa") {
            $cargarRelacionInscritos = $reporte_snies->cargarRelacionInscritos($periodo_actual);
            $datosEstudiante = $cargarRelacionInscritos;
            for ($i=0; $i < count($datosEstudiante) ; $i++) {
                $id_credencial = $datosEstudiante[$i]['id_credencial'];
                $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                $programa = $datosEstudiante[$i]['fo_programa'];
                $jornada = $datosEstudiante[$i]['jornada_e'];
                $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                // Cargar datos de la credencial del estudiante
                $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_identificacion' => '');
                $documento = $datosCredencial['credencial_identificacion'];

                // Cargar los datos personales del estudiante
                $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '');
                // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                $tipo_documento = $datosPersonales['tipo_documento'];
                if ($tipo_documento == "Cédula de Ciudadanía") {
                    $id_tipo_documento = "CC";
                } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                    $id_tipo_documento = "DE";
                } elseif ($tipo_documento == "Cédula de Extranjería") {
                    $id_tipo_documento = "CE";
                } elseif ($tipo_documento == "Tarjeta de Identidad") {
                    $id_tipo_documento = "TI";
                } elseif ($tipo_documento == "Pasaporte") {
                    $id_tipo_documento = "PS";
                } elseif ($tipo_documento == "Certificado cabildo") {
                    $id_tipo_documento = "CA";
                } else {
                    $id_tipo_documento = "";
                }

                // Cargar los datos del programa del estudiante
                $cargarDatosPrograma = $reporte_snies->cargarDatosPrograma($id_programa_ac);
                $datosPrograma = ($cargarDatosPrograma)?$cargarDatosPrograma:array("cod_snies" => 0); 
                $cod_snies = $datosPrograma['cod_snies'];

                // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                $data[]=array(
                    "0"=>'',
                    "1"=>$year,
                    "2"=>$semestre_actual,
                    "3"=>$id_tipo_documento,
                    "4"=>$documento,
                    "5"=>$cod_snies,
                    "6"=>"66001",
                    "7"=>$programa,
                    "8"=>$jornada,
                    "9"=>$semestre_estudiante
                    );
                // Vaciamos las variables a definir con condional
                $id_tipo_documento='';
            }
            $data = isset($data)?$data:array();
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        } elseif ($opcion == "Admitidos") {
                $cargarRelacionInscritos = $reporte_snies->cargarRelacionInscritos($periodo_actual);
              
                $datosEstudiante = $cargarRelacionInscritos;
                for ($i=0; $i < count($datosEstudiante) ; $i++) {
                    $id_credencial = $datosEstudiante[$i]['id_credencial'];
                    $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                    $programa = $datosEstudiante[$i]['fo_programa'];
                    $jornada = $datosEstudiante[$i]['jornada_e'];
                    $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                    // Cargar datos de la credencial del estudiante
                    $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                    $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_identificacion' => '');
                    $documento = $datosCredencial['credencial_identificacion'];

                    // Cargar los datos personales del estudiante
                    $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                    // print_r($cargarDatosPersonales);
                    $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '','celular' => '','email'=> '');
                    $celular = $datosPersonales['celular'];
                    $email = $datosPersonales['email'];
                    $estrato = $datosPersonales['estrato'];
                    $fecha_nacimiento = $datosPersonales['fecha_nacimiento'];
                    // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                    $tipo_documento = $datosPersonales['tipo_documento'];
                    if ($tipo_documento == "Cédula de Ciudadanía") {
                        $id_tipo_documento = "CC";
                    } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                        $id_tipo_documento = "DE";
                    } elseif ($tipo_documento == "Cédula de Extranjería") {
                        $id_tipo_documento = "CE";
                    } elseif ($tipo_documento == "Tarjeta de Identidad") {
                        $id_tipo_documento = "TI";
                    } elseif ($tipo_documento == "Pasaporte") {
                        $id_tipo_documento = "PS";
                    } elseif ($tipo_documento == "Certificado cabildo") {
                        $id_tipo_documento = "CA";
                    } else {
                        $id_tipo_documento = "";
                    }

                    // Cargar los datos del programa del estudiante
                    $cargarDatosPrograma = $reporte_snies->cargarDatosPrograma($id_programa_ac);
                    $datosPrograma = ($cargarDatosPrograma)?$cargarDatosPrograma:array("cod_snies" => 0); 
                    $cod_snies = $datosPrograma['cod_snies'];

                    // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                    $data[]=array(
                        "0"=>'',
                        "1"=>$year,
                        "2"=>$semestre_actual,
                        "3"=>$id_tipo_documento,
                        "4"=>$documento,
                        "5"=>$cod_snies,
                        "6"=>"66001",
                        "7"=>$celular,
                        "8"=>$email,
                        "9"=>$fecha_nacimiento,
                        "10"=>($estrato == 9 || $estrato == "")?"No Informa":$estrato_arr[$estrato],
                        "11"=>$programa,
                        "12"=>$jornada,
                        "13"=>$semestre_estudiante
                        );
                    // Vaciamos las variables a definir con condicional
                    $id_tipo_documento = '';
                }
                $data = isset($data)?$data:array();
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
        } else if ($opcion == "Participante") {
                $cargarRelacionInscritos = $reporte_snies->cargarRelacionInscritos($periodo_actual);
                $datosEstudiante = $cargarRelacionInscritos;
                for ($i=0; $i < count($datosEstudiante) ; $i++) {
                    $id_credencial = $datosEstudiante[$i]['id_credencial'];
                    $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                    $programa = $datosEstudiante[$i]['fo_programa'];
                    $jornada = $datosEstudiante[$i]['jornada_e'];
                    $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                    // Cargar datos de la credencial del estudiante
                    $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                    $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: 
                    array('credencial_nombre' => '',
                        'credencial_nombre_2' => '',
                        'credencial_apellido' => '' ,
                        'credencial_apellido_2' => '', 
                        'credencial_identificacion' => '',
                        'credencial_login' => '');
                    $nombre_1 = $datosCredencial['credencial_nombre'];
                    $nombre_1 = strtoupper($nombre_1);
                    $nombre_2 = $datosCredencial['credencial_nombre_2'];
                    $nombre_2 = strtoupper($nombre_2);
                    $apellido_1 = $datosCredencial['credencial_apellido'];
                    $apellido_1 = strtoupper($apellido_1);
                    $apellido_2 = $datosCredencial['credencial_apellido_2'];
                    $apellido_2  = strtoupper($apellido_2);
                    $documento = $datosCredencial['credencial_identificacion'];
                    $correo_ciaf = $datosCredencial['credencial_login'];

                    // Cargar los datos personales del estudiante
                    $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                    $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: 
                    array('fecha_expedicion' => '', 
                        'estado_civil' => '',
                        'fecha_nacimiento'=>'',
                        'departamento'=>'',
                        'municipio'=>'',
                        'tipo_documento' => '',
                        'genero' => '', 
                        'celular' => '',
                        'email'=> '');

                    $fecha_expedicion = $datosPersonales['fecha_expedicion'];
                    $estado_civil = $datosPersonales['estado_civil'];

                    if($estado_civil == "Soltero(a)" ){
                        $id_estado_civil = '1';
                    } else if($estado_civil == "Casado(a)"){
                        $id_estado_civil = '2';
                    } else if ($estado_civil == "Divorciado(a)") {
                        $id_estado_civil = "3";
                    } else if($estado_civil == "Viudo(a)"){
                        $id_estado_civil = '4';
                    } else if($estado_civil == "Unión Libre"){
                        $id_estado_civil = '5';
                    } else if($estado_civil == "Religioso"){
                        $id_estado_civil = '6';
                    }else if($estado_civil == "Separado(a)" ){
                        $id_estado_civil = '8';
                    } 

                    $fecha_nacimiento = $datosPersonales['fecha_nacimiento'];
                    $departamento = $datosPersonales['departamento_nacimiento'];
                    if (empty($departamento)) {
                        $departamento = 'Risaralda';
                    }
                    $consultar_departamento = $reporte_snies->cargarCodDepartamento($departamento);
                    @$cod_departamento = $consultar_departamento['id_departamento'];      
                    $municipio = empty($datosPersonales['lugar_nacimiento'])?'Pereira':$datosPersonales['lugar_nacimiento'];
                    $cargar_cod_divipola = $reporte_snies->cargarCodDivipola($cod_departamento,$municipio);
                    if($cargar_cod_divipola){
                        $cod_divipola = $cargar_cod_divipola['cod_divipola'];
                    }else{
                        $cod_divipola = '66001';
                    }
                    $celular = $datosPersonales['celular'];
                    $email = $datosPersonales['email'];
                    
                    // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                    $tipo_documento = $datosPersonales['tipo_documento'];
                    if ($tipo_documento == "Cédula de Ciudadanía") {
                        $id_tipo_documento = "CC";
                    } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                        $id_tipo_documento = "DE";
                    } elseif ($tipo_documento == "Cédula de Extranjería") {
                        $id_tipo_documento = "CE";
                    } elseif ($tipo_documento == "Tarjeta de Identidad") {
                        $id_tipo_documento = "TI";
                    } elseif ($tipo_documento == "Pasaporte") {
                        $id_tipo_documento = "PS";
                    } elseif ($tipo_documento == "Certificado cabildo") {
                        $id_tipo_documento = "CA";
                    } else {
                        $id_tipo_documento = "";
                    }

                    // Cargamos el género y establecemos el código para el reporte según corresponda
                    $genero = $datosPersonales['genero'];
                    if ($genero == "Masculino") {
                        $sexo_biologico = 1;
                    } elseif ($genero == "Femenino") {
                        $sexo_biologico = 2;
                    }

                    // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                    $data[]=array(
                        "0"=>'',
                        "1"=>$id_tipo_documento,
                        "2"=>$documento,
                        "3"=>$fecha_expedicion,
                        "4"=>$nombre_1,
                        "5"=>$nombre_2,
                        "6"=>$apellido_1,
                        "7"=>$apellido_2,
                        "8"=>$sexo_biologico,
                        "9"=>$id_estado_civil,
                        "10"=>$fecha_nacimiento,
                        "11"=>"170",
                        "12"=>$cod_divipola,
                        "13"=>$celular,
                        "14"=>$email,
                        "15"=>$correo_ciaf,
                        "16"=>"Carrera 6 #24-56",
                        "17"=>$programa,
                        "18"=>$jornada,
                        "19"=>$semestre_estudiante
                        );
                    // Vaciamos las variables definidas por un condicional
                    $id_estado_civil = '';
                    $id_tipo_documento = '';
                    $sexo_biologico = '';
                    $departamento = '';
                    $cod_divipola = '';
                }
                $data = isset($data)?$data:array();
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
        } else if ($opcion == "Estudiantes de primer curso") {
            $cargarRelacionInscritos = $reporte_snies->cargarRelacionInscritos($periodo_actual);
            $datosEstudiante = $cargarRelacionInscritos;
                for ($i=0; $i < count($datosEstudiante) ; $i++) {
                    $id_credencial = $datosEstudiante[$i]['id_credencial'];
                    $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                    $programa = $datosEstudiante[$i]['fo_programa'];
                    $jornada = $datosEstudiante[$i]['jornada_e'];
                    $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                    // Cargar datos de la credencial del estudiante
                    $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                    $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_identificacion' => '');
                    $documento = $datosCredencial['credencial_identificacion'];

                    // Cargar los datos personales del estudiante
                    $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                    $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '');
					
					$codigo_pruebas=$datosPersonales['codigo_pruebas'];
					
                    // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                    $tipo_documento = $datosPersonales['tipo_documento'];
                    if ($tipo_documento == "Cédula de Ciudadanía") {
                        $id_tipo_documento = "CC";
                    } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                        $id_tipo_documento = "DE";
                    } elseif ($tipo_documento == "Cédula de Extranjería") {
                        $id_tipo_documento = "CE";
                    } elseif ($tipo_documento == "Tarjeta de Identidad") {
                        $id_tipo_documento = "TI";
                    } elseif ($tipo_documento == "Pasaporte") {
                        $id_tipo_documento = "PS";
                    } elseif ($tipo_documento == "Certificado cabildo") {
                        $id_tipo_documento = "CA";
                    } else {
                        $id_tipo_documento = "";
                    }

                    // Hacemos la validación del grupo étnico y nombre étnico
                    $grupo_etnico = $datosPersonales['grupo_etnico'];

                    if($grupo_etnico == "Comunidad negra"){
                        $id_grupo_etnico = "2";
                        $categoria = 1;
                        $nombre_etnico = $datosPersonales['nombre_etnico'];
                        $cargarCodNombreEtnico = $reporte_snies->cargarCodigoEtnico($categoria,$nombre_etnico);
                        @$nombre_etnico_negros = $cargarCodNombreEtnico['codigo'];
                        $nombre_etnico_indigena = "0";
                    } else if($grupo_etnico == "No Informa" || $grupo_etnico == ""){
                        $id_grupo_etnico = "0";
                        $nombre_etnico_indigena = "0";
                        $nombre_etnico_negros = "0";
                    } else if($grupo_etnico == "No pertenece" || $grupo_etnico == "No aplica"){
                            $id_grupo_etnico = "4";
                            $nombre_etnico_indigena = "0";
                            $nombre_etnico_negros =	"0";
                    } else if($grupo_etnico == "Pueblo RROM"){
                        $id_grupo_etnico = "3";
                        $nombre_etnico_indigena = "0";
                        $nombre_etnico_negros = "0";
                    } else if($id_grupo_etnico == "Pueblo indígena"){
                        $id_grupo_etnico = "1";
                        $categoria = 0;
                        $cargarCodNombreEtnico = $reporte_snies->cargarCodigoEtnico($categoria,$nombre_etnico);
                        $nombre_etnico_indigena = $cargarCodNombreEtnico['codigo'];
                        $nombre_etnico_negros = "0";
                    } else {
                        $id_grupo_etnico = "0";
                        $nombre_etnico_indigena = "0";
                        $nombre_etnico_negros = "0";
                    }

                    // Cargar los datos del programa del estudiante
                    $cargarDatosPrograma = $reporte_snies->cargarDatosPrograma($id_programa_ac);
                    $datosPrograma = ($cargarDatosPrograma)?$cargarDatosPrograma:array("cod_snies" => 0); 
                    $cod_snies = $datosPrograma['cod_snies'];


                    // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                    $data[]=array(
                        "0"=>'',
                        "1"=>$year,
                        "2"=>$semestre_actual,
                        "3"=>$id_tipo_documento,
                        "4"=>$documento,
                        "5"=>$cod_snies,
                        "6"=>"66001",
                        "7"=>"VINCULACION",
                        "8"=>$id_grupo_etnico,
                        "9"=>$nombre_etnico_indigena,
                        "10"=>$nombre_etnico_negros,
                        "11"=>"DISCAPACIDAD",
                        "12"=>"TIPO DISCAPACIDAD",
                        "13"=>"CAPACIDAD EXCEPCIONAL",
                        "14"=>$codigo_pruebas,
                        "15"=>$programa,
                        "16"=>$jornada,
                        "17"=>$semestre_estudiante
                    );
                    // Limpiamos variables definidas con condicional
                    $id_tipo_documento = "";
                    $nombre_etnico = "";
                    $nombre_etnico_negros = "";	
                    $nombre_etnico_indigena	= "";
                    $id_grupo_etnico = "";
                    $categoria = "";
                }
                
                $data = isset($data)?$data:array();
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
        } else if ($opcion == "Matriculados") {
            $cargarMatriculados = $reporte_snies->cargarMatriculados($periodo_actual);
            $datosEstudiante = $cargarMatriculados;
                for ($i=0; $i < count($datosEstudiante) ; $i++) {
                    $id_credencial = $datosEstudiante[$i]['id_credencial'];
                    $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                    $programa = $datosEstudiante[$i]['fo_programa'];
                    $jornada = $datosEstudiante[$i]['jornada_e'];
                    $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                    // Cargar datos de la credencial del estudiante
                    $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                    $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_identificacion' => '');
                    $documento = $datosCredencial['credencial_identificacion'];

                    // Cargar los datos personales del estudiante
                    $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                    $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '',"zona_residencia" => '');
                    // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                    $tipo_documento = $datosPersonales['tipo_documento'];

                    if ($tipo_documento == "Cédula de Ciudadanía") {
                        $id_tipo_documento = "CC";
                    } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                        $id_tipo_documento = "DE";
                    } elseif ($tipo_documento == "Cédula de Extranjería") {
                        $id_tipo_documento = "CE";
                    } elseif ($tipo_documento == "Tarjeta de Identidad") {
                        $id_tipo_documento = "TI";
                    } elseif ($tipo_documento == "Pasaporte") {
                        $id_tipo_documento = "PS";
                    } elseif ($tipo_documento == "Certificado cabildo") {
                        $id_tipo_documento = "CA";
                    } else {
                        $id_tipo_documento = "";
                    }

                    $estrato = $datosPersonales['estrato'];
                    // Cargamos la zona de residencia del estudiante para determinar el tipo
                    $zona_residencia = $datosPersonales['zona_residencia'];
                    if ($zona_residencia == "Urbana") {
                        $id_zona_residencia = 1;
                    } else if ($zona_residencia == "Rural") {
                        $id_zona_residencia = 2;
                    } else {
                        $id_zona_residencia = '';
                    }

                    // Cargar los datos del programa del estudiante
                    $cargarDatosPrograma = $reporte_snies->cargarDatosPrograma($id_programa_ac);
                    $datosPrograma = ($cargarDatosPrograma)?$cargarDatosPrograma:array("cod_snies" => 0); 
                    $cod_snies = $datosPrograma['cod_snies'];

                    $fecha_nacimiento = $datosPersonales['fecha_nacimiento'];
                    $departamento = $datosPersonales['departamento_nacimiento'];
                    if (empty($departamento)) {
                        $departamento = 'Risaralda';
                    }
                    $consultar_departamento = $reporte_snies->cargarCodDepartamento($departamento);
                    @$cod_departamento = $consultar_departamento['id_departamento'];      
                    $municipio = empty($datosPersonales['lugar_nacimiento'])?'Pereira':$datosPersonales['lugar_nacimiento'];
                    $cargar_cod_divipola = $reporte_snies->cargarCodDivipola($cod_departamento,$municipio);
                    if($cargar_cod_divipola){
                        $cod_divipola = $cargar_cod_divipola['cod_divipola'];
                    }else{
                        $cod_divipola = '66001';
                    }
                    $celular = $datosPersonales['celular'];
                    $email = $datosPersonales['email'];

                    // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                    $data[]=array(
                        "0"=>'',
                        "1"=>$year,
                        "2"=>$semestre_actual,
                        "3"=>$id_tipo_documento,
                        "4"=>$documento,
                        "5"=>$documento,
                        "6"=>$cod_snies,
                        "7"=>"66001",
                        "8"=>$fecha_nacimiento,
                        "9"=>"170",
                        "10"=>$cod_divipola,
                        "11"=>$id_zona_residencia,
                        "12"=>$estrato,
                        "13"=>"N",
                        "14"=>"",
                        "15"=>"",
                        "16"=>"",
                        "17"=>$celular,
                        "18"=>$email,
                        "19"=>$programa,
                        "20"=>$jornada,
                        "21"=>$semestre_estudiante
                        );
                    // Vaciamos las variables definidas por un condicional
                    $id_tipo_documento = '';
                    $departamento = '';
                    $cod_divipola = '';
                    $id_zona_residencia = '';
                }
                $data = isset($data)?$data:array();
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
        } else if ($opcion == "Materias Matriculado") {
            $cargarMatriculados = $reporte_snies->cargarMatriculados($periodo_actual);
            $datosEstudiante = $cargarMatriculados;
                for ($i=0; $i < count($datosEstudiante) ; $i++) {
                    $id_credencial = $datosEstudiante[$i]['id_credencial'];
                    $id_estudiante = $datosEstudiante[$i]['id_estudiante'];
                    $ciclo = $datosEstudiante[$i]['ciclo'];
                    $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                    $programa = $datosEstudiante[$i]['fo_programa'];
                    $jornada = $datosEstudiante[$i]['jornada_e'];
                    $semestre_estudiante = $datosEstudiante[$i]['semestre_estudiante'];

                    // Cargar datos de la credencial del estudiante
                    $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                    $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_identificacion' => '');
                    $documento = $datosCredencial['credencial_identificacion'];

                    // Cargar los datos personales del estudiante
                    $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                    $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '');
                    // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                    $tipo_documento = $datosPersonales['tipo_documento'];
                    if ($tipo_documento == "Cédula de Ciudadanía") {
                        $id_tipo_documento = "CC";
                    } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                        $id_tipo_documento = "DE";
                    } elseif ($tipo_documento == "Cédula de Extranjería") {
                        $id_tipo_documento = "CE";
                    } elseif ($tipo_documento == "Tarjeta de Identidad") {
                        $id_tipo_documento = "TI";
                    } elseif ($tipo_documento == "Pasaporte") {
                        $id_tipo_documento = "PS";
                    } elseif ($tipo_documento == "Certificado cabildo") {
                        $id_tipo_documento = "CA";
                    } else {
                        $id_tipo_documento = "";
                    }

                    // Cargar los datos del programa del estudiante
                    $cargarDatosPrograma = $reporte_snies->cargarDatosPrograma($id_programa_ac);
                    $datosPrograma = ($cargarDatosPrograma)?$cargarDatosPrograma:array("cod_snies" => 0); 
                    $cod_snies = $datosPrograma['cod_snies'];

                    // Cargar los datos de las materias inscritas y las materias aprobadas
                    $cargarMateriasInscritas = $reporte_snies->cargarMateriasInscritas($id_estudiante,$ciclo,$periodo_actual);
                    $materias_inscritas = count($cargarMateriasInscritas);
                    $cargarMateriasAprobadas =  $reporte_snies->cargarMateriasAprobadas($id_estudiante,$ciclo,$periodo_actual);
                    $materias_aprobadas = count($cargarMateriasAprobadas);

                    // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                    $data[]=array(
                        "0"=>'',
                        "1"=>$year,
                        "2"=>$semestre_actual,
                        "3"=>$id_tipo_documento,
                        "4"=>$documento,
                        "5"=>$cod_snies,
                        "6"=>"66001",
                        "7"=>$materias_inscritas,
                        "8"=>$materias_aprobadas,
                        "9"=>$programa,
                        "10"=>$jornada,
                        "11"=>$semestre_estudiante
                        );
                    // Vaciamos las variables definidas por un condicional
                    $id_tipo_documento = '';
                    $departamento = '';
                    $cod_divipola = '';
                    $id_zona_residencia = '';
                }
                $data = isset($data)?$data:array();
                $results = array(
                    "sEcho"=>1, //Información para el datatables
                    "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                    "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
        } else if ($opcion == "Graduados") {
            $cargarGraduados = $reporte_snies->cargarGraduados($periodo_actual);
            $datosEstudiante = $cargarGraduados;

            for ($i=0; $i < count($datosEstudiante) ; $i++) {
                $id_credencial = $datosEstudiante[$i]['id_credencial'];
                $id_programa_ac = $datosEstudiante[$i]['id_programa_ac'];
                $codigo_pruebas = $datosEstudiante[$i]['pruebas_saber_pro'];
                $acta_grado = $datosEstudiante[$i]['acta_grado'];
                $fecha_grado = $datosEstudiante[$i]['fecha_grado'];
                $folio = $datosEstudiante[$i]['folio'];

                // Cargar datos de la credencial del estudiante
                $cargarDatosCredencial = $reporte_snies->cargarDatosCredencial($id_credencial);
                $datosCredencial = ($cargarDatosCredencial)? $cargarDatosCredencial: array('credencial_identificacion' => '');
                $documento = $datosCredencial['credencial_identificacion'];

                // Cargar los datos personales del estudiante
                $cargarDatosPersonales = $reporte_snies->cargarDatosPersonales($id_credencial);
                $datosPersonales = ($cargarDatosPersonales)? $cargarDatosPersonales: array('tipo_documento' => '','celular' => '', 'email' => '');
                // Cargamos el tipo de documento y establecemos el código para el reporte según corresponda
                $tipo_documento = $datosPersonales['tipo_documento'];
                if ($tipo_documento == "Cédula de Ciudadanía") {
                    $id_tipo_documento = "CC";
                } elseif ($tipo_documento == "Documento de Identidad Extranjera") {
                    $id_tipo_documento = "DE";
                } elseif ($tipo_documento == "Cédula de Extranjería") {
                    $id_tipo_documento = "CE";
                } elseif ($tipo_documento == "Tarjeta de Identidad") {
                    $id_tipo_documento = "TI";
                } elseif ($tipo_documento == "Pasaporte") {
                    $id_tipo_documento = "PS";
                } elseif ($tipo_documento == "Certificado cabildo") {
                    $id_tipo_documento = "CA";
                } else {
                    $id_tipo_documento = "";
                }
                
                $celular = $datosPersonales['celular'];
                $email = $datosPersonales['email'];

                // Cargar los datos del programa del estudiante
                $cargarDatosPrograma = $reporte_snies->cargarDatosPrograma($id_programa_ac);
                $datosPrograma = ($cargarDatosPrograma)?$cargarDatosPrograma:array("cod_snies" => 0); 
                $cod_snies = $datosPrograma['cod_snies'];

                // Llenamos el arreglo donde irán las variables que se mostrarán en el datatable		   
                $data[]=array(
                    "0"=>'',
                    "1"=>$year,
                    "2"=>$semestre_actual,
                    "3"=>$id_tipo_documento,
                    "4"=>$documento,
                    "5"=>$cod_snies,
                    "6"=>"66001",
                    "7"=>$email,
                    "8"=>$celular,
                    "9"=>$codigo_pruebas,
                    "10"=>$acta_grado,
                    "11"=>$fecha_grado,
                    "12"=>$folio
                    );
                // Vaciamos las variables definidas por un condicional
                $id_tipo_documento = '';
            }
            $data = isset($data)?$data:array();
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        }
        break;
}
?>