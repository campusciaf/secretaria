<?php

require_once "../modelos/Disponibilidad_salones.php";
$reser = new Reserva();

$fecha = date("Y-m-d");
$pe = $reser->periodoactual();

$reser->cambiarestado($fecha,$pe);

?>