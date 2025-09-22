<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Consulta
{

    public function periodoactual()
    {
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listar($programa, $periodo, $c, $semestre, $estado)
    {
        global $mbd;




        if ($programa == "1") {
            $se = ($semestre == "todos") ? "semestre != ''" : "semestre = '$semestre' ";


            $sql = "SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM ( SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM materias1 WHERE periodo = '$periodo' AND $se AND faltas = '$estado' UNION ALL SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM materias2 WHERE periodo = '$periodo' AND $se AND faltas = '$estado' UNION ALL SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM materias3 WHERE periodo = '$periodo' AND $se AND faltas = '$estado' UNION ALL SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM materias4 WHERE periodo = '$periodo' AND $se AND faltas = '$estado' UNION ALL SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM materias5 WHERE periodo = '$periodo' AND $se AND faltas = '$estado'UNION ALL SELECT id_estudiante,programa,nombre_materia,jornada,faltas,promedio FROM materias6 WHERE periodo = '$periodo' AND $se AND faltas = '$estado' ) materias1";
        } else {
            $mate = "materias" . $c;
            $se = ($semestre == "todos") ? "semestre != ''" : "semestre = '$semestre' ";
            $pro = ($programa == "1") ? "programa != ''" : "programa = '$programa' ";
            $sql = " SELECT * FROM $mate WHERE periodo = '$periodo' AND $se AND $pro AND faltas = '$estado' ";
        }

        // echo $sql;





        $sentencia  = $mbd->prepare($sql);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
        //print_r($sentencia);
    }

    public function datos($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT CONCAT(tres.credencial_nombre,' ',tres.credencial_nombre_2,' ',tres.credencial_apellido,' ',tres.credencial_apellido_2) AS nombre, dos.telefono, dos.email AS correo_p, tres.credencial_login AS correo, tres.credencial_identificacion AS cc FROM estudiantes AS uno INNER JOIN estudiantes_datos_personales AS dos ON uno.id_credencial = dos.id_credencial INNER JOIN credencial_estudiante AS tres ON dos.id_credencial = tres.id_credencial WHERE uno.id_estudiante = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }
    public function programa($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `programa_ac` WHERE `id_programa` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }


    //Implementar un método para traer las escuelas
    public function listarescuelas()
    {

        $sql = "SELECT * FROM escuelas WHERE estado='1' ORDER BY orden ASC";
        global $mbd;
        $consulta = $mbd->prepare($sql);

        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function listarprogamas($id_escuela)
    {
        $sql = "SELECT * FROM programa_ac WHERE escuela= :id_escuela AND estado='1' ";

        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_escuela", $id_escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function listarfaltas($id_programa, $periodo_actual)
    {
        $sql = "SELECT DISTINCT id_estudiante, id_materia FROM faltas WHERE programa= :id_programa AND periodo_falta= :periodo_actual ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function listardatofaltas($id_falta)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM faltas WHERE id_falta= :id_falta");
        $sentencia->bindParam(":id_falta", $id_falta);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function listardatosestudiante($id_estudiante)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT id_credencial, id_estudiante, jornada_e FROM `estudiantes` WHERE `id_estudiante` = :id_estudiante");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function listardatoscredencial($id_credencial)
    {
        global $mbd;

        $sentencia = $mbd->prepare(" SELECT * FROM credencial_estudiante ce INNER JOIN estudiantes_datos_personales edp ON ce.id_credencial = edp.id_credencial WHERE ce.id_credencial = :id_credencial");
        $sentencia->bindParam(":id_credencial", $id_credencial);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function listardatosmateria($id_materia, $ciclo)
    {
        global $mbd;
        $tabla = "materias" . $ciclo;

        $sentencia = $mbd->prepare(" SELECT * FROM $tabla WHERE id_materia= :id_materia");
        $sentencia->bindParam(":id_materia", $id_materia);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }




    public function listarnumerofaltas($id_estudiante, $id_materia, $periodo_actual)
    {
        $sql = "SELECT * FROM faltas WHERE id_estudiante= :id_estudiante AND id_materia= :id_materia AND periodo_falta= :periodo_actual ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verfaltas($id_estudiante, $id_materia)
    {
        $periodo_actual = $_SESSION['periodo_actual'];

        $sql = "SELECT * FROM faltas WHERE id_estudiante= :id_estudiante AND id_materia= :id_materia AND periodo_falta= :periodo_actual ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->bindParam(":id_materia", $id_materia);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Función para convertir la fecha a formato español //	
    function fechaesp($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];

        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        return $tomadia . ", " . $day . " de " . $meses[$month] . " de " . $year;
    }

    public function datosdocente($id_docente)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT usuario_nombre,usuario_nombre_2,usuario_apellido,usuario_apellido_2 FROM docente WHERE id_usuario= :id_docente");
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        return $registro;
    }


    public function grafico($fecha)
    {
        $sql = "SELECT * FROM faltas WHERE fecha_falta = :fecha";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":fecha", $fecha);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado; // Devuelve la lista de faltas
    }
    public function listarfaltasGrafica_consulta($periodo, $semestre, $programa, $fecha_consulta)
    {
        global $mbd;
        $sql = "SELECT e.estado, COUNT(f.id_falta) AS total_faltas FROM faltas f INNER JOIN estudiantes e ON f.id_estudiante = e.id_estudiante WHERE f.periodo_falta = :periodo AND (:semestre = 'todos' OR e.semestre_estudiante = :semestre) AND f.programa = :programa AND f.fecha_falta = :fecha_consulta GROUP BY e.estado";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":programa", $programa);
        $consulta->bindParam(":fecha_consulta", $fecha_consulta);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarMateria($escuela)
    {
        global $mbd;
        $sql = "SELECT id_programa, nombre FROM `programa_ac` WHERE estado=1 AND ciclo !='4' AND ciclo !='6' AND ciclo !='9' AND escuela = :escuela";
        // echo $sql;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":escuela", $escuela);

        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarTodasMaterias()
    {
        global $mbd;
        // Consulta para obtener todas las materias independientemente de la escuela
        $sql = "SELECT id_programa, nombre FROM `programa_ac` WHERE estado=1";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarMateriaporgrafica($escuela)
    {
        global $mbd;
        $sql = "SELECT id_programa FROM `programa_ac` WHERE estado=1 AND ciclo !='4' AND ciclo !='6' AND ciclo !='9' AND escuela = :escuela";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":escuela", $escuela);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function listarfaltasGrafica_escuela($periodo_actual, $programa)
    {
        global $mbd;
        $sql = "SELECT COUNT(*) AS total_faltas FROM faltas WHERE periodo_falta = :periodo_actual AND programa = :programa";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->bindParam(":programa", $programa);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
