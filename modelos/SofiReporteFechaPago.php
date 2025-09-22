<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class SofiReporteFechaPago{
	//Implementamos nuestro constructor
	public function __construct(){}
    //listar todos periodos
    public function listarPeriodos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `periodo` FROM `periodo` ORDER BY `periodo`.`periodo` DESC");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
	//Función para listar los pagos
    public function listarPagosPorPeriodo($periodo){
        $sql = "SELECT `sm`.`id` AS `consecutivo`, `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`celular`, `sp`.`email`, `shp`.`numero_cuota`, `shp`.`fecha_pago`, `shp`.`fecha_pagada`, `shp`.`valor_pagado`, `sm`.`periodo` FROM `sofi_historial_pagos` `shp` INNER JOIN `sofi_matricula` `sm` ON `sm`.`id` = `shp`.`consecutivo` INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `shp`.`valor_pagado` != 0 AND `sm`.`periodo` = :periodo;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	//Función para listar los pagos
    public function listarPagosPorDia($inicio, $fin){
        $sql= "SELECT `sm`.`id` AS `consecutivo`, `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`celular`, `sp`.`email`, `shp`.`numero_cuota`, `shp`.`fecha_pago`, `shp`.`fecha_pagada`, `shp`.`valor_pagado`, `sm`.`periodo` FROM `sofi_historial_pagos` `shp` INNER JOIN `sofi_matricula` `sm` ON `sm`.`id` = `shp`.`consecutivo` INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `shp`.`valor_pagado` != 0 AND `shp`.`fecha_pago` BETWEEN :inicio AND :fin;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":inicio", $inicio);
		$consulta->bindParam(":fin", $fin);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Función para listar los pagos
    public function porFechaPago($inicio, $fin){
        $sql= "SELECT `sm`.`id` AS `consecutivo`, `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`celular`, `sp`.`email`, `shp`.`numero_cuota`, `shp`.`fecha_pago`, `shp`.`fecha_pagada`, `shp`.`valor_pagado`, `sm`.`periodo` FROM `sofi_historial_pagos` `shp` INNER JOIN `sofi_matricula` `sm` ON `sm`.`id` = `shp`.`consecutivo` INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `shp`.`valor_pagado` > 0 AND `shp`.`fecha_pagada` BETWEEN :inicio AND :fin;";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":inicio", $inicio);
		$consulta->bindParam(":fin", $fin);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	//Función para listar los pagos
    public function listarPagosPorIdentificacion($identificacion){
        $sql= "SELECT `sm`.`id` AS `consecutivo`, `sp`.`numero_documento`, `sp`.`nombres`, `sp`.`apellidos`, `sp`.`celular`, `sp`.`email`, `shp`.`numero_cuota`, `shp`.`fecha_pago`, `shp`.`fecha_pagada`, `shp`.`valor_pagado`, `sm`.`periodo` FROM `sofi_historial_pagos` `shp` INNER JOIN `sofi_matricula` `sm` ON `sm`.`id` = `shp`.`consecutivo` INNER JOIN `sofi_persona` `sp` ON `sp`.`id_persona` = `sm`.`id_persona` WHERE `shp`.`valor_pagado` != 0 AND `sp`.`numero_documento` LIKE :identificacion";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":identificacion", $identificacion);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	
	 //listar pago detalle
    public function listarPagosDetalle($id_pago){  
		$sql="SELECT * FROM `pagos_rematricula` WHERE id_pagos= :id_pago";  
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_pago", $id_pago);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }

		 //taer semestre actual
		 public function traersemestre($id_estudiante){  
			$sql="SELECT id_estudiante,semestre_estudiante FROM `estudiantes` WHERE id_estudiante= :id_estudiante";  
			global $mbd;
			$consulta = $mbd->prepare($sql);
			$consulta->bindParam(":id_estudiante", $id_estudiante);
			$consulta->execute();
			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

}