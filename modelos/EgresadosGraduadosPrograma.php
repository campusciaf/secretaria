<?php
require "../config/Conexion.php";

class EgresadosGraduadosPrograma
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function periodoactual()
    {
        $sql = "SELECT * FROM on_periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar los estuidantes nuevos
    public function listargraduadosegresado($id_programa)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON ce.id_credencial=est.id_credencial INNER JOIN estudiantes_datos_personales edp ON edp.id_credencial=est.id_credencial  WHERE est.id_programa_ac= :id_programa and (est.estado='2' or est.estado='5')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los departamentos en un select
    public function selectPrograma()
    {
        $sql = "SELECT * FROM programa_ac order by nombre ASC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
}
