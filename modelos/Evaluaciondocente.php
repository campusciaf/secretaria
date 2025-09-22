<?php 
session_start(); 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Evaluacion
{
    public function consulta_programas($id)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `estudiantes` WHERE `id_credencial` = :id AND `periodo_activo` = :periodo ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consulta_materias($id,$ciclo)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `materias$ciclo` WHERE `id_estudiante` = :id AND `periodo` = :periodo ");
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function traeridmateria($materia,$programa){// consulta para traer el id de la materia
        global $mbd;
        $sentencia = $mbd->prepare("SELECT id FROM `materias_ciafi`  WHERE nombre= :materia AND id_programa_ac= :programa");
        $sentencia->bindParam(":materia",$materia);
        $sentencia->bindParam(":programa",$programa);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    
    public function consulta_grupo($id_materia,$jornada,$semestre,$programa,$grupo)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare("SELECT id_docente_grupo,id_docente FROM `docente_grupos`  WHERE `id_programa` = :programa AND `id_materia`= :id_materia AND `jornada` = :jornada AND `semestre` = :semestre AND `grupo` = :grupo AND `periodo` = :periodo");
        $sentencia->bindParam(":id_materia",$id_materia);
        $sentencia->bindParam(":jornada",$jornada);
        $sentencia->bindParam(":semestre",$semestre);
        $sentencia->bindParam(":programa",$programa);
        $sentencia->bindParam(":grupo",$grupo);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function preguntas_heteroevaluacion(){
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `preguntas_heteroevaluacion` WHERE `estado` = 1 ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function estado(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `estado` FROM `activar_evaluaciones` WHERE `tipo` = 'heteroevaluacion'");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function registro($id_docente_grupo,$id_usuario,$id_docente,$id_estudiante,$pregunta1,$pregunta2,$pregunta3,$pregunta4,$pregunta5,$pregunta6,$pregunta7,$pregunta8,$pregunta9,$pregunta10,$pregunta11,$pregunta12,$pregunta13,$pregunta14,$pregunta15,$pregunta16,$pregunta17, $pregunta18, $pregunta19, $pregunta20, $pregunta21, $pregunta22, $pregunta23)
    {
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $fecha = date('Y-m-d');
        $totalsuma = ($pregunta1 + $pregunta2 + $pregunta3 + $pregunta4 + $pregunta5 + $pregunta6 + $pregunta7);
        $total = round(($totalsuma / 35) * 100);// 35 es la suma maxima 
        $sentencia = $mbd->prepare("INSERT INTO `heteroevaluacion`(`id_usuario`,`id_estudiante`, `id_docente`, `id_docente_grupos`, `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `p7`, `p8`, `p9`, `p10`,`p11`,`p12`,`p13`,`p14`,`p15`,`p16`,`p17`,`p18`,`p19`,`p20`,`p21`,`p22`,`p23`, `total`, `fecha`, `periodo`) VALUES (:id_usuario,:id_estudiante,:id_docente,:id_docente_grupos,:pregunta1,:pregunta2,:pregunta3,:pregunta4,:pregunta5,:pregunta6,:pregunta7,:pregunta8,:pregunta9,:pregunta10,:pregunta11,:pregunta12,:pregunta13,:pregunta14,:pregunta15,:pregunta16,:pregunta17,:pregunta18,:pregunta19,:pregunta20,:pregunta21,:pregunta22,:pregunta23,:total,:fecha,:periodo)");
        //echo "INSERT INTO `heteroevaluacion`(`id_estudiante`,`id_usuario`, `id_docente`, `id_docente_grupos`, `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `p7`, `p8`, `p9`, `p10`,`p11`,`p12`,`p13`,`p14`,`p15`,`p16`,`p17`,`p18`,`p19`,`p20`,`p21`,`p22`,`p23`, `total`, `fecha`, `periodo`) VALUES ('$id_estudiante','$id_docente','$id_docente_grupo','$pregunta1','$pregunta2','$pregunta3','$pregunta4','$pregunta5','$pregunta6','$pregunta7','$pregunta8','$pregunta9','$pregunta10','$pregunta11','$pregunta12','$pregunta13','$pregunta14','$pregunta15','$pregunta16','$pregunta17','$pregunta18','$pregunta19','$pregunta20','$pregunta21','$pregunta22','$pregunta23','$total','$fecha','$periodo')";
        $sentencia->bindParam(":id_estudiante",$id_estudiante);
        $sentencia->bindParam(":id_usuario",$id_usuario);
        $sentencia->bindParam(":id_docente",$id_docente);
        $sentencia->bindParam(":id_docente_grupos",$id_docente_grupo);
        $sentencia->bindParam(":pregunta1",  $pregunta1);
        $sentencia->bindParam(":pregunta2",  $pregunta2);
        $sentencia->bindParam(":pregunta3",  $pregunta3);
        $sentencia->bindParam(":pregunta4",  $pregunta4);
        $sentencia->bindParam(":pregunta5",  $pregunta5);
        $sentencia->bindParam(":pregunta6",  $pregunta6);
        $sentencia->bindParam(":pregunta7",  $pregunta7);
        $sentencia->bindParam(":pregunta8",  $pregunta8);
        $sentencia->bindParam(":pregunta9",  $pregunta9);
        $sentencia->bindParam(":pregunta10", $pregunta10);
        $sentencia->bindParam(":pregunta11", $pregunta11);
        $sentencia->bindParam(":pregunta12", $pregunta12);
        $sentencia->bindParam(":pregunta13", $pregunta13);
        $sentencia->bindParam(":pregunta14", $pregunta14);
        $sentencia->bindParam(":pregunta15", $pregunta15);
        $sentencia->bindParam(":pregunta16", $pregunta16);
        $sentencia->bindParam(":pregunta17", $pregunta17);
        $sentencia->bindParam(":pregunta18", $pregunta18);
        $sentencia->bindParam(":pregunta19", $pregunta19);
        $sentencia->bindParam(":pregunta20", $pregunta20);
        $sentencia->bindParam(":pregunta21", $pregunta21);
        $sentencia->bindParam(":pregunta22", $pregunta22);
        $sentencia->bindParam(":pregunta23", $pregunta23);
        $sentencia->bindParam(":total",$total);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":periodo",$periodo);
        if($sentencia->execute()){
            $data['status'] = 'ok';
        }else {
            $data['status'] = 'error';
        }
        echo json_encode($data);
    }

    public function consulta_respondio($id_docente_grupo,$id_docente,$id_estudiante){// consulta para saber si ra realizo la evaluación
        global $mbd;
        $periodo = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT total FROM `heteroevaluacion` WHERE id_estudiante = :id_estudiante AND id_docente = :id_docente AND id_docente_grupos = :id_docente_grupo AND periodo = :periodo ");
        $sentencia->bindParam(":id_estudiante",$id_estudiante);
        $sentencia->bindParam(":id_docente",$id_docente);
        $sentencia->bindParam(":id_docente_grupo",$id_docente_grupo);
        $sentencia->bindParam(":periodo",$periodo);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function datos_docente($id_docente)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT usuario_identificacion,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2 FROM docente WHERE `id_usuario` = :id_docente ");
        $sentencia->bindParam(":id_docente",$id_docente);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function terminar()
    {
        global $mbd;
        $id_usuario=$_SESSION["id_usuario"];
        $periodo = $_SESSION['periodo_actual'];
       
        $sentencia = $mbd->prepare("INSERT INTO `heteroevalucionstatus`(`id_usuario`,`periodo`) VALUES (:id_usuario,:periodo)");
        $sentencia->bindParam(":id_usuario",$id_usuario);
        $sentencia->bindParam(":periodo",$periodo);
        return $sentencia->execute();

    }

        
	//Implementar un método para mirar si el punto esta otorgado
	public function validarpuntos($evento){	
        $id=$_SESSION["id_usuario"];
        $periodo = $_SESSION['periodo_actual'];
		$sql=" SELECT * FROM puntos WHERE id_credencial= :id and punto_nombre= :evento and punto_periodo= :periodo";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
		$consulta->bindParam(":evento", $evento);
        $consulta->bindParam(":periodo", $periodo);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

    //Insertar punto en tabla puntos
	public function insertarPunto($punto_nombre,$puntos_cantidad,$punto_fecha,$punto_hora)
	{
        $id_credencial=$_SESSION["id_usuario"];
        $punto_periodo = $_SESSION['periodo_actual'];
		$sql="INSERT INTO puntos (`id_credencial`, `punto_nombre`, `puntos_cantidad`, `punto_fecha`, `punto_hora`, `punto_periodo`) VALUES ('$id_credencial','$punto_nombre','$puntos_cantidad','$punto_fecha','$punto_hora','$punto_periodo')";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		return $consulta->execute();
	}

    //Implementar un método para ver los puntos del estudiante
	public function verpuntos(){	
        $id=$_SESSION["id_usuario"];
		$sql=" SELECT * FROM credencial_estudiante WHERE id_credencial= :id";
		global $mbd;
		$consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id", $id);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;	
	}

	//Implementamos un método para actualizar el valor de los puntos
	public function actulizarValor($puntos)
	{
        $id=$_SESSION["id_usuario"];
		$sql="UPDATE credencial_estudiante SET puntos= :puntos WHERE id_credencial= :id ";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id", $id);
        $consulta->bindParam(":puntos", $puntos);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}






}




?>