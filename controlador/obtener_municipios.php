<?php
require "../config/Conexion.php";

	$dep     		= $_POST['departamento'];
	$sql_municipio 	= mysqli_query($conexion,"SELECT * FROM municipios WHERE departamento_id='$dep'");
	$respuesta      = '<option value="vacio">Seleccione Un Municipio</option>';
	while($resultado_municipio = mysqli_fetch_array($sql_municipio))
	{
		$id_encontrado=$resultado_municipio["id_municipio"];
		$respuesta	.=	"<option value='$resultado_municipio[id_municipio]'>$resultado_municipio[municipio]</option>";
	}
	echo $respuesta;

?>

