<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Historial_Estudiante_QuedateVerCaso
{
    public function caso($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` WHERE `caso_id` = :id ");
        $sentencia->bindParam(":id",$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
    public function seguimientos($id_caso)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT seguimiento_contenido, seguimiento_tipo_encuentro, seguimiento_beneficio,created_at,docente,evidencia_seguimiento FROM `seguimientos` WHERE caso_id = :id ORDER BY `seguimientos`.`created_at` ASC ");
        $sentencia->bindParam(":id",$id_caso);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function tareas($id_caso)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT tarea_asunto,tarea_contenido,tarea_fecha_ejecucion,created_at,docente FROM tareas WHERE caso_id = :id ORDER BY `tareas`.`created_at` ASC ");
        $sentencia->bindParam(":id",$id_caso);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function remsiones($id_caso)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT remision_observacion,remision_para,remision_desde, remision_fecha as created_at FROM remisiones WHERE caso_id = :id ORDER BY `created_at` ASC ");
        $sentencia->bindParam(":id",$id_caso);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function datos_docente()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(usuario_nombre,' ',usuario_nombre_2,' ',usuario_apellido,' ',usuario_apellido_2) AS nombre, id_usuario FROM `docente` WHERE `usuario_condicion` = 1 ORDER BY `nombre` ASC ");
        $sentencia->execute();
        echo json_encode($sentencia->fetchAll(PDO::FETCH_ASSOC));
    }

    public function nombre_docente($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(usuario_nombre,' ',usuario_nombre_2,' ',usuario_apellido,' ',usuario_apellido_2) AS nombre FROM `docente` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['nombre'];
    }

    public function agregar_seguimiento($descripcion,$id,$encuentro,$recomendacion,$evidencia,$docente){
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" INSERT INTO `seguimientos`(`seguimiento_contenido`, `seguimiento_tipo_encuentro`, `seguimiento_beneficio`, `docente`, `evidencia_seguimiento`, `caso_id`, `area_id`) VALUES (:descripcion,:encuentro,:recomendacion,:docente,:evidencia,:id,:id_usuario) ");
        $sentencia->bindParam(":descripcion",$descripcion);
        $sentencia->bindParam(":encuentro",$encuentro);
        $sentencia->bindParam(":recomendacion",$recomendacion);
        $sentencia->bindParam(":docente",$docente);
        $sentencia->bindParam(":evidencia",$evidencia);
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":id_usuario",$id_user);

        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
            $data['msj'] = "Error al hacer el registro.";
            $data['info'] = array($descripcion,$id,$encuentro,$recomendacion,$evidencia,$docente);
        }
        echo json_encode($data);
    }

    public function agregar_tarea($asunto,$id,$fecha,$descripcion,$referencia,$docente)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" INSERT INTO `tareas`(`tarea_asunto`, `tarea_contenido`, `tarea_fecha_ejecucion`, `tarea_referencia`,`docente`, `caso_id`, `area_id`) VALUES (:asunto,:descripcion,:fecha,:referencia,:docente,:id,:id_user) ");
        $sentencia->bindParam(":asunto",$asunto);
        $sentencia->bindParam(":descripcion",$descripcion);
        $sentencia->bindParam(":fecha",$fecha);
        $sentencia->bindParam(":referencia",$referencia);
        $sentencia->bindParam(":docente",$docente);
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":id_user",$id_user);

        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);
        
    }

    public function estado_tareas()
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $fecha = date("Y-m-d H:i:s");
        $sentencia = $mbd->prepare(" SELECT * FROM `tareas` WHERE tarea_finalizada = '0' AND area_id = $id_user AND `tarea_fecha_ejecucion` >= '$fecha' ORDER BY `tareas`.`created_at` DESC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function estado_remisiones()
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT *, remision_fecha as created_at FROM `remisiones` WHERE remision_para = $id_user AND remision_visualizada = 0 ORDER BY `remisiones`.`remision_fecha` DESC ");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambia_estado_remision($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `remisiones` SET `remision_visualizada` = 1 WHERE `remision_id` = $id ");
        $sentencia->execute();
    }

    public function listar_dependencias()
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" SELECT dos.id_usuario, uno.nombre FROM `dependencias`as uno INNER JOIN usuario as dos ON uno.nombre=dos.usuario_cargo WHERE dos.id_usuario != $id_user ORDER BY `uno`.`nombre` ASC ");
        $sentencia->execute();
        echo json_encode ($sentencia->fetchAll(PDO::FETCH_ASSOC));
    }

    public function consulta_dependencia($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT `usuario_cargo`,`usuario_login` FROM `usuario` WHERE `id_usuario` = $id ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function agregar_remision($observacion,$dependencia,$id)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" INSERT INTO `remisiones`(`remision_observacion`, `remision_para`, `remision_desde`, `caso_id`) VALUES (:observacion,:dependencia,:id_user,:id) ");
        $sentencia->bindParam(':observacion',$observacion);
        $sentencia->bindParam(':dependencia',$dependencia);
        $sentencia->bindParam(':id_user',$id_user);
        $sentencia->bindParam(':id',$id);
        if ($sentencia->execute()) {
            $data['status'] = 'ok';
        } else {
            $data['status'] = 'error';
        }

        echo json_encode($data);
        
    }

    public function cerrar_caso($id,$observacion,$logro,$evidencia,$categoria_cerrar)
    {
        global $mbd;
        $id_user = $_SESSION['id_usuario'];
        $sentencia = $mbd->prepare(" INSERT INTO `seguimientos`(`seguimiento_contenido`,  `seguimiento_beneficio`, `evidencia_seguimiento`, `caso_id`, `area_id`) VALUES (:observacion,:logro,:evidencia,:id,:id_usuario) ");
        $sentencia->bindParam(":observacion",$observacion);
        $sentencia->bindParam(":logro",$logro);
        $sentencia->bindParam(":evidencia",$evidencia);
        $sentencia->bindParam(":id",$id);
        $sentencia->bindParam(":id_usuario",$id_user);

        if ($sentencia->execute()) {
            $data['status'] = 'ok';
            $sentencia2 = $mbd->prepare(" UPDATE `casos` SET `caso_estado` = 'Cerrado',`evidencia` = '$evidencia',`cerrado_por` = '$id_user', `categoria_caso_cerrado` = '$categoria_cerrar' WHERE `caso_id` = $id ");
            $sentencia2->execute();
        } else {
            $data['status'] = 'error';
            $data['msj'] = "Error al cerrar el caso.";
        }

        echo json_encode($data);
    }

    public function consulta_id_caso($id_caso)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `casos` WHERE caso_id = $id_caso ");
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function consultaEstudiante($id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM credencial_estudiante INNER JOIN estudiantes_datos_personales ON credencial_estudiante.id_credencial = estudiantes_datos_personales.id_credencial WHERE credencial_estudiante.id_credencial = :id_credencial");
        $sentencia->bindParam(":id_credencial",$id_credencial);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;

    }

    public function consultaProgramas($id_credencial){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `estudiantes` where id_credencial = :id_credencial ");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        return $registro;
    }


    public function mostrarCategoria()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `categoria_casos_cerrados` ");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($registro);
    }




}


?>