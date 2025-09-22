<?php
require "../config/Conexion.php";

class NoContinuaron
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
  public function traerestudiantes($id_escuela, $temporada)
  {

    $sql = "SELECT * FROM estudiantes WHERE escuela_ciaf= :id_escuela and temporada <= :temporada and (estado='2' or estado='5') and ciclo='1'";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_escuela", $id_escuela);
    $consulta->bindParam(":temporada", $temporada);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }
  public function dato_estudiante_credencial($id_credencial)
  {
    $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial= :id_credencial";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_credencial", $id_credencial);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado;
  }
  public function mirarsicontinuo($id_credencial)
  {
    $sql = "SELECT * FROM estudiantes WHERE id_credencial= :id_credencial and ciclo='2'";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_credencial", $id_credencial);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado;
  }
  public function dato_estudiante($id_estudiante)
  {
    $sql = "SELECT * FROM estudiantes est INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_estudiante= :id_estudiante";
    global $mbd;
    $consulta = $mbd->prepare($sql);
    $consulta->bindParam(":id_estudiante", $id_estudiante);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado;
  }
}
