<?php
// Se incluye el archivo de conexión a la base de datos
require "../config/Conexion.php";

class ConsultaContactanos
{
    // Implementamos nuestro constructor
    public function __construct() {}
    // Implementamos una función para cargar las dependencias habilitadas
    public function cargarDependencias()
    {
        $sql = "SELECT * FROM dependencias dep INNER JOIN usuario usu ON dep.id_dependencias=usu.id_dependencia WHERE usu.usuario_condicion='1' AND dep.ayuda='1' ";
        //$sql = "SELECT * FROM usuario usu INNER JOIN dependencias dep ON usu.id_dependencia = dep.id_dependencias WHERE dep.ayuda='1' ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    // Implementemos una función para cargar los periodos
    public function cargarPeriodo()
    {
        $sql = "SELECT * FROM periodo ORDER BY periodo DESC";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para listar las ayudas
    public function listar($dependencias, $periodo)
    {
        if ($dependencias == "0") {
            if ($periodo == "0") {
                $sql = "SELECT * FROM ayuda order by id_ayuda ASC";
                global $mbd;
                $consulta = $mbd->prepare($sql);
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } else {
                $sql = "SELECT * FROM ayuda WHERE periodo_ayuda = :periodo";
                global $mbd;
                $consulta = $mbd->prepare($sql);
                $consulta->bindParam(":periodo", $periodo);
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }
        } else {
            if ($periodo == "0") {
                $sql = "SELECT * FROM ayuda WHERE id_usuario= :dependencias";
                global $mbd;
                $consulta = $mbd->prepare($sql);
                $consulta->bindParam(":dependencias", $dependencias);
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } else {
                $sql = "SELECT * FROM ayuda WHERE id_usuario= :dependencias and periodo_ayuda= :periodo";
                global $mbd;
                $consulta = $mbd->prepare($sql);
                $consulta->bindParam(":periodo", $periodo);
                $consulta->bindParam(":dependencias", $dependencias);
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }
        }
    }


    //Implementar un método para listar los registros
    public function listarRespuesta($id_ayuda)
    {
        $sql = "SELECT * FROM ayuda_respuesta WHERE id_ayuda='" . $id_ayuda . "'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    // Implementamos una función para cargar los datos en credencial
    public function cargarDatosCredencial($id_credencial)
    {
        $sql = "SELECT * FROM credencial_estudiante WHERE id_credencial=:id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Implementamos una función para cargar los datos del programa
    public function cargarDatosPrograma($id_programa_ac)
    {
        $sql = "SELECT nombre, ciclo, semestres FROM programa_ac WHERE id_programa=:id_programa_ac";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa_ac", $id_programa_ac);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Implementamos una función para cargar los datos personales del estudiante
    public function cargarDatosPersonales($id_estudiante)
    {
        $sql = "SELECT telefono, celular, email FROM estudiantes_datos_personales WHERE id_estudiante=:id_estudiante";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    // Implementamos una función para validar las calificaciones
    public function cargarDatosCalificaciones($tabla, $id_estudiante, $semestre)
    {
        $sql = "SELECT promedio FROM $tabla WHERE id_estudiante=:id_estudiante AND semestre=:semestre";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function fechaesp($date)
    {
        if ($date === null) {
            return "Fecha no proporcionada";
        }

        $dia = explode("-", $date, 3);
        if (count($dia) !== 3) {
            return "Formato de fecha incorrecto";
        }

        $year = $dia[0];
        $month = $dia[1];
        $day = $dia[2];

        if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
            return "Fecha contiene valores no numéricos";
        }

        $month = (int)$month;
        $day = (int)$day;

        $dias = array(
            "domingo",
            "lunes",
            "martes",
            "miércoles",
            "jueves",
            "viernes",
            "sábado"
        );
        $tomadia = $dias[date("w", mktime(
            0,
            0,
            0,
            $month,
            $day,
            $year
        ))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }


    //Implementar un método para buscar el asunto
    public function buscarasunto($id_asunto)
    {
        $sql = "SELECT * FROM asunto WHERE id_asunto= :id_asunto";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_asunto", $id_asunto);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    //Implementar un método para buscar el opcion asunto
    public function buscaropcionasunto($id_asunto_opcion)
    {
        $sql = "SELECT * FROM asunto_opcion WHERE id_asunto_opcion = :id_asunto_opcion";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_asunto_opcion", $id_asunto_opcion);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    //Implementar un método para buscar el correo de la dependencia
    public function datosDependencia($dependencia)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario='" . $dependencia . "'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar los registros
    public function verAyuda($id_ayuda)
    {
        $sql = "SELECT * FROM ayuda ayd INNER JOIN credencial_estudiante ce ON ayd.id_credencial=ce.id_credencial WHERE ayd.id_ayuda= :id_ayuda";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_ayuda", $id_ayuda);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    //Implementar un método para listar el historial
    public function remiteA($id_ayuda)
    {

        $sql = "SELECT * FROM ayuda_respuesta WHERE id_ayuda='" . $id_ayuda . "'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($id_credencial)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`id_credencial` = :id_credencial LIMIT 1;");
        
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function obtenerRegistroWhastapp($numero_celular)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `whatsapp_registros` WHERE `numero_whatsapp` LIKE :numero_celular ORDER BY `numero_whatsapp` ASC");
        $sentencia->bindParam(':numero_celular', $numero_celular);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
}
