<?php
require_once "../modelos/HvFunInformacionPersonal.php";
$informacionPersonal = new HvFunInformacionPersonal();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
if (empty($id_usuario)) {
    die("Tu sesión ha caducad, Reinicia la pagina");
}
$cedula = $_SESSION["usuario_identificacion"];
$rspta_usuario = $informacionPersonal->cv_traerIdUsuario($cedula);
// $rspta_usuario = $informacionPersonal->cv_traerIdUsuario($_SESSION["usuario_imagen"]);
$id_cvadministrativos = $rspta_usuario["id_cvadministrativos"];
$porcentaje_actual = $rspta_usuario["porcentaje_avance"];

$departamentos_stmt = $informacionPersonal->get_all_states();
if ($departamentos_stmt->rowCount() > 0) {
    $departamentos_arr = array();
    while ($row_departamentos = $departamentos_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_departamentos);
        $departamentos_arr[] = array(
            'id' => $id_departamento,
            'departamento' => $departamento
        );
    }
}
$info_usuario = array(
    'hv_fun_id_informacion_personal' => '',
    'nombres' => '',
    'fecha_nacimiento' => '',
    'departamento' => '',
    'estado_civil' => '',
    'ciudad' => '',
    'direccion' => '',
    'celular' => '',
    'nacionalidad' => '',
    'pagina_web' => '',
    'nombre_emergencia' => '',
    'parentesco' => '',
    'numero_telefonico_emergencia' => '',
    'titulo_profesional' => '',
    'categoria_profesion' => '',
    'situacion_laboral' => '',
    'resumen_perfil' => '',
    'experiencia_docente' => '',
    'genero' => '',
    'genero_otro' => '',
    'tipo_vivienda' => '',
    'estrato' => '',
    'hijos_menores_10' => '',
    'numero_hijos' => '',
    'personas_a_cargo' => '',
    'nivel_escolaridad' => '',
    'politicamente_expuesta' => '',
    'cvadministrativos_nombre' => '',
    'usuario_apellido' => '',
);

$informacion_personal = $informacionPersonal->getInfoUser($id_cvadministrativos);
if ($informacion_personal->rowCount() > 0) {
    extract($informacion_personal->fetch(PDO::FETCH_ASSOC));
    //traemos las variables de base de datos
    $info_usuario['hv_fun_id_informacion_personal'] = $hv_fun_id_informacion_personal;
    $info_usuario['cvadministrativos_nombre'] = $cvadministrativos_nombre;
    $info_usuario['usuario_apellido'] = $usuario_apellido;
    $info_usuario['fecha_nacimiento'] = $fecha_nacimiento;
    $info_usuario['departamento'] = $departamento;
    $info_usuario['estado_civil'] = $estado_civil;
    $info_usuario['ciudad'] = $ciudad;
    $info_usuario['direccion'] = $direccion;
    $info_usuario['celular'] = $telefono;
    $info_usuario['nacionalidad'] = $nacionalidad;
    $info_usuario['pagina_web'] = $pagina_web;
    $info_usuario['nombre_emergencia'] = $nombre_emergencia;
    $info_usuario['parentesco'] = $parentesco;
    $info_usuario['numero_telefonico_emergencia'] = $numero_telefonico_emergencia;
    $info_usuario['titulo_profesional'] = $titulo_profesional;
    $info_usuario['categoria_profesion'] = $categoria_profesion;
    $info_usuario['situacion_laboral'] = $situacion_laboral;
    $info_usuario['resumen_perfil'] = $perfil_descripcion;
    $info_usuario['experiencia_docente'] = $experiencia_docente;
    $info_usuario['porcentaje_avance'] = $porcentaje_actual;
    $info_usuario['genero'] = $genero;
    $info_usuario['genero_otro'] = $genero_otro;
    $info_usuario['tipo_vivienda'] = $tipo_vivienda;
    $info_usuario['estrato'] = $estrato;
    $info_usuario['hijos_menores_10'] = $hijos_menores_10;
    $info_usuario['numero_hijos'] = $numero_hijos;
    $info_usuario['personas_a_cargo'] = $personas_a_cargo;
    $info_usuario['nivel_escolaridad'] = $nivel_escolaridad;
    $info_usuario['politicamente_expuesta'] = $politicamente_expuesta;
}
$municipios_stmt = $informacionPersonal->cv_get_cities_for_state($info_usuario['departamento']);
if ($municipios_stmt->rowCount() > 0) {
    $municipios_arr = array();
    while ($row_municipios = $municipios_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_municipios);
        $municipios_arr[] = array(
            'id' => $id_municipio,
            'municipio' => $municipio
        );
    }
} else {
    $municipios_arr[] = array(
        'id' => '',
        'municipio' => ''
    );
}
$categoria_prof_stmt = $informacionPersonal->getAllCategories();
if ($categoria_prof_stmt->rowCount() > 0) {
    $categorias_arr = array();
    while ($row_categoria = $categoria_prof_stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row_categoria);
        $categorias_arr[] = array(
            'id' => $id_categoria,
            'categoria' => $categoria
        );
    }
} else {
    $categorias_arr[] = array(
        'id' => '',
        'categoria' => ''
    );
}
