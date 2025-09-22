<?php
require "../config/Conexion.php";
date_default_timezone_set("America/Bogota");
session_start();
class Reserva{

    public function periodoactual(){
    	$sql="SELECT * FROM periodo_actual"; 
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
    }
    
    //actualiza los salones ya utilizados por el docente
    public function actualizarEstado($docente){
        global $mbd;
        $fecha = date('Y-m-d');
        $sentencia = $mbd->prepare("UPDATE `reservas_salones` SET `estado`= '1' WHERE `fecha_reserva` < :fecha AND `id_docente` = :id_docente AND `periodo` = :periodo_actual");
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":id_docente", $docente);
        $sentencia->bindParam(":periodo_actual", $_SESSION["periodo_actual"]);
        return $sentencia->execute();
    }
    //Implementar un método para listar las horas del dia
    public function listarHorasDia(){
        global $mbd;
        $sql = "SELECT * FROM `horas_del_dia`";
        $consulta = $mbd->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    //Implementar un método para listar las horas hasta
    public function traeridhora($hora){
        global $mbd;
        $sql = "SELECT * FROM `horas_del_dia` WHERE `horas` = :hora";
        $consulta = $mbd->prepare($sql);
        $consulta->bindParam(":hora", $hora);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    //Listar todos los salones por 
    public function consultarSalones($sede){
        global $mbd;
        $sql = "SELECT * FROM `salones` WHERE `sede`= :sede ORDER BY `salones`.`codigo` ASC";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":sede", $sede);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    //Implementar un método para traer el id del programa de la materia
	public function BuscarDatosAsignatura($id_materia){
		$sql = "SELECT id_programa_ac,nombre,semestre FROM materias_ciafi WHERE id= :id_materia";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_materia", $id_materia);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
	//Implementar un método para mirar datos del docente
	public function docente_datos($id_docente){
		$sql = "SELECT * FROM docente WHERE id_usuario= :id_docente";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_docente", $id_docente);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    //muestra los eventos con respecto a calendario
    public function eventosHorarios($codigo_salon){
        global $mbd;
        $sql = "SELECT * FROM `docente_grupos` WHERE `salon` = :codigo_salon AND `periodo` = :periodo_actual";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":codigo_salon", $codigo_salon);
        $stmt->bindParam(":periodo_actual", $_SESSION["periodo_actual"]);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra las reservas realizadas por docentes
    public function eventosReservas($codigo_salon,$startDate,$endDate){
        global $mbd;
        $sql = "SELECT * FROM `reservas_salones` WHERE `fecha_reserva` BETWEEN :startDate  AND  :endDate  AND `estado` = '0' AND `salon` = :codigo_salon";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":codigo_salon", $codigo_salon);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function verificarHorario($salon, $hora, $hasta, $dia){
        global $mbd;
        $sql = "SELECT `dia` FROM `docente_grupos` WHERE `dia` LIKE :dia AND (:hora BETWEEN `hora` AND `hasta` OR :hasta BETWEEN `hora` AND `hasta`) AND `salon` LIKE :salon AND `periodo` LIKE :periodo_actual;";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":salon", $salon);
        $stmt->bindParam(":hora", $hora);
        $stmt->bindParam(":hasta", $hasta);
        $stmt->bindParam(":dia", $dia);
        $stmt->bindParam(":periodo_actual", $_SESSION["periodo_actual"]);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function verificarReserva($salon, $hora, $hasta, $fecha_reserva){
        global $mbd;
        $sql = "SELECT * FROM `reservas_salones` WHERE `salon` LIKE :codigo_salon AND (:hora BETWEEN `horario` AND `hora_f` OR :hasta BETWEEN `horario` AND `hora_f`) AND  `periodo` LIKE :periodo_actual AND `fecha_reserva` = :fecha_reserva AND `estado` = '0';";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":codigo_salon", $salon);
        $stmt->bindParam(":fecha_reserva", $fecha_reserva);
        $stmt->bindParam(":hora", $hora);
        $stmt->bindParam(":hasta", $hasta);
        $stmt->bindParam(":periodo_actual", $_SESSION["periodo_actual"]);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function verificarDocenteSalon($codigo_salon, $id_docente){
        global $mbd;
        $sql = "SELECT * FROM `reservas_salones` WHERE `salon` LIKE :codigo_salon AND `periodo` LIKE :periodo_actual AND `id_docente` = :id_docente AND `estado` = '0' ;";
        $stmt = $mbd->prepare($sql);
        $stmt->bindParam(":codigo_salon", $codigo_salon);
        $stmt->bindParam(":periodo_actual", $_SESSION["periodo_actual"]);
        $stmt->bindParam(":id_docente", $id_docente);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function HistorialReservas($id_docente,$periodo){
        global $mbd;
        $consulta = "SELECT * FROM `reservas_salones` WHERE `id_docente` = :docente AND periodo= :periodo";
        $stmt = $mbd->prepare($consulta);
        $stmt->bindParam(":docente", $id_docente);
        $stmt->bindParam(":periodo", $periodo);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function listarmisreservas($id_docente){
        global $mbd;
        $consulta = "SELECT * FROM `reservas_salones` WHERE `id_docente` = :docente AND estado = '0' ";
        $stmt = $mbd->prepare($consulta);
        $stmt->bindParam(":docente", $id_docente);
        $stmt->execute();
        $registro = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    
    public function cancelarReserva($id){
        global $mbd;
        $stmt = $mbd->prepare("DELETE FROM `reservas_salones` WHERE `id`= :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }


    public function listarSalones($jornada, $fecha){
        $condicion = "";
        if ($jornada == "Mañana") {
            $condicion = " SELECT id_horas,formato FROM `horas_del_dia` WHERE `horas` BETWEEN' 06:00:00' AND '12:00:00'";
        }else{
            if($jornada == "Tarde"){
                $condicion = " SELECT id_horas,formato FROM `horas_del_dia` WHERE `horas` BETWEEN '12:15:00' AND '18:00:00' ORDER BY `horas_del_dia`.`id_horas` ASC ";
            }else{
                $condicion = " SELECT id_horas,formato FROM `horas_del_dia` WHERE `horas` BETWEEN '18:15:00' AND '23:30:00'";
            }
        }
        //echo $condicion;
        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare($condicion);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $registro;
    }

    public function listarSalonesPiso($cantidad){
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `salones` WHERE piso = :piso AND estado = 1 ");
        $sentencia->bindParam(":piso", $cantidad);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function ConsultaReserva($salon, $hora, $fecha)
    {
        global $mbd;

        $pe = $_SESSION['periodo_actual'];

        #consulta del salones reservados
        $sentencia7 = $mbd->prepare("SELECT * FROM `reservas_salones` WHERE `estado` = 'r' AND `salon` = :salon AND `fecha_reserva` = :fecha ");
        $sentencia7->bindParam(":salon", $salon);
        $sentencia7->bindParam(":fecha", $fecha);
        $sentencia7->execute();
        $registros7 = $sentencia7->fetchAll(PDO::FETCH_ASSOC);

        //print_r($registros7);

        #condicion para consultar y diferenciar entre el corte 1 y dos de viernes fds y sabado fds
        $diaFinal = "";
        $dia = self::convertir_fecha($fecha);
        $corte = self::consultarCorte();
        if ($dia == "Sabado") {
            $diaFinal = " `salon` = '$salon' AND `dia` = 'Sabado_FDS_Corte$corte' AND `periodo_hora` = '$pe' || `salon` = '$salon' AND `dia` = 'Sabado'  AND `periodo_hora` = '$pe' ";
        } else {
            if ($dia == "Viernes") {
                $diaFinal = " `salon` = '$salon' AND `dia` = 'Viernes' AND `periodo_hora` = '$pe' || `salon` = '$salon' AND  dia = 'Viernes_fds_corte$corte' AND `periodo_hora` = '$pe' ";
            } else {
                $diaFinal = " `salon` = '$salon' AND `dia` = '$dia' AND `periodo_hora` = '$pe' ";
            }
        }



        #consulta los salones que ya estan ocupados
        $sentencia3 = $mbd->prepare("SELECT * FROM `horas_grupos` WHERE $diaFinal ");
        $sentencia3->execute();
        $registros3 = $sentencia3->fetchAll(PDO::FETCH_ASSOC);

        //echo json_encode($sentencia3);

        $icon = '<a  data-toggle="tooltip" onclick="reservaSalon(' . $hora . ',' . $_SESSION['id_usuario'] . ',' . $fecha . ')" title="Reservar Salon" class="btn btn-warning btn-sm"><i class="fa fa-calendar-check"></i></a>';



        $data = array();

        for ($i = 0; $i < count($registros3); $i++) {
            #obtenemos el id del las horas del dia de los salones ocupados
            $ini = $registros3[$i]['hora'];
            $fin_f = $registros3[$i]['hasta'];
            $sentencia4 = $mbd->prepare("SELECT id_horas FROM `horas_del_dia` WHERE `horas` BETWEEN :hora AND :hasta");
            $sentencia4->bindParam(":hora", $ini);
            $sentencia4->bindParam(":hasta", $fin_f);
            $sentencia4->execute();


            $icon2 = '<span style="font-size: 15px;" class="label label-primary d-inline-block" data-toggle="tooltip" title="' . self::consultaDocenteGrupo($registros3[$i]['id_docente_grupo']) . '">Ocupado</span>';


            #guardamos los id obtenidos en un arreglo
            while ($registros4 = $sentencia4->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $registros4['id_horas']);
            }
            if (in_array($hora, $data)) {
                return $icon2;
            }
        }

        $data2 = array();

        for ($i = 0; $i < count($registros7); $i++) {
            $inicio = $registros7[$i]['horario'];
            $fin = $registros7[$i]['hora_f'];
            #consulto los id de de la hora de inicio y la hora final y los guardo en eun arreglo
            $sentencia6 = $mbd->prepare("SELECT id_horas FROM `horas_del_dia` WHERE `id_horas` BETWEEN :id_i AND :id_f ");
            $sentencia6->bindParam(":id_i", $inicio);
            $sentencia6->bindParam(":id_f", $fin);
            $sentencia6->execute();
            while ($registros6 = $sentencia6->fetch(PDO::FETCH_ASSOC)) {
                array_push($data2, $registros6['id_horas']);
            }
            $docente = self::consultaDocente($registros7[$i]['id_docente'], $registros7[$i]['tipo_usuario']) . ' Detalles de la reserva: ' . $registros7[$i]['detalle_reserva'];

            $icon3 = '<span style="font-size: 15px;" class="label label-success d-inline-block" data-toggle="tooltip" title="' . $docente . '">Reservado</span>';
            if (in_array($hora, $data2)) {
                return $icon3;
            }
        }

        return $icon;


        //print_r($sentencia6);




    }

    public function consultaReservaID($id_i, $id_f, $hora)
    {
        global $mbd;
        $sentencia6 = $mbd->prepare("SELECT id_horas FROM `horas_del_dia` WHERE `id_horas` BETWEEN :id_i AND :id_f");
        $sentencia6->bindParam(":id_i", $id_i);
        $sentencia6->bindParam(":id_f", $id_f);
        $sentencia6->execute();
        $data2 = array();
        while ($registros6 = $sentencia6->fetch(PDO::FETCH_ASSOC)) {
            array_push($data2, $registros6['id_horas']);
        }

        $retVal = (in_array($hora, $data2)) ? "1" : "2";

        return $retVal;
    }

    public function consultaDocente($id, $tipo)
    {
        if ($tipo == "d") {
            $sql = "SELECT * FROM `docente` WHERE id_usuario = :id";
            $tipo = "Docente: ";
        } else {
            $sql = "SELECT * FROM `usuario` WHERE id_usuario = :id";
            $tipo = "Funcionario: ";
        }


        global $mbd;
        $sentencia = $mbd->prepare($sql);
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $data = $registro['usuario_nombre'] . " " . $registro['usuario_nombre_2'] . " " . $registro['usuario_apellido'] . " " . $registro['usuario_apellido_2'];

        return $tipo . $data;
    }

    public function consultaDocenteGrupo($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `docente_grupos` WHERE `id_docente_grupo` = :id");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $data = $registro['semestre'] . "° " . self::consultaPrograma($registro['id_programa']) . " 
        Materia: " . $registro['materia'] . " 
        " . self::consultaDocente($registro['id_docente'], 'd') . " 
        Jornada: " . $registro['jornada'];

        return $data;
    }

    public function consultaPrograma($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `nombre` FROM `programa_ac` WHERE `id_programa` = :id ");
        $sentencia->bindParam(":id", $id);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $data = $registro['nombre'];

        return $data;
    }

    public function listarHoraSalones($salon)
    {
        $condicion = "";

        if ($salon == "0") {
            $condicion = "SELECT * FROM `salones` WHERE `codigo` BETWEEN 'S-01' AND 'S-04'";
        }

        if ($salon == "1") {
            $condicion = "SELECT * FROM `salones` WHERE `codigo` = 'SALAJUNTAS'";
        }

        if ($salon == "2") {
            $condicion = "SELECT * FROM `salones` WHERE `codigo` BETWEEN '202' AND '299'";
        }
        if ($salon == "3") {
            $condicion = "SELECT * FROM `salones` WHERE `codigo` BETWEEN '301' AND '399'";
        }

        if ($salon == "4") {
            $condicion = "SELECT * FROM `salones` WHERE `codigo` BETWEEN '402' AND '499'";
        }

        if ($salon == "5") {
            $condicion = "SELECT * FROM `salones` WHERE `codigo` BETWEEN '502' AND '599'";
        }


        global $mbd;
        $data = array();
        $sentencia = $mbd->prepare("$condicion");
        $sentencia->execute();
        $registros = $sentencia->fetchAll();
        $mbd = null;
        echo json_encode($registros);
    }

    // public function aggReserva($id_docente, $horario, $hora_f, $salon, $descripcion, $fecha_reserva)
    // {
    //     global $mbd;
    //     $tipo_user = ($_SESSION['usuario_cargo'] == "Docente") ? "d" : "f";
    //     $periodo = $_SESSION['periodo_actual'];
    //     $estado = "0";
    //     $fecha = date('Y-m-d');
    //     $sentencia = $mbd->prepare("INSERT INTO `reservas_salones`(tipo_usuario,`id_docente`, `horario`, `salon`, `periodo`, `detalle_reserva`, `fecha_solicitud`, `fecha_reserva`, `estado`, `hora_f` ) VALUES (:tipo_usu,:id_docente, :horario, :salon, :periodo, :detalle, :fecha_soli, :fecha_reserva, :estado, :hora)");
    //     $sentencia->bindParam(":tipo_usu", $tipo_user);
    //     $sentencia->bindParam(":id_docente", $id_docente);
    //     $sentencia->bindParam(":horario", $horario);
    //     $sentencia->bindParam(":salon", $salon);
    //     $sentencia->bindParam(":periodo", $periodo);
    //     $sentencia->bindParam(":detalle", $descripcion);
    //     $sentencia->bindParam(":fecha_soli", $fecha);
    //     $sentencia->bindParam(":fecha_reserva", $fecha_reserva);
    //     $sentencia->bindParam(":estado", $estado);
    //     $sentencia->bindParam(":hora", $hora_f);
    //     return($sentencia->execute());
    // }

      public function aggReserva($id_docente, $horario, $hora_f, $salon, $descripcion, $fecha_reserva, $nombre_docente, $correo_docente, $telefono_docente, $programa, $programa_otro, $asistentes, $asistentes_otro, $materia_evento, $experiencia_nombre, $experiencia_objetivo, $duracion_horas, $requerimientos, $requerimientos_otro, $novedad)
    {
        global $mbd;
        $tipo_user = ($_SESSION['usuario_cargo'] == "Docente") ? "d" : "f";
        $periodo = $_SESSION['periodo_actual'];
        $estado = "0";
        $fecha = date('Y-m-d');
        $sentencia = $mbd->prepare("INSERT INTO `reservas_salones`(tipo_usuario,`id_docente`, `horario`, `salon`, `periodo`, `detalle_reserva`, `fecha_solicitud`, `fecha_reserva`,`estado`,`hora_f`,`nombre_docente`,`correo_docente`,`telefono_docente`,`programa`,`programa_otro`,`asistentes`,`asistentes_otro`,`materia_evento`,`experiencia_nombre`,`experiencia_objetivo`,`duracion_horas`,`requerimientos`,`requerimientos_otro`,`novedad`) VALUES (:tipo_usu,:id_docente, :horario, :salon, :periodo, :detalle, :fecha_soli, :fecha_reserva,:estado,:hora,:nombre_docente,:correo_docente,:telefono_docente,:programa,:programa_otro,:asistentes,:asistentes_otro,:materia_evento,:experiencia_nombre,:experiencia_objetivo,:duracion_horas,:requerimientos,:requerimientos_otro,:novedad)");
        $sentencia->bindParam(":tipo_usu", $tipo_user);
        $sentencia->bindParam(":id_docente", $id_docente);
        $sentencia->bindParam(":horario", $horario);
        $sentencia->bindParam(":salon", $salon);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->bindParam(":detalle", $descripcion);
        $sentencia->bindParam(":fecha_soli", $fecha);
        $sentencia->bindParam(":fecha_reserva", $fecha_reserva);
        $sentencia->bindParam(":estado", $estado);
        $sentencia->bindParam(":hora", $hora_f);
        // campos nuevos
        $sentencia->bindParam(":nombre_docente", $nombre_docente);
        $sentencia->bindParam(":correo_docente", $correo_docente);
        $sentencia->bindParam(":telefono_docente", $telefono_docente);
        $sentencia->bindParam(":programa", $programa);
        $sentencia->bindParam(":programa_otro", $programa_otro);
        $sentencia->bindParam(":asistentes", $asistentes);
        $sentencia->bindParam(":asistentes_otro", $asistentes_otro);
        $sentencia->bindParam(":materia_evento", $materia_evento);
        $sentencia->bindParam(":experiencia_nombre", $experiencia_nombre);
        $sentencia->bindParam(":experiencia_objetivo", $experiencia_objetivo);
        $sentencia->bindParam(":duracion_horas", $duracion_horas);
        $sentencia->bindParam(":requerimientos", $requerimientos);
        $sentencia->bindParam(":requerimientos_otro", $requerimientos_otro);
        $sentencia->bindParam(":novedad", $novedad);
        return ($sentencia->execute());
    }

    public function consultaReservas($inicio, $fin, $salon, $fecha)
    {
        global $mbd;
        $data2 = array();
        $data3 = array();
        #consulto los id de de la hora de inicio y la hora final y los guardo en eun arreglo
        $sentencia6 = $mbd->prepare("SELECT id_horas FROM `horas_del_dia` WHERE `id_horas` BETWEEN :id_i AND :id_f");
        $sentencia6->bindParam(":id_i", $inicio);
        $sentencia6->bindParam(":id_f", $fin);
        $sentencia6->execute();


        $sentencia = $mbd->prepare(" SELECT * FROM `reservas_salones` WHERE horario = :inicio AND hora_f = :fin AND salon = :salon AND fecha_reserva = :fecha AND estado = 'r' ");
        $sentencia->bindParam(":inicio", $inicio);
        $sentencia->bindParam(":fin", $fin);
        $sentencia->bindParam(":salon", $salon);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        $pe = $_SESSION['periodo_actual'];

        if ($registro != false) {
            while ($registros6 = $sentencia6->fetch(PDO::FETCH_ASSOC)) {
                array_push($data2, $registros6['id_horas']);
            }

            for ($inicio; $inicio <= $fin; $inicio++) {
                if (in_array($inicio, $data2)) {
                    //return 1;
                }
            }
        } else {
            $corte = self::consultarCorte();
            $dia = self::convertir_fecha($fecha);
            if ($dia == "Sabado") {
                $diaFinal = " `dia` = 'Sabado' AND salon = '$salon' AND periodo_hora = '$pe' ||  `dia` = 'Sabado_FDS_Corte$corte' AND salon = '$salon' AND periodo_hora = '$pe' ";
            } else {
                if ($dia == "Viernes") {
                    $diaFinal = " `dia` = 'Viernes' AND salon = '$salon' AND periodo_hora = '$pe' || dia = 'Viernes_fds_corte$corte' AND salon = '$salon' AND periodo_hora = '$pe' ";
                } else {
                    $diaFinal = " `dia` = '$dia' AND salon = '$salon' AND periodo_hora = '$pe' ";
                }
            }

            $sen = $mbd->prepare(" SELECT * FROM `horas_grupos` WHERE $diaFinal ");
            $sen->execute();
            $resp = $sen->fetchAll(PDO::FETCH_ASSOC);
            //print_r($sen);
            if ($resp) {
                for ($i = 0; $i < count($resp); $i++) {
                    $ini = $resp[$i]['hora'];
                    $f = $resp[$i]['hasta'];
                    $senten = $mbd->prepare(" SELECT id_horas FROM `horas_del_dia` WHERE `horas` BETWEEN '$ini' AND '$f' ");
                    $senten->execute();
                    $res = $senten->fetchAll(PDO::FETCH_ASSOC);

                    $a = 0;
                    while ($a < count($res)) {
                        if (in_array($res[$a]['id_horas'], $data3)) {
                            //return 1;
                        } else {
                            array_push($data3, $res[$a]['id_horas']);
                        }

                        $a++;
                    }
                    //print_r($senten);
                }

                //print_r($data3);

                if ($data3) {
                    for ($inicio; $inicio <= $fin; $inicio++) {
                        if (in_array($inicio, $data3)) {
                            return 1;
                            die();
                        }
                    }
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    public function consultaFecha($id_hora, $hora_i, $salon)
    {
        global $mbd;
        $tipo_user = ($_SESSION['usuario_cargo'] == "Docente") ? "d" : "f";
        $id = $_SESSION['id_usuario'];
        $pe = $_SESSION['periodo_actual'];
        $sentencia = $mbd->prepare(" SELECT * FROM `reservas_salones` WHERE horario BETWEEN  :hora AND :hora_f AND hora_f BETWEEN :hora AND :hora_f AND id_docente = :id AND salon = :salon AND periodo = :pe AND tipo_usuario = :tipo AND estado = 'r' ");
        $sentencia->bindParam(":hora", $id_hora);
        $sentencia->bindParam(":hora_f", $hora_i);
        $sentencia->bindParam(":salon", $salon);
        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":tipo", $tipo_user);
        $sentencia->bindParam(":pe", $pe);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($registro == false) {
            return 0;
        } else {
            return $registro;
        }
    }

    public function convertir_fecha($date)
    {
        $dia     = explode("-", $date, 3);
        $year     = $dia[0];
        $month     = (string)(int)$dia[1];
        $day     = (string)(int)$dia[2];

        $dias         = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
        $tomadia     = $dias[intval((date("w", mktime(0, 0, 0, $month, $day, $year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        return $tomadia;
    }

    public function convertir_fecha_completa($date)
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


    public function consultaHoraF($hora, $jornada)
    {
        $condicion = "";

        if ($jornada == "Mañana") {
            $condicion = " SELECT * FROM `horas_del_dia` WHERE `horas` BETWEEN :id AND '12:00:00'";
        } else {
            if ($jornada == "Tarde") {
                $condicion = " SELECT * FROM `horas_del_dia` WHERE `horas` BETWEEN :id AND '18:00:00' ";
            } else {
                $condicion = " SELECT * FROM `horas_del_dia` WHERE `horas` BETWEEN :id AND '23:30:00'";
            }
        }

        global $mbd;
        $sentencia = $mbd->prepare($condicion);
        $hora_fin = self::consultaHora($hora);
        $sentencia->bindParam(":id", $hora_fin['horas']);
        $sentencia->execute();
        $registros = $sentencia->fetchAll();

        echo json_encode($registros);
    }

    public function consultaHora($hora)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `horas_del_dia` WHERE `id_horas` = :hora ");
        $sentencia->bindParam(":hora", $hora);
        $sentencia->execute();
        $registros = $sentencia->fetch();

        return $registros;
    }


    public function consultaHoraI($hora)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `horas_del_dia` WHERE `id_horas` = :hora ");
        $sentencia->bindParam(":hora", $hora);
        $sentencia->execute();
        $registros = $sentencia->fetch();

        echo json_encode($registros);
    }

    public function consultarCorte()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `corte` ");
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros['corte'];
    }



    public function cambiarestado($fecha, $pe)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `reservas_salones` SET `estado`= 'c' WHERE `fecha_reserva` = :fecha AND periodo = :pe ");
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":pe", $pe);
        $sentencia->execute();

        //echo json_encode($fecha);

    }

    public function consultar_informacion_usuario($usuario_identificacion)
	{
		$sql = "SELECT * FROM `usuario` WHERE `usuario_identificacion` = :usuario_identificacion";
		global $mbd;
		// echo $sql;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":usuario_identificacion", $usuario_identificacion);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}
}
