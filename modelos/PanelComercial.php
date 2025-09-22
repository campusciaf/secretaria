<?php
session_start(); 
require "../config/Conexion.php";
class PanelComercial
{


    public function __construct() {
        
    }

    public function periodoactual(){
    	$sql="SELECT * FROM on_periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    
	//Implementar un método para listar
    public function listarUno($fecha)
    {
        $sql="SELECT * FROM on_interesados WHERE fecha_ingreso = :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	//Implementar un método para listar
    public function listarUnoSemana($fecha)
    {
        $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

	


    


    //Implementar un método para listar
    public function listarNombreDos($fecha,$estado)
    {
        $sql="SELECT * FROM `on_seguimiento` INNER JOIN `on_interesados` ON `on_seguimiento`.`id_estudiante` = `on_interesados`.`id_estudiante` WHERE fecha_seguimiento= :fecha and mensaje_seguimiento= :estado";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":estado", $estado);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    
    //Implementar un método para listar
    public function listarNombreDosSemana($fecha,$estado)
    {
        $sql="SELECT * FROM `on_seguimiento` INNER JOIN `on_interesados` ON `on_seguimiento`.`id_estudiante` = `on_interesados`.`id_estudiante` WHERE fecha_seguimiento>= :fecha and mensaje_seguimiento= :estado";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":estado", $estado);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para listar
    // public function listarDosSemana($fecha,$estado)
    // {
    //     $sql="SELECT * FROM on_seguimiento WHERE fecha_seguimiento >= :fecha and mensaje_seguimiento= :estado";
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->bindParam(":fecha", $fecha);
    //     $consulta->bindParam(":estado", $estado);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }

    //Implementar un método para listar los medios
    public function listarMedios()
    {
        $sql="SELECT * FROM on_medio WHERE estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    
    //Implementar un método para listar los medios con fecha
    public function listarDatosMedios($fecha,$nombremedio)
    {
        $sql="SELECT * FROM on_interesados WHERE fecha_ingreso= :fecha and medio= :nombremedio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":nombremedio", $nombremedio);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    

    //Implementar un método para listar los medios con fecha
    public function listarDatosMediosSemana($fecha,$nombremedio)
    {
        $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha and medio= :nombremedio";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":nombremedio", $nombremedio);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para listar las tareas creadas
     public function listarTarea($fecha)
     {
         $sql="SELECT * FROM on_interesados_tareas_programadas WHERE fecha_registro= :fecha";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha", $fecha);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }
     //Implementar un método para listar las tareas creadas
     public function listarTareaSemana($fecha)
     {
         $sql="SELECT * FROM on_interesados_tareas_programadas WHERE fecha_registro >= :fecha";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha", $fecha);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }
      //Implementar un método para listar las tareas realizadas
      public function listarTareaRealizadas($fecha)
      {
          $sql="SELECT * FROM on_interesados_tareas_programadas WHERE fecha_realizo= :fecha and estado = 0";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":fecha", $fecha);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }

      //Implementar un método para listar las tareas realizadas
      public function listarTareaRealizadasSemana($fecha)
      {
          $sql="SELECT * FROM on_interesados_tareas_programadas WHERE fecha_realizo >= :fecha and estado = 0";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":fecha", $fecha);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }

      //Implementar un método para listar los medios
      public function listarSeguimiento($fecha,$motivo)
      {

        // SELECT * FROM on_seguimiento INNER JOIN `usuario` ON `usuario`.`id_usuario` = on_seguimiento.`id_usuario` WHERE fecha_seguimiento= "2022-07-13" and motivo_seguimiento= "Seguimiento";

          $sql="SELECT * FROM on_seguimiento INNER JOIN `usuario` ON `usuario`.`id_usuario` = on_seguimiento.`id_usuario` WHERE fecha_seguimiento= :fecha and motivo_seguimiento= :motivo";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":fecha", $fecha);
          $consulta->bindParam(":motivo", $motivo);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }

      //Implementar un método para listar los medios
      public function listarSeguimientoSemana($fecha,$motivo)
      {
          $sql="SELECT * FROM on_seguimiento INNER JOIN `usuario` ON `usuario`.`id_usuario` = on_seguimiento.`id_usuario` WHERE fecha_seguimiento >= :fecha and motivo_seguimiento= :motivo";
          global $mbd;
          $consulta = $mbd->prepare($sql);
          $consulta->bindParam(":fecha", $fecha);
          $consulta->bindParam(":motivo", $motivo);
          $consulta->execute();
          $resultado = $consulta->fetchAll();
          return $resultado;
      }


      

      	//Implementar un método para listar los interesados
    public function listarInteresado($periodo)
    {
        $sql="SELECT * FROM on_interesados WHERE periodo_ingreso= :periodo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los demas estasdos en la tabla de seguimiento
    public function listarOtrosEstados($estado,$periodo)
    {
        $sql="SELECT * FROM on_cambioestado WHERE estado= :estado and periodo= :periodo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":estado", $estado);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar los interesados
        public function listarMatriculado($periodo,$estado)
        {
            $sql="SELECT * FROM on_interesados WHERE periodo_campana= :periodo and estado= :estado";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":periodo", $periodo);
            $consulta->bindParam(":estado", $estado);
            $consulta->execute();
            $resultado = $consulta->fetchAll();
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

        //Implementar un método para listar los interesados
        public function nombreestudiante($id_estudiante)
        {	
            $sql="SELECT * FROM on_interesados oni INNER JOIN on_interesados_datos onid ON oni.id_estudiante=onid.id_estudiante WHERE oni.id_estudiante= :id_estudiante";
            global $mbd;
            $consulta = $mbd->prepare($sql);
            $consulta->bindParam(":id_estudiante", $id_estudiante);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
        
            

    //Implementar un método para listar las tareas creadas
    public function listarRangoTarea($fecha_inicial,$fecha_final)
    {
        // SELECT * FROM on_interesados_tareas_programadas WHERE fecha_registro >= '2022-07-01' and fecha_registro <= '2022-07-20'
        $sql="SELECT * FROM on_interesados_tareas_programadas WHERE fecha_registro >= :fecha_inicial and fecha_registro <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar
    public function listarNombreDosRango($fecha_inicial,$fecha_final,$estado)
    {
        $sql="SELECT * FROM `on_seguimiento` INNER JOIN `on_interesados` ON `on_seguimiento`.`id_estudiante` = `on_interesados`.`id_estudiante` WHERE  fecha_seguimiento >= :fecha_inicial and fecha_seguimiento <= :fecha_final and mensaje_seguimiento= :estado";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->bindParam(":estado", $estado);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    //Implementar un método para listar las tareas creadas
    public function listarRangoTareaTerminada($fecha_inicial,$fecha_final)
    {
        // SELECT * FROM on_interesados_tareas_programadas WHERE fecha_registro >= '2022-07-01' and fecha_registro <= '2022-07-20'
        $sql="SELECT * FROM on_interesados_tareas_programadas WHERE fecha_registro >= :fecha_inicial and fecha_registro <= :fecha_final and estado = 0";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar
    public function listarUnoRango($fecha_inicial,$fecha_final)
    {
        // fecha_ingreso >= :fecha_inicial and fecha_ingreso <= :fecha_final
        $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha_inicial and fecha_ingreso <= :fecha_final";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_inicial", $fecha_inicial);
        $consulta->bindParam(":fecha_final", $fecha_final);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
     //Implementar un método para listar
     public function listarDosRango($fecha_inicial,$fecha_final,$estado)
     {
         $sql="SELECT * FROM on_seguimiento WHERE fecha_seguimiento >= :fecha_inicial and fecha_seguimiento <= :fecha_final and mensaje_seguimiento= :estado";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha_inicial", $fecha_inicial);
         $consulta->bindParam(":fecha_final", $fecha_final);
         $consulta->bindParam(":estado", $estado);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }

     //Implementar un método para listar los medios
     public function listarSeguimientoRango($fecha_inicial,$fecha_final,$motivo)
     {

       // SELECT * FROM on_seguimiento INNER JOIN `usuario` ON `usuario`.`id_usuario` = on_seguimiento.`id_usuario` WHERE fecha_seguimiento= "2022-07-13" and motivo_seguimiento= "Seguimiento";

         $sql="SELECT * FROM on_seguimiento INNER JOIN `usuario` ON `usuario`.`id_usuario` = on_seguimiento.`id_usuario` WHERE fecha_seguimiento >= :fecha_inicial and fecha_seguimiento <= :fecha_final and motivo_seguimiento= :motivo";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha_inicial", $fecha_inicial);
         $consulta->bindParam(":fecha_final", $fecha_final);
         $consulta->bindParam(":motivo", $motivo);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }


     //Implementar un método para listar
    public function listarDos($fecha,$estado)
    {
        $sql="SELECT * FROM on_seguimiento WHERE fecha_seguimiento= :fecha and mensaje_seguimiento= :estado";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":estado", $estado);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para listar
    public function sinexito($fecha,$estado)
    {
        $sql="SELECT * FROM on_interesados WHERE fecha_ingreso= :fecha and estado= :estado";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->bindParam(":estado", $estado);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

     //Implementar un método para listar
     public function sinexitosemana($fecha,$estado)
     {
         $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha and estado= :estado";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha", $fecha);
         $consulta->bindParam(":estado", $estado);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }



     //Implementar un método para listar los medios
     public function sinexitoRango($fecha_inicial,$fecha_final,$estado)
     {

      
         $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha_inicial and fecha_ingreso <= :fecha_final and estado= :estado";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha_inicial", $fecha_inicial);
         $consulta->bindParam(":fecha_final", $fecha_final);
         $consulta->bindParam(":estado", $estado);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }



     //Implementar un método para listar
     public function listarDatosMediosRango($fecha_inicial,$fecha_final,$nombremedio)
     {
         $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha_inicial and fecha_ingreso <= :fecha_final and medio= :nombremedio";
         global $mbd;
         $consulta = $mbd->prepare($sql);
         $consulta->bindParam(":fecha_inicial", $fecha_inicial);
         $consulta->bindParam(":fecha_final", $fecha_final);
         $consulta->bindParam(":nombremedio", $nombremedio);
         $consulta->execute();
         $resultado = $consulta->fetchAll();
         return $resultado;
     }


      //Implementar un método para listar los medios con fecha
    //   public function listarDatosMediosRango($fecha_inicial,$fecha_final,$nombremedio)
    //   {
    //       $sql="SELECT * FROM on_interesados WHERE fecha_ingreso >= :fecha_inicial and fecha_ingreso <= :fecha_final and mensaje_seguimiento= :estado";
    //       global $mbd;
    //       $consulta = $mbd->prepare($sql);
    //       $consulta->bindParam(":fecha_inicial", $fecha_inicial);
    //      $consulta->bindParam(":fecha_final", $fecha_final);
    //       $consulta->bindParam(":nombremedio", $nombremedio);
    //       $consulta->execute();
    //       $resultado = $consulta->fetchAll();
    //       return $resultado;
    //   }



     //Implementar un método para listar los medios
    //  public function mostrarmarketin($fecha,$motivo)
    //  {

    //    // SELECT * FROM on_seguimiento INNER JOIN `usuario` ON `usuario`.`id_usuario` = on_seguimiento.`id_usuario` WHERE fecha_seguimiento= "2022-07-13" and motivo_seguimiento= "Seguimiento";

    //      $sql="SELECT * FROM on_interesados WHERE fecha_ingreso= :fecha and medio= :nombremedio";
    //      global $mbd;
    //      $consulta = $mbd->prepare($sql);
    //      $consulta->bindParam(":fecha", $fecha);
    //      $consulta->bindParam(":motivo", $motivo);
    //      $consulta->execute();
    //      $resultado = $consulta->fetchAll();
    //      return $resultado;
    //  }
     


   
}

?>