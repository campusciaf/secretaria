<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
session_start();
date_default_timezone_set('America/Bogota');
class SofiFinanciados
{
    public function mostrarDepartamentos()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `departamentos`");
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function traerInfoTicket($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_ticket_financion` WHERE `id_persona` = :id_persona ORDER BY `sofi_ticket_financion`.`id_ticket` DESC");
        $sentencia->bindParam(":id_persona", $id_persona);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function mostrarMunicipios($id_departamento)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `municipios` WHERE `departamento_id` = :id_departamento");
        $sentencia->bindParam(":id_departamento", $id_departamento);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    //periodos en los que esta el sofi actualemnte
    public function periodoActualyAnterior()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista los periodos en los que el sofi tiene creditos
    public function periodosEnSofi()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `periodo` WHERE periodo_sofi='1'");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los programas
    public function listarProgramas()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `programa_ac`");
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los programas
    public function traerNombrePrograma($id_programa)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `nombre` FROM `programa_ac` WHERE `id_programa` = :id_programa");
        $sentencia->bindParam(":id_programa", $id_programa);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes o filtro de estudiantes que se necesiten
    public function listarFinanciados($estado, $periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sp`.*, `ce`.`id_credencial` FROM `sofi_persona` `sp` LEFT JOIN `credencial_estudiante` `ce` ON `sp`.`numero_documento` = `ce`.`credencial_identificacion`  WHERE `sp`.`estado` = :estado AND `sp`.`periodo` = :periodo AND `sp`.`tipo` = 'Solicitante'");
        $sentencia->bindParam(':estado', $estado);
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //lista todos los estudiantes sin importar su estado
    public function listarTodos($periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sp`.*, `ce`.`id_credencial` FROM `sofi_persona` `sp` LEFT JOIN `credencial_estudiante` `ce` ON `sp`.`numero_documento` = `ce`.`credencial_identificacion`  WHERE `sp`.`periodo` = :periodo AND `sp`.`tipo` = 'Solicitante';
");
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico
    public function verInfoSolicitante($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_persona` WHERE id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra a un solicitante especifico
    public function verRefeSolicitante($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_referencias` WHERE idpersona = :id_persona ORDER BY `sofi_referencias`.`idrefencia` ASC");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //verifica que el consecutivo ya este 
    public function consultarConsecutivo($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `id` FROM `sofi_matricula` WHERE `id` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //hace la insercion de la matricula para que los estudiantes pasen a aprobados
    public function insertarMatricula($consecutivo, $id_persona, $programa, $valor_total, $valor_financiacion, $motivo_financiacion, $descuento, $descuento_por, $fecha_inicial, $dia_pago, $cantidad_tiempo, $semestre, $jornada, $primer_curso, $periodo, $id_usuario)
    {
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_matricula`(`id`, `programa`, `valor_total`, `valor_financiacion`,`motivo_financiacion`, `descuento`, `descuento_por`, `periodo`, `fecha_inicial`, `dia_pago`, `cantidad_tiempo`, `semestre`, `jornada`, `id_persona`, `primer_curso`, `creado_por`) VALUES(:consecutivo, :programa, :valor_total, :valor_financiacion,:motivo_financiacion, :descuento, :descuento_por, :periodo, :fecha_inicial, :dia_pago, :cantidad_tiempo, :semestre, :jornada, :id_persona, :primer_curso, :id_usuario )");
        //echo "$consecutivo,$programa, $valor_total, $valor_financiacion,$motivo_financiacion, $descuento, $descuento_por, $periodo, $fecha_inicial, $dia_pago, $cantidad_tiempo, $semestre, $jornada, $id_persona, $primer_curso";
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->bindParam(':programa', $programa);
        $sentencia->bindParam(':valor_total', $valor_total);
        $sentencia->bindParam(':valor_financiacion', $valor_financiacion);
        $sentencia->bindParam(':motivo_financiacion', $motivo_financiacion);
        $sentencia->bindParam(':descuento', $descuento);
        $sentencia->bindParam(':descuento_por', $descuento_por);
        $sentencia->bindParam(':periodo', $periodo);
        $sentencia->bindParam(':fecha_inicial', $fecha_inicial);
        $sentencia->bindParam(':dia_pago', $dia_pago);
        $sentencia->bindParam(':cantidad_tiempo', $cantidad_tiempo);
        $sentencia->bindParam(':semestre', $semestre);
        $sentencia->bindParam(':jornada', $jornada);
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':primer_curso', $primer_curso);
        $sentencia->bindParam(':id_usuario', $id_usuario);
        if ($sentencia->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //hace la insercion de la matricula para que los estudiantes pasen a aprobados
    public function insertarCuota($i, $cuota_val, $temp_date, $consecutivo, $id_persona)
    {
        $plazo_pago = date("Y-m-d", strtotime($temp_date . ' + 3 days'));
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_financiamiento`(`numero_cuota`, `valor_cuota`,  `fecha_pago`, `plazo_pago`, `estado`, `numero_documento`, `id_matricula`) VALUES (:i, :cuota_val, :temp_date, :plazo_pago , 'A Pagar', :id_persona, :consecutivo)");
        $sentencia->bindParam(':i', $i);
        $sentencia->bindParam(':cuota_val', $cuota_val);
        $sentencia->bindParam(':temp_date', $temp_date);
        $sentencia->bindParam(':plazo_pago', $plazo_pago);
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':consecutivo', $consecutivo);
        //echo "$cuota_val, '$temp_date', '$plazo_pago' $id_persona, $consecutivo";
        return $sentencia->execute();
    }
    //cambia el estado del estudiante a aprobado
    public function aprobarCredito($id_persona, $periodo, $ultima_fecha_cuota)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_persona` SET `estado` = 'Aprobado', `periodo` = '$periodo' WHERE `id_persona` = :id_persona; UPDATE `sofi_matricula` SET `ultima_fecha_cuota` = :ultima_fecha_cuota WHERE `id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':ultima_fecha_cuota', $ultima_fecha_cuota);
        return $sentencia->execute();
    }
    //anula el credito del estdiante seleccionado
    public function anularSolicitud($id_persona, $motivo_cancela)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE sofi_persona SET estado = 'Anulado', motivo_cancela = :motivo_cancela WHERE id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':motivo_cancela', $motivo_cancela);
        return $sentencia->execute();
    }
    //pre aprueba el credito del estdiante seleccionado
    public function preAprobarSolicitud($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE sofi_persona SET estado = 'Pre-Aprobado' WHERE id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        return $sentencia->execute();
    }
    //trae los datos que van en el plan de pagos
    public function datosPlanPagos($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `sofi_persona`.nombres, `sofi_persona`.apellidos, `sofi_persona`.telefono, `sofi_persona`.labora, `sofi_persona`.celular, `sofi_persona`.numero_documento, `sofi_matricula`.id , `sofi_matricula`.valor_total ,`sofi_matricula`.valor_financiacion ,`sofi_matricula`.dia_pago ,`sofi_matricula`.cantidad_tiempo ,DATE(`sofi_matricula`.fecha_inicial) as fecha_inicial , `sofi_referencias`.nombre as nombre_codeudor, `sofi_referencias`.telefono as telefono_codeudor, `sofi_referencias`.celular as celular_codeudor FROM `sofi_referencias` INNER JOIN `sofi_persona` ON `sofi_referencias`.`idpersona` = `sofi_persona`.`id_persona` INNER JOIN `sofi_matricula` on `sofi_matricula`.id_persona = `sofi_persona`.id_persona WHERE `sofi_persona`.id_persona = :id_persona AND `sofi_referencias`.`tipo_referencia` = 'Familiar' limit 1");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //trae los datos que van en el plan de pagos
    public function dePrimerCurso($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_persona` INNER JOIN `sofi_matricula` on `sofi_matricula`.id_persona = `sofi_persona`.id_persona WHERE `sofi_matricula`.id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //Lista la informacion de las cuotas del financiamiento
    public function listarCuotas($consecutivo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_financiamiento` WHERE `id_matricula` = :consecutivo");
        $sentencia->bindParam(':consecutivo', $consecutivo);
        $sentencia->execute();
        $registro = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el motivo de anulacion
    public function detallesAnulamiento($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT `motivo_cancela`, `anulado_por` FROM `sofi_persona` WHERE `id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra el motivo de anulacion
    public function enviarPrejuridico($id_persona, $estado)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_matricula` SET `en_cobro` = :estado WHERE `id_persona` = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->bindParam(':estado', $estado);
        return $sentencia->execute();
    }
    public function moneyFormat($price)
    {
        $currencies['EUR'] = array(2, ',', '.'); // Euro
        $currencies['ESP'] = array(2, ',', '.'); // Euro
        $currencies['USD'] = array(2, '.', ','); // US Dollar
        $currencies['COP'] = array(2, ',', '.'); // Colombian Peso
        $currencies['CLP'] = array(0,  '', '.'); // Chilean Peso
        return number_format($price, $currencies['COP'][0], $currencies['COP'][1], $currencies['COP'][2]);
    }
    public function obtenerPeriodoCampana()
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `on_periodo_actual`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function buscarInteresado($numero_documento, $periodo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `on_interesados` WHERE `identificacion` = :numero_documento AND `periodo_campana` = :periodo AND `estado` != 'No_Interesado';");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->bindParam(":periodo", $periodo);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function actualizar_seleccionado($id_estudiante)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `on_interesados` SET `estado`='Admitido', `matricula`= 0 WHERE `id_estudiante` = :id_estudiante;");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        return $sentencia->execute();
    }
    public function insertarSeguimientoOncenter($id_usuario, $id_estudiante_agregar, $motivo_seguimiento, $mensaje_seguimiento, $fecha, $hora, $asesor)
    {
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `on_seguimiento`(`id_usuario`, `id_estudiante`, `motivo_seguimiento`, `mensaje_seguimiento`, `fecha_seguimiento`, `hora_seguimiento`, `asesor`) VALUES( :id_usuario, :id_estudiante_agregar, :motivo_seguimiento, :mensaje_seguimiento, :fecha, :hora, :asesor)");
        $sentencia->bindParam(":id_usuario", $id_usuario);
        $sentencia->bindParam(":id_estudiante_agregar", $id_estudiante_agregar);
        $sentencia->bindParam(":motivo_seguimiento", $motivo_seguimiento);
        $sentencia->bindParam(":mensaje_seguimiento", $mensaje_seguimiento);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":hora", $hora);
        $sentencia->bindParam(":asesor", $asesor);
        return $sentencia->execute();
    }
    public function actualizar_matriculado($id_estudiante)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `on_interesados` SET `matricula`= 0 WHERE `id_estudiante` = :id_estudiante;");
        $sentencia->bindParam(":id_estudiante", $id_estudiante);
        return $sentencia->execute();
    }
    public function actualizarEnvioCampus($id)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_persona` SET `matricula_campus` = 0 WHERE `id_persona` = :id");
        $sentencia->bindParam(":id", $id);
        return $sentencia->execute();
    }
    public function editarPersona($id_persona_editar, $tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $direccion, $ciudad, $telefono, $celular, $email, $ocupacion, $persona_a_cargo)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `sofi_persona` SET `tipo_documento` = :tipo_documento , `numero_documento` = :numero_documento , `nombres` = :nombres , `apellidos` = :apellidos , `fecha_nacimiento` = :fecha_nacimiento , `direccion` = :direccion , `ciudad` = :ciudad , `telefono` = :telefono , `celular` = :celular , `email` = :email , `ocupacion` = :ocupacion , `persona_a_cargo` = :persona_a_cargo WHERE `id_persona` = :id");
        $sentencia->bindParam(":id", $id_persona_editar);
        $sentencia->bindParam(":tipo_documento", $tipo_documento);
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->bindParam(":nombres", $nombres);
        $sentencia->bindParam(":apellidos", $apellidos);
        $sentencia->bindParam(":fecha_nacimiento", $fecha_nacimiento);
        $sentencia->bindParam(":direccion", $direccion);
        $sentencia->bindParam(":ciudad", $ciudad);
        $sentencia->bindParam(":telefono", $telefono);
        $sentencia->bindParam(":celular", $celular);
        $sentencia->bindParam(":email", $email);
        $sentencia->bindParam(":ocupacion", $ocupacion);
        $sentencia->bindParam(":persona_a_cargo", $persona_a_cargo);
        return $sentencia->execute();
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
    public function etiquetas()
    {
        global $mbd;
        $sentencia = $mbd->prepare(" SELECT * FROM `etiquetas` WHERE `etiqueta_dependencia` = 'Financiera'");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cambiarEtiqueta($id_persona, $valor)
    {
        global $mbd;
        $sentencia = $mbd->prepare(" UPDATE `sofi_matricula` SET id_etiqueta= :valor WHERE id_persona= :id_persona");
        $sentencia->bindParam(":id_persona", $id_persona);
        $sentencia->bindParam(":valor", $valor);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function sofimatricula($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_matricula` WHERE id_persona= :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //traer el numero de whatsapp estudiantes
    public function traerCelularEstudiante($numero_documento)
    {
        global $mbd;
        $hoy = date("Y-m-d");
        $sentencia = $mbd->prepare("SELECT `edp`.`celular` FROM `credencial_estudiante` `ce` INNER JOIN `estudiantes_datos_personales` `edp` ON `ce`.`id_credencial` = `edp`.`id_credencial` WHERE `ce`.`credencial_identificacion` = :numero_documento LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    //muestra si el credito finalizo o sigue pendiente
    public function estadoCredito($id_persona)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT credito_finalizado FROM `sofi_matricula` WHERE id_persona = :id_persona");
        $sentencia->bindParam(':id_persona', $id_persona);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro ? $registro['credito_finalizado'] : null;
    }
    //muestra si el credito finalizo o sigue pendiente
    public function traerScoreDatacredito($numero_documento){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT COALESCE(( SELECT `score_value` FROM `sofi_datacredito_score` WHERE `numero_documento` LIKE :numero_documento ORDER BY `create_dt` DESC LIMIT 1 ), -1) AS `score_value`;");
        $sentencia->bindParam(':numero_documento', $numero_documento);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro['score_value'];
    }
}