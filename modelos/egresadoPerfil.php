<?php
session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class EgresadoPerfil
{
	//Implementamos nuestro constructor
	public function __construct() {}

	//Implementamos un método saber si ya esta el habeas data
    public function aceptoData($id_credencial)
	{
		$sql = "SELECT * FROM egresados_caracterizacion WHERE id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    //Implementamos un método saber si ya es egresado de algun programa
     public function verificarEgresado($id_credencial)
	{
		$sql = "SELECT * FROM estudiantes WHERE id_credencial = :id_credencial AND ciclo=3 AND estado IN (2, 5)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    //metodo para insertar el habeasdata
    public function insertardata($id_credencial, $aceptodata, $fechaaceptodata)
	{
		$sql = "INSERT INTO egresados_caracterizacion (id_credencial, acepta_terminos, fecha_acepto_data)
            VALUES (:id_credencial, :aceptodata, :fechaaceptodata)";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->bindParam(":aceptodata", $aceptodata);
		$consulta->bindParam(":fechaaceptodata", $fechaaceptodata);
		return $consulta->execute();
	}

    
	public function listar($id_credencial)
	{
		$sql = "SELECT * FROM egresados_caracterizacion WHERE id_credencial = :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam(":id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

    public function editarCaracter(
        $id_credencial,
        $vida_graduado,
        $significado_egresado,
        $familiares_estudian_ciaf,
        $tiene_hijos,
        $situacion_laboral,
        $relacion_campo_estudio,
        $aporte_ciaf,
        $preparacion_laboral,
        $tipo_emprendimiento,
        $tipo_emprendimiento_otro,
        $ingreso_mensual,
        $estado_posgrado,
        $nombre_empresa,
        $capacitaciones_complementarias,
        $capacitaciones_otro,
        $habilidades_utiles,
        $habilidades_otro,
        $sugerencias_plan_estudio,
        $sugerencias_otro,
        $satisfaccion_formacion,
        $formas_conexion,
        $formas_conexion_otro,
        $servicios_utiles,
        $servicios_utiles_otro,
        $disposicion_participar,
        $canal_contacto_preferido,
        $recomendaria_ciaf,
        $celular,
        $correo,
        $red_social_activa,
        $usuario_red_social,
        $grupo_etnicos,
        $grupo_etnico_otro,
        $tiene_discapacidad,
        $descripcion_discapacidad,
        $primer_profesional,
        $estrato_socioeconomico,
        $fecha
    ) {
	    global $mbd;

        $sql = "UPDATE egresados_caracterizacion SET
            vida_graduado = :vida_graduado,
            significado_egresado = :significado_egresado,
            familiares_estudian_ciaf = :familiares_estudian_ciaf,
            tiene_hijos = :tiene_hijos,
            situacion_laboral = :situacion_laboral,
            relacion_campo_estudio = :relacion_campo_estudio,
            aporte_ciaf = :aporte_ciaf,
            preparacion_laboral = :preparacion_laboral,
            tipo_emprendimiento = :tipo_emprendimiento,
            tipo_emprendimiento_otro = :tipo_emprendimiento_otro,
            ingreso_mensual = :ingreso_mensual,
            estado_posgrado = :estado_posgrado,
            nombre_empresa = :nombre_empresa,
            capacitaciones_complementarias = :capacitaciones_complementarias,
            capacitaciones_otro = :capacitaciones_otro,
            habilidades_utiles = :habilidades_utiles,
            habilidades_otro = :habilidades_otro,
            sugerencias_plan_estudio = :sugerencias_plan_estudio,
            sugerencias_otro = :sugerencias_otro,
            satisfaccion_formacion = :satisfaccion_formacion,
            formas_conexion = :formas_conexion,
            formas_conexion_otro = :formas_conexion_otro,
            servicios_utiles = :servicios_utiles,
            servicios_utiles_otro = :servicios_utiles_otro,
            disposicion_participar = :disposicion_participar,
            canal_contacto_preferido = :canal_contacto_preferido,
            recomendaria_ciaf = :recomendaria_ciaf,
            celular = :celular,
            correo= :correo,
            red_social_activa = :red_social_activa,
            usuario_red_social = :usuario_red_social,
            grupo_etnicos = :grupo_etnicos,
            grupo_etnico_otro = :grupo_etnico_otro,
            tiene_discapacidad = :tiene_discapacidad,
            descripcion_discapacidad = :descripcion_discapacidad,
            primer_profesional = :primer_profesional,
            estrato_socioeconomico = :estrato_socioeconomico,
            fecha_actualizacion = :fecha
        WHERE id_credencial = :id_credencial";

        $consulta = $mbd->prepare($sql);

        $consulta->bindParam(':id_credencial', $id_credencial);
        $consulta->bindParam(':vida_graduado', $vida_graduado);
        $consulta->bindParam(':significado_egresado', $significado_egresado);
        $consulta->bindParam(':familiares_estudian_ciaf', $familiares_estudian_ciaf);
        $consulta->bindParam(':tiene_hijos', $tiene_hijos);
        $consulta->bindParam(':situacion_laboral', $situacion_laboral);
        $consulta->bindParam(':relacion_campo_estudio', $relacion_campo_estudio);
        $consulta->bindParam(':aporte_ciaf', $aporte_ciaf);
        $consulta->bindParam(':preparacion_laboral', $preparacion_laboral);
        $consulta->bindParam(':tipo_emprendimiento', $tipo_emprendimiento);
        $consulta->bindParam(':tipo_emprendimiento_otro', $tipo_emprendimiento_otro);
        $consulta->bindParam(':ingreso_mensual', $ingreso_mensual);
        $consulta->bindParam(':estado_posgrado', $estado_posgrado);
        $consulta->bindParam(':nombre_empresa', $nombre_empresa);
        $consulta->bindParam(':capacitaciones_complementarias', $capacitaciones_complementarias);
        $consulta->bindParam(':capacitaciones_otro', $capacitaciones_otro);
        $consulta->bindParam(':habilidades_utiles', $habilidades_utiles);
        $consulta->bindParam(':habilidades_otro', $habilidades_otro);
        $consulta->bindParam(':sugerencias_plan_estudio', $sugerencias_plan_estudio);
        $consulta->bindParam(':sugerencias_otro', $sugerencias_otro);
        $consulta->bindParam(':satisfaccion_formacion', $satisfaccion_formacion);
        $consulta->bindParam(':formas_conexion', $formas_conexion);
        $consulta->bindParam(':formas_conexion_otro', $formas_conexion_otro);
        $consulta->bindParam(':servicios_utiles', $servicios_utiles);
        $consulta->bindParam(':servicios_utiles_otro', $servicios_utiles_otro);
        $consulta->bindParam(':disposicion_participar', $disposicion_participar);
        $consulta->bindParam(':canal_contacto_preferido', $canal_contacto_preferido);
        $consulta->bindParam(':recomendaria_ciaf', $recomendaria_ciaf);
        $consulta->bindParam(':celular', $celular);
        $consulta->bindParam(':correo', $correo);
        $consulta->bindParam(':red_social_activa', $red_social_activa);
        $consulta->bindParam(':usuario_red_social', $usuario_red_social);
        $consulta->bindParam(':grupo_etnicos', $grupo_etnicos);
        $consulta->bindParam(':grupo_etnico_otro', $grupo_etnico_otro);
        $consulta->bindParam(':tiene_discapacidad', $tiene_discapacidad);
        $consulta->bindParam(':descripcion_discapacidad', $descripcion_discapacidad);
        $consulta->bindParam(':primer_profesional', $primer_profesional);
        $consulta->bindParam(':estrato_socioeconomico', $estrato_socioeconomico);
        $consulta->bindParam(':fecha', $fecha);

	return $consulta->execute();
}

	//Implementar un método para traer los datos de credencial
	public function datoscredencial($id_credencial)
	{
		$sql = "SELECT * FROM credencial_estudiante ce INNER JOIN egresados_caracterizacion ec ON ce.id_credencial=ec.id_credencial WHERE ce.id_credencial= :id_credencial";
		global $mbd;
		$consulta = $mbd->prepare($sql);
		$consulta->bindParam("id_credencial", $id_credencial);
		$consulta->execute();
		$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	
}
