<?php 
require "../config/Conexion.php";
require '../calendarapi/vendor/autoload.php';
class OnSeguiTareas
{

	protected $client;
    private $tokenPath;

	public function __construct() {

		$this->client = new Google_Client();
		$this->client->setAuthConfig('../calendarapi/credentials.json'); // Ruta al archivo de credenciales
		// $this->client->setRedirectUri('http://localhost/campus-virtual/vistas/on_segui_tareas.php');//local
		$this->client->setRedirectUri('https://ciaf.digital/vistas/calendar.php');// produccion

		$this->client->addScope('https://www.googleapis.com/auth/calendar.events');
		$this->client->addScope(Google_Service_Calendar::CALENDAR);
		
		$this->client->addScope(Google_Service_Tasks::TASKS);
		$this->client->addScope('https://www.googleapis.com/auth/tasks'); // ⬅ ¡Añadir este scope!

		$this->client->setAccessType('offline'); // Necesario para obtener el refresh token
		$this->client->setPrompt('consent'); // Asegura que se solicite siempre el refresh token
	
		$this->tokenPath = realpath(__DIR__ . '/../calendarapi') . '/'.$_SESSION['usuario_identificacion'].'token.json';// linea que crea el archivo token.json
	  
	}

	public function getClient() {
        return $this->client;
    }

    

	public function authenticate($code) {
        if (file_exists($this->tokenPath)) {
            $accessToken = json_decode(file_get_contents($this->tokenPath), true);
            $this->client->setAccessToken($accessToken);

            if ($this->client->isAccessTokenExpired()) {
                if ($this->client->getRefreshToken()) {
                    $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    
                    file_put_contents($this->tokenPath, json_encode($this->client->getAccessToken()));
                } else {
                    return "El token ha expirado y no se puede renovar automáticamente.";
                }
            }else{
				return "Correcto";
			}
        } else {
            return $this->requestAuthentication($code);
        }
    }

	private function requestAuthentication($code) {
        
        // Verificar si el código de autorización no está presente en la URL
        if ($code=='false') {

            $authUrl = $this->client->createAuthUrl();
            return "<div class='mt-4 pt-4'><img src='../public/img/calendar.webp'><br><br>Para acceder al calendario<br> autentícate con una cuenta <br> @ciaf.edu.co  <br><br> <a href='$authUrl' class='btn btn-primary'> <i class='fa-brands fa-google'></i> Continuar con GOOGLE </a></div>";
        } else {
            // Captura el código de autorización
            $authCode = $code;
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
    
            if (array_key_exists('error', $accessToken)) {
                return "Error durante la autenticación: " . $accessToken['error'];
            }
    
            // Verificar si la carpeta tiene permisos de escritura
            if (!is_writable(dirname($this->tokenPath))) {
                return "La carpeta no tiene permisos de escritura: " . dirname($this->tokenPath);
            }
    
            // Guardar el token
            if (file_put_contents($this->tokenPath, json_encode($accessToken)) === false) {
                return "Error al guardar el archivo token.json en la ruta: " . $this->tokenPath;
            }
    
            return "Autenticación completada. Vuelve a cargar la página.";
        }
    }
    
  
	
	public function VerHistorial($id_estudiante)
	{	
		$sql="SELECT * FROM on_interesados oni INNER JOIN on_interesados_datos onid ON oni.id_estudiante=onid.id_estudiante WHERE oni.id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    //Implementamos un método para insertar seguimiento
    public function insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora)
    {
        $sql="INSERT INTO on_seguimiento (id_usuario,id_estudiante,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento)
        VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora')";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    	 //Implementamos un método para actualziar el campo segui
	public function actualizarSegui($id_estudiante)
	{
		$sql="UPDATE on_interesados SET segui=0 WHERE id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		return $consulta->execute();

    }

	//Implementamos un método para insertar una tarea
	public function insertarTarea($id_usuario,$id_estudiante_tarea,$motivo_tarea,$mensaje_tarea,$fecha_registro,$hora_registro,$fecha_programada,$hora_programada,$periodo_actual)
	{
		$sql="INSERT INTO on_interesados_tareas_programadas (id_usuario,id_estudiante,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo)
		VALUES ('$id_usuario','$id_estudiante_tarea','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada',NULL,NULL,'$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
        return $mbd->lastInsertId();
	}

    public function getEvents() {
        $service = new Google_Service_Calendar($this->client);
        $calendarId = 'primary';
        $optParams = [
       
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c', strtotime('-15 days')),  // Obtener eventos desde hace un año
            'timeMax' => date('c', strtotime('+1 year')),  // Obtener eventos hasta un año en el futuro
        ];

        try {
            $results = $service->events->listEvents($calendarId, $optParams);
            return $results->getItems();
        } catch (Exception $e) {
            return "Error al obtener los eventos: " . $e->getMessage();
        }
    }

    public function createEvent($eventoData) {
    
        $service = new Google_Service_Calendar($this->client );
    
        $event = new Google_Service_Calendar_Event($eventoData);
    
        try {
            $calendarId = 'primary'; // ID del calendario
            $createdEvent = $service->events->insert($calendarId, $event);
            return $createdEvent;
        } catch (Exception $e) {
            error_log('Error al crear el evento: ' . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
            return false;
        }
    }

    public function deleteEvent($eventId) {
        $service = new Google_Service_Calendar($this->client);
        $calendarId = 'primary';
    
        try {
            $service->events->delete($calendarId, $eventId);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateEvent($eventId, $eventoData) {
        $service = new Google_Service_Calendar($this->client);
        
        try {
            $calendarId = 'primary'; // ID del calendario
    
            // Obtener el evento existente
            $event = $service->events->get($calendarId, $eventId);
    
            // Actualizar los datos del evento
            if (isset($eventoData['summary'])) {
                $event->setSummary($eventoData['summary']);
            }
            if (isset($eventoData['start'])) {
                $start = new Google_Service_Calendar_EventDateTime();
                $start->setDateTime($eventoData['start']['dateTime']);
                $start->setTimeZone($eventoData['start']['timeZone'] ?? 'America/New_York');  // Zona horaria por defecto
                $event->setStart($start);
            }
            
            if (isset($eventoData['end'])) {
                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime($eventoData['end']['dateTime']);
                $end->setTimeZone($eventoData['end']['timeZone'] ?? 'America/New_York');  // Zona horaria por defecto
                $event->setEnd($end);
            }
            if (isset($eventoData['description'])) {
                $event->setDescription($eventoData['description']);
            }
    
            // Actualizar el evento en Google Calendar
            $updatedEvent = $service->events->update($calendarId, $eventId, $event);
    
            return $updatedEvent;
        } catch (Exception $e) {
            error_log('Error al actualizar el evento: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
    
    function generarTiempos($fecha, $hora, $zonaHoraria = 'America/New_York') {
        // Crear el objeto DateTime para startTime
        $startTime = new DateTime("$fecha $hora", new DateTimeZone($zonaHoraria));
        
        // Clonar el objeto para endTime y sumar 15 minutos
        $endTime = clone $startTime;
        $endTime->modify('+60 minutes');
    
        // Formatear en ISO 8601
        return [
            'startTime' => $startTime->format('Y-m-d\TH:i:sP'),
            'endTime' => $endTime->format('Y-m-d\TH:i:sP')
        ];
    }



}
?>