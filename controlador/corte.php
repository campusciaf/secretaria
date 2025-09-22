<?php 
require_once "../modelos/Corte.php";
$corte = new Corte();
switch ($_GET['op']) {
    case 'consulta':
        $corte->consulta();
        break;
    case 'cambiarCorte':
        $newCorte = $_POST['corte'];
        $corte->cambiarCorte($newCorte);
        break;
}

?>