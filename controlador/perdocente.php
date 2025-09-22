<?php
require_once "../modelos/PerDocente.php";
$perdocente = new perdocente();

date_default_timezone_set("America/Bogota");	
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$mes_actual=date('Y-m')."-00";

switch ($_GET['op']) {

  case 'listarTema':
    $datos = $perdocente->listarTema();
    $modo_ui=$datos["modo_ui"];

    $data['conte'] = $modo_ui;
    echo json_encode($data);

  break;

  case 'cambioTema':
    $ancho=$_POST["ancho"];


    $valor='';

    if($ancho == "121px"){
      $valor=1;
    }else{
      $valor=0;
    }

    $datos2 = $perdocente->cambioTema($valor);
    $data['conte'] = '';
    echo json_encode($data);


  break;


}

?>