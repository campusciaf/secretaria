<?php
// Se incluye el archivo de conexión a la base de datos
require "../config/Conexion.php";

Class Consultaporrenovar{
    // Implementamos nuestro constructor
    public function __construct()
    {
        
    }
    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

    // public function consulta_desercion($identificacion){
    //     global $mbd;
    //     $sql = "SELECT * FROM `on_interesados` WHERE `identificacion` = :identificacion";
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":identificacion", $identificacion);
    //     $consulta->execute();
    //     $registros = $consulta->fetch(PDO::FETCH_ASSOC);
    //     return $registros;
    // }

    public function consulta_id_credencial($credencial_identificacion){	
        $sql="SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE ce.credencial_identificacion = :credencial_identificacion";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        // $resultado = $consulta->fetchAll();


        return $resultado;
    }

    public function vernombreestudiantesinactivos($id_credencial){
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE ce.id_credencial = :id_credencial";
        global $mbd;
        
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado; 
    }


    //Implementamos un método para insertar seguimiento del estudiante inactivo
    public function insertarSeguimiento($id_usuario,$id_estudiante_agregar,$motivo_seguimiento,$mensaje_seguimiento,$fecha,$hora,$id_estudiante){
        $sql="INSERT INTO estudiante_seguimiento (id_usuario,id_credencial,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento,id_estudiante)
        VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora','$id_estudiante')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    //Implementamos un método para actualziar el campo segui
    public function actualizarSegui($id_estudiante){
        $sql="UPDATE on_interesados SET segui=0 WHERE id_estudiante= :id_estudiante";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        return $consulta->execute();

    }

    //Implementar un método para listar el historial de seguimiento
    public function verHistorialTabla($id_credencial){	
        $sql="SELECT * FROM estudiante_seguimiento WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para eliminar el interesado
    public function datosAsesor($id_usuario){
        $sql="SELECT * FROM usuario WHERE id_usuario= :id_usuario"; 
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;

    }

    public function fechaesp($date) {
        $dia 	= explode("-", $date, 3);
        $year 	= $dia[0];
        $month 	= (string)(int)$dia[1];
        $day 	= (string)(int)$dia[2];
        $dias 		= array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia 	= $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
    }


    //Implementar un método para listar el historial de seguimiento
    public function verHistorialTablaTareas($id_credencial){	
        $sql="SELECT * FROM estudiante_tareas_programadas WHERE id_credencial= :id_credencial";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementamos un método para insertar una tarea
    public function insertarTarea($id_usuario, $id_estudiante_tarea, $motivo_tarea, $mensaje_tarea, $fecha_registro, $hora_registro, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual, $id_estudiante) {
        $sql = "INSERT INTO estudiante_tareas_programadas 
            (id_usuario, id_credencial, motivo_tarea, mensaje_tarea, fecha_registro, hora_registro, fecha_programada, hora_programada, fecha_realizo, hora_realizo, periodo, id_estudiante)
            VALUES (:id_usuario, :id_credencial, :motivo_tarea, :mensaje_tarea, :fecha_registro, :hora_registro, :fecha_programada, :hora_programada, :fecha_realizo, :hora_realizo, :periodo, :id_estudiante)";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
    
        // Configurar parámetros
        $consulta->bindParam(':id_usuario', $id_usuario);
        $consulta->bindParam(':id_credencial', $id_estudiante_tarea);
        $consulta->bindParam(':motivo_tarea', $motivo_tarea);
        $consulta->bindParam(':mensaje_tarea', $mensaje_tarea);
        $consulta->bindParam(':fecha_registro', $fecha_registro);
        $consulta->bindParam(':hora_registro', $hora_registro);
        $consulta->bindParam(':fecha_programada', $fecha_programada);
        $consulta->bindParam(':hora_programada', $hora_programada);
    
        // Manejar valores NULL para `fecha_realizo` y `hora_realizo`
        if ($fecha_realizo === NULL) {
            $consulta->bindValue(':fecha_realizo', NULL, PDO::PARAM_NULL);
        } else {
            $consulta->bindParam(':fecha_realizo', $fecha_realizo);
        }
    
        if ($hora_realizo === NULL) {
            $consulta->bindValue(':hora_realizo', NULL, PDO::PARAM_NULL);
        } else {
            $consulta->bindParam(':hora_realizo', $hora_realizo);
        }
    
        $consulta->bindParam(':periodo', $periodo_actual);
        $consulta->bindParam(':id_estudiante', $id_estudiante);
    
        return $consulta->execute();
    }
    
    

    //Implementar un método para listar los estados de los egresados
	public function selectEstado(){	
		$sql="SELECT * FROM reingreso_estados";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementamos un método para editar el estado del egresado
	public function editarreingreso($nombre_estado, $id_credencial, $id_estudiante){
		$sql="UPDATE `seguimiento_reingreso` SET `nombre_estado` = '$nombre_estado', `id_credencial` = '$id_credencial' , `id_estudiante` = '$id_estudiante' WHERE `id_credencial` = $id_credencial";
		
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		return $consulta;	
	}

    //Implementamos un método para agregar un proyecto
	public function insertarEstadoEgresado($nombre_estado, $id_credencial,$id_estudiante){
		global $mbd;
		$sql="INSERT INTO `seguimiento_reingreso`(`nombre_estado`, `id_credencial`, `id_estudiante`) VALUES('$nombre_estado', '$id_credencial', '$id_estudiante')";
		// echo $sql;  
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


    // muestra la categoria por id 
	public function mostrar_estados($id_credencial){
		global $mbd;
		$sql = "SELECT * FROM `seguimiento_reingreso` WHERE `id_credencial` = :id_credencial";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
}
?>