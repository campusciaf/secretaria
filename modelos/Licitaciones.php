<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
class ProcesosExtension{
	//Implementamos nuestro constructor
	public function __construct() {}
	public function verTareas()
	{
		$sql = "SELECT * FROM `licitaciones_tareas`";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function Buscar_Usuario($id_usuario)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario= :id_usuario";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function Buscar_Perfil($id_licitacion_rol)
	{
		$sql = "SELECT * FROM licitacion_rol WHERE id_licitacion_rol= :id_licitacion_rol";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitacion_rol", $id_licitacion_rol);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function Buscar_Prioridad($id_licitacion_prioridad)
	{
		$sql = "SELECT * FROM licitacion_prioridad WHERE id_licitacion_prioridad= :id_licitacion_prioridad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitacion_prioridad", $id_licitacion_prioridad);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function Mostrar_Tarea($id_licitaciones_tarea)
	{
		$sql = "SELECT * FROM `licitaciones_tareas` WHERE `id_licitaciones_tarea` = :id_licitaciones_tarea";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_tarea", $id_licitaciones_tarea);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function fechaesp($date)
	{
		$dia 	= explode("-", $date, 3);
		$year 	= $dia[0];
		$month 	= (string)(int)$dia[1];
		$day 	= (string)(int)$dia[2];
		$dias 		= array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
		$tomadia 	= $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
		$meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
	}
	public function ListarComentariosGlobales($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM `licitaciones_comentarios_general` JOIN `usuario` ON `licitaciones_comentarios_general`.`id_usuario` = `usuario`.`id_usuario` WHERE `licitaciones_comentarios_general`.`id_licitaciones_tarea` = :id_licitaciones_tarea";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function InsertarTareas($nombre_tarea, $progreso_tarea, $prioridad, $fecha_inicio, $fecha_vencimiento, $notas, $id_usuario, $codigo, $valor, $entidad_contratante, $facultad, $tipo_contratacion, $enlace_proceso, $tipo_de_proceso, $observaciones)
	{
		$sql = "INSERT INTO `licitaciones_tareas`(`nombre_tarea`, `progreso_tarea`, `prioridad`, `fecha_inicio`, `fecha_vencimiento`, `notas`, `id_usuario`, `codigo`,`valor`, `entidad_contratante`, `facultad`, `tipo_contratacion`, `enlace_proceso`, `tipo_de_proceso`, `observaciones`) VALUES(:nombre_tarea,:progreso_tarea, :prioridad, :fecha_inicio, :fecha_vencimiento, :notas, :id_usuario, :codigo, :valor, :entidad_contratante, :facultad, :tipo_contratacion, :enlace_proceso, :tipo_de_proceso, :observaciones);";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':nombre_tarea', $nombre_tarea);
		$consulta->bindParam(':progreso_tarea', $progreso_tarea);
		$consulta->bindParam(':prioridad', $prioridad);
		$consulta->bindParam(':fecha_inicio', $fecha_inicio);
		$consulta->bindParam(':fecha_vencimiento', $fecha_vencimiento);
		$consulta->bindParam(':notas', $notas);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':codigo', $codigo);
		$consulta->bindParam(':valor', $valor);
		$consulta->bindParam(':entidad_contratante', $entidad_contratante);
		$consulta->bindParam(':facultad', $facultad);
		$consulta->bindParam(':tipo_contratacion', $tipo_contratacion);
		$consulta->bindParam(':enlace_proceso', $enlace_proceso);
		$consulta->bindParam(':tipo_de_proceso', $tipo_de_proceso);
		$consulta->bindParam(':observaciones', $observaciones);
		if ($consulta->execute()) {
			return $mbd->lastInsertId();
		} else {
			return false;
		}
	}
	public function insertarItemDefault($id_licitacion)
	{
		$sql = "INSERT INTO `licitaciones_item`(`nombre_elemento`, `id_licitaciones_tarea`, `tipo_estado`) VALUES ('Revisión General', :id_licitacion, 'Marcar'), ('Revisión Técnica', :id_licitacion, 'Marcar'),('Revisión Financiera', :id_licitacion, 'Marcar'),('Aprobación Miembros Comité', :id_licitacion, 'Aprobar')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitacion', $id_licitacion);
		$consulta->execute();
	}
	public function EditarTarea($id_licitaciones_tarea, $nombre_tarea, $progreso_tarea, $prioridad, $fecha_inicio, $fecha_vencimiento, $notas, $codigo, $valor, $entidad_contratante, $facultad, $tipo_contratacion, $enlace_proceso, $tipo_de_proceso, $observaciones)
	{
		$sql = "UPDATE `licitaciones_tareas` SET `nombre_tarea` = '$nombre_tarea', `progreso_tarea` = '$progreso_tarea', `prioridad` = '$prioridad', `fecha_inicio` = '$fecha_inicio', `fecha_vencimiento` = '$fecha_vencimiento', `notas` = '$notas', `codigo` = '$codigo', `valor` = '$valor', `entidad_contratante` = '$entidad_contratante', `facultad` = '$facultad', `enlace_proceso` = '$enlace_proceso', `tipo_contratacion` = '$tipo_contratacion', `tipo_de_proceso` = '$tipo_de_proceso', `observaciones` = '$observaciones' WHERE `id_licitaciones_tarea` = '$id_licitaciones_tarea';";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function selectlistarUsuarios()
	{
		$sql = "SELECT * FROM usuario WHERE usuario_condicion = 1 AND licitacion_activos =0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function selectlistarPrioridad()
	{
		$sql = "SELECT * FROM licitacion_prioridad";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	public function AgregarElemento($nombre_elemento, $id_usuario_responsable, $id_licitaciones_tarea, $fecha_inicio_item, $fecha_entregar_item)
	{
		$sql = "INSERT INTO licitaciones_item (nombre_elemento, id_usuario_responsable, id_licitaciones_tarea,fecha_inicio_item,fecha_entregar_item) VALUES (:nombre_elemento, :id_usuario_responsable, :id_licitaciones_tarea, :fecha_inicio_item, :fecha_entregar_item)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':nombre_elemento', $nombre_elemento);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->bindParam(':id_usuario_responsable', $id_usuario_responsable);
		$consulta->bindParam(':fecha_inicio_item', $fecha_inicio_item);
		$consulta->bindParam(':fecha_entregar_item', $fecha_entregar_item);
		if ($consulta->execute()) {
			return $mbd->lastInsertId();
		} else {
			return false;
		}
	}
	public function ListarElementos($id_licitaciones_tarea)
	{
		$sql = "SELECT * FROM licitaciones_item WHERE id_licitaciones_tarea = :id_licitaciones_tarea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function FinalizarElemento($id_licitaciones_item, $estado_terminado, $fecha_finalizado, $hora_finalizado, $id_usuario_finalizo, $motivo_incumplido)
	{
		$sql = "UPDATE `licitaciones_item` SET `estado_terminado` = '$estado_terminado', `fecha_finalizado` = '$fecha_finalizado', `hora_finalizado` = '$hora_finalizado', `id_usuario_finalizo` = '$id_usuario_finalizo',  `motivo_incumplido` = '$motivo_incumplido' WHERE `id_licitaciones_item` = '$id_licitaciones_item'";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}
	public function ObtenerNombreElemento($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT nombre_elemento FROM licitaciones_item WHERE id_licitaciones_item = :id_licitaciones_item";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetch(PDO::FETCH_ASSOC);
	}
	public function InsertarArchivoLicitacion($id_licitaciones_tarea, $nombre_archivo, $id_usuario, $fecha, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO licitaciones_archivos (id_licitaciones_tarea, nombre_archivo, id_usuario, fecha, hora) VALUES (:id_licitaciones_tarea, :nombre_archivo, :id_usuario, :fecha, :hora)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->bindParam(':nombre_archivo', $nombre_archivo);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':fecha', $fecha);
		$consulta->bindParam(':hora', $hora);
		return $consulta->execute();
	}
	public function ObtenerArchivosPorTarea($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM licitaciones_archivos WHERE id_licitaciones_tarea = :id_licitaciones_tarea ORDER BY id_licitaciones_tarea ASC";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ListarComentarios($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM licitaciones_comentarios_general WHERE id_licitaciones_tarea = :id_licitaciones_tarea";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function GuardarComentarioGeneral($id_licitaciones_tarea, $comentario, $id_usuario, $fecha, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO licitaciones_comentarios_general (id_licitaciones_tarea, comentario, id_usuario, fecha, hora) VALUES (:id_licitaciones_tarea, :comentario, :id_usuario, :fecha, :hora)";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->bindParam(':comentario', $comentario);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':fecha', $fecha);
		$consulta->bindParam(':hora', $hora);
		return $consulta->execute();
	}
	public function GuardarComentarioItem($id_licitaciones_item, $comentario, $id_usuario, $fecha, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO licitaciones_comentarios_por_item(id_licitaciones_item, comentario, id_usuario, fecha, hora) VALUES (:id_licitaciones_item, :comentario, :id_usuario, :fecha, :hora)";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->bindParam(':comentario', $comentario);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':fecha', $fecha);
		$consulta->bindParam(':hora', $hora);
		return $consulta->execute();
	}
	public function ListarComentariosPorItem($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT *  FROM licitaciones_comentarios_por_item JOIN usuario ON licitaciones_comentarios_por_item.id_usuario = usuario.id_usuario WHERE licitaciones_comentarios_por_item.id_licitaciones_item = :id_licitaciones_item";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ListarItems($id_licitaciones_tarea)
	{
		$sql = "SELECT `lle`.*, CONCAT(`u`.`usuario_nombre`, ' ', `u`.`usuario_nombre_2`, ' ', `u`.`usuario_apellido`, ' ', `u`.`usuario_apellido_2`) AS `nombre_completo` FROM `licitaciones_item` AS `lle` LEFT JOIN `usuario` AS `u` ON `u`.`id_usuario` = `lle`.`id_usuario_responsable` WHERE `lle`.`id_licitaciones_tarea` = :id_licitaciones_tarea";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function EditarElemento($id_licitaciones_item, $nombre_elemento, $id_usuario_responsable, $fecha_inicio_item, $fecha_entregar_item)
	{
		$sql = "UPDATE `licitaciones_item` SET `nombre_elemento` = :nombre_elemento, `id_usuario_responsable` = :id_usuario_responsable , `fecha_inicio_item` = :fecha_inicio_item , `fecha_entregar_item` = :fecha_entregar_item WHERE `id_licitaciones_item` = :id_licitaciones_item";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":nombre_elemento", $nombre_elemento);
		$consulta->bindParam(":id_licitaciones_item", $id_licitaciones_item);
		$consulta->bindParam(":id_usuario_responsable", $id_usuario_responsable);
		$consulta->bindParam(":fecha_inicio_item", $fecha_inicio_item);
		$consulta->bindParam(":fecha_entregar_item", $fecha_entregar_item);
		return $consulta->execute();
	}
	public function mostrar_elemento($id_licitaciones_item)
	{
		$sql = "SELECT * FROM `licitaciones_item` WHERE `id_licitaciones_item` = :id_licitaciones_item";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_item", $id_licitaciones_item);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function EliminarLicitacion($id_licitaciones_tarea)
	{
		$sql = "DELETE FROM licitaciones_tareas WHERE id_licitaciones_tarea= :id_licitaciones_tarea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_tarea", $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta;
	}
	public function EliminarItem($id_licitaciones_item)
	{
		$sql = "DELETE FROM `licitaciones_item` WHERE `id_licitaciones_item` = :id_licitaciones_item";
		// echo $sql;
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_item", $id_licitaciones_item);
		$consulta->execute();
		return $consulta;
	}
	public function ListarArchivosPorItems($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT * FROM `licitaciones_archivos_items` JOIN `usuario` ON `licitaciones_archivos_items`.`id_usuario` = `usuario`.`id_usuario` WHERE `licitaciones_archivos_items`.`id_licitaciones_item` = :id_licitaciones_item";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function GuardarArchivoItem($id_licitaciones_item, $nombre_archivo, $id_usuario, $fecha, $hora, $id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "INSERT INTO `licitaciones_archivos_items`(`id_licitaciones_item`, `nombre_archivo`, `id_usuario`, `fecha`, `hora` , `id_licitaciones_tarea`) VALUES (:id_licitaciones_item, :nombre_archivo, :id_usuario, :fecha, :hora, :id_licitaciones_tarea)";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->bindParam(':nombre_archivo', $nombre_archivo);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':fecha', $fecha);
		$consulta->bindParam(':hora', $hora);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		return $consulta->execute();
	}
	public function EditarEstadoCompletado($id_licitaciones_tarea, $aprobado, $porque_aprobado)
	{
		$sql = "UPDATE licitaciones_tareas SET aprobado = :aprobado, porque_aprobado = :porque_aprobado , progreso_tarea  = 'Completado' WHERE id_licitaciones_tarea = :id_licitaciones_tarea";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_tarea", $id_licitaciones_tarea);
		$consulta->bindParam(":aprobado", $aprobado);
		$consulta->bindParam(":porque_aprobado", $porque_aprobado);
		return $consulta->execute();
	}
	public function GuardarComentarioGlobal($id_licitaciones_tarea, $comentario, $id_usuario, $fecha, $hora)
	{
		global $mbd;
		$sql = "INSERT INTO licitaciones_comentarios_general(id_licitaciones_tarea, comentario, id_usuario, fecha, hora) VALUES (:id_licitaciones_tarea, :comentario, :id_usuario, :fecha, :hora)";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->bindParam(':comentario', $comentario);
		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':fecha', $fecha);
		$consulta->bindParam(':hora', $hora);
		return $consulta->execute();
	}
	public function TraerNombreLicitacion($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT *  FROM `licitaciones_tareas`  WHERE `id_licitaciones_tarea` = :id_licitaciones_tarea";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ListarComentariosGlobalesPorItem($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT *  FROM licitaciones_item  WHERE id_licitaciones_tarea = :id_licitaciones_item";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function NombreItem($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT *  FROM `licitaciones_item`  WHERE `id_licitaciones_tarea` = :id_licitaciones_tarea";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ComentariosPorItem($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT *  FROM `licitaciones_comentarios_por_item` JOIN `usuario` ON `licitaciones_comentarios_por_item`.`id_usuario` = `usuario`.`id_usuario` WHERE `licitaciones_comentarios_por_item`.`id_licitaciones_item` = :id_licitaciones_item";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ArchivosPorItem($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT `lai`.`nombre_archivo`, `lai`.`fecha`, `lai`.`hora`, `u`.`usuario_nombre`, `u`.`usuario_nombre_2`, `u`.`usuario_apellido`, `u`.`usuario_apellido_2` FROM `licitaciones_archivos_items` `lai` JOIN `usuario` `u` ON `lai`.`id_usuario` = `u`.`id_usuario` WHERE `lai`.`id_licitaciones_item` = :id_licitaciones_item";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function ListarItemAvance($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM licitaciones_item WHERE id_licitaciones_tarea= :id_licitaciones_tarea";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_tarea", $id_licitaciones_tarea);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function ListarItemAvanceTerminado($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT * FROM licitaciones_item WHERE id_licitaciones_tarea= :id_licitaciones_tarea AND estado_terminado = 0";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_licitaciones_tarea", $id_licitaciones_tarea);
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function BuscarArchivoEliminar($id_licitaciones_item)
	{
		global $mbd;
		$sql = "SELECT *  FROM `licitaciones_archivos_items`  WHERE `id_licitaciones_item` = :id_licitaciones_item";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_item', $id_licitaciones_item);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	public function BuscarArchivoEliminarPorLicitacion($id_licitaciones_tarea)
	{
		global $mbd;
		$sql = "SELECT *  FROM `licitaciones_archivos_items`  WHERE `id_licitaciones_tarea` = :id_licitaciones_tarea";
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':id_licitaciones_tarea', $id_licitaciones_tarea);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	}
	function BuscarCodigo($numero_codigo)
	{
		global $mbd;
		$sql = "SELECT * FROM `licitaciones_codigos` WHERE `numero_codigo` LIKE :numero_codigo '%' ";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':numero_codigo', $numero_codigo);
		$consulta->execute();
		$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	function listarEntidadesContratantes()
	{
		global $mbd;
		$sql = "SELECT `nit`, `razon_social` FROM `licitaciones_directorio`;";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $registros;
	}
	function generarCodigoPrivado()
	{
		global $mbd;
		$sql = "SELECT `codigo` FROM `licitaciones_tareas` WHERE `tipo_de_proceso` = 'Privado' ORDER BY `licitaciones_tareas`.`id_licitaciones_tarea` DESC Limit 1;";
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$registros = $consulta->fetch(PDO::FETCH_ASSOC);
		return $registros;
	}
	function AgregarEntidadContratante($razon_social)
	{
		global $mbd;
		$sql = "INSERT INTO `licitaciones_directorio` (`id_entidad`, `nit`, `razon_social`, `departamento`, `municipio`, `direccion`, `codigo_postal`, `telefono`, `fax`, `email`, `pagina_web`, `ambito_siif`) VALUES (NULL, NULL, :razon_social, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(':razon_social', $razon_social);
		return $consulta->execute();
	}
}
