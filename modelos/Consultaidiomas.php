<?php
require "../config/Conexion.php";

Class Consulta
{
	//Implementamos nuestro constructor
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

    
    //Implementar un método para listar los periodos en un select
	public function selectPeriodo()
	{	
		$sql="SELECT * FROM periodo order by id_periodo DESC";
		//return ejecutarConsulta($sql);
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    //Implementar un método para traer las escuelas
    public function selectEscuelas()
    {	
        $sql="SELECT * FROM escuelas WHERE estado='1' ORDER BY orden ASC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        // $consulta->bindParam(":relacion", $relacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer la cantidad de estudiantes por escuela
    public function estudiantesactivos($periodo,$id_escuela)
    {	
    
        if($id_escuela==''){
            $sql="SELECT * FROM estudiantes_activos ea INNER JOIN credencial_estudiante ce ON ea.id_credencial=ce.id_credencial WHERE ea.periodo= :periodo and (ea.escuela != '7' and ea.escuela !='4') and ea.nivel !=5 and (ea.programa !=93 and ea.programa !=94 and ea.programa !=71)";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":periodo", $periodo);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }else{
        $sql="SELECT * FROM estudiantes_activos ea INNER JOIN credencial_estudiante ce ON ea.id_credencial=ce.id_credencial WHERE ea.escuela= :id_escuela and ea.periodo= :periodo and ea.nivel !=5 and (ea.programa !=93 and ea.programa !=94 and ea.programa !=71)";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_escuela", $id_escuela);
            $consulta->bindParam(":periodo", $periodo);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }
        
    }

    //Implementar un método para traer  los datos de la tabla programa ac
    public function programa($id_programa)
    {	
        $sql="SELECT id_programa,nombre FROM programa_ac WHERE id_programa= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para traer  los programas del nivel a1 de idiomas
    public function nivel($id_credencial,$id_programa)
    {	
        $sql="SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and id_programa_ac= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

        //Implementar un método para traer la asigatura del nivel de idiomas
        public function nivelasignatura($id_estudiante,$asignatura)
        {	
            $sql="SELECT * FROM materias6 WHERE id_estudiante= :id_estudiante and nombre_materia= :asignatura";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_estudiante", $id_estudiante);
            $consulta->bindParam(":asignatura", $asignatura);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }




}

?>