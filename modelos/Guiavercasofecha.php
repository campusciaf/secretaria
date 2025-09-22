<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
class Estado
{
    public function guia_buscar($mes,$ano)
    {
        $periodo_actual = $_SESSION['periodo_actual'];
        global $mbd;
        $sentencia = $mbd->prepare("SELECT uno.caso_id, uno.caso_asunto, uno.created_at, uno.caso_estado, uno.categoria_caso, CONCAT(dos.usuario_nombre,' ',dos.usuario_nombre_2,' ',dos.usuario_apellido,' ',dos.usuario_apellido_2) as nombre FROM guia_casos AS uno INNER JOIN docente AS dos ON uno.id_docente = dos.id_usuario WHERE uno.created_at like '$ano-$mes%' ORDER BY `uno`.`created_at` DESC ");
        // SELECT uno.caso_id, uno.caso_asunto, uno.created_at, uno.caso_estado, uno.categoria_caso, CONCAT(dos.usuario_nombre,' ',dos.usuario_nombre_2,' ',dos.usuario_apellido,' ',dos.usuario_apellido_2) FROM guia_casos AS uno INNER JOIN docente as dos on uno.id_docente = dos.id_usuario WHERE uno.created_at like '$ano-$mes%' ORDER BY `uno`.`created_at` DESC
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

    public function nombre_usuario($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(`usuario_nombre`,' ',`usuario_nombre_2`,' ',`usuario_apellido`,' ',`usuario_apellido_2`) AS nombre FROM `usuario` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }

    public function guia_convertir_fecha($date) 
    {
        $dia    = explode("-", $date, 3);
        $year   = $dia[0];
        $month  = (string)(int)$dia[1];
        $day    = (string)(int)$dia[2];

        $dias       = array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia    = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
    }

}


?>