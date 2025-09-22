<?php
// Se incluye el archivo de conexión a la base de datos
require "../config/Conexion.php";

class Desercion
{
    // Implementamos nuestro constructor
    public function __construct()
    {
    }
    public function periodoactual()
    {
        $sql = "SELECT * FROM periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    // Implementamos una función para cargar los estudiantes que estan pendientes por renovar
    public function listargeneralporrenovar($periodo_anterior)
    {
        $sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_anterior and renovar='1' and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para cargar los estudiantes que renovaron
    public function listargeneralrenovaron($periodo_actual)
    {
        $sql = "SELECT * FROM estudiantes WHERE periodo!= :periodo_actual and periodo_activo= :periodo_actual and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function listarestudaintesrenovaron($periodo_actual)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo!= :periodo_actual and est.periodo_activo= :periodo_actual and est.estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function listarestudaintesporrenovar($periodo_anterior)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo_anterior and est.estado='1' and est.renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para cargar los estudiantes que faltan por renovar por nivel
    public function listargeneralporrenovarnivel($periodo_anterior, $nivel)
    {
        $sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_anterior and renovar='1' and ciclo= :nivel and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->bindParam(":nivel", $nivel);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para listar los los estuidantes que renovaron por nivel
    public function listargeneralrenovaronnivel($periodo_actual, $nivel)
    {
        $sql = "SELECT * FROM estudiantes WHERE periodo_activo= :periodo_actual and estado='1' and periodo!= :periodo_actual and ciclo= :nivel";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->bindParam(":nivel", $nivel);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para listar los los estuidantes que renovaron por nivel
    public function  listarestudaintesrenovaronnivel($periodo_actual, $nivel)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo!= :periodo_actual and  est.periodo_activo= :periodo_actual and est.estado='1' and est.ciclo= :nivel";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->bindParam(":nivel", $nivel);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    public function listarestudaintesporrenovarnivel($periodo_anterior, $nivel)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.periodo_activo= :periodo_anterior and est.estado='1' and est.renovar='1' and est.ciclo= :nivel";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->bindParam(":nivel", $nivel);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    // Implementamos una función para cargar los programas asociados
    public function programaAc($profesional)
    {
        $sql = "SELECT * FROM programa_ac WHERE profesional= :profesional ORDER BY id_programa ASC";
        
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":profesional", $profesional);

        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    // Implementamos una función para cargar los jorandas de por renovar activas
    public function jornadas()
    {
        $sql = "SELECT nombre,estado,codigo FROM jornada WHERE porrenovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para cargartodas las jornadas
    public function jornadastodas()
    {
        $sql = "SELECT id_jornada,nombre,estado,codigo,porrenovar FROM jornada";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function traernumeropendientes($id_programa, $elsemestre, $jornadafila, $temporadainactivos, $periodoactual)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornadafila and temporada < :temporadainactivos and  renovar='1' and periodo_activo <= :periodoactual";

        //  echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":elsemestre", $elsemestre);
        $consulta->bindParam(":jornadafila", $jornadafila);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);
        $consulta->bindParam(":periodoactual", $periodoactual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function traernumero($id_programa, $elsemestre, $jornada, $periodo)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo!= :periodo and periodo_activo= :periodo and renovar='1' ";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":elsemestre", $elsemestre);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función para cargartodas las jornadas
    public function activarjornada($id_jornada, $valor)
    {
        $sql = "UPDATE jornada SET porrenovar= :valor WHERE id_jornada= :id_jornada";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_jornada", $id_jornada);
        $consulta->bindParam(":valor", $valor);
        return $consulta->execute();
    }

    public function verestudiantesinactivos($id_programa, $jornada, $semestre, $temporadainactivos, $periodoactual)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.temporada< :temporadainactivos and est.renovar='1' and est.periodo_activo <= :periodoactual";

        // echo $sql;
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);
        $consulta->bindParam(":periodoactual", $periodoactual);

        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function vernombreestudiantesinactivos($id_credencial)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE ce.id_credencial = :id_credencial";
        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verestudiantesinactivosseguimiento($id_programa, $jornada, $semestre, $temporadainactivos, $id_credencial)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and est.temporada< :temporadainactivos and est.renovar='1' and edp.id_credencial : id_credencial";

        global $mbd;

        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);

        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function insertarSeguimiento($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $id_estudiante)
    {
        $sql = "INSERT INTO estudiante_seguimiento (id_usuario,id_credencial,motivo_seguimiento,mensaje_seguimiento,fecha_seguimiento,hora_seguimiento,id_estudiante)
    VALUES ('$id_usuario','$id_estudiante_agregar','$motivo_seguimiento','$mensaje_seguimiento','$fecha','$hora','$id_estudiante')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    //Implementamos un método para actualziar el campo segui
    public function actualizarSegui($id_estudiante)
    {
        $sql = "UPDATE on_interesados SET segui=0 WHERE id_estudiante= :id_estudiante";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        return $consulta->execute();
    }

    //Implementamos un método para insertar una tarea
    public function insertarTarea($id_usuario, $id_estudiante_tarea, $motivo_tarea, $mensaje_tarea, $fecha_registro, $hora_registro, $fecha_programada, $hora_programada, $fecha_realizo, $hora_realizo, $periodo_actual, $id_estudiante)
    {
        $sql = "INSERT INTO estudiante_tareas_programadas (id_usuario,id_credencial,motivo_tarea,mensaje_tarea,fecha_registro,hora_registro,fecha_programada,hora_programada,fecha_realizo,hora_realizo,periodo,id_estudiante)
    VALUES ('$id_usuario','$id_estudiante_tarea','$motivo_tarea','$mensaje_tarea','$fecha_registro','$hora_registro','$fecha_programada','$hora_programada','$fecha_realizo','$hora_realizo','$periodo_actual','$id_estudiante')";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        return $consulta->execute();
    }

    public function VerHistorial($id_estudiante)
    {
        $sql = "SELECT * FROM on_interesados oni INNER JOIN on_interesados_datos onid ON oni.id_estudiante=onid.id_estudiante WHERE oni.id_estudiante= :id_estudiante";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
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

    //Implementar un método para listar el historial de seguimiento
    public function verHistorialTabla($id_credencial)
    {
        $sql = "SELECT * FROM estudiante_seguimiento WHERE id_credencial= :id_credencial";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_credencial", $id_credencial);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    //Implementar un método para eliminar el interesado
    public function datosAsesor($id_usuario)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario= :id_usuario";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Implementar un método para listar el historial de seguimiento
    public function verHistorialTablaTareas($id_estudiante)
    {
        $sql = "SELECT * FROM estudiante_tareas_programadas WHERE id_estudiante= :id_estudiante";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_estudiante", $id_estudiante);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verestudiantes($id_programa, $jornada, $semestre, $periodo, $porrenovar)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and periodo!= :periodo and est.periodo_activo= :periodo  and est.renovar= :porrenovar";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":porrenovar", $porrenovar);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verestudiantesok($id_programa, $jornada, $semestre, $periodo)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre and periodo!= :periodo and est.periodo_activo= :periodo";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function sumanumeroinactivos($id_programa, $jornadafila, $temporadainactivos, $periodo_actual)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornadafila and temporada < :temporadainactivos and  renovar='1' and periodo_activo<= :periodo_actual";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornadafila", $jornadafila);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function sumanumeropendiente($id_programa, $jornada, $periodo)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and jornada_e= :jornada and periodo!= :periodo and periodo_activo= :periodo and renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }



    public function verestudiantesinactivostotal($id_programa, $jornada, $temporadainactivos, $periodo_actual)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.temporada< :temporadainactivos and renovar='1' and est.periodo_activo<= :periodo_actual";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verestudiantestotal($id_programa, $jornada, $periodo, $porrenovar)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and periodo!= :periodo and est.periodo_activo= :periodo  and est.renovar= :porrenovar";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->bindParam(":porrenovar", $porrenovar);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function verestudiantesoktotal($id_programa, $jornada, $periodo)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and periodo!= :periodo and est.periodo_activo= :periodo and est.renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    /* consultas por meta */


    // Implementamos una función paracargar los que deben renovar segun la meta
    public function porrenovarmeta($jornada, $periodo_anterior)
    {
        $sql = "SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo_activo= :periodo_anterior and renovar='1' and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo_anterior", $periodo_anterior);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // Implementamos una función paracargar los que deben renovar que renovaron
    public function renovaronmeta($jornada, $periodo_actual)
    {
        $sql = "SELECT * FROM estudiantes WHERE jornada_e= :jornada and periodo!= :periodo_actual and periodo_activo= :periodo_actual and estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function listarrenovaronmeta($jornada, $periodo)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.jornada_e= :jornada and periodo!= :periodo and est.periodo_activo= :periodo and est.estado='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function listarporrenovarmeta($jornada, $periodo)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.jornada_e= :jornada and est.periodo_activo= :periodo and est.estado='1' and est.renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function consulta_desercion($identificacion)
    {
        global $mbd;
        $sql = "SELECT * FROM `on_interesados` WHERE `identificacion` = :identificacion";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":identificacion", $identificacion);
        $consulta->execute();
        $registros = $consulta->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }

    public function consulta_id_credencial($credencial_identificacion)
    {
        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial  WHERE  ce.credencial_identificacion = :credencial_identificacion";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":credencial_identificacion", $credencial_identificacion);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function sumaporrenovar($id_programa, $jornada, $periodo)
    {

        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo_activo= :periodo and estado='1' and renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function traerporrenovar($id_programa, $elsemestre, $jornada, $periodo)
    {
        $sql = "SELECT * FROM estudiantes WHERE id_programa_ac= :id_programa and semestre_estudiante= :elsemestre and jornada_e= :jornada and periodo_activo= :periodo and estado='1' and renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":elsemestre", $elsemestre);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function porrenovarestudiante($id_programa, $jornada, $periodo, $semestre)
    {

        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.semestre_estudiante= :semestre  and est.periodo_activo= :periodo and estado='1' and renovar='1'";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":semestre", $semestre);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function porrenovarestudiantetotal($id_programa, $jornada, $periodo)
    {

        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.jornada_e= :jornada and est.periodo_activo= :periodo and estado='1' and renovar='1'";
        // echo $sql;
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":id_programa", $id_programa);
        $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function sumanumeroinactivostotal($id_programa, $temporadainactivos,$jornada, $periodo_actual)
    {   
        $sql = "SELECT * FROM `estudiantes` AS `est` INNER JOIN `credencial_estudiante` AS `ce` ON `est`.`id_credencial` = `ce`.`id_credencial` INNER JOIN `estudiantes_datos_personales` AS `edp` ON `est`.`id_credencial` = `edp`.`id_credencial` WHERE `est`.`id_programa_ac` = :id_programa AND `est`.`temporada` < :temporadainactivos AND `renovar` LIKE '1' AND `est`.`periodo_activo` <= :periodo_actual AND (";
        $condition = "";
        for($i = 0 ; $i < count($jornada); $i++){
            $condition .= "est.jornada_e LIKE '".$jornada[$i]."'"; 
            if(($i+1) < count($jornada) ){
                $condition .= " OR ";
            }else{
                $condition .= ")";
            }
        }
        
        global $mbd;
        $consulta = $mbd->prepare($sql.$condition);
        $consulta->bindParam(":id_programa", $id_programa);
        // $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":temporadainactivos", $temporadainactivos);
        $consulta->bindParam(":periodo_actual", $periodo_actual);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    

    public function sumaporrenovartotal($id_programa,$jornada,$periodo)
    {
        // and est.jornada_e= :jornada

        // $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.periodo_activo= :periodo and estado='1' and renovar='1'";

        $sql = "SELECT * FROM estudiantes est INNER JOIN credencial_estudiante ce ON est.id_credencial=ce.id_credencial INNER JOIN estudiantes_datos_personales edp ON est.id_credencial=edp.id_credencial WHERE est.id_programa_ac= :id_programa and est.periodo_activo= :periodo and estado='1' and renovar='1' AND (";
        
        $condition = "";
        for($i = 0 ; $i < count($jornada); $i++){
            $condition .= "est.jornada_e LIKE '".$jornada[$i]."'"; 
            if(($i+1) < count($jornada) ){
                $condition .= " OR ";
            }else{
                $condition .= ")";
            }
        }


        global $mbd;
        $consulta = $mbd->prepare($sql.$condition);
        $consulta->bindParam(":id_programa", $id_programa);
        // $consulta->bindParam(":jornada", $jornada);
        $consulta->bindParam(":periodo", $periodo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    public function activarjornadatotalestudiantes($valor)
    {

        $sql = "SELECT * FROM jornada WHERE porrenovar= :valor";
        global $mbd;
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":valor", $valor);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


}
