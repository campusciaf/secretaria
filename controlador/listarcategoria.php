<?php
require_once "../modelos/Listarcategoria.php";
$listar = new Listar();

switch ($_GET['op']) {
    case 'listarProgra':
        $listar->listarMateria();
        break;
    case 'listarJornada':
        $listar->listarJornada();
        break;
    case 'consultaEstudiantes':
        $programa = $_POST['programa'];
        $jornada = $_POST['jornada'];
        $semestre = $_POST['semestre'];
        $listar->consultaEstudiantes($programa,$jornada,$semestre);
        break;
}

?>