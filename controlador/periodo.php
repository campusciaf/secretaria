<?php 

require_once "../modelos/Periodo.php";

switch ($_GET['op']) {
    case 'periodoActual':
        Periodo::periodoActual();
        break;
    case 'updatePeriodo':
        $periodo = $_POST['periodo'];
        Periodo::updatePeriodo($periodo);
        break;
    case 'aggPeriodo':
        $periodo = $_POST['periodo'];
        Periodo::aggPeriodo($periodo);
        break;
}


?>