<?php
require_once "../config/Conexion.php";
class SofiInscribete{
    public function mostrarDepartamentos(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `departamentos`");
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function mostrarMunicipios($id_departamento){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `municipios` WHERE `departamento_id` = :id_departamento");
        $sentencia->bindParam(":id_departamento", $id_departamento);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    //periodos en los que esta el sofi actualemnte
    public function periodoActualyAnterior(){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_periodo`");
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $registro;
    }
    public function insertarSolicitud($tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $estado_civil, $direccion, $ciudad, $celular, $email, $persona_a_cargo, $ocupacion, $tipo, $estado, $idsolicitante, $labora, $genero, $numero_hijos, $nivel_educativo, $nacionalidad, $codeudor_nombre, $codeudor_telefono, $estrato){
        $periodo_actual = $this->periodoActualyAnterior()['periodo_actual'];
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_persona` (`id_persona`, `tipo_documento`, `numero_documento`, `nombres`, `apellidos`, `fecha_nacimiento`, `estado_civil`, `direccion`, `ciudad`, `celular`, `email`, `persona_a_cargo`, `ocupacion`, `periodo`, `tipo`, `estado`, `idsolicitante`, `labora`, `id_programa`, `genero`, `numero_hijos`, `nivel_educativo`, `nacionalidad`, `codeudor_nombre`, `codeudor_telefono`, `estrato`) VALUES (NULL, :tipo_documento, :numero_documento, :nombres, :apellidos, :fecha_nacimiento, :estado_civil, :direccion, :ciudad, :celular, :email, :persona_a_cargo, :ocupacion,  :periodo_actual, :tipo, :estado, :idsolicitante, :labora, 1, :genero, :numero_hijos, :nivel_educativo, :nacionalidad, :codeudor_nombre, :codeudor_telefono, :estrato);");
        $sentencia->bindParam(':tipo_documento', $tipo_documento);
        $sentencia->bindParam(':numero_documento', $numero_documento);
        $sentencia->bindParam(':nombres', $nombres);
        $sentencia->bindParam(':apellidos', $apellidos);
        $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $sentencia->bindParam(':estado_civil', $estado_civil);
        $sentencia->bindParam(':direccion', $direccion);
        $sentencia->bindParam(':ciudad', $ciudad);
        $sentencia->bindParam(':celular', $celular);
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':persona_a_cargo', $persona_a_cargo);
        $sentencia->bindParam(':ocupacion', $ocupacion);
        $sentencia->bindParam(':tipo', $tipo);
        $sentencia->bindParam(':estado', $estado);
        $sentencia->bindParam(':idsolicitante', $idsolicitante);
        $sentencia->bindParam(':labora', $labora);
        $sentencia->bindParam(':periodo_actual', $periodo_actual);
        $sentencia->bindParam(':genero', $genero);
        $sentencia->bindParam(':numero_hijos', $numero_hijos);
        $sentencia->bindParam(':nivel_educativo', $nivel_educativo);
        $sentencia->bindParam(':nacionalidad', $nacionalidad);
        $sentencia->bindParam(':codeudor_nombre', $codeudor_nombre);
        $sentencia->bindParam(':codeudor_telefono', $codeudor_telefono);
        $sentencia->bindParam(':estrato', $estrato);
        if ($sentencia->execute()) {
            return $mbd->lastInsertId();
        }
    }
    public function insertar_referencia($familiarnombre, $familiartelefono, $idpersona){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_referencias`(`tipo_referencia`, `nombre`, `telefono`, `idpersona`) VALUES ('Familiar', :familiarnombre, :familiartelefono, :idpersona);");
        $sentencia->bindParam(":familiarnombre", $familiarnombre);
        $sentencia->bindParam(":familiartelefono", $familiartelefono);
        $sentencia->bindParam(":idpersona", $idpersona);
        return $sentencia->execute();
    }
    public function InsertarReprensentante($nombre_completo_acudiente, $numero_documento_acudiente, $fecha_expedicion_acudiente, $parentesco, $id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_reprensentate_menor`(`nombre_completo_acudiente`, `numero_documento_acudiente`, `fecha_expedicion_acudiente`, `parentesco`, `id_persona`) VALUES(:nombre_completo_acudiente, :numero_documento_acudiente, :fecha_expedicion_acudiente, :parentesco, :id_persona);");
        $sentencia->bindParam(':nombre_completo_acudiente', $nombre_completo_acudiente);
        $sentencia->bindParam(':numero_documento_acudiente', $numero_documento_acudiente);
        $sentencia->bindParam(':fecha_expedicion_acudiente', $fecha_expedicion_acudiente);
        $sentencia->bindParam(':parentesco', $parentesco);
        $sentencia->bindParam(':id_persona', $id_persona);
        return $sentencia->execute();
    }
    public function insertarIngresos($sector_laboral, $tiempo_servicio, $salario, $tipo_vivienda, $id_persona){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_ingresos`( `idpersona`, `sector_laboral`, `tiempo_servicio`, `salario`, `tipo_vivienda`) VALUES (:idpersona, :sector_laboral, :tiempo_servicio, :salario, :tipo_vivienda);");
        $sentencia->bindParam(":tiempo_servicio", $tiempo_servicio);
        $sentencia->bindParam(":sector_laboral", $sector_laboral);
        $sentencia->bindParam(":salario", $salario);
        $sentencia->bindParam(":tipo_vivienda", $tipo_vivienda);
        $sentencia->bindParam(":idpersona", $id_persona);
        return $sentencia->execute();
    }
    public function generarScoreDatacredito($id_persona, $numero_documento, $primer_apellido, $score_value){
        global $mbd;
        $sentencia = $mbd->prepare("INSERT INTO `sofi_datacredito_score`(`id_persona`, `numero_documento`, `primer_apellido`, `score_value`) VALUES (:id_persona, :numero_documento, :primer_apellido, :score_value);");
        $sentencia->bindParam(":id_persona", $id_persona);
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->bindParam(":primer_apellido", $primer_apellido);
        $sentencia->bindParam(":score_value", $score_value);
        return $sentencia->execute();
    }
    public function obtenerUltimoScore($numero_documento){
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `sofi_datacredito_score` WHERE `numero_documento` = :numero_documento ORDER BY `id_score` DESC LIMIT 1;");
        $sentencia->bindParam(":numero_documento", $numero_documento);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}
