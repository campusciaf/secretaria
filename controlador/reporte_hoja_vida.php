<?php

require_once "../modelos/ReporteHojaVida.php";
date_default_timezone_set("America/Bogota");
$reporte_hoja_vida = new ReporteHojaVida();
switch ($_GET['op']) {
    case 'listar_funcionarios':
        $data = array();
        $fecha_actualizacion = "";
        $registro = $reporte_hoja_vida->InformacionDatosFuncionario();
        for ($i = 0; $i < count($registro); $i++) {
            if (!empty($registro[$i]['usuario_imagen']) && file_exists('../cv_funcionarios/usuarios/' . $registro[$i]['usuario_imagen'])) {
                $foto = '../cv_funcionarios/usuarios/' . $registro[$i]['usuario_imagen'];
            } else {
                $foto = '../cv_funcionarios/usuarios/default_user.webp';
            }
            $cvadministrativos_identificacion = $registro[$i]['cvadministrativos_identificacion'];
            $cvadministrativos_nombre = $registro[$i]['cvadministrativos_nombre'];
            $usuario_apellido = $registro[$i]['usuario_apellido'];
            $fecha_nacimiento = $registro[$i]['fecha_nacimiento'];
            $estado_civil = $registro[$i]['estado_civil'];
            $departamento = $registro[$i]['departamento'];
            $ciudad = $registro[$i]['ciudad'];
            $direccion = $registro[$i]['direccion'];
            $celular = $registro[$i]['cvadministrativos_celular'];
            $nacionalidad = $registro[$i]['nacionalidad'];
            $pagina_web = $registro[$i]['pagina_web'];
            $genero = $registro[$i]['genero'];
            $tipo_vivienda = $registro[$i]['tipo_vivienda'];
            $estrato = $registro[$i]['estrato'];
            $numero_hijos = $registro[$i]['numero_hijos'];
            $hijos_menores_10 = $registro[$i]['hijos_menores_10'];
            $personas_a_cargo = $registro[$i]['personas_a_cargo'];
            $nivel_escolaridad = $registro[$i]['nivel_escolaridad'];
            $nombre_emergencia  = $registro[$i]['nombre_emergencia'];
            $parentesco = $registro[$i]['parentesco'];
            $numero_telefonico_emergencia = $registro[$i]['numero_telefonico_emergencia'];
            $titulo_profesional = $registro[$i]['titulo_profesional'];
            $categoria_profesion = $registro[$i]['categoria_profesion'];
            $situacion_laboral = $registro[$i]['situacion_laboral'];
            $perfil_descripcion = $registro[$i]['perfil_descripcion'];
            $experiencia_docente = $registro[$i]['experiencia_docente'];
            $politicamente_expuesta = $registro[$i]['politicamente_expuesta'];
            // buscamos el nombre del departamento
            $traer_departamento = $reporte_hoja_vida->obtenerDepartamento($departamento);
            $departamento_nombre = $traer_departamento['departamento'];
            // buscamos el nombre del municipio
            $traer_municipio = $reporte_hoja_vida->obtenerMunicipio($ciudad);
            $municipio_nombre = $traer_municipio['municipio'];
            // definimos array para mostrar en la tabla con texto.
            $array_genero = array("1" => "Masculino","2" => "Femenino","3" => "Otro");
            $array_tipo_vivienda = array("1" => "Propia","2" => "Alquilada","3" => "Viviendo con Familiares","4" => "Otros");
            $array_nivel_escolaridad = array( "1" => "Primaria", "2" => "Secundaria", "3" => "Técnico", "4" => "Tecnólogo", "5" => "Profesional", "6" => "Especialización", "7" => "Maestría", "8" => "Doctorado");
            $array_si_no = array("1" => "Sí","0" => "No");

            $data[] = array(
                '0'  => $cvadministrativos_identificacion,
                '1'  => $cvadministrativos_nombre,
                '2'  => $usuario_apellido,
                '3'  => $fecha_nacimiento,
                '4'  => $estado_civil,
                '5'  => $departamento_nombre,
                '6'  => $municipio_nombre,
                '7'  => '<img src="' . $foto . '" height="30" width="30" alt="foto">',
                '8'  => $direccion,
                '9'  => $celular,
                '10' => $nacionalidad,
                '11' => $pagina_web,
                '12' => $array_genero[$genero],
                '13' => $array_tipo_vivienda[$tipo_vivienda],
                '14' => $estrato,
                '15' => $numero_hijos,
                '16' => $hijos_menores_10,
                '17' => $personas_a_cargo,
                '18' => $array_nivel_escolaridad[$nivel_escolaridad],
                '19' => $nombre_emergencia,
                '20' => $parentesco,
                '21' => $numero_telefonico_emergencia,
                '22' => $titulo_profesional,
                '23' => $categoria_profesion,
                '24' => $situacion_laboral,
                '25' => $perfil_descripcion,
                '26' => $array_si_no[$experiencia_docente],
                '27' => $array_si_no[$politicamente_expuesta],
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}
