<?php 
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Class PeaDocente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	

	
		//Implementamos un método para insertar las actividades
	public function insertar($id_tema,$id_docente_grupo,$nombre_actividad,$descripcion_actividad,$tipo_archivo,$archivo_actividad,$fecha_actividad,$hora_actividad,$id_usuario)
	{
		$sql="INSERT INTO pea_actividades (id_tema,id_docente_grupo,nombre_actividad,descripcion_actividad,tipo_archivo,archivo_actividad,fecha_actividad,hora_actividad,id_docente)
		VALUES ('$id_tema','$id_docente_grupo','$nombre_actividad','$descripcion_actividad','$tipo_archivo','$archivo_actividad','$fecha_actividad','$hora_actividad','$id_usuario')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		//echo $sql;
		
	}

	//Implementamos un método para insertar una carpeta
	public function insertarCarpeta($id_pea_docentes,$carpeta,$fecha,$hora)
	{
		$sql="INSERT INTO pea_documento_carpeta (id_pea_docentes,carpeta,fecha,hora)
		VALUES ('$id_pea_docentes','$carpeta','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para insertar una carpeta
	public function insertarCarpetaEjercicios($id_pea_docentes,$carpeta_ejercicios,$fecha,$hora)
	{
		$sql="INSERT INTO pea_ejercicios_carpeta (id_pea_docentes,carpeta_ejercicios,fecha,hora)
		VALUES ('$id_pea_docentes','$carpeta_ejercicios','$fecha','$hora')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para insertar una carpeta
	public function insertarDocumento($id_pea_docentes,$id_tema,$nombre_documento,$descripcion_documento,$tipo_archivo,$archivo_documento,$fecha_respuesta,$hora_respuesta,$ciclo,$condicion_finalizacion_documento, $tipo_condicion_documento, $fecha_inicio_documento, $fecha_limite_documento,$porcentaje_documento,$otorgar_puntos_documento,$puntos_actividad_documento)
	{
		$sql="INSERT INTO pea_documentos (id_pea_docentes,id_tema,nombre_documento,descripcion_documento,tipo_archivo,archivo_documento,fecha_actividad,hora_actividad,ciclo,condicion_finalizacion_documento, tipo_condicion_documento, fecha_inicio_documento, fecha_limite_documento,porcentaje_documento,otorgar_puntos_documento,puntos_actividad_documento)
		VALUES ('$id_pea_docentes','$id_tema','$nombre_documento','$descripcion_documento','$tipo_archivo','$archivo_documento','$fecha_respuesta','$hora_respuesta','$ciclo','$condicion_finalizacion_documento', '$tipo_condicion_documento', '$fecha_inicio_documento', '$fecha_limite_documento','$porcentaje_documento','$otorgar_puntos_documento','$puntos_actividad_documento')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para insertar una carpeta
	public function insertarVideo($id_pea_docentes,$id_tema,$titulo_video,$descripcion_video,$video,$fecha_video,$hora_video,$ciclo,$condicion_finalizacion_video, $tipo_condicion_video, $fecha_inicio_video, $fecha_limite_video,$porcentaje_video,$otorgar_puntos_video,$puntos_actividad_video)
	{
		$sql="INSERT INTO pea_videos (id_pea_docentes,id_tema,titulo_video,descripcion_video,video,fecha_video,hora_video,ciclo,condicion_finalizacion_video, tipo_condicion_video, fecha_inicio_video, fecha_limite_video,porcentaje_video,otorgar_puntos_video,puntos_actividad_video)
		VALUES ('$id_pea_docentes','$id_tema','$titulo_video','$descripcion_video','$video','$fecha_video','$hora_video','$ciclo','$condicion_finalizacion_video', '$tipo_condicion_video', '$fecha_inicio_video', '$fecha_limite_video','$porcentaje_video','$otorgar_puntos_video','$puntos_actividad_video')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	public function saveQuestionVideo($tiempo,$pregunta,$video,$tipo) {
		global $mbd;

		$docente = $_SESSION["id_usuario"];

		$sql = "INSERT INTO `pea_preguntas_video`(`id_docente`, `id_video`, `tiempo_segundos`, `pregunta`, `tipo_pregunta`) VALUES(:docente, :video, :tiempo, :pregunta, :tipo);";
        
        $consulta = $mbd->prepare($sql);

		$consulta->bindParam(":docente", $docente);
		$consulta->bindParam(":tiempo", $tiempo);
		$consulta->bindParam(":pregunta", $pregunta);
		$consulta->bindParam(":video", $video);
		$consulta->bindParam(":tipo", $tipo);


        if ($consulta->execute()) {
            return($mbd->lastInsertId());
        } else {
			$error = $consulta->errorInfo();
			print_r($error);
			echo("error");
            return FALSE;
        }
	}

	public function editQuestionVideo($id_pregunta, $pregunta, $tipo) {
		global $mbd;

		$sql = "UPDATE pea_preguntas_video SET pregunta = :pregunta, tipo_pregunta = :tipo WHERE id = :id_pregunta";

		$consulta = $mbd->prepare($sql);

		$consulta->bindParam(":id_pregunta", $id_pregunta);
		$consulta->bindParam(":pregunta", $pregunta);
		$consulta->bindParam(":tipo", $tipo);

		return $consulta->execute();
	}

	public function deleteQuestionVideo($id_pregunta)
	{
		$sql="DELETE FROM pea_preguntas_video WHERE id = :id_pregunta;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pregunta", $id_pregunta);
		return $consulta->execute();
	}

	public function getQuestionsVideo($video) {
		global $mbd;

		$sql = "SELECT * 
            FROM pea_preguntas_video 
            WHERE id_video = :video
            ORDER BY tiempo_segundos ASC;";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":video", $video);
		$consulta->execute();

		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

		return $resultado;
	}

	public function getRequetsVideo($video, $id_estudiante) {
		global $mbd;

		$sql = "SELECT vr.*, pv.pregunta, pv.tiempo_segundos, pv.tipo_pregunta
				FROM pea_videos_respuestas vr
				INNER JOIN pea_preguntas_video pv
					ON vr.id_pea_pregunta = pv.id
				WHERE pv.id_video = :video
				AND vr.id_estudiante = :id_estudiante
				ORDER BY pv.tiempo_segundos ASC;";

		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":video", $video);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();

		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}



	


	//Implementamos un método para insertar una ejercicio
	public function insertarEjercicio($id_pea_ejercicios_carpeta,$nombre_ejercicios,$descripcion_ejercicios,$tipo_archivo_ejercicios,$archivo_ejercicios,$fecha_inicio,$fecha_entrega,$fecha_publicacion,$hora_publicacion,$ciclo,$por_ejercicios)
	{
		$sql="INSERT INTO pea_ejercicios (id_pea_ejercicios_carpeta,nombre_ejercicios,descripcion_ejercicios,tipo_archivo,archivo_ejercicios,fecha_inicio,fecha_entrega,fecha_publicacion,hora_publicacion,ciclo,por_ejercicios)
		VALUES ('$id_pea_ejercicios_carpeta','$nombre_ejercicios','$descripcion_ejercicios','$tipo_archivo_ejercicios','$archivo_ejercicios','$fecha_inicio','$fecha_entrega','$fecha_publicacion','$hora_publicacion','$ciclo','$por_ejercicios')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		
		
	}

	//Implementamos un método para insertar una carpeta
	public function insertarEnlace($id_pea_docentes,$id_tema_enlace,$titulo_enlace,$descripcion_enlace,$enlace,$fecha_enlace,$hora_enlace,$condicion_finalizacion_enlace, $tipo_condicion_enlace, $fecha_inicio_enlace, $fecha_limite_enlace,$porcentaje_enlace,$otorgar_puntos_enlace,$puntos_actividad_enlace,$ciclo)
	{
		$sql="INSERT INTO pea_enlaces (id_pea_docentes,id_tema,titulo_enlace,descripcion_enlace,enlace,fecha_enlace,hora_enlace,condicion_finalizacion_enlace, tipo_condicion_enlace, fecha_inicio_enlace, fecha_limite_enlace,porcentaje_enlace,otorgar_puntos_enlace,puntos_actividad_enlace,ciclo)
		VALUES ('$id_pea_docentes','$id_tema_enlace','$titulo_enlace','$descripcion_enlace','$enlace','$fecha_enlace','$hora_enlace','$condicion_finalizacion_enlace', '$tipo_condicion_enlace', '$fecha_inicio_enlace', '$fecha_limite_enlace','$porcentaje_enlace','$otorgar_puntos_enlace','$puntos_actividad_enlace','$ciclo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		
		
	}

	//Implementamos un método para insertar una glosario
	public function insertarGlosario($id_pea_docentes,$id_tema_glosario,$titulo_glosario,$definicion_glosario,$fecha_glosario,$hora_glosario,$otorgar_puntos_glosario,$puntos_actividad_glosario,$ciclo)
	{
		$sql="INSERT INTO pea_glosario (id_pea_docentes,id_tema,titulo_glosario,definicion_glosario,fecha_glosario,hora_glosario,otorgar_puntos_glosario,puntos_actividad_glosario,ciclo)
		VALUES ('$id_pea_docentes','$id_tema_glosario','$titulo_glosario','$definicion_glosario','$fecha_glosario','$hora_glosario','$otorgar_puntos_glosario','$puntos_actividad_glosario','$ciclo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		
		
	}

	
	
		//Implementamos un método para editar las actividades del pea docente
	public function editar($id_pea_actividades,$nombre_actividad,$descripcion_actividad,$archivo_actividad,$fecha_actividad,$hora_actividad)
	{
		$sql="UPDATE pea_actividades SET nombre_actividad='$nombre_actividad', descripcion_actividad='$descripcion_actividad', archivo_actividad='$archivo_actividad', fecha_actividad='$fecha_actividad', hora_actividad='$hora_actividad' WHERE id_pea_actividades='$id_pea_actividades'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar la carpeta
	public function editarCarpeta($id_pea_documento_carpeta,$carpeta)
	{
		$sql="UPDATE pea_documento_carpeta SET carpeta='$carpeta' WHERE id_pea_documento_carpeta='$id_pea_documento_carpeta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

	//Implementamos un método para editar la carpeta
	public function editarCarpetaEjercicios($id_pea_ejercicios_carpeta,$carpeta_ejercicios)
	{
		$sql="UPDATE pea_ejercicios_carpeta SET carpeta_ejercicios='$carpeta_ejercicios' WHERE id_pea_ejercicios_carpeta='$id_pea_ejercicios_carpeta'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function editarCarpetaDocumento($id_pea_documento_carpeta)
	{
		$sql="SELECT * FROM pea_documento_carpeta WHERE id_pea_documento_carpeta= :id_pea_documento_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_documento_carpeta", $id_pea_documento_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para editar la carpeta de los ejercicios
	public function mostrarCarpetaEjercicios($id_pea_ejercicios_carpeta)
	{
		$sql="SELECT * FROM pea_ejercicios_carpeta WHERE id_pea_ejercicios_carpeta= :id_pea_ejercicios_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_carpeta", $id_pea_ejercicios_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

		//Implementar un método para mostrar los datos de un registro a modificar
	public function editarArchivo($id_pea_documento)
	{
		$sql = "
			SELECT 
				ped.*, 
				pd.id_pea_docentes, 
				dg.id_programa, 
				dg.id_materia, 
				dg.ciclo 
			FROM pea_documentos ped 
			INNER JOIN pea_docentes pd ON ped.id_pea_docentes = pd.id_pea_docentes 
			INNER JOIN docente_grupos dg ON pd.id_docente_grupo = dg.id_docente_grupo 
			WHERE ped.id_pea_documento = :id_pea_documento
		";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_documento", $id_pea_documento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



	//Implementar un método para mostrar los datos de un registro a modificar
	public function editarArchivoEjercicios($id_pea_ejercicios)
	{
		$sql="SELECT * FROM pea_ejercicios WHERE id_pea_ejercicios= :id_pea_ejercicios";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios", $id_pea_ejercicios);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function editarEnlace($id_pea_enlaces)
	{
		$sql = "
			SELECT 
				pe.*, 
				pd.id_pea_docentes, 
				dg.id_programa, 
				dg.id_materia, 
				dg.ciclo 
			FROM pea_enlaces pe 
			INNER JOIN pea_docentes pd ON pe.id_pea_docentes = pd.id_pea_docentes 
			INNER JOIN docente_grupos dg ON pd.id_docente_grupo = dg.id_docente_grupo 
			WHERE pe.id_pea_enlaces = :id_pea_enlaces
		";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_enlaces", $id_pea_enlaces);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	//Implementar un método para mostrar los datos de un registro a modificar

	public function editarGlosario($id_pea_glosario)
	{
		$sql = "
			SELECT 
				pg.*, 
				pd.id_pea_docentes, 
				dg.id_programa, 
				dg.id_materia, 
				dg.ciclo 
			FROM pea_glosario pg 
			INNER JOIN pea_docentes pd ON pg.id_pea_docentes = pd.id_pea_docentes 
			INNER JOIN docente_grupos dg ON pd.id_docente_grupo = dg.id_docente_grupo 
			WHERE pg.id_pea_glosario = :id_pea_glosario
		";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_glosario", $id_pea_glosario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function editarVideo($id_pea_video)
	{
		$sql = "
			SELECT 
				pe.*, 
				pd.id_pea_docentes, 
				dg.id_programa, 
				dg.id_materia, 
				dg.ciclo 
			FROM pea_videos pe 
			INNER JOIN pea_docentes pd ON pe.id_pea_docentes = pd.id_pea_docentes 
			INNER JOIN docente_grupos dg ON pd.id_docente_grupo = dg.id_docente_grupo 
			WHERE pe.id_pea_video = :id_pea_video
		";

		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_video", $id_pea_video);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}



		// Implementar un método para asignar el id a la materia del estudiante
		public function actualizarArchivo(
			$id_pea_documento,
			$nombre_documento,
			$descripcion_documento,
			$archivo_documento,
			$condicion_finalizacion_documento,
			$tipo_condicion_documento,
			$fecha_inicio_documento,
			$fecha_limite_documento,
			$porcentaje_documento,
			$otorgar_puntos_documento,
			$puntos_actividad_documento
		) {
			$sql = "UPDATE pea_documentos SET 
						nombre_documento = :nombre_documento,
						descripcion_documento = :descripcion_documento,
						archivo_documento = :archivo_documento,
						condicion_finalizacion_documento = :condicion_finalizacion_documento,
						tipo_condicion_documento = :tipo_condicion_documento,
						fecha_inicio_documento = :fecha_inicio_documento,
						fecha_limite_documento = :fecha_limite_documento,
						porcentaje_documento = :porcentaje_documento,
						otorgar_puntos_documento = :otorgar_puntos_documento,
						puntos_actividad_documento = :puntos_actividad_documento
					WHERE id_pea_documento = :id_pea_documento";

			global $mbd;
			$consulta = $mbd->prepare($sql);

			$consulta->bindParam(":id_pea_documento", $id_pea_documento);
			$consulta->bindParam(":nombre_documento", $nombre_documento);
			$consulta->bindParam(":descripcion_documento", $descripcion_documento);
			$consulta->bindParam(":archivo_documento", $archivo_documento);
			$consulta->bindParam(":condicion_finalizacion_documento", $condicion_finalizacion_documento);
			$consulta->bindParam(":tipo_condicion_documento", $tipo_condicion_documento);
			$consulta->bindParam(":fecha_inicio_documento", $fecha_inicio_documento);
			$consulta->bindParam(":fecha_limite_documento", $fecha_limite_documento);
			$consulta->bindParam(":porcentaje_documento", $porcentaje_documento);
			$consulta->bindParam(":otorgar_puntos_documento", $otorgar_puntos_documento);
			$consulta->bindParam(":puntos_actividad_documento", $puntos_actividad_documento);

			return $consulta->execute();
		}

	//Implementar un método para asigar el id a la materia del estudiante
	public function actualizarArchivoEjercicios($id_pea_ejercicios,$nombre_ejercicios,$descripcion_ejercicios,$archivo_ejercicios,$fecha_inicio,$fecha_entrega,$fecha_publicacion,$hora_publicacion,$por_ejercicios)
    {
    	$sql="UPDATE pea_ejercicios SET nombre_ejercicios= :nombre_ejercicios, descripcion_ejercicios= :descripcion_ejercicios, archivo_ejercicios= :archivo_ejercicios, fecha_inicio= :fecha_inicio, fecha_entrega= :fecha_entrega, fecha_publicacion= :fecha_publicacion, hora_publicacion= :hora_publicacion, por_ejercicios= :por_ejercicios WHERE id_pea_ejercicios= :id_pea_ejercicios";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios", $id_pea_ejercicios);
		$consulta->bindParam(":nombre_ejercicios", $nombre_ejercicios);
		$consulta->bindParam(":descripcion_ejercicios", $descripcion_ejercicios);
		$consulta->bindParam(":archivo_ejercicios", $archivo_ejercicios);
		$consulta->bindParam(":fecha_inicio", $fecha_inicio);
		$consulta->bindParam(":fecha_entrega", $fecha_entrega);
		$consulta->bindParam(":fecha_publicacion", $fecha_publicacion);
		$consulta->bindParam(":hora_publicacion", $hora_publicacion);
		$consulta->bindParam(":por_ejercicios", $por_ejercicios);
		return $consulta->execute();

    }

	// Implementar un método para asignar el id a la materia del estudiante
	public function actualizarEnlace(
		$id_pea_enlaces,
		$titulo_enlace,
		$descripcion_enlace,
		$enlace,
		$condicion_finalizacion_enlace,
		$tipo_condicion_enlace,
		$fecha_inicio_enlace,
		$fecha_limite_enlace,
		$porcentaje_enlace,
		$otorgar_puntos_enlace,
		$puntos_actividad_enlace
	) {
		$sql = "UPDATE pea_enlaces SET 
					titulo_enlace = :titulo_enlace,
					descripcion_enlace = :descripcion_enlace,
					enlace = :enlace,
					condicion_finalizacion_enlace = :condicion_finalizacion_enlace,
					tipo_condicion_enlace = :tipo_condicion_enlace,
					fecha_inicio_enlace = :fecha_inicio_enlace,
					fecha_limite_enlace = :fecha_limite_enlace,
					porcentaje_enlace = :porcentaje_enlace,
					otorgar_puntos_enlace = :otorgar_puntos_enlace,
					puntos_actividad_enlace = :puntos_actividad_enlace
				WHERE id_pea_enlaces = :id_pea_enlaces";

		global $mbd;
		$consulta = $mbd->prepare($sql);

		$consulta->bindParam(":id_pea_enlaces", $id_pea_enlaces);
		$consulta->bindParam(":titulo_enlace", $titulo_enlace);
		$consulta->bindParam(":descripcion_enlace", $descripcion_enlace);
		$consulta->bindParam(":enlace", $enlace);
		$consulta->bindParam(":condicion_finalizacion_enlace", $condicion_finalizacion_enlace);
		$consulta->bindParam(":tipo_condicion_enlace", $tipo_condicion_enlace);
		$consulta->bindParam(":fecha_inicio_enlace", $fecha_inicio_enlace);
		$consulta->bindParam(":fecha_limite_enlace", $fecha_limite_enlace);
		$consulta->bindParam(":porcentaje_enlace", $porcentaje_enlace);
		$consulta->bindParam(":otorgar_puntos_enlace", $otorgar_puntos_enlace);
		$consulta->bindParam(":puntos_actividad_enlace", $puntos_actividad_enlace);

		return $consulta->execute();
	}


	//Implementar un método para asigar el id a la materia del estudiante
	public function actualizarGlosario($id_pea_glosario,$titulo_glosario,$definicion_glosario,$otorgar_puntos_glosario,$puntos_actividad_glosario)
	{
		$sql="UPDATE pea_glosario SET titulo_glosario= :titulo_glosario, definicion_glosario= :definicion_glosario, otorgar_puntos_glosario = :otorgar_puntos_glosario, puntos_actividad_glosario = :puntos_actividad_glosario WHERE id_pea_glosario= :id_pea_glosario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_glosario", $id_pea_glosario);
		$consulta->bindParam(":titulo_glosario", $titulo_glosario);
		$consulta->bindParam(":definicion_glosario", $definicion_glosario);
		$consulta->bindParam(":otorgar_puntos_glosario", $otorgar_puntos_glosario);
		$consulta->bindParam(":puntos_actividad_glosario", $puntos_actividad_glosario);
		return $consulta->execute();

	}
	

	
// Actualizar un video por id_pea_video
public function actualizarVideo(
    $id_pea_video,
    $id_pea_docentes_video,
    $id_tema_video,
    $titulo_video,
    $descripcion_video,
    $url_video,
    $ciclo_video,
    $condicion_finalizacion_video,
    $tipo_condicion_video,
    $fecha_inicio_video,
    $fecha_limite_video,
    $porcentaje_video,
    $otorgar_puntos_video,
    $puntos_actividad_video
) {
    $sql = "UPDATE pea_videos SET 
                id_pea_docentes        		 = :id_pea_docentes_video,
                id_tema		                 = :id_tema_video,
                titulo_video                 = :titulo_video,
                descripcion_video            = :descripcion_video,
                video  		                 = :url_video,
                ciclo		                 = :ciclo_video,
                condicion_finalizacion_video = :condicion_finalizacion_video,
                tipo_condicion_video         = :tipo_condicion_video,
                fecha_inicio_video           = :fecha_inicio_video,
                fecha_limite_video           = :fecha_limite_video,
                porcentaje_video             = :porcentaje_video,
                otorgar_puntos_video         = :otorgar_puntos_video,
                puntos_actividad_video       = :puntos_actividad_video
            WHERE id_pea_video = :id_pea_video";

    global $mbd;
    $consulta = $mbd->prepare($sql);

    // --- Binds numéricos
    $consulta->bindParam(":id_pea_video", $id_pea_video, PDO::PARAM_INT);
    $consulta->bindParam(":id_pea_docentes_video", $id_pea_docentes_video, PDO::PARAM_INT);
    $consulta->bindParam(":id_tema_video", $id_tema_video, PDO::PARAM_INT);
    $consulta->bindParam(":ciclo_video", $ciclo_video, PDO::PARAM_INT);
    $consulta->bindParam(":porcentaje_video", $porcentaje_video, PDO::PARAM_INT);
    $consulta->bindParam(":otorgar_puntos_video", $otorgar_puntos_video, PDO::PARAM_INT); // 0/1
    $consulta->bindParam(":puntos_actividad_video", $puntos_actividad_video, PDO::PARAM_INT);

    // --- Binds de texto
    $consulta->bindParam(":titulo_video", $titulo_video);
    $consulta->bindParam(":descripcion_video", $descripcion_video);
    $consulta->bindParam(":url_video", $url_video);
    $consulta->bindParam(":condicion_finalizacion_video", $condicion_finalizacion_video);
    $consulta->bindParam(":tipo_condicion_video", $tipo_condicion_video);

    // --- Fechas/Horas con soporte a NULL cuando vienen vacías

    if ($fecha_inicio_video === null || $fecha_inicio_video === '') {
        $consulta->bindValue(":fecha_inicio_video", null, PDO::PARAM_NULL);
    } else {
        $consulta->bindValue(":fecha_inicio_video", $fecha_inicio_video);
    }

    if ($fecha_limite_video === null || $fecha_limite_video === '') {
        $consulta->bindValue(":fecha_limite_video", null, PDO::PARAM_NULL);
    } else {
        $consulta->bindValue(":fecha_limite_video", $fecha_limite_video);
    }

    return $consulta->execute();
}


	//Implementar un método para mirar si tiene pea creado
	public function tienepea($id_docente_grupo)
    {
    	$sql="SELECT * FROM pea_docentes WHERE id_docente_grupo= :id_docente_grupo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

	
		//Implementar un método para mirar el programa
	public function comprobar($id_docente_grupo)
    {
    	$sql="SELECT * FROM docente_grupos WHERE id_docente= :id_usuario and id_docente_grupo= :id_docente_grupo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_usuario", $_SESSION['id_usuario']);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementamos un método para insertar registros
	public function insertarpeadocente($id_pea,$id_docente_grupo,$fecha_pea,$hora_pea)
	{
		$periodo_actual=$_SESSION['periodo_actual'];
		
		$sql="INSERT INTO pea_docentes (id_pea,id_docente_grupo,fecha_pea,hora_pea,periodo_pea)
		VALUES ('$id_pea','$id_docente_grupo','$fecha_pea','$hora_pea','$periodo_actual')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
		
	}
	
			//Implementar un método para mirar el programa
	public function pea($id_programa,$id_materia)
    {
    	$sql="SELECT * FROM pea WHERE id_programa= :id_programa and id_materia= :id_materia and estado=1"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	
		
	//Implementar un método para listar los registros
	public function listar($id_pea)
	{
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
	}
	
	
	
	//Implementar un método para mirar el programa
	public function programaacademico($id_programa)
    {
    	$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	
		//Implementar un métodolistar las actividades
	public function listaractividades($id_tema,$id_docente_grupo)
    {
    	$sql="SELECT * FROM pea_actividades WHERE id_tema= :id_tema and id_docente_grupo= :id_docente_grupo"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
		
    }
	
public function fechaesp($date) {
    if (empty($date) || $date === '0000-00-00') {
        return ""; // O puedes retornar: return "Sin fecha";
    }

    $dia = explode("-", $date, 3);

    if (count($dia) < 3) {
        return "";
    }

    $year  = $dia[0];
    $month = (string)(int)$dia[1];
    $day   = (string)(int)$dia[2];

    $dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    $tomadia = $dias[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];

    $meses = ["", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

    return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
}

public function fechaespsinano($date) {
    if (empty($date) || $date === '0000-00-00') {
        return ""; // o puedes retornar "Sin fecha"
    }

    $dia   = explode("-", $date, 3);

    if (count($dia) < 3) {
        return ""; // Evita errores si la cadena es malformada
    }

    $year  = $dia[0];
    $month = (string)(int)$dia[1];
    $day   = (string)(int)$dia[2];

    $dias  = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    $tomadia = $dias[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];

    $meses = ["", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

    return $tomadia . " " . $day . " de " . $meses[$month];
}


public function horaAMPM($hora) {
    if (empty($hora) || $hora === '00:00:00') {
        return ""; // O "Sin hora"
    }

    // strtotime convierte la hora a timestamp y date la formatea en am/pm
    return date("g:i a", strtotime($hora));
}

	
	
		//Implementar un método para listar los cargos
	public function selectTipoArchivo()
	{	
		$sql="SELECT * FROM tipo_archivo";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_pea_actividades)
	{
		$sql="SELECT * FROM pea_actividades WHERE id_pea_actividades= :id_pea_actividades";
		//return ejecutarConsultaSimpleFila($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_actividades", $id_pea_actividades);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	
	
		//Implementar un método para eliminar el grupo
	public function eliminar($id_pea_actividades,$tipo)
	{
		$sql="DELETE FROM pea_actividades WHERE id_pea_actividades= :id_pea_actividades";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_actividades", $id_pea_actividades);
		return $consulta->execute();
	}
	

	
	
	
	
	
	
	
	//Implementar un método para mirar el docente
	public function docente_grupo($materia,$jornada,$periodo,$programa)
    {
    	$sql="SELECT * FROM docente_grupos WHERE materia= :materia and jornada= :jornada and periodo= :periodo and  programa= :programa "; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->bindParam(":programa", $programa);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para mirar el id del estudiante
	public function id_estudiante($id_estudiante)
    {
    	$sql="SELECT * FROM estudiantes WHERE id_estudiante= :id_estudiante"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
		//Implementar un método para mirar datos del estudiante
	public function estudiante_datos($id_credencial)
    {
    	$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial"; 
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	
	//Implementar un método para mirar si el docente tiene PEA
	public function docente_pea($id_docente_materia)
    {
    	$sql="SELECT * FROM pea_docentes WHERE id_materia= :id_docente_materia"; 		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_materia", $id_docente_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
	
	//Implementar un método para asigar el id a la materia del estudiante
	public function asignar_pea_docente($numero_id_pea_encontrado,$id_estudiante_materia)
    {
    	$sql="UPDATE materias SET id_pea= :numero_id_pea_encontrado WHERE id_materia= :id_estudiante_materia"; 		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":numero_id_pea_encontrado", $numero_id_pea_encontrado);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
		return $consulta->execute();

    }
	
		//Implementar un método para listar el contenido del PEA
	public function listar_pea($id_estudiante_materia)
	{	
		$sql="SELECT * FROM pea_docentes WHERE id_materia= :id_estudiante_materia ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_estudiante_materia", $id_estudiante_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
		//Implementar un método para listar el contenido del PEA
	public function listar_temas($id_pea)
	{	
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	
	//Implementar un método para listar las actividades
	public function listar_actividades($id_tema,$id_materia)
	{	
		$sql="SELECT * FROM pea_actividades WHERE id_tema= :id_tema and id_materia= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
		
	//Implementar un método para listar las actividades
	public function listar_archivos($id_pea_actividades)
	{	
		$sql="SELECT * FROM pea_archivos WHERE id_pea_actividad= :id_pea_actividades";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_actividades", $id_pea_actividades);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}


	//Implementar un método para traer lso datos de la tabla PEA DOCENTE
	public function peadocente($id_docente_grupo)
	{	
		$sql="SELECT * FROM pea_docentes pead INNER JOIN pea pe ON pe.id_pea=pead.id_pea WHERE pead.id_docente_grupo = :id_docente_grupo ORDER BY pead.periodo_pea DESC";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementamos un método para taer los datos del PEA
	public function datospea($id_pea)
	{
		$sql="SELECT * FROM pea WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

		
	//Implementar un método para mostrar los temas de los PEA
	public function verPea($id_pea)
	{
		$sql="SELECT * FROM pea_temas WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar las referencias del PEA
	public function verPeaReferencia($id_pea)
	{
		$sql="SELECT * FROM pea_referencia WHERE id_pea= :id_pea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para mostrar los datos de la materia
	public function datosmateria($id_materia)
	{
		$sql="SELECT * FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos del programa
	public function datosprograma($id_programa_ac)
	{
		$sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa_ac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa_ac", $id_programa_ac);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para mostrar los datos del programa
	public function datosescuela($id_escuela)
	{
		$sql="SELECT * FROM escuelas WHERE id_escuelas= :id_escuela";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_escuela", $id_escuela);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mostrar los datos de la materia
	public function datosmateriapre($prerequisito)
	{
		$sql="SELECT nombre FROM materias_ciafi WHERE id= :prerequisito";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":prerequisito", $prerequisito);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para ver las carpetas
	public function verCarpetas($id_pea_docentes)
	{
		$sql="SELECT * FROM pea_documento_carpeta WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

	//Implementar un método para ver las carpetas
	public function verCarpetasEjercicios($id_pea_docentes)
	{
		$sql="SELECT * FROM pea_ejercicios_carpeta WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

		//Implementar un método para traer el id_docnte_grupo
		public function traeridpeadocente($id_pea_docentes)
		{	
			$sql="SELECT id_pea_docentes,id_docente_grupo FROM pea_docentes WHERE id_pea_docentes= :id_pea_docentes";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

			//Implementar un método para mostrar los documentos de los PEA
		public function verPeaDocumentos($id_pea_docente,$id_tema)
		{
			$sql="SELECT * FROM pea_documentos WHERE id_pea_docentes= :id_pea_docente AND id_tema= :id_tema";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docente", $id_pea_docente);
			$consulta->bindParam(":id_tema", $id_tema);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}



		//Implementar un método para mostrar los documentos de los PEA
		public function verPeaDocumentosEjercicios($id_pea_ejercicios_carpeta)
		{
			$sql="SELECT * FROM pea_ejercicios WHERE id_pea_ejercicios_carpeta= :id_pea_ejercicios_carpeta";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_ejercicios_carpeta", $id_pea_ejercicios_carpeta);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para mostrar los datos de un pea documento
		public function verDatosDocumento($id_pea_documento)
		{
			$sql="SELECT * FROM pea_documentos WHERE id_pea_documento= :id_pea_documento";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_documento", $id_pea_documento);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

				//Implementar un método para mostrar los datos de un pea documento
		public function verDatosEnlaces($id_pea_enlaces)
		{
			$sql="SELECT * FROM pea_enlaces WHERE id_pea_enlaces= :id_pea_enlaces";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_enlaces", $id_pea_enlaces);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}


		//Implementar un método para eliminar el grupo
		public function eliminarArchivo($id_pea_documento)
		{
			$sql="DELETE FROM pea_documentos WHERE id_pea_documento= :id_pea_documento";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_documento", $id_pea_documento);
			return $consulta->execute();
		}

		public function eliminarVideo($id_pea_video)
		{
			$sql="DELETE FROM pea_videos WHERE id_pea_video= :id_pea_video";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_video", $id_pea_video);
			return $consulta->execute();
		}


		//Implementar un método para eliminar el archivo ejercicio de un estudiante
		public function eliminarArchivoEstudiante($id_pea_ejercicios_est)
		{
			$sql="DELETE FROM pea_ejercicios_est WHERE id_pea_ejercicios_est= :id_pea_ejercicios_est";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_ejercicios_est", $id_pea_ejercicios_est);
			return $consulta->execute();
		}

		//Implementar un método para eliminar un enlace
		public function eliminarEnlace($id_pea_enlaces)
		{
			$sql="DELETE FROM pea_enlaces WHERE id_pea_enlaces= :id_pea_enlaces";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_enlaces", $id_pea_enlaces);
			return $consulta->execute();
		}

		//Implementar un método para eliminar un glosario
		public function eliminarGlosario($id_pea_glosario)
		{
			$sql="DELETE FROM pea_glosario WHERE id_pea_glosario= :id_pea_glosario";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_glosario", $id_pea_glosario);
			return $consulta->execute();
		}

		//Implementar un método para mostrar la cantidad de descargas
		public function descargasDoc($id_pea_documento)
		{
			$sql="SELECT * FROM pea_documento_descarga WHERE id_pea_documento= :id_pea_documento";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_documento", $id_pea_documento);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para mostrar los datos del estudiante
		public function datosEstudiante($id_credencial)
		{
			$sql="SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_credencial", $id_credencial);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Implementar un método para mostrar los enlaces
		public function verEnlaces($id_pea_docente)
		{
			$sql="SELECT * FROM pea_enlaces WHERE id_pea_docentes= :id_pea_docente";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docente", $id_pea_docente);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		
		//Implementar un método para mostrar los enlaces
		public function verEnlacesTema($id_pea_docente,$id_tema)
		{
			$sql="SELECT * FROM pea_enlaces WHERE id_pea_docentes= :id_pea_docente AND id_tema= :id_tema";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docente", $id_pea_docente);
			$consulta->bindParam(":id_tema", $id_tema);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}
		//Implementar un método para mostrar los enlaces
		public function verGlosarioTema($id_pea_docentes,$id_tema)
		{
			$sql="SELECT * FROM pea_glosario WHERE id_pea_docentes= :id_pea_docentes AND id_tema= :id_tema";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
			$consulta->bindParam(":id_tema", $id_tema);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

				//Implementar un método para mostrar los enlaces
		public function verVideosTema($id_pea_docentes,$id_tema)
		{
			$sql="SELECT * FROM pea_videos WHERE id_pea_docentes= :id_pea_docentes AND id_tema= :id_tema";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
			$consulta->bindParam(":id_tema", $id_tema);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para mostrar los enlaces
		public function verGlosario($id_pea_docentes)
		{
			$sql="SELECT * FROM pea_glosario WHERE id_pea_docentes= :id_pea_docentes";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		
		
		//Implementar un método para listar las materias
		public function listarelgrupo($id_docente_grupo)
		{
			$sql = "SELECT * FROM docente_grupos WHERE id_docente_grupo= :id_docente_grupo and periodo='" . $_SESSION["periodo_actual"] . "' ";
			//return ejecutarConsulta($sql);
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Implementar un método para buscar los datos de la materia a matricular
		public function materiaDatos($id)
		{
			$sql = "SELECT * FROM materias_ciafi WHERE id= :id ";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id", $id);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

			//Implementar un método para listar las materias
		public function listarCalificar($ciclo, $materia, $jornada, $id_programa, $grupo)
		{

			$tabla = "materias" . $ciclo;
			$periodo_actual = $_SESSION["periodo_actual"];

			$sql = "SELECT * FROM $tabla WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `periodo` = '$periodo_actual' AND `grupo` = :grupo";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":materia", $materia);
			$consulta->bindParam(":jornada", $jornada);
			$consulta->bindParam(":id_programa", $id_programa);
			$consulta->bindParam(":grupo", $grupo);
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			return $resultado;
		}

		//Implementar un método para buscar los datos de la materia a matricular
		public function traerejercicio($id_pea_ejercicios,$id_estudiante)
		{
			$sql = "SELECT * FROM pea_ejercicios_est WHERE id_pea_ejercicios= :id_pea_ejercicios and id_estudiante= :id_estudiante";
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_pea_ejercicios", $id_pea_ejercicios);
			$consulta->bindParam(":id_estudiante", $id_estudiante);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

	//Implementar un método para buscar los datos de la materia a matricular
	public function traerejercicioparaeliminar($id_pea_ejercicios_est)
	{
		$sql = "SELECT * FROM pea_ejercicios_est WHERE id_pea_ejercicios_est= :id_pea_ejercicios_est";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_est", $id_pea_ejercicios_est);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	
	//Implementar un método para eliminar el grupo
	public function calificarTaller($id_pea_ejercicios_est,$nota_ejercicios)
	{
		$sql="UPDATE pea_ejercicios_est SET nota_ejercicios= :nota_ejercicios WHERE id_pea_ejercicios_est= :id_pea_ejercicios_est";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_est", $id_pea_ejercicios_est);
		$consulta->bindParam(":nota_ejercicios", $nota_ejercicios);
		return $consulta->execute();
	}

	//Implementar un método para listar los creditos matriculados
	public function sumarProEjerciciosCarpeta($id_pea_ejercicios_carpeta)
	{
		$sql="SELECT sum(por_ejercicios) as suma_por_ejercicios FROM pea_ejercicios WHERE id_pea_ejercicios_carpeta= :id_pea_ejercicios_carpeta";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_carpeta", $id_pea_ejercicios_carpeta);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
		
			//Implementamos un método para taer los datos del PEA
	public function verEstadoTema($ciclo,$id_pea,$id_pea_docente,$id_tema)
	{
		$periodo_actual=$_SESSION['periodo_actual'];
		$sql="SELECT * FROM pea_tema_ciclo_$ciclo WHERE id_pea= :id_pea AND id_pea_docente= :id_pea_docente AND id_tema= :id_tema AND periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->bindParam(":id_pea_docente", $id_pea_docente);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

	//Implementamos un método para editar la carpeta
	public function marcarvisto($ciclo,$id_pea_tema_ciclo)
	{
		$sql="UPDATE pea_tema_ciclo_$ciclo SET estado_tema=2 WHERE id_pea_tema_ciclo='".$id_pea_tema_ciclo."' ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
		
			//Implementamos un método para taer los datos del PEA
	public function validarsiexistema($ciclo,$id_pea,$id_pea_docente,$id_tema)
	{
		$periodo_actual=$_SESSION['periodo_actual'];
		$sql="SELECT * FROM pea_tema_ciclo_$ciclo WHERE id_pea= :id_pea AND id_pea_docente= :id_pea_docente AND id_tema= :id_tema AND periodo= :periodo_actual";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->bindParam(":id_pea_docente", $id_pea_docente);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

	public function insertarTema($ciclo, $id_materia, $id_programa, $id_pea, $id_pea_docente, $id_tema)
	{
		$periodo_actual = $_SESSION['periodo_actual'];
		$sql = "INSERT INTO pea_tema_ciclo_$ciclo (id_materia, id_programa, id_pea, id_pea_docente, id_tema, periodo)
				VALUES (:id_materia, :id_programa, :id_pea, :id_pea_docente, :id_tema, :periodo_actual)";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea", $id_pea);
		$consulta->bindParam(":id_pea_docente", $id_pea_docente);
		$consulta->bindParam(":id_tema", $id_tema);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->bindParam(":id_programa", $id_programa);

		return $consulta->execute(); // devuelve true si se inserta correctamente
	}


		//Implementar un método para traer los datos del taller del docente
	public function datostaller($id_pea_documento){
		$sql = "SELECT * FROM pea_documentos doc INNER JOIN pea_docentes pd ON doc.id_pea_docentes=pd.id_pea_docentes WHERE doc.id_pea_documento= :id_pea_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_documento", $id_pea_documento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
			//Implementar un método para traer los datos del taller del docente
	public function datosenlace($id_pea_enlaces){
		$sql = "SELECT * FROM pea_enlaces pe INNER JOIN pea_docentes pd ON pe.id_pea_docentes=pd.id_pea_docentes WHERE pe.id_pea_enlaces= :id_pea_enlaces";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_enlaces", $id_pea_enlaces);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

				//Implementar un método para traer los datos del taller del docente
	public function datosvideo($id_pea_video){
		$sql = "SELECT * FROM pea_videos pe INNER JOIN pea_docentes pd ON pe.id_pea_docentes=pd.id_pea_docentes WHERE pe.id_pea_video= :id_pea_video";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_video", $id_pea_video);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

				//Implementar un método para traer los datos del taller del docente
	public function datosglosario($id_pea_glosario){
		$sql = "SELECT * FROM pea_glosario pe INNER JOIN pea_docentes pd ON pe.id_pea_docentes=pd.id_pea_docentes WHERE pe.id_pea_glosario= :id_pea_glosario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_glosario", $id_pea_glosario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	

		//Implementar un método para listar las materias
	public function listarEstudiantes($ciclo, $materia, $jornada, $id_programa, $grupo){
		$tabla = "materias" . $ciclo;
		$periodo_actual = $_SESSION["periodo_actual"];
		$sql = "SELECT *, $ciclo AS `ciclo_estudiante` FROM $tabla WHERE `nombre_materia` = :materia AND `jornada` = :jornada AND `programa` = :id_programa AND `periodo` = '$periodo_actual' AND `grupo` = :grupo AND `activar_grupo_esp` = 0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":materia", $materia);
		$consulta->bindParam(":jornada", $jornada);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":grupo", $grupo);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

		//Implementar un método para ver quien mando el enlace
	public function verEjerciciosEntregados($id_pea_documento,$id_estudiante,$ciclo){
		$sql = "SELECT * FROM pea_ejercicios_est_ciclo_$ciclo WHERE id_pea_documento= :id_pea_documento AND id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_documento", $id_pea_documento);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

			//Implementar un método para ver quien mando el enlace
	public function verEnlacesEntregados($id_pea_enlaces,$id_estudiante,$ciclo){
		$sql = "SELECT * FROM pea_enlaces_est_ciclo_$ciclo WHERE id_pea_enlaces= :id_pea_enlaces AND id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_enlaces", $id_pea_enlaces);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	//Implementar un método para ver quien mando el enlace
	public function verVideosEntregados($id_pea_videos,$id_estudiante,$ciclo){
		$sql = "SELECT * FROM pea_video_est_ciclo_$ciclo WHERE id_pea_videos= :id_pea_videos AND id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_videos", $id_pea_videos);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

				//Implementar un método para ver quien mando el enlace
	public function verGlosarioEntregados($id_pea_glosario,$id_estudiante,$ciclo){
		$sql = "SELECT * FROM pea_glosario_est_ciclo_$ciclo WHERE id_pea_glosario= :id_pea_glosario AND id_estudiante= :id_estudiante";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_glosario", $id_pea_glosario);
		$consulta->bindParam(":id_estudiante", $id_estudiante);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

		//Implementar un método para traer el id_docnte_grupo
	public function datosdocumento($id_pea_documento){
		$sql = "SELECT * FROM pea_documentos WHERE id_pea_documento= :id_pea_documento";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_documento", $id_pea_documento);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
			//Implementar un método para datos personales
	public function datos_delid_usuario($id_credencial,$ciclo,$periodo_actual){
		$sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial AND ciclo= :ciclo AND periodo_activo= :periodo_actual";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":ciclo", $ciclo);
		$consulta->bindParam(":periodo_actual", $periodo_actual);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

			//Implementar un método para traer el id_docnte_grupo
	public function verDocumentoMensaje($id_pea_ejercicios_est,$ciclo){
		$sql = "SELECT * FROM pea_ejercicios_est_ciclo_$ciclo WHERE id_pea_ejercicios_est= :id_pea_ejercicios_est";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_est", $id_pea_ejercicios_est);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

				//Implementar un método para traer el id_docnte_grupo
	public function verEnlacesMensaje($id_pea_enlaces_est,$ciclo){
		$sql = "SELECT * FROM pea_enlaces_est_ciclo_$ciclo WHERE id_pea_enlaces_est= :id_pea_enlaces_est";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_enlaces_est", $id_pea_enlaces_est);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

				//Implementar un método para traer el id_docnte_grupo
	public function verEnlaceMensaje($id_pea_enlaces_est,$ciclo){
		$sql = "SELECT * FROM pea_enlaces_est_ciclo_$ciclo WHERE id_pea_enlaces_est= :id_pea_enlaces_est";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_enlaces_est", $id_pea_enlaces_est);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

		//Implementar un método para actulizar la nota del taller
	public function notadocumento($nota,$id_pea_ejercicios_est,$ciclo)
    {
    	$sql="UPDATE pea_ejercicios_est_ciclo_$ciclo SET nota_ejercicios= :nota, estado_ejercicios=2 WHERE id_pea_ejercicios_est= :id_pea_ejercicios_est"; 		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nota", $nota);
		$consulta->bindParam(":id_pea_ejercicios_est", $id_pea_ejercicios_est);
		return $consulta->execute();

    }

			//Implementar un método para actulizar la nota del taller
	public function notaenlace($nota,$id_pea_enlaces_est,$ciclo)
    {
    	$sql="UPDATE pea_enlaces_est_ciclo_$ciclo SET nota_ejercicios= :nota, estado_ejercicios=2 WHERE id_pea_enlaces_est= :id_pea_enlaces_est"; 		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nota", $nota);
		$consulta->bindParam(":id_pea_enlaces_est", $id_pea_enlaces_est);
		return $consulta->execute();

    }
	public function buscarBilleteraDocente($id_pea_docentes){
		$sql = "SELECT id_pea_docentes,billetera_asignatura FROM pea_docentes WHERE id_pea_docentes= :id_pea_docentes";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
		//Implementamos un método para actualizar el valor de los puntos
	public function actualizarBilleteraDocente($id_pea_docentes,$nuevosaldo)
	{
		$sql="UPDATE pea_docentes SET billetera_asignatura= :nuevosaldo WHERE id_pea_docentes= :id_pea_docentes ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_docentes", $id_pea_docentes);
        $consulta->bindParam(":nuevosaldo", $nuevosaldo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}
	    //Insertar punto en tabla puntos
	public function insertarPunto($id_credencial,$punto_nombre,$puntos_cantidad,$punto_fecha,$punto_hora)
	{
		$punto_periodo = $_SESSION["periodo_actual"];
		$sql="INSERT INTO puntos (`id_credencial`, `punto_nombre`, `puntos_cantidad`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES ('$id_credencial','$punto_nombre','$puntos_cantidad','$punto_fecha','$punto_hora','$punto_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}


    //Implementar un método para ver los puntos del estudiante
	public function verpuntos($id_credencial){	

		$sql=" SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

		//Implementamos un método para actualizar el valor de los puntos
	public function actulizarValor($puntos,$id_credencial)
	{

		$sql="UPDATE credencial_estudiante SET puntos= :puntos WHERE id_credencial= :id_credencial ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":puntos", $puntos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

			//Implementamos un método para actualizar el valor de los puntos
	public function actulizarPuntoTaller($id_pea_ejercicios_est,$puntos_otorgados,$ciclo)
	{

		$sql="UPDATE pea_ejercicios_est_ciclo_$ciclo SET puntos_otorgados= :puntos_otorgados WHERE id_pea_ejercicios_est= :id_pea_ejercicios_est ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_ejercicios_est", $id_pea_ejercicios_est);
		$consulta->bindParam(":puntos_otorgados", $puntos_otorgados);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

				//Implementamos un método para actualizar el valor de los puntos
	public function actulizarPuntoTallerEnlaces($id_pea_enlaces_est,$puntos_otorgados,$ciclo)
	{

		$sql="UPDATE pea_enlaces_est_ciclo_$ciclo SET puntos_otorgados= :puntos_otorgados WHERE id_pea_enlaces_est= :id_pea_enlaces_est ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pea_enlaces_est", $id_pea_enlaces_est);
		$consulta->bindParam(":puntos_otorgados", $puntos_otorgados);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

}

?>