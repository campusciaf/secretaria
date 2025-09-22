<?php

require_once "../modelos/HvFunHojaDeVida.php";
$informacionPersonal = new HvFunHojaDeVida();

$info_usuario = array(
    'id_informacion_personal' => '',
    'cvadministrativos_nombre' => '',
    'usuario_apellido' => '',
    'id_cvadministrativos' => '',
    'cvadministrativos_identificacion' => '',
    'cvadministrativos_correo' => '',
    'usuario_imagen' => '',
    'edad' => '',
    'fecha_nacimiento' => '',
    'departamento' => '',
    'estado_civil' => '',
    'ciudad' => '',
    'direccion' => '',
    'celular' => '',
    'nacionalidad' => '',
    'pagina_web' => '',
    'titulo_profesional' => '',
    'categoria_profesion' => '',
    'situacion_laboral' => '',
    'resumen_perfil' => '',
    'experiencia_docente' => '',
    // campos nuevos
    'genero' => '',
    'tipo_vivienda' => '',
    'estrato' => '',
    'numero_hijos' => '',
    'hijos_menores_10' => '',
    'personas_a_cargo' => '',
    'nivel_escolaridad' => '',
    'nombre_emergencia' => '',
    'parentesco' => '',
    'numero_telefonico_emergencia' => '',
    'politicamente_expuesta' => '',
);


// tomamos la cedula seleccionada para visualizar todos los datos
// $cedula = $_SESSION["usuario_identificacion"];
// $cedula = $_GET["uid"];
$cedula = !empty($_GET["uid"]) ? $_GET["uid"] : $_SESSION["usuario_identificacion"];

$rspta_usuario = $informacionPersonal->cv_traerIdUsuario($cedula);

$id_cvadministrativos = $rspta_usuario["id_cvadministrativos"];
$informacion_personal = $informacionPersonal->cv_getInfoHoja($id_cvadministrativos);

if ($informacion_personal->rowCount() > 0) {
    //extract convierte los valorees de un array a variables unitarias  
    extract($informacion_personal->fetch(PDO::FETCH_ASSOC));
    $tiempo = strtotime($fecha_nacimiento);
    $ahora = time();
    $edad = ($ahora - $tiempo) / (60 * 60 * 24 * 365.25);
    $edad = floor($edad);
    $municipio_info = $informacionPersonal->cv_get_municipio($ciudad);
    $ciudad_nombre = "";
    if ($municipio_info->rowCount() > 0) {
        extract($municipio_info->fetch(PDO::FETCH_ASSOC));
        $ciudad_nombre = $municipio;
    }
    $departamento_info = $informacionPersonal->cv_get_departamento($departamento);
    $departamento_nombre = "";
    if ($departamento_info->rowCount() > 0) {
        extract($departamento_info->fetch(PDO::FETCH_ASSOC));
        $departamento_nombre = $departamento;
    }
    // aqui llenamos la informacion personal del usuario para visualizar la hoja de vida
    $info_usuario['cvadministrativos_nombre'] = $cvadministrativos_nombre;
    $info_usuario['cvadministrativos_identificacion'] = $cvadministrativos_identificacion;
    $info_usuario['hv_fun_id_informacion_personal'] = $hv_fun_id_informacion_personal;
    $info_usuario['id_cvadministrativos'] = $id_cvadministrativos;
    $info_usuario['usuario_apellido'] = $usuario_apellido; 
    $info_usuario['cvadministrativos_correo'] = $cvadministrativos_correo;
    $info_usuario['usuario_imagen'] = $usuario_imagen;
    $info_usuario['fecha_nacimiento'] = $fecha_nacimiento;
    $info_usuario['edad'] = $edad;
    $info_usuario['departamento'] = $departamento_nombre;
    $info_usuario['estado_civil'] = $estado_civil;
    $info_usuario['ciudad'] = $ciudad_nombre;
    $info_usuario['direccion'] = $direccion;
    $info_usuario['celular'] = $telefono;
    $info_usuario['nacionalidad'] = $nacionalidad;
    $info_usuario['pagina_web'] = $pagina_web;
    $info_usuario['titulo_profesional'] = $titulo_profesional;
    $info_usuario['categoria_profesion'] = $categoria_profesion;
    $info_usuario['situacion_laboral'] = $situacion_laboral;
    $info_usuario['resumen_perfil'] = $perfil_descripcion;
    $info_usuario['experiencia_docente'] = $experiencia_docente;
    // campos nuevos
    $info_usuario['genero'] = $genero;
    $info_usuario['tipo_vivienda'] = $tipo_vivienda;
    $info_usuario['estrato'] = $estrato;
    $info_usuario['numero_hijos'] = $numero_hijos;
    $info_usuario['hijos_menores_10'] = $hijos_menores_10;
    $info_usuario['personas_a_cargo'] = $personas_a_cargo;
    $info_usuario['nivel_escolaridad'] = $nivel_escolaridad;
    $info_usuario['nombre_emergencia'] = $nombre_emergencia;
    $info_usuario['parentesco'] = $parentesco;
    $info_usuario['numero_telefonico_emergencia'] = $numero_telefonico_emergencia;
    $info_usuario['politicamente_expuesta'] = $politicamente_expuesta;

}

