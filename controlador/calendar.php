<?php 
require_once "../modelos/Calendar.php";
date_default_timezone_set("America/Bogota");	

$consulta = new Calendario();
$myEmail = $_SESSION['usuario_login'];
$id_usuario = $_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:s');



switch ($_GET["op"]){
    case "autenticacion":
        $code = $_POST["code"];
        $data = []; // Inicializa un arreglo para los eventos
    
        
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
        // Si la autenticación no es correcta, significa que necesitamos un enlace de autenticación
        if ($resultado == "Correcto") {
            // Obtener los eventos
            $listar = $consulta->getEvents();
    
            if (is_array($listar) && !empty($listar)) {
                foreach ($listar as $event) {
                    $start = null;
    
                    // Verificar si la propiedad 'dateTime' está definida
                    if (isset($event->start->dateTime)) {
                        // Convertir a formato ISO 8601 sin zona horaria
                        $start = (new DateTime($event->start->dateTime))->format('Y-m-d\TH:i:s');
                    } elseif (isset($event->start->date)) {
                        // Si es un evento de todo el día, usar la fecha sin hora
                        $start = (new DateTime($event->start->date))->format('Y-m-d');
                    }
    
                    $end = null;
    
                    // Verificar si la propiedad 'dateTime' está definida
                    if (isset($event->end->dateTime)) {
                        // Convertir a formato ISO 8601 sin zona horaria
                        $end = (new DateTime($event->end->dateTime))->format('Y-m-d\TH:i:s');
                    } elseif (isset($event->end->date)) {
                        // Si es un evento de todo el día, usar la fecha sin hora
                        $end = (new DateTime($event->end->date))->format('Y-m-d');
                    }
    
                    $eventId = $event->getId(); // ID único del evento
                    $title = $event->getSummary(); // Título del evento
                    $startDate = $event->getStart()->getDate(); // Fecha de inicio (solo fecha, para eventos de todo el día)
                    $description = $event->description; // Descripción del evento

                    // Verificar si eres el organizador
                    if ($event->organizer->email === $myEmail) {
                        $color="#828bc2";
                    } else {
                        $color="#999";
                    }

                    $buscarconclusiones=$consulta->conclusiones($eventId);
                    $conclusion = $buscarconclusiones["conclusion"] ?? '';
                    $id_calendarconclusion = $buscarconclusiones["id_calendarconclusion"] ?? '';

                    $buscartarea=$consulta->verEstadoTarea($event->extendedProperties->shared['idTarea']);
                    $estadotarea = $buscartarea["estado"] ?? '';

                    // Construye el evento con el formato correcto
                    $data[] = [
                        'id' => $eventId,
                        'title' => $title,
                        'start' => $start,
                        'end' => $end,
                        'fecha' => $startDate,
                        'eventDescription' => $description,
                        'organizerEmail' => $event->organizer->email ?? '',
                        'organizerName' => $event->organizer->displayName ?? '',
                        'meetLink' => $event->hangoutLink ?? '', // Aquí obtienes el enlace de Google Meet
                        'color' => $color,
                        'id_calendarconclusion' => $id_calendarconclusion,
                        'conclusion' => $conclusion,
                        // Accediendo a los valores de extendedProperties.shared
                        'categoria' => $event->extendedProperties->shared['categoria'] ?? '',
                        'idEstudiante' => $event->extendedProperties->shared['idEstudiante'] ?? '',
                        'idTarea' => $event->extendedProperties->shared['idTarea'] ?? '',
                        'estadoTarea' => $estadotarea,
                    ];
                }
            } else {
                // Si no hay eventos, enviar un arreglo vacío
                $data = [];
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
    
    case "crearevento":
        $code = $_POST["code"];
        $data = []; // Inicializa un arreglo para los eventos
    
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
        if ($resultado == "Correcto") {
            // Obtener los datos del evento
            $ubicacion = null;
            $fecha_inicio = "2025-01-20T20:30:45"; // Formato esperado: 'Y-m-d\TH:i:s'
            $fecha_fin = "2025-01-20T21:30:45";       // Formato esperado: 'Y-m-d\TH:i:s'
            // // $zona_horaria = $_POST["zona_horaria"] ?? 'America/Bogota'; // Por defecto
            $zona_horaria = 'America/New_York'; // Verificar si funciona con otra zona horaria

            $id = $_POST["id"] ?? null;// el id del evento
            $titulo = $_POST["eventTitle"] ?? null;
            $descripcion = $_POST["eventDescription"] ?? null;
            $ubicacion = $_POST["ubicacion"] ?? null;
            $fecha_inicio = $_POST["startTime"] ?? null; // Formato esperado: 'Y-m-d\TH:i:s'
            $fecha_fin = $_POST["endTime"] ?? null;       // Formato esperado: 'Y-m-d\TH:i:s'
            $zona_horaria = 'America/New_York'; // Verificar si funciona con otra zona horaria

            // Validar que los datos requeridos estén presentes
            if (!$titulo || !$fecha_inicio || !$fecha_fin) {
                $data['conte'] .= json_encode(['error' => 'Faltan datos obligatorios']);
                break;
            }
        
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
                        'categoria' => 'global',
                        'idEstudiante' => '', // Puedes agregar más valores personalizados
                        'idTarea' => ''// Puedes agregar más valores personalizados
                    ]
                ],
            ];
        
            if ($id==null) {

                // // Intentar crear el evento
                $resultado = $consulta->createEvent($evento);
                        
                if ($resultado) {
                    $data = ['success' => 'ok'];
                } else {
                    $data = ['error' => 'error'];
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

    case "deleteEvent":
        $code = $_POST["code"];
        $data = []; // Inicializa un arreglo para los eventos
    
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
        if ($resultado == "Correcto") {
            $eventId = $_POST['eventId'];

            // Llama a la función para eliminar el evento
            $result = $consulta->deleteEvent($eventId);
        
            if ($result) {
                $data = ['success' => "ok"];
            } else {
                $data = ['error' => 'Error al eliminar el evento'];
            }

        } else {
            // Mensaje de error si la autenticación no es correcta
            $data = ['error' => 'Autenticación fallida 222'];
        }

    
        // Enviar la respuesta como JSON
        echo json_encode($data);
        
    break;

    case "conclusion":
       
        $data = []; // Inicializa un arreglo para los eventos
        
        $id_calendarconclusion = $_POST["id_calendarconclusion"] ?? null;
        $titulo= $_POST["titulo2"] ?? null;
        $eventid= $_POST["id2"] ?? null;
        $conclusion = $_POST["conclusion"] ?? null;
        if($id_calendarconclusion == ''){
            $insertar = $consulta->insertarConclusion($eventid, $titulo,$conclusion, $fecha, $id_usuario);
            if ($insertar) { // Si insertarConclusion devuelve true o un valor válido
                $data = ['success' => 'Registrada'];
            } else {
                $data = ['error' => 'No se pudo registrar'];
            }
        }else{
            $actualizar = $consulta->actualizarConclusion($id_calendarconclusion,$titulo, $conclusion, $fecha, $id_usuario);
            if ($actualizar) { // Si actualizarConclusion devuelve true o un valor válido
                $data = ['success' => 'actualizada'];
            } else {
                $data = ['error' => 'No se pudo actualizar'];
            }
            
        }

        

        // Enviar la respuesta como JSON
        echo json_encode($data);
        
    break;

    case "creartarea":
        $code = $_POST["code"];
    
        // Autenticar al usuario
        $resultado = $consulta->authenticate($code);
    
        if ($resultado == "Correcto") {
            // Obtener los datos de la tarea
            $titulo = $_POST["taskTitle"] ?? null;
            $descripcion = $_POST["taskDescription"] ?? null;
            $fecha_vencimiento = $_POST["dueDate"] ?? null; // Formato: 'Y-m-d\TH:i:s\Z'
            $id_lista = "@default"; // ID de la lista de tareas (puedes usar "@default" para la predeterminada)
    
            // Validar que los datos requeridos estén presentes
            if (!$titulo) {
                $data = ['error' => 'Faltan datos obligatorios'];
                break;
            }
    
            // Preparar los detalles de la tarea
            $tarea = [
                'title'       => $titulo,
                'notes'       => $descripcion,
                'due'         => $fecha_vencimiento ? date("c", strtotime($fecha_vencimiento)) : null, // Convierte a formato ISO 8601
            ];
    
            // Intentar crear la tarea
            $resultado = $consulta->createTask($id_lista, $tarea);
    
            if ($resultado) {
                $data = ['success' => 'Tarea creada correctamente'];
            } else {
                $data = ['error' => 'Error al crear la tarea'];
            }
        } else {
            // Mensaje de error si la autenticación no es correcta
            $data = ['error' => 'Autenticación fallida'];
        }
    
        // Enviar la respuesta como JSON
        echo json_encode($data);
    break;

    case 'validarTarea':
        $id_tarea = $_POST['tareacodigo'];
        $consulta->validarTarea($id_tarea,$hora,$fecha);
    break;
    
    
    

}


    