<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class CvAdmin
{
    //Implementamos nuestro constructor
    public function __construct() {}

    public function listar()
    {
        $sql = "SELECT `cvadministrativos`.`id_cvadministrativos`,`cvadministrativos`.`cvadministrativos_identificacion`,`cvadministrativos`.`cvadministrativos_nombre`,`cvadministrativos`.`cvadministrativos_correo`, `cvadministrativos`.`cvadministrativos_estado`, `cvadministrativos`.`cvadministrativos_celular`, `cvadministrativos`.`cvadministrativos_fecha`,`cvadministrativos`.`porcentaje_avance`, `hv_fun_informacion_personal`.`estado`, `hv_fun_informacion_personal`.`titulo_profesional`, `cvadministrativos`.`cvadministrativos_cargo`, `cvadministrativos`.`cvadministrativos_pdf` FROM `cvadministrativos` LEFT JOIN `hv_fun_informacion_personal` ON `hv_fun_informacion_personal`.`id_cvadministrativos` = `cvadministrativos`.`id_cvadministrativos`";
        // $sql = "SELECT cvadministrativos.id_cvadministrativos,cvadministrativos.cvadministrativos_identificacion,cvadministrativos.cvadministrativos_nombre,cvadministrativos.cvadministrativos_correo,cvadministrativos.cvadministrativos_estado,cvadministrativos.cvadministrativos_celular,cvadministrativos.cvadministrativos_fecha,cvadministrativos.porcentaje_avance,MAX(hv_fun_informacion_personal.estado) AS estado FROM cvadministrativos LEFT JOIN hv_fun_informacion_personal ON hv_fun_informacion_personal.id_cvadministrativos = cvadministrativos.id_cvadministrativos GROUP BY  cvadministrativos.id_cvadministrativos, cvadministrativos.cvadministrativos_identificacion, cvadministrativos.cvadministrativos_nombre, cvadministrativos.cvadministrativos_correo, cvadministrativos.cvadministrativos_estado, cvadministrativos.cvadministrativos_celular, cvadministrativos.cvadministrativos_fecha, cvadministrativos.porcentaje_avance;";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //     public function listar(){
    //     $sql = "SELECT * FROM cvadministrativos";
    //     //return ejecutarConsulta($sql);
    //     global $mbd;
    //     $consulta = $mbd->prepare($sql);
    //     $consulta->execute();
    //     $resultado = $consulta->fetchAll();
    //     return $resultado;
    // }
    // public function cv_traerIdUsuario($documento)
    // {
    //     $sql = "SELECT `id_cvadministrativos` FROM `cvadministrativos` WHERE `cvadministrativos_identificacion` = :documento";
    //     global $mbd;
    //     $stmt = $mbd->prepare($sql);
    //     $stmt->bindParam(':documento', $documento);
    //     $stmt->execute();
    //     $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $registro;
    // }


    // public function id_usuario($usuario_login)
    // {
    //     $sql = "SELECT id_usuario, usuario_nombre FROM usuario WHERE usuario_login = :usuario_login";
    //     global $mbd;
    //     $stmt = $mbd->prepare($sql);
    //     $stmt->bindParam(':usuario_login', $usuario_login);
    //     $stmt->execute();
    //     $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $registro;
    // }


    // public function id_cvadministrativos($cvadministrativos_correo)
    // {
    //     $sql = "SELECT id_cvadministrativos FROM cvadministrativos WHERE cvadministrativos_correo = :cvadministrativos_correo";
    //     global $mbd;
    //     $stmt = $mbd->prepare($sql);
    //     $stmt->bindParam(':cvadministrativos_correo', $cvadministrativos_correo);
    //     $stmt->execute();
    //     $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $registro;
    // }


    public function insertar_cita($cvadministrativos_entrevista_direccion, $cvadministrativos_entrevista_fecha, $cvadministrativos_entrevista_hora, $cvadministrativos_entrevista_comentario, $id_cvadministrativos_cv, $id_usuario)
    {
        $sql = "INSERT INTO cvadministrativos_entrevista (cvadministrativos_entrevista_direccion, cvadministrativos_entrevista_fecha, cvadministrativos_entrevista_hora, cvadministrativos_entrevista_comentario, id_cvadministrativos, id_usuario) 
                VALUES (:cvadministrativos_entrevista_direccion, :cvadministrativos_entrevista_fecha, :cvadministrativos_entrevista_hora, :cvadministrativos_entrevista_comentario, :id_cvadministrativos_cv, :id_usuario)";
        //echo $sql;


        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":cvadministrativos_entrevista_direccion", $cvadministrativos_entrevista_direccion);
        $consulta->bindParam(":cvadministrativos_entrevista_fecha", $cvadministrativos_entrevista_fecha);
        $consulta->bindParam(":cvadministrativos_entrevista_hora", $cvadministrativos_entrevista_hora);
        $consulta->bindParam(":cvadministrativos_entrevista_comentario", $cvadministrativos_entrevista_comentario);
        $consulta->bindParam(":id_cvadministrativos_cv", $id_cvadministrativos_cv);
        $consulta->bindParam(":id_usuario", $id_usuario);

        return $consulta->execute();
    }



    //Implementamos un método para insertar registros
    public function registrarUsuario($cvadministrativos_identificacion, $cvadministrativos_nombre, $cvadministrativos_apellido, $cvadministrativos_correo)
    {

        $sql = "INSERT INTO cvadministrativos_identificacion (cvadministrativos_identificacion,cvadministrativos_nombre,cvadministrativos_apellido,cvadministrativos_correo,cvadministrativos_estado) VALUES (:cvadministrativos_identificacion,:cvadministrativos_nombre,:cvadministrativos_apellido,:cvadministrativos_correo)";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":cvadministrativos_identificacion", $cvadministrativos_identificacion);
        $consulta->bindParam(":cvadministrativos_nombre", $cvadministrativos_nombre);
        $consulta->bindParam(":cvadministrativos_apellido", $cvadministrativos_apellido);
        $consulta->bindParam(":cvadministrativos_correo", $cvadministrativos_correo);
        return $consulta->execute();
    }





    //Implementamos un método para editar registros


    //Implementamos un método para desactivar categorías
    public function desactivar($id_cvadministrativos)
    {
        $sql = "UPDATE cvadministrativos SET cvadministrativos_estado='0' WHERE id_cvadministrativos = :id_cvadministrativos";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function activar($id_cvadministrativos)
    {
        $sql = "UPDATE cvadministrativos SET cvadministrativos_estado='1' WHERE id_cvadministrativos = :id_cvadministrativos";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function contratar($id_cvadministrativos)
    {
        $sql = "UPDATE cv_informacion_personal SET estado='contratado' WHERE id_cvadministrativos= :id_cvadministrativos";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function desvincular($id_cvadministrativos)
    {
        $sql = "UPDATE cv_informacion_personal SET estado='desvinculado' WHERE id_cvadministrativos= :id_cvadministrativos";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementamos un método para activar categorías
    public function editarpassword($id_cvadministrativos, $cvadministrativos_identificacion)
    {
        $sql = "UPDATE `referencias_personal` SET `id_cvadministrativos` = :id_cvadministrativos WHERE id_cvadministrativos= :cedula";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":cedula", $cvadministrativos_identificacion);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para mostrar los datos de un registro a modificar

    //Implementar un método para listar los registros



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

    public function validar_mail($cvadministrativos_correo)
    {
        $sql = "SELECT cvadministrativos_correo FROM id_cvadministrativos where cvadministrativos_correo = :cvadministrativos_correo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":cvadministrativos_correo", $cvadministrativos_correo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }




    //consulta para eliminar los usuarios en hoja de vida
    public function eliminarUsuarioCv($id_cvadministrativos)
    {
        $sql = "DELETE FROM `cvadministrativos` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_informacion_personal` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_experiencia_laboral` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_habilidades_aptitudes` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_portafolio` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_referencias_laborales` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_documentacion_usuario` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_areas_de_conocimiento` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_educacion_formacion` WHERE `id_cvadministrativos` = :id_cvadministrativos;
                DELETE FROM `hv_fun_referencias_personal` WHERE `id_cvadministrativos` = :id_cvadministrativos ";
                
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        return $consulta->execute();
    }


    public function PDF($id)
    {
        $sql = "SELECT cvadministrativos_pdf FROM cvadministrativos WHERE id_cvadministrativos = :id";
        global $mbd;
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registro && !empty($registro['cvadministrativos_pdf'])) {
            $archivo_pdf = $registro['cvadministrativos_pdf'];
            $ruta = "https://ciaf.edu.co/cvadmin/" . $archivo_pdf;
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="pdf.pdf"');
            readfile($ruta);
            exit();
        } else {
            echo "No se encontró el archivo PDF.";
        }
    }


    public function editar($id_cvadministrativos, $cvadministrativos_identificacion, $cvadministrativos_nombre, $cvadministrativos_celular, $cvadministrativos_correo, $cvadministrativos_cargo)
    {

        $sql = "UPDATE cvadministrativos SET cvadministrativos_identificacion = :cvadministrativos_identificacion, cvadministrativos_nombre = :cvadministrativos_nombre, cvadministrativos_celular = :cvadministrativos_celular, cvadministrativos_correo = :cvadministrativos_correo, cvadministrativos_cargo = :cvadministrativos_cargo WHERE id_cvadministrativos = :id_cvadministrativos";

        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":cvadministrativos_identificacion", $cvadministrativos_identificacion);
        $consulta->bindParam(":cvadministrativos_nombre", $cvadministrativos_nombre);
        $consulta->bindParam(":cvadministrativos_celular", $cvadministrativos_celular);
        $consulta->bindParam(":cvadministrativos_correo", $cvadministrativos_correo);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->bindParam(":cvadministrativos_cargo", $cvadministrativos_cargo);
        $consulta->execute();
        $resultado = $consulta->execute();
        return $resultado;
    }


    public function mostrar($id_cvadministrativos)
    {
        $sql = "SELECT id_cvadministrativos, cvadministrativos_identificacion, cvadministrativos_nombre, cvadministrativos_correo, cvadministrativos_celular, cvadministrativos_cargo  FROM cvadministrativos WHERE id_cvadministrativos = :id_cvadministrativos";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_cvadministrativos", $id_cvadministrativos);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("domingo", "lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

    public function selectDependencia()
    {
        $sql = "SELECT * FROM dependencias";
        //return ejecutarConsulta($sql);
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
}
