<?php
require "../config/Conexion.php";

Class ConsultaCifras
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
    //Implementar un método para traer las escuelas
    public function listarescuelas()
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
    public function traerestudiantes($id_escuela,$periodo_actual)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE escuela_ciaf= :id_escuela and periodo_activo= :periodo_actual and estado='1' and consulta_cifras='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer la cantidad de estudiantes por escuela
    public function traerestudiantesnuevos($id_escuela,$periodo_actual)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE escuela_ciaf= :id_escuela and periodo= :periodo_actual and estado='1' and admisiones='si'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer las jorandas por programa
    public function traerjornadas($id_escuela)
    {	
    
        $sql="SELECT * FROM escuela_jornada WHERE escuela= :id_escuela and sede='CIAF'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer las jorandas por programa
    public function traerjornadasarticulacion($id_escuela)
    {	
    
        $sql="SELECT * FROM escuela_jornada WHERE escuela= :id_escuela and sede != 'CIAF'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    
    //Implementar un método para traer  los datos de la tabla programa ac
    public function traerdatosprograma ($id_escuela)
    {	
    
        $sql="SELECT id_programa,nombre FROM programa_ac WHERE escuela= :id_escuela";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer  los datos de los graduados general
    public function traergraduados($id_programa,$periodo_anterior)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and (estado='5' or estado='2') and periodo_activo= :periodo_anterior";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer  los datos de los graduados ciaf
    public function traergraduadosciaf($id_programa,$jornada,$periodo_anterior)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and (estado='5' or estado='2') and periodo_activo= :periodo_anterior";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer  los datos de los graduados laborales
    public function traerestudiantesprogramagraduados($id_programa,$periodo_anterior)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and (estado='5' or estado='2') and periodo_activo= :periodo_anterior";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);

        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer  los datos de los programas terminales de la tabla programa ac
    public function listarprogramaterminal($id_escuela)
    {	
    
        $sql="SELECT id_programa,nombre,escuela,terminal FROM programa_ac WHERE escuela= :id_escuela and terminal='0'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

        //Implementar un método para traer  los datos de los programas terminales del intep
        public function listarprogramaterminalintep($id_programa)
        {	
        
            $sql="SELECT id_programa,nombre,escuela,terminal FROM programa_ac WHERE id_programa= :id_programa and terminal='0'";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_programa", $id_programa);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }

    //Implementar un método para traer  los datos de la tabla programa ac
    public function traerdatosprogramauniversidad($universidad)
    {	
        $sql="SELECT id_programa,nombre,universidad FROM programa_ac WHERE universidad= :universidad";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":universidad", $universidad);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para traer  los datos de la la sede ciaf del progama de contaduria
    public function traerdatosprogramacontaduria($id_escuela)
    {	
        $sql="SELECT id_programa,nombre,escuela,universidad FROM programa_ac WHERE escuela= :id_escuela and universidad IS NULL";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function traerestudiantesjornadaciaf($id_escuela,$periodo_actual,$jornada)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE escuela_ciaf= :id_escuela and periodo_activo= :periodo_actual and jornada_e= :jornada and estado='1' and consulta_cifras='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para traer  los datos de estudiantes nuevos 
     public function traerestudiantesjornadaciafnuevos($id_escuela,$periodo_actual,$jornada)
     {	
     
         $sql="SELECT * FROM estudiantes WHERE escuela_ciaf= :id_escuela and periodo= :periodo_actual and jornada_e= :jornada and estado='1' and admisiones='si'";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":id_escuela", $id_escuela);
         $consulta->bindParam(":periodo_actual", $periodo_actual);
         $consulta->bindParam(":jornada", $jornada);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }


 //Implementar un método para traer  los datos de estudiantes nuevos 
    public function traerdatosestudiantesnuevossede($id_escuela,$periodo_actual)
    {	
    
        $sql="SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.escuela_ciaf= :id_escuela and est.periodo= :periodo_actual and est.estado='1' and est.admisiones='si'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":periodo_actual", $periodo_actual);

        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    

     //Implementar un método para traer  los datos de estudiantes que renovaron 
     public function traerestudiantesjornadaciafrenovaron($id_escuela,$periodo_actual,$jornada)
     {	
     
         $sql="SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.jornada_e= :jornada and est.periodo!= :periodo_actual and est.escuela_ciaf= :id_escuela and est.estado='1' and est.periodo_activo= :periodo_actual ";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":id_escuela", $id_escuela);
         $consulta->bindParam(":periodo_actual", $periodo_actual);
         $consulta->bindParam(":jornada", $jornada);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }

     //Implementar un método para traer  los datos de estudiantes que renovaron 
     public function traerestudiantesjornadaciafrenovaroninternos($id_escuela,$periodo_actual,$jornada)
     {	
     
         $sql="SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.jornada_e= :jornada and est.periodo= :periodo_actual and est.escuela_ciaf= :id_escuela and est.estado='1' and est.periodo_activo= :periodo_actual and est.admisiones='no' and est.homologado='1'";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":id_escuela", $id_escuela);
         $consulta->bindParam(":periodo_actual", $periodo_actual);
         $consulta->bindParam(":jornada", $jornada);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }

    //Implementar un método para listar los estuidantes que renovaron
    public function listarrematricula($id_escuela,$periodo_actual)
    {	

        $sql="SELECT * FROM estudiantes WHERE periodo!= :periodo_actual and escuela_ciaf= :id_escuela and estado='1' and periodo_activo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los estuidantes que renovaron
    public function listarrematriculajornadaciaf($id_escuela,$periodo_actual,$jornada)
    {	

        $sql="SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo!= :periodo_actual and escuela_ciaf= :id_escuela and estado='1' and periodo_activo= :periodo_actual and consulta_cifras='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
         


    //Implementar un método para traer  los datos de estudiantes por programa
    public function traerestudiantesprograma($id_programa,$periodo_actual)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo_activo= :periodo_actual and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


     //Implementar un método para traer  los datos de estudiantes por programa que iniciaron de la tabla estudiantes_activos
     public function traerestudiantesprogramainicio($id_programa,$periodo_anterior)
     {	
     
         $sql="SELECT * FROM estudiantes_activos WHERE programa= :id_programa and periodo= :periodo_anterior";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":id_programa", $id_programa);
         $consulta->bindParam(":periodo_anterior", $periodo_anterior);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }

       //Implementar un método para traer  los datos de estudiantes  quer renovaron por programa
       public function traerestudiantesprogramarenovaron($id_programa,$periodo_actual)
       {	
       
           $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo != :periodo_actual and estado='1' and periodo_activo= :periodo_actual ";
           global $mbd;
           $consulta = $mbd->prepare($sql);
           $consulta->bindParam(":id_programa", $id_programa);
           $consulta->bindParam(":periodo_actual", $periodo_actual);
           $consulta->execute();
           $resultado = $consulta->fetchAll();
           return $resultado;
       }
          //Implementar un método para traer  los datos de estudiantes  quer renovaron por programa
          public function traerestudiantesprogramarenovaroninterno($id_programa,$periodo_actual)
          {	
          
              $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo = :periodo_actual and estado='1' and periodo_activo= :periodo_actual and admisiones='no' and homologado='1'";
              global $mbd;
              $consulta = $mbd->prepare($sql);
              $consulta->bindParam(":id_programa", $id_programa);
              $consulta->bindParam(":periodo_actual", $periodo_actual);
              $consulta->execute();
              $resultado = $consulta->fetchAll();
              return $resultado;
          }
        //Implementar un método para traer  los datos de estudiantes que renovaronpor programa con internos
        public function traerestudiantesrenovaroninternosintep($id_programa,$periodo_actual)
        {	
        
            $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo = :periodo_actual and estado='1' and periodo_activo= :periodo_actual and admisiones='no' and homologado='1' ";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_programa", $id_programa);
            $consulta->bindParam(":periodo_actual", $periodo_actual);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }

        //Implementar un método para traer  los datos de estudiantes por programa nuevos
        public function traerestudiantesprogramanuevo($id_programa,$periodo_actual)
        {	
        
            $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo= :periodo_actual and estado='1' and admisiones='si'";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_programa", $id_programa);
            $consulta->bindParam(":periodo_actual", $periodo_actual);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }
   
    //Implementar un método para traer la cantidad de estudiantes por escuela
    public function traerestudiantesactivos($id_escuela,$periodo_actual)
    {	
    
        $sql="SELECT * FROM estudiantes_activos WHERE escuela= :id_escuela and periodo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para traer la cantidad de estudiantes de la tabla estudiantes activosde la sede CIAF
     public function traerestudiantesiniciociaf($id_escuela,$periodo_anterior,$jornada)
     {	
         $sql="SELECT * FROM estudiantes_activos WHERE jornada_e= :jornada and periodo= :periodo_anterior and escuela= :id_escuela ";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":jornada", $jornada);
         $consulta->bindParam(":periodo_anterior", $periodo_anterior);
         $consulta->bindParam(":id_escuela", $id_escuela);
         
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }


        // Implementar un método para traer la cantidad de estudiantes de la tabla estudiantes activosde la sede CIAF
        public function traerestudiantesrenovociaf($id_escuela,$periodo_actual,$jornada)
        {	
            $sql="SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo_activo= :periodo_actual and escuela_ciaf= :id_escuela and renovar='1' ";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":jornada", $jornada);
            $consulta->bindParam(":periodo_actual", $periodo_actual);
            $consulta->bindParam(":id_escuela", $id_escuela);
            
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }


    public function nombreescuela($id_escuela)
    {
        $sql="SELECT * FROM escuelas WHERE id_escuelas= :id_escuela ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para listar los estuidantes internos
    public function listarinternos($id_escuela,$periodo_actual)
    {	
    
        $sql="SELECT * FROM estudiantes WHERE periodo= :periodo_actual and escuela_ciaf= :id_escuela and estado='1' and periodo_activo= :periodo_actual and admisiones='no' and homologado='1' and consulta_cifras='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para listar los estuidantes internos
     public function listarinternosjornadaciaf($id_escuela,$periodo_actual,$jornada)
     {	
        
         $sql="SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo= :periodo_actual and escuela_ciaf= :id_escuela and estado='1' and periodo_activo= :periodo_actual and admisiones='no' and homologado='1' and consulta_cifras='1'";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":jornada", $jornada);
         $consulta->bindParam(":id_escuela", $id_escuela);
         $consulta->bindParam(":periodo_actual", $periodo_actual);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }

      //Implementar un método para listar los estuidantes internos
      public function listarinternosprogramarenovaron($id_programa,$periodo_actual)
      {	
         
          $sql="SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and periodo= :periodo_actual and estado='1' and periodo_activo= :periodo_actual and admisiones='no' and homologado='1' ";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":id_programa", $id_programa);
          $consulta->bindParam(":periodo_actual", $periodo_actual);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }



    //Implementar un método para listar los programas por escuela
    public function listarprogramas($id_escuelas)
    {	
  
        $sql="SELECT * FROM programa_ac WHERE escuela= :id_escuelas and relacion >0";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuelas", $id_escuelas);
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


     //traer datos sede ciaf
     public function traerdatos($id_escuela,$periodo_anterior)
     {	
         $sql="SELECT * FROM estudiantes_activos WHERE  periodo= :periodo_anterior and escuela= :id_escuela ";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":periodo_anterior", $periodo_anterior);
         $consulta->bindParam(":id_escuela", $id_escuela);
         
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }



    //traer datos sede ciaf
    public function traerdatosarticulacion($id_escuela,$periodo_anterior,$jornadaarticulacion)
    {	
        $sql="SELECT * FROM estudiantes_activos WHERE  periodo= :periodo_anterior and escuela= :id_escuela and jornada_e= :jornadaarticulacion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":jornadaarticulacion", $jornadaarticulacion);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
      
    //validar la joranda del estudiante
    public function validarjornada($id_escuela,$jornada)
    {	
    
        $sql="SELECT * FROM escuela_jornada WHERE escuela= :id_escuela and jornada= :jornada";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //validar la programa
    public function validarprograma($id_programa)
    {	
    
        $sql="SELECT id_programa, estado_renovacion_financiera, terminal, universidad  FROM programa_ac WHERE id_programa= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

        //validar la programa
        public function validarrenovacion($id_estudiante,$periodo_anterior)
        {	
        
            $sql="SELECT * FROM estudiantes_activos WHERE id_estudiante= :id_estudiante AND periodo= :periodo_anterior";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_estudiante", $id_estudiante);
            $consulta->bindParam(":periodo_anterior", $periodo_anterior);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }

           //validar la programa
           public function validarrenovacioninterno($credencial,$periodo_anterior)
           {	
           
               $sql="SELECT * FROM estudiantes_activos WHERE id_credencial= :credencial AND periodo= :periodo_anterior";
               global $mbd;
               $consulta = $mbd->prepare($sql);
               $consulta->bindParam(":credencial", $credencial);
               $consulta->bindParam(":periodo_anterior", $periodo_anterior);
               $consulta->execute();
               $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
               return $resultado;
           }

         

      public function dato_estudiante($id_estudiante){
        $sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_estudiante= :id_estudiante";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
      }

      public function dato_estudiante_credencial($id_credencial){
        $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
      }

      public function dato_estudiante_periodo_actual($id_credencial,$periodo_actual){
        $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and periodo_activo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
      }

          //Implementar un método para listar los estuidantes que renovaron
        public function traerdatosestudiantesrenovacionsede($id_escuela,$periodo_actual)
        {	

            $sql="SELECT * FROM estudiantes WHERE periodo!= :periodo_actual and escuela_ciaf= :id_escuela and estado='1' and periodo_activo= :periodo_actual and consulta_cifras='1'";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":periodo_actual", $periodo_actual);
            $consulta->bindParam(":id_escuela", $id_escuela);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }

            //Implementar un método para listar los estuidantes internos
        public function traerdatosestudiantesrenovacioninternasede($id_escuela,$periodo_actual)
        {	
            
            $sql="SELECT * FROM estudiantes WHERE periodo= :periodo_actual and escuela_ciaf= :id_escuela and estado='1' and periodo_activo= :periodo_actual and admisiones='no' and homologado='1' and consulta_cifras='1'";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_escuela", $id_escuela);
            $consulta->bindParam(":periodo_actual", $periodo_actual);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
            return $resultado;
        }

        public function miestado($estado){
            $sql = "SELECT * FROM estado_academico WHERE id_estado_academico= :estado";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":estado", $estado);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
          }


	
}

?>