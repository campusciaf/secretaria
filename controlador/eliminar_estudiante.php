<?php 

require_once "../modelos/Eliminar_estudiante.php";
$obj = new Eliminar();

switch ($_GET['op']) {
    case 'buscar':
        $cedula = $_POST['cedula'];
        $obj->buscar($cedula);
        break;
    case 'listarMateria':
        $id = $_GET['id'];
        $ciclo = $_GET['ciclo'];
        $obj->listarMateria($id,$ciclo);
        break;
    case 'consultaPrograma':
        $cedula = $_POST['id'];
        $obj->consultaPrograma($cedula);
        break;
    case 'deletePrograma':
        $id = $_POST['id'];
        $ciclo = $_POST['ciclo'];
        
        $obj->eliminarPrograma($id,$ciclo);
        break;
    case 'deleteEstudiante':
        $id = $_POST['id'];
        $ciclo = $_POST['ciclo'];
        $cedula = $_POST['cedula'];
        $programa = $_POST['programa'];
        $obj->deleteEstudiante($id,$ciclo,$cedula,$programa);
        break;
}


?>