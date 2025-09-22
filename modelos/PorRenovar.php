<?php
// Se incluye el archivo de conexión a la base de datos
require "../config/Conexion.php";

Class PorRenovar{
    // Implementamos nuestro constructor
    public function __construct()
    {
        
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


    // Implementamos una función para cargar el periodo anterior
    public function cargarPeriodo(){
        $sql = "SELECT periodo_anterior,periodo_actual,periodo_pecuniario FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta -> execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function listar($id_escuela,$periodo_anterior){

        if($id_escuela==0){// significa todas las escuelas
            $sql = "SELECT * FROM estudiantes_activos est 
            INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial 
            INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial 
            WHERE est.periodo= :periodo_anterior";
        }else{
            $sql = "SELECT 
                est.*, 
                est.id_estudiante AS mi_id_estudiante, -- aquí renombras el campo
                ce.id_credencial,
                ce.credencial_nombre,
                ce.credencial_apellido,
                ce.credencial_identificacion,
                ce.nivel AS nivel_ciclo, 
                edp.*
             FROM estudiantes_activos est 
            INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial 
            INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial 
            WHERE est.periodo= :periodo_anterior AND est.escuela=$id_escuela";
        }

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta -> bindParam(":periodo_anterior", $periodo_anterior);
        $consulta -> execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
          
     
    }

    public function peridoactivoestudiante($id_estudiante){


       $sql = "SELECT id_estudiante,periodo_activo FROM estudiantes WHERE id_estudiante= :id_estudiante ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta -> bindParam(":id_estudiante", $id_estudiante);
        $consulta -> execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
          
     
    }
    
    public function renovo($id_credencial,$periodo){


       $sql = "SELECT * FROM estudiantes_activos WHERE id_credencial= :id_credencial AND periodo= :periodo and escuela !=4 ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta -> bindParam(":id_credencial", $id_credencial);
        $consulta -> bindParam(":periodo", $periodo);
        $consulta -> execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
          
     
    }

    //Implementar un método para traer el horario dela tabla horario fijo
    public function traer_nom_escuela($id_escuela)
    {
        $sql="SELECT * FROM escuelas WHERE id_escuelas= :id_escuela";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para traer el nombre del programa
    public function traer_nom_programa($id_programa)
    {
        $sql="SELECT * FROM programa_ac WHERE id_programa= :id_programa";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

       //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
       public function verificarjornada($jornada)
       {
           $sql="SELECT nombre,rematricula FROM jornada WHERE nombre= :jornada";
           global $mbd;
           $consulta = $mbd->prepare($sql);
           $consulta->bindParam(":jornada", $jornada);
           $consulta->execute();
           $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
           return $resultado;
       }

           //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($numero_documento){
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    
    public function obtenerRegistroWhastapp($numero_celular){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
        $sentencia->bindParam(':numero_celular', $numero_celular);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
    public function buscarpagos($identificacion,$periodo_pecuniario)
    {
        $sql="SELECT * FROM pagos_rematricula WHERE identificacion_estudiante= :identificacion and periodo_pecuniario= :periodo_pecuniario and x_respuesta='Aceptada'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para verificar a jornada de estudio si es una joranda para renovar
    public function buscarcredito($identificacion,$periodo_pecuniario)
    {
        $sql="SELECT * FROM sofi_persona WHERE numero_documento= :identificacion and periodo= :periodo_pecuniario and estado='Aprobado'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->bindParam(":periodo_pecuniario", $periodo_pecuniario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    
}
?>