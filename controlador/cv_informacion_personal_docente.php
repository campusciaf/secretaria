<?php
    session_start();
    require_once "../modelos/CvInformacionPersonalDocente.php";
    require_once "../modelos/CvEducacionFormacion.php";
    $informacionPersonalDocente = new CvInformacionPersonalDocente();
    $educacionFormacion = new CvEducacionFormacion();
    //Informacion_personal
    $id_usuario = isset($_SESSION['id_usuario'])?$_SESSION['id_usuario']:"";
    if(empty($id_usuario)){die(json_encode(Array("estatus" => 0,"valor" => "Tu sesión ha caducad, Reinicia la pagina")));}
    $id_usuario_cv = isset($_POST['id_usuario_cv'])?$_POST['id_usuario_cv']:"";
    $nombres = isset($_POST['nombres'])?$_POST['nombres']:"";
    $apellidos = isset($_POST['apellidos'])?$_POST['apellidos']:"";
    $fecha_nacimiento = isset($_POST['fecha_nacimiento'])?$_POST['fecha_nacimiento']:"";
    $fecha_nacimiento = empty($fecha_nacimiento)?NULL:$fecha_nacimiento;
    $departamento = isset($_POST['departamento'])?$_POST['departamento']:"";
    $estado_civil = isset($_POST['estado_civil'])?$_POST['estado_civil']:"";
    $ciudad = isset($_POST['ciudad'])?$_POST['ciudad']:"";
    $direccion = isset($_POST['direccion'])?$_POST['direccion']:"";
    $celular = isset($_POST['celular'])?$_POST['celular']:"";
    $nacionalidad = isset($_POST['nacionalidad'])?$_POST['nacionalidad']:"";
    $pagina_web = isset($_POST['pagina_web'])?$_POST['pagina_web']:"";
    $titulo_profesional = isset($_POST['titulo_profesional'])?$_POST['titulo_profesional']:"";
    $categoria_profesion = isset($_POST['categoria_profesion'])?$_POST['categoria_profesion']:"";
    $situacion_laboral = isset($_POST['situacion_laboral'])?$_POST['situacion_laboral']:"";
    $resumen_perfil = isset($_POST['resumen_perfil'])?$_POST['resumen_perfil']:"";
    $experiencia_docente = isset($_POST['view2'])?$_POST['view2']:"";
    $usuario_imagen = isset($_POST['usuario_imagen'])?$_POST['usuario_imagen']:"";
    //experiencialaboral
    $id_experiencia = isset($_POST['id_experiencia'])?$_POST['id_experiencia']:"";
    $nombre_empresa = isset($_POST['nombre_empresa'])?$_POST['nombre_empresa']:"";
    $cargo_empresa = isset($_POST['cargo_empresa'])?$_POST['cargo_empresa']:"";
    $desde_cuando = isset($_POST['desde_cuando'])?$_POST['desde_cuando']:"";
    $hasta_cuando = isset($_POST['hasta_cuando'])?$_POST['hasta_cuando']:"";
    $mas_detalles = isset($_POST['mas_detalles'])?$_POST['mas_detalles']:"";
    // traemos el id del docente 


    $id_usuario_docente = $educacionFormacion->traeriddocente($_SESSION["id_usuario"]);

    $usuario_identificacion = $id_usuario_docente["usuario_identificacion"];
    // traemos el id del docente en la hoja de vida con la identificacion 
    $rspta_usuario = $educacionFormacion->cv_traerIdUsuario($usuario_identificacion);

    $id_usuario_cv = $rspta_usuario["id_usuario_cv"];
    
    switch($_GET['op']){
        case 'guardaryeditar':

            // print_r($_SESSION);
            /*echo ("'$id_usuario' - id_usuario  \n");
            echo ("'$id_usuario_cv' - id_usuario_cv  \n");
            echo ("'$fecha_nacimiento' - fecha_nacimiento  \n");
            echo ("'$estado_civil' - estado_civil  \n");
            echo ("'$departamento' - departamento  \n");
            echo ("'$ciudad' - ciudad  \n");
            echo ("'$direccion' - direccion  \n");
            echo ("'$celular' - celular  \n");
            echo ("'$nacionalidad' - nacionalidad  \n");
            echo ("'$pagina_web' - pagina_web  \n");
            echo ("'$titulo_profesional' - titulo_profesional  \n");
            // echo ("'$categoria_profesion' - categoria_profesion  \n");
            echo ("'$situacion_laboral' - situacion_laboral  \n");
            echo ("'$resumen_perfil' - resumen_perfil  \n");
            echo ("'$experiencia_docente' - experiencia_docente  \n");*/
            if(empty($id_usuario_cv)){

                // echo $id_usuario_cv;

                $rspta = $informacionPersonalDocente->cv_insertar($id_usuario_cv, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion,  $situacion_laboral, $resumen_perfil, $experiencia_docente);
                if($rspta){
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Información Insertada con éxito "
                    );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo Insertada con éxito $id_usuario_cv - $id_usuario_cv"
                    );
                    echo json_encode($inserto);
                }
            }else{
                $rspta=$informacionPersonalDocente->cv_editar($id_usuario_cv, $fecha_nacimiento, $estado_civil, $departamento, $ciudad, $direccion, $celular, $nacionalidad, $pagina_web, $titulo_profesional, $categoria_profesion,  $situacion_laboral, $resumen_perfil, $experiencia_docente,$id_usuario_cv);
                if($rspta){
                    $rspta2 = $informacionPersonalDocente->editarUser($nombres,$apellidos,$id_usuario_cv);
                    if($rspta2){
                        $_SESSION['usuario_nombre']=$nombres;
                        $_SESSION['usuario_apellido']=$apellidos;
                        $inserto = Array(
                            "estatus" => 1,
                            "valor" => "Información Actualizada "
                        );
                    }
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo actualizar"
                    );
                    echo json_encode($inserto);
                }
            }		
		break;
        case 'guardaryeditarImagen':
            $file_type = $_FILES['foto']['type'];
            $allowed = array("image/jpeg", "image/jpg", "image/gif", "image/png");
            if(!in_array($file_type, $allowed)) {
                $inserto = Array(
                    "estatus" => 0,
                    "valor" => "Formato de imagen no reconocido"
                );
                echo json_encode($inserto);
                exit();
            }
            $target_path = '../files/usuarios/';
            $img1path = $target_path."".$_SESSION['usuario_identificacion'].".jpg";
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $img1path)){
                $usuario_imagen = $_SESSION['usuario_identificacion'].".jpg";
                $rspta = $informacionPersonalDocente->editarImagen($id_usuario_cv, $usuario_imagen);
                if($rspta){
                    $_SESSION['usuario_imagen_cv'] = $_SESSION['usuario_identificacion'].".jpg"; 
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Información Guardada",
                        "imagen" => $usuario_imagen
                    );
                }
                echo json_encode($inserto);
            }
		break;
        //experiencia_laboral
        case 'guardaryeditarexperiencialaboral':
            if(empty($id_experiencia)){
                $rspta = $informacionPersonalDocente->cv_insertarExperiencia($id_usuario_cv,$nombre_empresa,$cargo_empresa,$desde_cuando, $hasta_cuando, $mas_detalles);
                if($rspta){
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Información Guardada"
                    );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo guardar"
                    );
                    echo json_encode($inserto);
                }
            }else{
                $rspta=$informacionPersonalDocente->cveditarExperiencia($id_usuario_cv,$nombre_empresa,$cargo_empresa,$desde_cuando, $hasta_cuando, $mas_detalles,$id_experiencia);
                if($rspta){
                        $inserto = Array(
                            "estatus" => 1,
                            "valor" => "Información Guardada"
                        );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo guardar"
                    );
                    echo json_encode($inserto);
                }
            }		
		break;
        case 'mostrarexperiencias':
            
            $experiencias_stmt = $informacionPersonalDocente->cv_listarExperiencias($id_usuario_cv);
            if($experiencias_stmt->rowCount()>0){
                $experiencias_arr = array();
                while($row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row_experiencias);
                    $experiencias_arr[] = array(
                        'id_usuario_cv'=>$id_usuario_cv,
                        'nombre_empresa'=>$nombre_empresa,
                        'cargo_empresa'=>$cargo_empresa,
                        'desde_cuando'=>$desde_cuando, 
                        'hasta_cuando'=>$hasta_cuando, 
                        'mas_detalles'=>$mas_detalles,
                        'id_experiencia'=>$id_experiencia);
                }
            }else{
                $experiencias_arr[] = array(
                    'id_usuario_cv'=>"0",
                    'nombre_empresa'=>"",
                    'cargo_empresa'=>"",
                    'desde_cuando'=>"", 
                    'hasta_cuando'=>"", 
                    'mas_detalles'=>"",
                    'id_experiencia'=>"");
            }
            echo(json_encode($experiencias_arr));

            //print_r($experiencias_stmt);
		break;
        case 'eliminarExperiencia':
            $rspta=$informacionPersonalDocente->cv_eliminarExperiencia($id_experiencia);
                if($rspta){
                        $inserto = Array(
                            "estatus" => 1,
                            "valor" => "Información Elimanada"
                        );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo eliminar"
                    );
                    echo json_encode($inserto);
                }
		break;
        case 'verExperienciaEspecifica':
            $experiencias_stmt = $informacionPersonalDocente->cv_listarExperienciaEspecifica($id_experiencia);
            if($experiencias_stmt->rowCount()>0){
                $experiencias_arr = array();
                    $row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row_experiencias);
                    $experiencias_arr[] = array(
                        'id_usuario_cv'=>$id_usuario_cv,
                        'nombre_empresa'=>$nombre_empresa,
                        'cargo_empresa'=>$cargo_empresa,
                        'desde_cuando'=>$desde_cuando, 
                        'hasta_cuando'=>$hasta_cuando, 
                        'mas_detalles'=>$mas_detalles,
                        'id_experiencia'=>$id_experiencia);
            }else{
                $experiencias_arr[] = array(
                    'id_usuario_cv'=>"0",
                    'nombre_empresa'=>"",
                    'cargo_empresa'=>"",
                    'desde_cuando'=>"", 
                    'hasta_cuando'=>"", 
                    'mas_detalles'=>"",
                    'id_experiencia'=>"");
            }
            echo(json_encode($experiencias_arr));
		break;
        //experiencia_laboral
        case 'guardaryeditarEducacion':
            if(empty($id_experiencia)){
                $rspta = $informacionPersonalDocente->cv1_insertarEducacion($id_usuario_cv,$nombre_empresa,$cargo_empresa,$desde_cuando, $hasta_cuando, $mas_detalles, "$imagen");
                print_r($rspta);
                if($rspta){
                    $inserto = Array(
                        "estatus" => 1,
                        "valor" => "Información Guardada"
                    );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo guardar"
                    );
                    echo json_encode($inserto);
                }
            }else{
                $rspta=$EducacionFormacion->editareducacion($id_usuario_cv,$nombre_empresa,$cargo_empresa,$desde_cuando, $hasta_cuando, $mas_detalles,$id_educacion);
                if($rspta){
                        $inserto = Array(
                            "estatus" => 1,
                            "valor" => "Información Guardada"
                        );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo guardar"
                    );
                    echo json_encode($inserto);
                }
            }		
		break;
        case 'mostrarEducacion':
            $educacions_stmt = $educacionFormacion->cv_listareducacion($_SESSION["usuario_identificacion"]);
            if($educacions_stmt->rowCount()>0){
                $educacions_arr = array();
                while($row_educacions = $educacions_stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row_educacions);
                    $educacions_arr[] = array(
                        'id_usuario'=>$id_usuario,
                        'nombre_empresa'=>$nombre_empresa,
                        'cargo_empresa'=>$cargo_empresa,
                        'desde_cuando'=>$desde_cuando, 
                        'hasta_cuando'=>$hasta_cuando, 
                        'mas_detalles'=>$mas_detalles,
                        'id_educacion'=>$id_educacion);
                }
            }else{
                $educacions_arr[] = array(
                    'id_usuario'=>"0",
                    'nombre_empresa'=>"",
                    'cargo_empresa'=>"",
                    'desde_cuando'=>"", 
                    'hasta_cuando'=>"", 
                    'mas_detalles'=>"",
                    'id_experiencia'=>"");
            }
            echo(json_encode($experiencias_arr));
		break;
        case 'eliminarExperiencia':
            $rspta=$informacionPersonalDocente->cv_eliminarExperiencia($id_experiencia);
                if($rspta){
                        $inserto = Array(
                            "estatus" => 1,
                            "valor" => "Información Elimanada"
                        );
                    echo json_encode($inserto);
                }else{
                    $inserto = Array(
                        "estatus" => 0,
                        "valor" => "La información no se pudo eliminar"
                    );
                    echo json_encode($inserto);
                }
		break;
        case 'verExperienciaEspecifica':
            $experiencias_stmt = $informacionPersonalDocente->cv_listarExperienciaEspecifica($id_experiencia);
            if($experiencias_stmt->rowCount()>0){
                $experiencias_arr = array();
                    $row_experiencias = $experiencias_stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row_experiencias);
                    $experiencias_arr[] = array(
                        'id_usuario'=>$id_usuario,
                        'nombre_empresa'=>$nombre_empresa,
                        'cargo_empresa'=>$cargo_empresa,
                        'desde_cuando'=>$desde_cuando, 
                        'hasta_cuando'=>$hasta_cuando, 
                        'mas_detalles'=>$mas_detalles,
                        'id_experiencia'=>$id_experiencia);
            }else{
                $experiencias_arr[] = array(
                    'id_usuario'=>"0",
                    'nombre_empresa'=>"",
                    'cargo_empresa'=>"",
                    'desde_cuando'=>"", 
                    'hasta_cuando'=>"", 
                    'mas_detalles'=>"",
                    'id_experiencia'=>"");
            }
            echo(json_encode($experiencias_arr));
		break;

        case "selectDepartamento":
            $rspta = $usuario->selectDepartamento();
            for ($i = 0; $i < count($rspta); $i++) {
                echo "<option value='" . $rspta[$i]["id_departamento"] . "'>" . $rspta[$i]["departamento"] . "</option>";
            }
        break;
        case "selectMunicipio":
            $rspta = $usuario->selectMunicipio();
            for ($i = 0; $i < count($rspta); $i++) {
                echo "<option value='" . $rspta[$i]["id_municipio"] . "'>" . $rspta[$i]["municipio"] . "</option>";
            }
        break;
	}
?>