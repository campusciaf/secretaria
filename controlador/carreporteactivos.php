<?php
session_start();
require_once "../modelos/CarReporteActivos.php";
$consulta = new CarReporteActivos();

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');


$rsptaperiodo = $consulta->periodoactual();	
$periodo_actual=$rsptaperiodo["periodo_actual"];
$periodo_siguiente=$rsptaperiodo["periodo_siguiente"];


switch ($_GET["op"]) {


	case 'listar':
		$rspta = $consulta->listar($periodo_actual);
		//Vamos a declarar un array
		$data = array();
		$reg = $rspta;


		for ($i = 0; $i < count($reg); $i++) {


			$data[] = array(
                "0"  => $reg[$i]["id_credencial"],
                "1"  => $reg[$i]["credencial_identificacion"],
                "2"  => $reg[$i]["nombre_completo"],
                "3"  => $reg[$i]["programa_actual"],
                "4"  => $reg[$i]["jornada_e"],
                "5"  => $reg[$i]["genero"],
                "6"  => $reg[$i]["periodo_ingreso"],
                "7"  => $reg[$i]["fecha_nacimiento"],
                "8"  => $reg[$i]["departamento_nacimiento"],
                "9"  => $reg[$i]["municipio_nacimiento"],
                "10" => $reg[$i]["estado_civil"],
                "11" => $reg[$i]["grupo_etnico"],
                "12" => $reg[$i]["nombre_etnico"],
                "13" => $reg[$i]["desplazado_violencia"],
                "14" => $reg[$i]["conflicto_armado"],
                "15" => $reg[$i]["departamento_residencia"],
                "16" => $reg[$i]["municipio_residencia"],
                "17" => $reg[$i]["tipo_residencia"],
                "18" => $reg[$i]["zona_residencia"],
                "19" => $reg[$i]["direccion"],
                "20" => $reg[$i]["barrio"],
                "21" => $reg[$i]["estrato"],
                "22" => $reg[$i]["celular"],
                "23" => $reg[$i]["whatsapp"],
                "24" => $reg[$i]["instagram"],
                "25" => $reg[$i]["facebook"],
                "26" => $reg[$i]["twitter"],
                "27" => $reg[$i]["email_personal"],
                "28" => $reg[$i]["tipo_sangre"],
                "29" => $reg[$i]["estas_embarazada"],
                "30" => $reg[$i]["meses_embarazo"],
                "31" => $reg[$i]["eres_desplazado_violencia"],
                "32" => $reg[$i]["tipo_desplazamiento"],
                "33" => $reg[$i]["grupo_poblacional"],
                "34" => $reg[$i]["comunidad_lgbtiq"],
                "35" => $reg[$i]["cual_comunidad"],
                "36" => $reg[$i]["contacto1_nombre"],
                "37" => $reg[$i]["contacto1_relacion"],
                "38" => $reg[$i]["contacto1_email"],
                "39" => $reg[$i]["contacto1_telefono"],
                "40" => $reg[$i]["contacto2_nombre"],
                "41" => $reg[$i]["contacto2_relacion"],
                "42" => $reg[$i]["contacto2_email"],
                "43" => $reg[$i]["contacto2_telefono"],
                "44" => $reg[$i]["tiene_computador_tablet"],
                "45" => $reg[$i]["conexion_internet_casa"],
                "46" => $reg[$i]["planes_datos_celular"],
                "47" => $reg[$i]["estado_civil_2"],
                "48" => $reg[$i]["tiene_hijos"],
                "49" => $reg[$i]["cantidad_hijos"],
                "50" => $reg[$i]["padre_vivo"],
                "51" => $reg[$i]["nombre_padre"],
                "52" => $reg[$i]["telefono_padre"],
                "53" => $reg[$i]["nivel_educativo_padre"],
                "54" => $reg[$i]["madre_viva"],
                "55" => $reg[$i]["nombre_madre"],
                "56" => $reg[$i]["telefono_madre"],
                "57" => $reg[$i]["nivel_educativo_madre"],
                "58" => $reg[$i]["situacion_laboral_padres"],
                "59" => $reg[$i]["sector_laboral_padres"],
                "60" => $reg[$i]["cursos_interes_padres"],
                "61" => $reg[$i]["tienes_pareja"],
                "62" => $reg[$i]["nombre_pareja"],
                "63" => $reg[$i]["celular_pareja"],
                "64" => $reg[$i]["tienes_hermanos"],
                "65" => $reg[$i]["cantidad_hermanos"],
                "66" => $reg[$i]["edad_hermanos"],
                "67" => $reg[$i]["con_quien_vive"],
                "68" => $reg[$i]["personas_a_cargo"],
                "69" => $reg[$i]["cantidad_personas_cargo"],
                "70" => $reg[$i]["inspirador_estudio"],
                "71" => $reg[$i]["nombre_inspirador"],
                "72" => $reg[$i]["whatsapp_inspirador"],
                "73" => $reg[$i]["email_inspirador"],
                "74" => $reg[$i]["nivel_formacion_inspirador"],
                "75" => $reg[$i]["situacion_laboral_inspirador"],
                "76" => $reg[$i]["sector_inspirador"],
                "77" => $reg[$i]["cursos_inspirador"],
                "78" => $reg[$i]["trabajas_actualmente"],
                "79" => $reg[$i]["empresa_trabajas"],
                "80" => $reg[$i]["sector_empresa_trabajas"],
                "81" => $reg[$i]["direccion_empresa"],
                "82" => $reg[$i]["telefono_empresa"],
                "83" => $reg[$i]["jornada_laboral"],
                "84" => $reg[$i]["incentivos_empresa_formacion"],
                "85" => $reg[$i]["alguien_trabajo_te_inspiro"],
                "86" => $reg[$i]["nombre_inspirador_trabajo"],
                "87" => $reg[$i]["telefono_inspirador_trabajo"],
                "88" => $reg[$i]["empresa_propia"],
                "89" => $reg[$i]["nombre_razon_empresa"],
                "90" => $reg[$i]["tienes_emprendimiento"],
                "91" => $reg[$i]["nombre_emprendimiento"],
                "92" => $reg[$i]["sector_emprendimiento"],
                "93" => $reg[$i]["motivacion_emprender"],
                "94" => $reg[$i]["recursos_emprendimiento"],
                "95" => $reg[$i]["curso_emprendimiento"],
                "96" => $reg[$i]["cual_curso_emprendimiento"],
                "97" => $reg[$i]["ingresos_mensuales"],
                "98" => $reg[$i]["quien_paga_matricula"],
                "99" => $reg[$i]["apoyo_financiero"],
                "100" => $reg[$i]["recibe_prima_cesantias"],
                "101" => $reg[$i]["obligaciones_financieras"],
                "102" => $reg[$i]["tipo_obligaciones"],
                "103" => $reg[$i]["motivacion_estudio"],
                "104" => $reg[$i]["como_enteraste_ciaf"],
                "105" => $reg[$i]["area_preferencia"],
                "106" => $reg[$i]["forma_aprendizaje"],
                "107" => $reg[$i]["doble_titulacion"],
                "108" => $reg[$i]["programa_interes"],
                "109" => $reg[$i]["dominas_segundo_idioma"],
                "110" => $reg[$i]["cual_idioma"],
                "111" => $reg[$i]["nivel_idioma"],
                "112" => $reg[$i]["segundo_contacto_emergencia_nombre"],
                "113" => $reg[$i]["enfermedad_fisica"],
                "114" => $reg[$i]["cual_enfermedad_fisica"],
                "115" => $reg[$i]["tratamiento_enfermedad_fisica"],
                "116" => $reg[$i]["trastorno_mental"],
                "117" => $reg[$i]["cual_trastorno_mental"],
                "118" => $reg[$i]["tratamiento_mental"],
                "119" => $reg[$i]["bienestar_emocional"],
                "120" => $reg[$i]["eps_afiliado"],
                "121" => $reg[$i]["medicamentos_permanentes"],
                "122" => $reg[$i]["cuales_medicamentos"],
                "123" => $reg[$i]["habilidad_talento"],
                "124" => $reg[$i]["cual_habilidad"],
                "125" => $reg[$i]["actividades_extracurriculares"],
                "126" => $reg[$i]["reconocimientos_habilidad"],
                "127" => $reg[$i]["integracion_habilidad"],
                "128" => $reg[$i]["actividades_interes"],
                "129" => $reg[$i]["voluntariado"],
                "130" => $reg[$i]["cual_voluntariado"],
                "131" => $reg[$i]["participar_en_ciaf"],
                "132" => $reg[$i]["temas_interes"],
                "133" => $reg[$i]["musica_preferencia"],
                "134" => $reg[$i]["habilidades_a_desarrollar"],
                "135" => $reg[$i]["deporte_interes"],
                "136" => $reg[$i]["estado_credito"],
                "137" => $reg[$i]["dias_atraso"],
                "138" => $reg[$i]["credito_finalizado"],
                "139" => $reg[$i]["uso_plataforma"],
                "140" => $reg[$i]["edad"],


            );

		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

	break;

}
