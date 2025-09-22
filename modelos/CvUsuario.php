<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class CvUsuario
{
    //Implementamos nuestro constructor
    public function __construct() {}

    public function cv_traerIdUsuario($documento)
    {
        $sql = "SELECT `id_usuario_cv` FROM `cv_usuario` WHERE `usuario_identificacion` = :documento";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':documento', $documento);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    //Implementamos un método para insertar registros
    public function registrarUsuario($usuario_identificacion, $usuario_nombre, $usuario_apellido, $usuario_email, $usuario_clave, $usuario_sexo)
    {
        $usuario_clave = hash("sha256", $usuario_clave);
        if ($usuario_sexo == 2) {
            $usuario_image = "avatar_mujer.png";
        } else {
            $usuario_image = "avatar_hombre.png";
        }
        $sql = "INSERT INTO cv_usuario (usuario_identificacion,usuario_nombre,usuario_apellido,usuario_email,usuario_clave,usuario_imagen,usuario_condicion) VALUES (:usuario_identificacion,:usuario_nombre,:usuario_apellido,:usuario_email,:usuario_clave,:usuario_imagen,1)";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
        $consulta->bindParam(":usuario_nombre", $usuario_nombre);
        $consulta->bindParam(":usuario_apellido", $usuario_apellido);
        $consulta->bindParam(":usuario_email", $usuario_email);
        $consulta->bindParam(":usuario_clave", $usuario_clave);
        $consulta->bindParam(":usuario_imagen", $usuario_image);
        return $consulta->execute();
    }
    //Implementamos un método para insertar cita
    public function insertar_cita($nombre_usuario, $celular_usuario, $mi_correo_electronico, $correo_electronico, $direccion_entrevista, $fecha_entrevista, $hora_entrevista, $comentario_entrevista, $id_usuario_cv)
    {
        $sql = "INSERT INTO `cv_entrevistas`(`nombre_usuario`, `celular_usuario`, `mi_correo_electronico`, `correo_electronico`, `direccion_entrevista`, `fecha_entrevista`, `hora_entrevista`, `comentario_entrevista`, `relizado_por`) VALUES (:nombre_usuario, :celular_usuario, :mi_correo_electronico, :correo_electronico, :direccion_entrevista, :fecha_entrevista, :hora_entrevista, :comentario_entrevista, :id_usuario_cv)";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->bindParam(":nombre_usuario", $nombre_usuario);
        $consulta->bindParam(":celular_usuario", $celular_usuario);
        $consulta->bindParam(":mi_correo_electronico", $mi_correo_electronico);
        $consulta->bindParam(":correo_electronico", $correo_electronico);
        $consulta->bindParam(":direccion_entrevista", $direccion_entrevista);
        $consulta->bindParam(":fecha_entrevista", $fecha_entrevista);
        $consulta->bindParam(":hora_entrevista", $hora_entrevista);
        $consulta->bindParam(":comentario_entrevista", $comentario_entrevista);
        return $consulta->execute();
    }
    public function editar($id_usuario_cv, $usuario_identificacion, $usuario_nombre, $usuario_apellido, $fecha_nacimiento, $departamento, $ciudad, $direccion, $telefono, $usuario_email)
    {
        global $mbd;
        $sql = "UPDATE cv_usuario SET usuario_identificacion = :usuario_identificacion, usuario_nombre = :usuario_nombre, usuario_apellido = :usuario_apellido, usuario_email = :usuario_email WHERE id_usuario_cv = :id_usuario_cv";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
        $consulta->bindParam(":usuario_nombre", $usuario_nombre);
        $consulta->bindParam(":usuario_apellido", $usuario_apellido);
        $consulta->bindParam(":usuario_email", $usuario_email);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $sql = "UPDATE cv_informacion_personal SET fecha_nacimiento = :fecha_nacimiento, departamento = :departamento, ciudad = :ciudad, direccion = :direccion, telefono = :telefono  WHERE id_usuario_cv = :id_usuario_cv";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $consulta->bindParam(":departamento", $departamento);
        $consulta->bindParam(":ciudad", $ciudad);
        $consulta->bindParam(":direccion", $direccion);
        $consulta->bindParam(":telefono", $telefono);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        return $consulta->execute();
    }
    //Implementamos un método para desactivar categorías
    public function desactivar($id_usuario_cv)
    {
        $sql = "UPDATE cv_usuario SET usuario_condicion='0' WHERE id_usuario_cv = :id_usuario_cv";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function activar($id_usuario_cv)
    {
        $sql = "UPDATE cv_usuario SET usuario_condicion='1' WHERE id_usuario_cv = :id_usuario_cv";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function contratar($id_usuario_cv)
    {
        $sql = "UPDATE cv_informacion_personal SET estado='contratado' WHERE id_usuario_cv= :id_usuario_cv";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function desvincular($id_usuario_cv)
    {
        $sql = "UPDATE cv_informacion_personal SET estado='desvinculado' WHERE id_usuario_cv= :id_usuario_cv";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function editarpassword($id_usuario, $usuario_cedula)
    {
        $sql = "UPDATE `referencias_personal` SET `id_usuario` = :id_usuario WHERE id_usuario= :cedula";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":cedula", $usuario_cedula);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_usuario_cv)
    {
        $sql = "SELECT * FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE `cv_usuario`.`id_usuario_cv`= :id_usuario_cv";
        //return ejecutarConsultaSimpleFila($sql);

        //SELECT * FROM `cv_usuario` WHERE `usuario_identificacion` = 

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql = "SELECT `cv_usuario`.`id_usuario_cv`,`cv_usuario`.`usuario_identificacion`,`cv_usuario`.`usuario_nombre`,`cv_usuario`.`usuario_clave`,`cv_usuario`.`usuario_apellido`,`cv_usuario`.`usuario_email`, `cv_usuario`.`usuario_condicion`, `cv_informacion_personal`.`telefono`, `cv_informacion_personal`.`estado`, `cv_informacion_personal`.`create_dt` , `cv_usuario`.`porcentaje_avance`  FROM `cv_usuario` LEFT JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv`";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function MostrarTittuloObtenido($id_usuario_cv)
    {
        $sql = "SELECT * FROM `cv_informacion_personal` WHERE `id_usuario_cv`= :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ObtenerInformacionUsuario($id_usuario_cv)
    {
        $sql = "SELECT * FROM `cv_usuario` WHERE `id_usuario_cv`= :id_usuario_cv";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para listar los registros
    public function listarPorEstado($valorbusqueda)
    {
        $sql = "SELECT * FROM `cv_informacion_personal` WHERE `cv_informacion_personal`.`estado` = :valorbusqueda";
        // echo $sql;
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":valorbusqueda", $valorbusqueda);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function listarPorCategoria($valorbusqueda)
    {
        $sql = "SELECT * FROM `cv_informacion_personal` WHERE `cv_informacion_personal`.`categoria_profesion` = :valorbusqueda";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":valorbusqueda", $valorbusqueda);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function listarPorArea($valorbusqueda)
    {
        $sql = "SELECT * FROM ((`cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv`) INNER JOIN `cv_areas_de_conocimiento` ON `cv_areas_de_conocimiento`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv`) WHERE `cv_areas_de_conocimiento`.`nombre_area` = :valorbusqueda";
        // echo $sql;
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":valorbusqueda", $valorbusqueda);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function listarPorFecha($valorbusqueda)
    {
        $sql = "SELECT `cv_usuario`.`id_usuario_cv`,`cv_usuario`.`usuario_identificacion`,`cv_usuario`.`usuario_nombre`,`cv_usuario`.`usuario_clave`,`cv_usuario`.`usuario_apellido`,`cv_usuario`.`usuario_email`, `cv_usuario`.`usuario_condicion`, `cv_informacion_personal`.`telefono`, `cv_informacion_personal`.`estado`, `cv_informacion_personal`.`create_dt`, `cv_informacion_personal`.`titulo_profesional` FROM `cv_usuario` INNER JOIN `cv_informacion_personal` ON `cv_informacion_personal`.`id_usuario_cv` = `cv_usuario`.`id_usuario_cv` WHERE date(`cv_informacion_personal`.`ultima_actualizacion`) BETWEEN :valorbusqueda AND '" . date("Y-m-d") . "'";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":valorbusqueda", $valorbusqueda);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para listar las titulaciones
    public function listartitulaciones($email_ciaf)
    {
        $sql = "SELECT * FROM cv_estudiantes WHERE email_ciaf= :email_ciaf";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":email_ciaf", $email_ciaf);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar los Departamentos
    public function selectDepartamento()
    {
        $sql = "SELECT * FROM `departamentos`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las titulaciones
    public function selectMunicipio()
    {
        $sql = "SELECT * FROM `municipios`";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function validar_mail($usuario_email)
    {
        $sql = "SELECT usuario_email FROM cv_usuario where usuario_email = :usuario_email";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":usuario_email", $usuario_email);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verificarfuncionario($logina, $clave)
    {
        global $mbd;
        $sql = "SELECT id_usuario_cv, usuario_nombre, usuario_apellido,usuario_identificacion,usuario_email,usuario_imagen FROM cv_usuario WHERE usuario_email= :logina AND usuario_clave= :clave AND usuario_condicion=1";

        //echo "SELECT id_usuario_cv, usuario_nombre, usuario_apellido,usuario_identificacion,usuario_email,usuario_imagen FROM cv_usuario WHERE usuario_email= $logina AND usuario_clave = $clave AND usuario_condicion=1"; 

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":logina", $logina);
        $consulta->bindParam(":clave", $clave);
        $consulta->execute();
        if ($consulta->rowCount() > 0) {
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            $resultado = false;
        }
        return $resultado;
    }

    //Implementar un método para listar los permisos marcados
    public function listarmarcados($id_usuario)
    {
        $sql = "SELECT * FROM usuario_permiso WHERE id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //consulta para eliminar los usuarios en hoja de vida
    public function eliminarUsuarioCv($id_usuario_cv)
    {
        $sql = "DELETE FROM `cv_usuario` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_informacion_personal` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_experiencia_laboral` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_habilidades_aptitudes` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_portafolio` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_referencias_laborales` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_documentacion_usuario` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_areas_de_conocimiento` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_educacion_formacion` WHERE `id_usuario_cv` = :id_usuario_cv;
                DELETE FROM `cv_referencias_personal` WHERE `id_usuario_cv` = :id_usuario_cv;
                
                
                 ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario_cv", $id_usuario_cv);
        return $consulta->execute();
    }
    //validaciones para saber que paso tiene listo el usuario
    public function obtenerProgresoUsuario($id_usuario_cv)
    {
        global $mbd;
        // realizamos una subconsulta para optimizar el codigo
        $sql = "SELECT 
        (SELECT COUNT(*) FROM cv_informacion_personal WHERE id_usuario_cv = :id_usuario_cv) AS info_personal,
        (SELECT COUNT(*) FROM cv_educacion_formacion WHERE id_usuario_cv = :id_usuario_cv) AS educacion,
        (SELECT COUNT(*) FROM cv_experiencia_laboral WHERE id_usuario_cv = :id_usuario_cv) AS experiencia,
        (SELECT COUNT(*) FROM cv_habilidades_aptitudes WHERE id_usuario_cv = :id_usuario_cv) AS habilidades,
        (SELECT COUNT(*) FROM cv_referencias_personal WHERE id_usuario_cv = :id_usuario_cv) AS referencias_personales,
        (SELECT COUNT(*) FROM cv_portafolio WHERE id_usuario_cv = :id_usuario_cv) AS portafolio,
        (SELECT COUNT(*) FROM cv_referencias_laborales WHERE id_usuario_cv = :id_usuario_cv) AS referencias_laborales,
        (SELECT COUNT(*) FROM cv_documentacion_usuario WHERE id_usuario_cv = :id_usuario_cv) AS documentos_adicionales,
        (SELECT COUNT(*) FROM cv_documentacion_usuario WHERE id_usuario_cv = :id_usuario_cv) AS documentos_adicionales,
        (SELECT COUNT(*) FROM cv_areas_de_conocimiento WHERE id_usuario_cv = :id_usuario_cv) AS areas_conocimiento";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC); 
    }

    public function obtenertotaldocumentosobligatorios($id_usuario_cv)
    {
        global $mbd;
        $sql = "SELECT COUNT(DISTINCT documento_nombre) FROM cv_documentacion_usuario  WHERE id_usuario_cv = :id_usuario_cv AND documento_nombre IN ('Cédula de ciudadanía','Certificación Bancaria','Antecedentes Judiciales Policía','Antecedentes Contraloría','Antecedentes Procuraduría','Referencias Laborales','Certificado Afiliación EPS','Certificado Afiliación AFP')";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(':id_usuario_cv', $id_usuario_cv);
        $consulta->execute();
        return $consulta->fetchColumn(); // Devuelve un solo número
    }

}
