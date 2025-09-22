<?php
session_start();
date_default_timezone_set("America/Bogota");
require_once "../modelos/OnSeguiTareas.php";
$consulta = new OnSeguiTareas();
$myEmail = $_SESSION['usuario_login'];
$id_usuario = $_SESSION['id_usuario'];
$periodo_actual = $_SESSION['periodo_actual'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');

switch ($_GET['op']) {
    case "autenticaciontarea":
        $code = $_POST["code"];
        $data = []; // Inicializa un arreglo para los eventos
    
        
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
            // Si la autenticación no es correcta, significa que necesitamos un enlace de autenticación
            if ($resultado == "Correcto") {
                // Obtener tareas de Google Tasks
            $service = new Google_Service_Tasks($consulta->getClient()); // Cliente autenticado
            $taskLists = $service->tasklists->listTasklists();

            $data['tasks'] = [];

            foreach ($taskLists->getItems() as $taskList) {
                $tasks = $service->tasks->listTasks($taskList->getId());

                foreach ($tasks->getItems() as $task) {
                    $data['tasks'][] = [
                        'id' => $task->getId(),
                        'title' => $task->getTitle(),
                        'status' => $task->getStatus(), // "needsAction" o "completed"
                        'due' => $task->getDue() ? (new DateTime($task->getDue()))->format('Y-m-d\TH:i:s') : null,
                        'notes' => $task->getNotes(),
                        'taskListId' => $taskList->getId(),
                        'taskListTitle' => $taskList->getTitle(),
                    ];
                }
            }
            
        } else {
            // Si el resultado no es "Correcto", significa que debemos mostrar el enlace de autenticación
            $data = [
                'error' => 'Autenticación fallida',
                'authUrl' => $resultado // Aquí el resultado será el enlace de autenticación
            ];
        }
    
        // Enviar la respuesta como JSON
        echo json_encode($data);
    break;

    case "autenticacion":
        $code = $_POST["code"];
        $data = []; // Inicializa un arreglo para los eventos
    
        
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
        // Si la autenticación no es correcta, significa que necesitamos un enlace de autenticación
        if ($resultado == "Correcto") {

            $data = ['success' => 'Ok' ];

        } else {
            // Si el resultado no es "Correcto", significa que debemos mostrar el enlace de autenticación
            $data = [
                'error' => 'Autenticación fallida',
                'authUrl' => $resultado // Aquí el resultado será el enlace de autenticación
            ];
        }
    
        // Enviar la respuesta como JSON
        echo json_encode($data);
    break;
    

    case 'agregar':
        $id_estudiante = $_POST["id_estudiante"];
        $data = array(); //Vamos a declarar un array
        $data["0"] = ""; //iniciamos el arreglo

        $datos = $consulta->verHistorial($id_estudiante); // consulta para traer los interesados
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


        $data["0"] .= '

            <div class="row col-12 m-0 p-0">
            
                <div class="col-12 m-0 p-0" id="accordion">
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
                                    <dd>' . ($fecha_ingreso) . ' a las ' . $hora_ingreso . ' del ' . $periodo_ingreso . '</dd>
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

    case 'agregarSeguimiento':
        $id_estudiante_agregar = isset($_POST["id_estudiante_agregar"]) ? limpiarCadena($_POST["id_estudiante_agregar"]) : "";
        $motivo_seguimiento = isset($_POST["motivo_seguimiento"]) ? limpiarCadena($_POST["motivo_seguimiento"]) : "";
        $mensaje_seguimiento = isset($_POST["mensaje_seguimiento"]) ? limpiarCadena($_POST["mensaje_seguimiento"]) : "";

        $rspta = $consulta->insertarSeguimiento($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora);
        echo $rspta ? "Seguimiento registrado" : "Seguimiento no se pudo registrar";
        if ($rspta) {
            $actualizarcamposegui = $consulta->actualizarSegui($id_estudiante_agregar);
        }
    break;

    
    case "crearevento":
        $code = $_POST["code"];
        $data = []; // Inicializa un arreglo para los eventos
    
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
        if ($resultado == "Correcto") {
            // Obtener los datos del evento

           $fechainicial=$_POST["fecha_programada"];
           $horainicial=$_POST["hora_programada"];
            
           $tiempos = $consulta->generarTiempos($fechainicial, $horainicial);
           
            $id = $_POST["id"] ?? null;// el id del evento
            $id_estudiante_agregar=$_POST["id_estudiante_tarea"] ?? null;
            $titulo = $_POST["motivo_tarea"] ?? null;
            $descripcion = $_POST["mensaje_tarea"] ?? null;
            $ubicacion = $_POST["ubicacion"] ?? null;
            $fecha_inicio = $tiempos['startTime'] ?? null; // Formato esperado: 'Y-m-d\TH:i:s'
            $fecha_fin = $tiempos['endTime'] ?? null;       // Formato esperado: 'Y-m-d\TH:i:s'
            $zona_horaria = 'America/New_York'; // Verificar si funciona con otra zona horaria

           

            // Validar que los datos requeridos estén presentes
            if (!$titulo || !$fecha_inicio || !$fecha_fin) {
                $data['conte'] .= json_encode(['error' => 'Faltan datos obligatorios']);
                break;
            }
        
            $id_retornado=$consulta->insertarTarea($id_usuario, $id_estudiante_agregar, $titulo, $descripcion, $fecha, $hora, $fechainicial, $horainicial, $periodo_actual);// crear la tarea en base de datos


            // Preparar los detalles del evento
            $evento = [
                'summary'     => $titulo,
                'description' => $descripcion,
                'location'    => $ubicacion,
                'start'       => [
                    'dateTime' => $fecha_inicio,
                    'timeZone' => $zona_horaria,
                ],
                'end'         => [
                    'dateTime' => $fecha_fin,
                    'timeZone' => $zona_horaria,
                ],
                'reminders'   => [
                    'useDefault' => false,
                    'overrides'  => [
                        ['method' => 'email', 'minutes' => 60],  // Recordatorio 1 hora antes
                        ['method' => 'popup', 'minutes' => 10],  // Notificación 10 minutos antes
                    ],
                ],
                'extendedProperties' => [
                    'shared' => [
                        'categoria' => 'admisiones',
                        'idEstudiante' => $id_estudiante_agregar, // Puedes agregar más valores personalizados
                        'idTarea' => $id_retornado // Puedes agregar más valores personalizados
                    ]
                ]
            ];
        
            if ($id==null) {

                // // Intentar crear el evento
                $resultado = $consulta->createEvent($evento);
                        
                if ($resultado) {

                    $data = ['success' => 'ok'];
                    

                } else {
                    $data = ['error' => $evento];
                }

            }else{

                $resultado = $consulta->updateEvent($id, $evento);

                if (isset($resultado['error'])) {
                    $data = ['error' => 'Error al actualizar el evento: ' . $resultado['error']];
                } else {
                    $data = ['success' => 'Evento actualizado correctamente'];
                }
                
                
            }
            
        } else {
            // Mensaje de error si la autenticación no es correcta
            $data = ['error' => 'Autenticación fallida 222'];
        }

        // Enviar la respuesta como JSON
        echo json_encode($data);
        
    break;
    

    
    
    
    
    
    
}
