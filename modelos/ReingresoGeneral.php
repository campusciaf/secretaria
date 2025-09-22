<?php
require "../config/Conexion.php";

class ReingresoGeneral
{
  //Implementamos nuestro constructor
  public function __construct()
  {
  }
  public function periodoactual()
  {
    $sql = "SELECT * FROM periodo_actual";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado;
  }
  //Implementar un método para traer las escuelas
  public function listarescuelas()
  {

    $sql = "SELECT * FROM escuelas WHERE estado='1' ORDER BY orden ASC";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    // $consulta->bindParam(":relacion", $relacion);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }
  public function nombreescuela($id_escuela)
  {
    $sql = "SELECT * FROM escuelas WHERE id_escuelas= :id_escuela ";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_escuela", $id_escuela);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado;
  }


  //Implementar un método para traer la cantidad de estudiantes por escuela
  public function traerestudiantes($id_escuela)
  {

    $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial WHERE est.escuela_ciaf= :id_escuela and est.ciclo < 4";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_escuela", $id_escuela);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }


//Implementar un método para saber si termino
public function traerfinal($id_credencial,$ciclo){
    $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and ciclo= :ciclo and (estado=2 or estado=5)";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_credencial", $id_credencial);
    $consulta->bindParam(":ciclo", $ciclo);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado;
    }








      //Implementar un método para traer la cantidad de estudiantes por escuela
  public function traerestudiantesunicos($id_escuela)
  {

    $sql = "SELECT DISTINCT id_credencial from estudiantes WHERE escuela_ciaf= :id_escuela";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_escuela", $id_escuela);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }

    //Implementar un método para traer la cantidad de estudiantes por escuela
    public function datosestudiante($id_credencial)
    {
  
      $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial WHERE est.id_credencial= :id_credencial";
      global $mbd;
      $consulta = $mbd->prepare($sql);
      $consulta->bindParam(":id_credencial", $id_credencial);
      $consulta->execute();
      $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
      return $resultado;
    }

    //Implementar un método para traer el sigueinte ciclo
    public function terminoProfesional($id_credencial,$ciclo){
        $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and ciclo= :ciclo and (estado=2 or estado=5)";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":ciclo", $ciclo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para saber si esta estudiando este periodo
    public function estaActivo($id_credencial,$periodo_actual){
        $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and periodo_activo= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    
    //Implementar un método para traer el sigueinte ciclo
    public function traersiguiente($id_credencial,$ciclo){
        $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and ciclo= :ciclo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":ciclo", $ciclo);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


}