$educacions_stmt = $informacionPersonal->cv_listareducacion($id_cvadministrativos);
if ($educacions_stmt->rowCount() > 0) {
    $educacions_arr = array();
    while ($row_educacions = $educacions_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_educacions);
        $educacions_arr[] = array(
            'titulo_obtenido' => $titulo_obtenido,
            'institucion_academica' => $institucion_academica,
            'desde_cuando_f' => $desde_cuando_f,
            'hasta_cuando_f' => $hasta_cuando_f,
            'mas_detalles_f' => $mas_detalles_f,
            'certificado_educacion' => $certificado_educacion
        );
    }
} else {
    $educacions_arr[] = array(
        'titulo_obtenido' => "",
        'institucion_academica' => "",
        'desde_cuando_f' => "",
        'hasta_cuando_f' => "",
        'mas_detalles_f' => "",
        'certificado_educacion' => ""
    );
}
$experiencias_stmt = $informacionPersonal->cv_listarExperienciasHoja($id_cvadministrativos);
if ($experiencias_stmt->rowCount() > 0) {
    $experiencias_arr = array();
    while ($row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_experiencias);
        $experiencias_arr[] = array(
            'nombre_empresa' => $nombre_empresa,
            'cargo_empresa' => $cargo_empresa,
            'desde_cuando' => $desde_cuando,
            'hasta_cuando' => $hasta_cuando,
            'mas_detalles' => $mas_detalles,
            'id_experiencia' => $id_experiencia
        );
    }
} else {
    $experiencias_arr[] = array(
        'nombre_empresa' => "",
        'cargo_empresa' => "",
        'desde_cuando' => "",
        'hasta_cuando' => "",
        'mas_detalles' => "",
        'id_experiencia' => ""
    );
}

$habilidad_stmt = $informacionPersonal->cv_listarHabilidad($id_cvadministrativos);
if ($habilidad_stmt->rowCount() > 0) {
    $habilidad_arr = array();
    while ($row_habilidad = $habilidad_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_habilidad);
        $color;
        switch ($nivel_habilidad) {
            case "1":
                $color = "bg-red";
                break;
            case "2":
                $color = "bg-orange";
                break;
            case "3":
                $color = "bg-warning";
                break;
            case "4":
                $color = "bg-teal";
                break;
            case "5":
                $color = "bg-green";
                break;
            default:
                $color = "bg-gray";
                break;
        }
        $habilidad_arr[] = array(
            'id_habilidad' => $id_habilidad,
            'nombre_categoria' => $nombre_categoria,
            'nivel_habilidad' => $nivel_habilidad,
            'color' => $color,
        );
    }
} else {
    $habilidad_arr[] = array(
        'id_habilidad' => "",
        'nombre_categoria' => "",
        'nivel_habilidad' => "",
        'color' => ""
    );
}

$referencias_stmt = $informacionPersonal->listarReferencias($id_cvadministrativos);
if ($referencias_stmt->rowCount() > 0) {
    $referencias_arr = array();
    while ($row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_referencias);
        $referencias_arr[] = array(
            'id_referencias' => $id_referencias,
            'referencias_nombre' => $referencias_nombre,
            'referencias_profesion' => $referencias_profesion,
            'referencias_empresa' => $referencias_empresa,
            'referencias_telefono' => $referencias_telefono,
        );
    }
} else {
    $referencias_arr[] = array(
        'id_referencias' => "",
        'referencias_nombre' => "",
        'referencias_profesion' => "",
        'referencias_empresa' => "",
        'referencias_telefono' => ""
    );
}

$referencias_stmt = $informacionPersonal->listarReferenciasL($id_cvadministrativos);
if ($referencias_stmt->rowCount() > 0) {
    $referenciasL_arr = array();
    while ($row_referencias = $referencias_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_referencias);
        $referenciasL_arr[] = array(
            'id_referenciasl' => $id_referencias,
            'referencias_nombrel' => $referencias_nombre,
            'referencias_profesionl' => $referencias_profesion,
            'referencias_empresal' => $referencias_empresa,
            'referencias_telefonol' => $referencias_telefono,
        );
    }
} else {
    $referenciasL_arr[] = array(
        'id_referenciasl' => "",
        'referencias_nombrel' => "",
        'referencias_profesionl' => "",
        'referencias_empresal' => "",
        'referencias_telefonol' => ""
    );
}
$documentosO_stmt = $informacionPersonal->listarDocumentosObligatorios($id_cvadministrativos);
if ($documentosO_stmt->rowCount() > 0) {
    $documentosO_arr = array();
    while ($documentosOrow_ = $documentosO_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($documentosOrow_);
        $documentosO_arr[] = array(
            'id_documento' => $id_documentacion,
            'documento_nombre' => $documento_nombre,
            'documento_archivo' => $documento_archivo,
            'tipo_documento' => substr($documento_archivo, -3),
        );
    }
} else {
    $documentosO_arr[] = array(
        'id_documento' => "",
        'documento_nombre' => "",
        'documento_archivo' => "",
        'tipo_documento' => "",
    );
}

$documentosA_stmt = $informacionPersonal->listarDocumentosAdicionales($id_cvadministrativos);
if ($documentosA_stmt->rowCount() > 0) {
    $documentosA_arr = array();
    while ($documentosArow_ = $documentosA_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($documentosArow_);
        $documentosA_arr[] = array(
            'id_documentoA' => $id_documentacion,
            'documento_nombreA' => $documento_nombre,
            'documento_archivoA' => $documento_archivo,
            'tipo_documento' => substr($documento_archivo, -3),
        );
    }
} else {
    $documentosA_arr[] = array(
        'id_documentoA' => "",
        'documento_nombreA' => "",
        'documento_archivoA' => "",
        'tipo_documento' => "",
    );
}
