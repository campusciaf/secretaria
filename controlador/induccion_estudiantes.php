<?php 
require_once "../modelos/InduccionEstudiantes.php";

$induccion_estudiantes = new InduccionEstudiantes();
$op = (isset($_GET['op']))?$_GET['op']:'mostrar';
switch ($op) {
    case 'verificar':
        $identificacion = $_POST['identificacion'];
        $nombre_texto = $_POST['nombre'];
        $nombre = ucwords(strtolower($nombre_texto));
        $programa = $_POST['programa'];
        $inspirador_texto = $_POST['inspirador'];
        $inspirador = ucwords(strtolower($inspirador_texto));
        $parentesco_texto = $_POST['parentesco'];
        $parentesco= ucwords(strtolower($parentesco_texto));
        $registrar_datos_estudiante = $induccion_estudiantes->registrarDatosEstudiante($identificacion,$nombre,$programa,$inspirador,$parentesco);

        if ($registrar_datos_estudiante) {
            echo 1;
        }
    break;
}
?>