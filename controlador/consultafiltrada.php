<?php
require_once "../modelos/ConsultaFiltrada.php";
$consultafiltrada = new ConsultaFiltrada();

switch ($_GET['op']) {


	case "selectPrograma":	
		$rspta = $consultafiltrada->selectPrograma();
		echo "<option value='' disabled selected>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++){
		  echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;
	case "selectJornada":	
		$rspta = $consultafiltrada->selectJornada();
		echo "<option value='todos2'>Todas</option>";
		for ($i=0;$i<count($rspta);$i++){
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
        }
	break;
    case 'consultaEstudiantes':
        $programa = $_POST['programa'];
        $jornada = $_POST['jornada'];
        $semestre = $_POST['semestre'];
        $consultafiltrada->consultaEstudiantes($programa,$jornada,$semestre);
    break;

}
?>