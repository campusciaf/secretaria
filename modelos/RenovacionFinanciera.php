<?php
// Se incluye el archivo de conexión a la base de datos
require "../config/Conexion.php";

Class RenovacionFinanciera{
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


    
    // Implementamos una función para cargar los estudiantes que estan pendientes por renovar
    public function listargeneralporrenovar($periodo_anterior){
      $sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_anterior and renovar='1' and (estado='1' or estado='2' or estado='5')";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":periodo_anterior", $periodo_anterior);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }

      // Implementamos una función para cargar los estudiantes que renovaron
      public function listargeneralrenovaron($periodo_actual){
          $sql = "SELECT * FROM pagos_rematricula WHERE x_respuesta= 'Aceptada' and periodo_pecuniario= :periodo_actual";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":periodo_actual", $periodo_actual);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }
      // Implementamos una función para cargar los estudiantes que renovaron
      public function listargeneralrenovaroncontadopp($periodo_actual){
        $sql = "SELECT * FROM pagos_rematricula WHERE x_respuesta= 'Aceptada' and tiempo_pago='pp-e' and periodo_pecuniario= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
     
      public function listarestudaintesrenovaron($periodo_actual){
        $sql = "SELECT * FROM pagos_rematricula WHERE x_respuesta= 'Aceptada' and periodo_pecuniario= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

        // Implementamos una función para cargar los estudiantes que renovaron
        public function listarestudiantesrenovaroncontadopp($periodo_actual){
            $sql = "SELECT * FROM pagos_rematricula WHERE x_respuesta= 'Aceptada' and tiempo_pago='pp-e' and periodo_pecuniario= :periodo_actual";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":periodo_actual", $periodo_actual);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }




      public function listarestudaintesporrenovar($periodo_anterior){
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo_anterior and est.estado='1' and est.renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

      // Implementamos una función para cargar los estudiantes que faltan por renovar por nivel
    public function listargeneralporrenovarnivel($periodo_anterior,$nivel){
      $sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_anterior and renovar='1' and ciclo= :nivel and estado='1'";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":periodo_anterior", $periodo_anterior);
      $consulta->bindParam(":nivel", $nivel);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }

     // Implementamos una función para listar los los estuidantes que renovaron por nivel
     public function listargeneralrenovaronnivel($periodo_actual,$nivel){
      $sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_actual and estado='1' and periodo!= :periodo_actual and ciclo= :nivel";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":periodo_actual", $periodo_actual);
      $consulta->bindParam(":nivel", $nivel);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }

     // Implementamos una función para listar los los estuidantes que renovaron por nivel
     public function  listarestudaintesrenovaronnivel($periodo_actual,$nivel){
      $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo!= :periodo_actual and  est.periodo_activo= :periodo_actual and est.estado='1' and est.ciclo= :nivel";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":periodo_actual", $periodo_actual);
      $consulta->bindParam(":nivel", $nivel);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }

   

  public function listarestudaintesporrenovarnivel($periodo_anterior,$nivel){
      $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo_anterior and est.estado='1' and est.renovar='1' and est.ciclo= :nivel";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":periodo_anterior", $periodo_anterior);
      $consulta->bindParam(":nivel", $nivel);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }



     // Implementamos una función para cargar los programas asociados
     public function programaAc($profesional){
        $sql = "SELECT * FROM programa_ac WHERE profesional= :profesional ORDER BY id_programa ASC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":profesional", $profesional);

        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    // Implementamos una función para cargar los jorandas de por renovar activas
    public function jornadas(){
      $sql = "SELECT nombre,estado,codigo FROM jornada WHERE porrenovar='1'";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }

      // Implementamos una función para cargartodas las jornadas
      public function jornadastodas(){
        $sql = "SELECT id_jornada,nombre,estado,codigo,porrenovar FROM jornada";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

      public function traernumeropendientes($id_programa,$elsemestre,$jornadafila,$temporadainactivos){
       $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornadafila and temporada < :temporadainactivos and  renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":elsemestre", $elsemestre);
        $consulta->bindParam(":jornadafila", $jornadafila);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

      





    public function traernumero($id_programa,$elsemestre,$jornada,$periodo){
      $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo!= :periodo and periodo_activo= :periodo and renovar='1' ";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":id_programa", $id_programa);
      $consulta->bindParam(":elsemestre", $elsemestre);
      $consulta->bindParam(":jornada", $jornada);
      $consulta->bindParam(":periodo", $periodo);
      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    }





  // Implementamos una función para cargartodas las jornadas
  public function activarjornada($id_jornada,$valor){
    $sql = "UPDATE jornada SET porrenovar= :valor WHERE id_jornada= :id_jornada";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_jornada", $id_jornada);
    $consulta->bindParam(":valor", $valor);
    return $consulta->execute();
  }

    public function verestudiantesinactivos($id_programa,$jornada,$semestre,$temporadainactivos){
      $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.temporada< :temporadainactivos and est.renovar='1'";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":id_programa", $id_programa);
      $consulta->bindParam(":jornada", $jornada);
      $consulta->bindParam(":semestre", $semestre);
      $consulta->bindParam(":temporadainactivos", $temporadainactivos);

      $consulta->execute();
      $resultado = $consulta->fetchAll();
      return $resultado;
    
  }

  public function verestudiantes($id_programa,$jornada,$semestre,$periodo,$porrenovar){
    $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and periodo!= :periodo and est.periodo_activo= :periodo  and est.renovar= :porrenovar";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_programa", $id_programa);
    $consulta->bindParam(":jornada", $jornada);
    $consulta->bindParam(":semestre", $semestre);
    $consulta->bindParam(":periodo", $periodo);
    $consulta->bindParam(":porrenovar", $porrenovar);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }

  public function verestudiantesok($id_programa,$jornada,$semestre,$periodo){
    $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and periodo!= :periodo and est.periodo_activo= :periodo";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_programa", $id_programa);
    $consulta->bindParam(":jornada", $jornada);
    $consulta->bindParam(":semestre", $semestre);
    $consulta->bindParam(":periodo", $periodo);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }

  public function sumanumeroinactivos($id_programa,$jornadafila,$temporadainactivos){
    $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornadafila and temporada < :temporadainactivos and  renovar='1'";
     global $mbd;
     $consulta = $mbd->prepare($sql);
     $consulta->bindParam(":id_programa", $id_programa);
     $consulta->bindParam(":jornadafila", $jornadafila);
     $consulta->bindParam(":temporadainactivos", $temporadainactivos);
     $consulta->execute();
     $resultado = $consulta->fetchAll();
     return $resultado;
   }

   public function sumanumeropendiente($id_programa,$jornada,$periodo){
    $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo!= :periodo and periodo_activo= :periodo and renovar='1'";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_programa", $id_programa);
    $consulta->bindParam(":jornada", $jornada);
    $consulta->bindParam(":periodo", $periodo);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }



   public function verestudiantesinactivostotal ($id_programa,$jornada,$temporadainactivos){
    $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.temporada< :temporadainactivos and renovar='1'";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_programa", $id_programa);
    $consulta->bindParam(":jornada", $jornada);
    $consulta->bindParam(":temporadainactivos", $temporadainactivos);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }

  public function verestudiantestotal($id_programa,$jornada,$periodo,$porrenovar){
    $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and periodo!= :periodo and est.periodo_activo= :periodo  and est.renovar= :porrenovar";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_programa", $id_programa);
    $consulta->bindParam(":jornada", $jornada);
    $consulta->bindParam(":periodo", $periodo);
    $consulta->bindParam(":porrenovar", $porrenovar);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }

  public function verestudiantesoktotal($id_programa,$jornada,$periodo){
    $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and periodo!= :periodo and est.periodo_activo= :periodo and est.renovar='1'";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_programa", $id_programa);
    $consulta->bindParam(":jornada", $jornada);
    $consulta->bindParam(":periodo", $periodo);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }




