<?php
require "../config/Conexion.php";

Class ConsultaTotalEscuelas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

    //Implementar un método para listar las escuelas
    public function listarescuelas()
    {	
    
        $sql="SELECT * FROM escuelas Where estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los estuidantes nuevos
    public function listarelprogramas($id_escuelas)
    {	
    
        $sql="SELECT * FROM programa_ac WHERE escuela= :id_escuelas and estado_total_escuelas='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuelas", $id_escuelas);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	//Implementar un método para mostrar todos losprogramas de la plataforma
	public function totalprogramas()
	{
		$sql="SELECT * FROM programa_ac";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}

    	//Implementamos un método para cambiar de estado al programa
	public function cambioestado($id_programa,$estado)
	{
		$sql="UPDATE programa_ac SET estado_total_escuelas= :estado WHERE id_programa= :id_programa";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}






    




    //Implementar un método para listar los estuidantes nuevos
    public function listarprogramas($relacion)
    {	
  
        $sql="SELECT * FROM programa_ac WHERE relacion= :relacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":relacion", $relacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los estuidantes nuevos
    public function listarestudiantes($id_programa)
    {	
        $periodo_actual=$_SESSION['periodo_actual'];

        $sql="SELECT * FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1' and id_programa_ac= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los estuidantes nuevos
    public function listarestudiantesnuevos($id_programa)
    {	
        $periodo_actual=$_SESSION['periodo_actual'];

        $sql="SELECT * FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1' and id_programa_ac= :id_programa and periodo='".$periodo_actual."' and admisiones='si' and homologado='1' ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para listar los estuidantes homologados
     public function listarestudiantesnuevoshomologados($id_programa)
     {	
         $periodo_actual=$_SESSION['periodo_actual'];
 
         $sql="SELECT * FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1' and id_programa_ac= :id_programa and periodo='".$periodo_actual."' and admisiones='si' and homologado='0' ";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":id_programa", $id_programa);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }

      //Implementar un método para listar los estuidantes internos
      public function listarestudiantesinternos($id_programa)
      {	
          $periodo_actual=$_SESSION['periodo_actual'];
  
          $sql="SELECT * FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1' and id_programa_ac= :id_programa and periodo='".$periodo_actual."' and admisiones='no' and homologado='1' ";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":id_programa", $id_programa);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }

      //Implementar un método para listar los estuidantes rematriculados
      public function listarestudiantesrematricula($id_programa)
      {	
          $periodo_actual=$_SESSION['periodo_actual'];
  
          $sql="SELECT * FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1' and id_programa_ac= :id_programa and periodo!='".$periodo_actual."' ";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":id_programa", $id_programa);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }

       //Implementar un método para listar los estuidantes rematriculados
       public function listartotal($id_programa)
       {	
           $periodo_actual=$_SESSION['periodo_actual'];
   
           $sql="SELECT * FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1' and id_programa_ac= :id_programa";
           global $mbd;
           $consulta = $mbd->prepare($sql);
           $consulta->bindParam(":id_programa", $id_programa);
           $consulta->execute();
           $resultado = $consulta->fetchAll();
           return $resultado;
       }


    //    public function listarsindobles()
    //    {	
    //        $periodo_actual=$_SESSION['periodo_actual'];
   
    //        $sql="SELECT DISTINCT id_credencial  FROM estudiantes WHERE periodo_activo='".$periodo_actual."' and estado='1'";
    //        global $mbd;
    //        $consulta = $mbd->prepare($sql);
    //        $consulta->execute();
    //        $resultado = $consulta->fetchAll();
    //        return $resultado;
    //    }

 
        // public function solodobles()
        // {	
        //     $periodo_actual=$_SESSION['periodo_actual'];  
        //     $sql="SELECT id_credencial,periodo_activo,estado FROM estudiantes GROUP BY id_credencial,periodo_activo,estado HAVING COUNT( * ) > 1";
        //     global $mbd;
        //     $consulta = $mbd->prepare($sql);
        //     $consulta->execute();
        //     $resultado = $consulta->fetchAll();
        //     return $resultado;
        // }
      



	
}

?>