<?php

require_once "../modelos/Estado_estudiante.php";

class ControllerEstado
{
    public function consultaEstudiante($cedula)
    {
        Estado::consultaEstudiante($cedula);
    }
    public function estadoEst($estado,$cedula)
    {
        Estado::estadoEst($estado,$cedula);
    }
}


switch ($_GET['op']) {
    case 'consultaEstudiante':
        $cedula = $_POST['cedula'];
        $obj = new ControllerEstado();
        $obj->consultaEstudiante($cedula);
        break;
    case 'estadoEst':
        $estado = $_POST['estado'];
        $cedula = $_POST['cedula'];
        $obj = new Estado();
        $obj->estadoEst($estado,$cedula);
        break;
    case 'prueba':
        $cedula = "1088034238";
        $estado = "0";
        Estado::estadoEst($estado,$cedula);
        break;
}


?>