/* consultas por meta */


      // Implementamos una función paracargar los que deben renovar segun la meta
      public function porrenovarmeta($jornada,$periodo_anterior){
        $sql = "SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo_activo= :periodo_anterior and renovar='1' and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

       // Implementamos una función paracargar los que deben renovar que renovaron
       public function renovaronmeta($jornada,$periodo_actual){
        $sql = "SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo!= :periodo_actual and periodo_activo= :periodo_actual and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

      public function listarrenovaronmeta($jornada,$periodo){
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.jornada_e= :jornada and periodo!= :periodo and est.periodo_activo= :periodo and est.estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
      }

      public function listarporrenovarmeta($jornada,$periodo){
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='1' and est.renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
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
		$sql="UPDATE programa_ac SET estado_renovacion_financiera= :estado WHERE id_programa= :id_programa";
		
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_programa", $id_programa);
		$consulta->bindParam(":estado", $estado);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
		
	}

		//Implementamos un método para traer losd atos del programa del estudiante 
    public function datosprograma($id_programa)
    {
      $sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
      
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":id_programa", $id_programa);
      $consulta->execute();
      $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
      return $resultado;
      
    } 

    		//Implementamos un método para ctraer losd atos de la joranda del estudainte
        public function datosjornada($jornada)
        {
          $sql="SELECT * FROM escuela_jornada WHERE jornada= :jornada";
          
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":jornada", $jornada);
          $consulta->execute();
          $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
          return $resultado;
          
        } 

        public function traerdatosestudiante($id_estudiante){
          $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_estudiante= :id_estudiante";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":id_estudiante", $id_estudiante);
          $consulta->execute();
          $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
        }

 
}
?>