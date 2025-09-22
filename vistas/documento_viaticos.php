<?php
require "../config/Conexion.php";
session_start();
// archivo donde se genera la impresión 
$id_solicitud		=	$_GET['id'];
$periodo_actual		= 	'2019-2';
// bloque php donde se guarda la información del documento que se va imprimir para realizar el pago por financiera
global $mbd;
$sentencia=$mbd->prepare("SELECT * FROM solicitudes_viaticos WHERE periodo='$periodo_actual' AND id='$id_solicitud'");
$sentencia->execute();
$array_sql_solicitud = $sentencia->fetch(PDO::FETCH_ASSOC);



$id_docente 			=	$array_sql_solicitud['id_docentes'];
$sql_doc_y_ad=$mbd->prepare("SELECT usuario_identificacion,usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2 FROM docente WHERE id_usuario='$id_docente'");
$sql_doc_y_ad->execute();

$array_doc_y_ad			=	$sql_doc_y_ad->fetch(PDO::FETCH_ASSOC);
$docente				=	$array_doc_y_ad['usuario_nombre']." ".$array_doc_y_ad['usuario_nombre_2']." ".$array_doc_y_ad['usuario_apellido']." ".$array_doc_y_ad['usuario_apellido_2'];

$cedula_docente         =   $array_doc_y_ad['usuario_identificacion'];
?>
<body onLoad="window.print()"> 
	<!-- en el cuerpo del archuivo se generara el documento que estara disponible para imprimirse o guardarse en pdf, para continuar con el proceso -->
<meta charset='utf-8'/>

<div style="width: 100%; display: flex;">
	<div style="width: 50%; text-align: left;">
		<b>SOLICITUD GASTOS DE MOVILIZACIÓN</b><br/><br/>
		<b>Docente:</b><?php echo" ".$docente; ?><br/>
		<b>Identificación:</b><?php echo" ".$cedula_docente; ?>
	</div>
	<div style="width: 50%; text-align: right;">
		<img src="../../public/img/imagenes/logo_nuevo.png" style="width: 200px;">
	</div>
</div>


	<table border="1" cellspacing="0" width="95%" cellpadding="8" style="font-size: 12px; ">

				<?php
					$sql_detalles_solicitud_1			=	$mbd->prepare("SELECT colegios_articulacion.tarifa FROM detalle_solicitud LEFT JOIN colegios_articulacion ON detalle_solicitud.id_colegio=colegios_articulacion.id WHERE detalle_solicitud.id_solicitud='$id_solicitud'");
					$sql_detalles_solicitud_1->execute();
					$total_viaticos						=	0;
					while($array_detalles_solicitud_1	=	$sql_detalles_solicitud_1->fetch(PDO::FETCH_ASSOC))
					{
						$total_viaticos				    =	$total_viaticos + $array_detalles_solicitud_1['tarifa'];	
					}
				?>
		<tr>
			<td colspan="2">
				<label> Valor Gastos Movilización:</label><br><br>
			</td>
			<td colspan="2" style="text-align: right">
			<label> <?php echo '$ '. number_format($total_viaticos,0,",",".")?></label>
			</td>
		</tr>	
		
		<tr>
			<td colspan="4" ><center><h3>Detalles Solicitud</h3></center></td>
		</tr>
		<tr>
			<td>Fecha</td>
			<td>Colegio</td>
			<td>Municipio</td>
			<td>Valor</td>
		</tr>
		<?php
			$sql_detalles_solicitud		=	$mbd->prepare("SELECT colegios_articulacion.tarifa,colegios_articulacion.nombre AS nombre_colegio,detalle_solicitud.fecha_actividad,municipios_articulacion.nombre AS nombre_municipio FROM detalle_solicitud LEFT JOIN colegios_articulacion ON detalle_solicitud.id_colegio=colegios_articulacion.id LEFT JOIN municipios_articulacion ON colegios_articulacion.id_municipio=municipios_articulacion.id WHERE detalle_solicitud.id_solicitud='$id_solicitud'");
			$sql_detalles_solicitud->execute();
		while($array_detalles_solicitud	=	$sql_detalles_solicitud->fetch(PDO::FETCH_ASSOC)){
		?>
		<tr>
			<td><?php echo $array_detalles_solicitud['fecha_actividad'] ?></td>
			<td><?php echo $array_detalles_solicitud['nombre_colegio'] ?></td>
			<td><?php echo $array_detalles_solicitud['nombre_municipio'] ?></td>
			<td><?php echo '$ '. number_format($array_detalles_solicitud['tarifa'],0,",",".") ?></td>
		</tr>
		<?php } ?>
		<br><tr>
			<td colspan="4" ><center><h3>Información Pago</h3></center></td>
		</tr>
		<tr>
			<td colspan="2">
				<label>__________________________</label><br>
				<label>Fecha Pago</label>
			</td>
			<td colspan="2" style="text-align: right" >
				<label>__________________________</label><br>
				<label>Valor Pago</label>
			</td>
		</tr>
	</table><br><br>
	
	<table cellspacing="0" width="90%" cellpadding="8" style="font-size: 12px;">
	<tr>
		<td colspan="2">
				<label>__________________________</label><br>
				<label>Coordinación Administrativa</label>
		</td>
		<td colspan="2" style="text-align: right">
				<label>__________________________</label><br>
				<label>Responsable</label>
		</td>
		</tr>
	</table>
 </body>