<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Header_Estudiante{
    // metodo para traer el periodo
    public function periodoactual(){
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarTema($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT id_credencial,modo_ui FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
    public function listarPuntos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT id_credencial,puntos,nivel FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
     	//Implementar un método para saber si acepto los datos 
	public function verificarseres($id_credencial)
	{
		$sql="SELECT * FROM carseresoriginales WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
       	//Implementar un método para saber si acepto los datos 
	public function verificarinspiradores($id_credencial)
	{
		$sql="SELECT * FROM carinspiradores WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    public function verificarempresas($id_credencial)
	{
		$sql="SELECT * FROM carempresas WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    public function verificarconfiamos($id_credencial)
	{
		$sql="SELECT * FROM carconfiamos WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    public function verificarexp($id_credencial)
	{
		$sql="SELECT * FROM carexperiencia WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    public function verificarbienestar($id_credencial)
	{
		$sql="SELECT * FROM carbienestar WHERE id_credencial= :id_credencial and estado=0";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
    public function verificar_veedor($id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `veedores` WHERE `id_credencial` = :id_credencial AND `estado` = 0");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function guardarConfirmacionVeedor($id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `veedores` SET `estado` = 1 WHERE `id_credencial` = :id_credencial");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        return $sentencia->execute();
    }

    public function consulta_programas($id){
        // metodo que trae los programas activos
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare("SELECT * FROM `estudiantes` WHERE `id_credencial` = :id AND `periodo_activo` = :periodo and estado = '1' AND `fo_programa` NOT LIKE '%Idiomas%'");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function consulta_materias($id, $ciclo){
        // metodo que trae las materias matriculadas
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare("SELECT * FROM `materias$ciclo` WHERE `id_estudiante` = :id AND `periodo` = :periodo");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function consulta_grupo($materia, $jornada, $semestre, $programa, $grupo){
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $consulta = $mbd->prepare("SELECT `docente_grupos`.* FROM `docente_grupos` INNER JOIN `materias_ciafi` ON `materias_ciafi`.`id` = `docente_grupos`.`id_materia` WHERE `materias_ciafi`.`nombre` = :materia AND `docente_grupos`.`jornada` = :jornada AND `docente_grupos`.`semestre` = :semestre AND `docente_grupos`.`id_programa` = :programa AND `docente_grupos`.`periodo` = :periodo AND `docente_grupos`.`grupo` = :grupo");
        $consulta->bindParam(":materia", $materia);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":programa", $programa);
        $consulta->bindParam(":grupo", $grupo);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function consulta_heteroevaluacion($id_estudiante, $id_docente, $id_docente_grupo){
        $periodo = $_SESSION['periodo_actual'];
        //echo "SELECT * FROM `heteroevaluacion` WHERE `id_estudiante` = $id_estudiante AND id_docente = $id_docente AND id_docente_grupos = $id_docente_grupo AND periodo = $periodo";
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `heteroevaluacion` WHERE `id_estudiante` = :id_estudiante AND id_docente = :id_docente AND id_docente_grupos = :id_docente_grupo AND periodo = :periodo");
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function verificarEstadoEvaluacion(){
        global $mbd;
        $consulta = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = 'heteroevaluacion'");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function verificarCalificaciones($id_usuario){
        $periodo = $_SESSION['periodo_actual'];
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `heteroevalucionstatus` WHERE `id_usuario`= :id_usuario AND periodo= :periodo");
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar las titulaciones
    public function listartitulaciones($id_credencial){
        $sql = "SELECT id_estudiante,id_programa_ac,ciclo,grupo FROM estudiantes WHERE id_credencial= :id_credencial and estado=1"; // el estado solo muestra las matriculadas
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
        //mirar si soy egresada en el periodo actual
    public function egresadaperiodoactual($id_credencial){
        $periodo = $_SESSION['periodo_actual'];
        $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and estado=1 and periodo_activo= :periodo"; // el estado solo muestra las matriculadas
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
         $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function nombredelprogramaterminal($id_programa_ac){
        global $mbd;
        $consulta = $mbd->prepare("SELECT nombre,original,carnet,campus FROM `programa_ac` WHERE `id_programa` = :id_programa_ac");
        $consulta->bindParam(":id_programa_ac", $id_programa_ac);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function consultaEstudiante(){
        global $mbd;
        $id = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM credencial_estudiante WHERE id_credencial = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function encuentaEstDigital(){
        global $mbd;
        $id = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT * FROM encuestaidiomas2024 WHERE id_credencial = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function insertarencuesta($credencial, $fecha, $hora, $pre1, $pre2, $pre3, $pre4, $pre5, $pre6, $pre7){
        $sql = "INSERT INTO encuestaidiomas2024 (id_credencial,fecha,hora,r1,r2,r3,r4,r5,r6,r7) VALUES ('$credencial','$fecha','$hora','$pre1','$pre2','$pre3','$pre4','$pre5','$pre6','$pre7')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    // consulta para tomar el estado de evaluacion docente preguntas nuevas.
    public function verificarEstadoEvaluacionDocente(){
        global $mbd;
        $consulta = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = 'evaluaciondocente'");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function consulta_evaluacion_docente($id_estudiante, $id_docente, $id_docente_grupo){
        $periodo = $_SESSION['periodo_actual'];
        global $mbd;
        $consulta = $mbd->prepare("SELECT * FROM `encuesta_evaluacion` WHERE `id_estudiante` = :id_estudiante AND id_docente = :id_docente AND id_docente_grupos = :id_docente_grupo AND periodo = :periodo");
        $consulta->bindParam(":id_docente", $id_docente);
        $consulta->bindParam(":id_docente_grupo", $id_docente_grupo);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

  
}