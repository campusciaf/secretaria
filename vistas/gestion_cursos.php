<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.php");
} else {
    $menu = 32;
    $submenu = 321;
    require 'header.php';
    if ($_SESSION['gestioncursos'] == 1) {
?>


    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Gestión cursos</span><br>
                        <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Educación continuada</li>
                        </ol>
                </div>
            </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row card card-primary" style="padding: 2% 1%">

                    <div id="listadoregistros" class="col-12">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button class="btn btn-success btn-xs" onclick="mostrar_form(true)"> <i class="fas fa-plus"></i> Agregar un nuevo curso</button>
                            </div>
                            <table id="tbllistado" class="table table-compact table-sm table-responsive">
                                <thead>
                                    <th></th>
                                    <th> Curso</th>
                                    <th> Sede</th>
                                    <th> Modalidad</th>
                                    <th> Docente(s)</th>
                                    <th> Inicio</th>
                                    <th> Fin</th>
                                    <th> Horario</th>
                                    <th> Precio</th>
                                    <th> Estado</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="div_formulario" class="col-12">
                        <form method="post" class="row" name="formulario_cursos" id="formulario_cursos">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="sede_curso"> Sede:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-laptop-code"></i></span>
                                    </div>
                                    <select name="sede_curso" id="sede_curso" class="form-control border border-success rounded-0" required>
                                        <option value="" selected disabled>- Selecciona la sede -</option>
                                        <option value="CIAF"> CIAF - Cra. 6 #24-56 </option>
                                        <option value="CRAI"> CRAI - Calle 20 #4-57 </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="nombre_curso"> Nombre del curso:</label>
                                <div class="input-group mb-3  ">
                                    <div class="input-group-prepend rounded-0">
                                        <span class="input-group-text rounded-0 border-success bg-white"> <i class="fab fa-cuttlefish"></i> </span>
                                    </div>
                                    <input type="hidden" name="id_curso" id="id_curso">
                                    <input type="text" name="nombre_curso" id="nombre_curso" class="form-control border border-success rounded-0" required placeholder="Nombre del curso">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="docente_curso"> Nombre del docente:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-user-graduate"></i></span>
                                    </div>
                                    <select name="docente_curso" id="docente_curso" class="form-control border border-success rounded-0 listado_docentes" required data-live-search="true">

                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="modalidad_curso"> Modalidad:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-laptop-code"></i></span>
                                    </div>
                                    <select name="modalidad_curso" id="modalidad_curso" class="form-control border border-success rounded-0" required>
                                        <option value="" selected disabled>- Selecciona la modalidad -</option>
                                        <option value="Presencial"> Presencial </option>
                                        <option value="Virtual"> Virtual </option>
                                        <option value="Semi-presencial"> Semi-presencial </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                <label for="fecha_inicio"> Fecha de inicio:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-calendar-check"></i></span>
                                    </div>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control border border-success rounded-0" required placeholder="- Selecciona la fecha -">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                <label for="fecha_fin"> Fecha de fin:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-calendar-times"></i></span>
                                    </div>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control border border-success rounded-0" required placeholder="- Selecciona la fecha -">
                                </div>
                            </div>
                            <!-- <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="estado_curso"> Estado:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <select name="estado_curso" id="estado_curso" class="form-control border border-success rounded-0" required>
                                        <option value="" selected disabled>- Selecciona El Estado -</option>
                                        <option value="Proximamente"> Proximamente </option>
                                        <option value="Abierto"> Abierto </option>
                                        <option value="Cerrado"> Cerrado </option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="categoria"> Categoria:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <select name="categoria" id="categoria" class="form-control border border-success rounded-0" required>
                                        <option value="" selected disabled>- Selecciona la categoria -</option>
                                        <option value="seminario"> seminario </option>
                                        <option value="diplomado"> diplomado </option>
                                        <option value="curso"> curso </option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="nivel_educacion"> Nivel: </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <select name="nivel_educacion" id="nivel_educacion" class="form-control border border-success rounded-0" required>
                                        <option value="" selected disabled>- Selecciona el nivel -</option>
                                        <option value="basico"> basico </option>
                                        <option value="intermedio"> intermedio </option>
                                        <option value="superior"> superior </option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label for="horario_curso"> Horario: <small>Campo libre: puedes elegir tu propia distribución</small></label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-success bg-white"><i class="fas fa-hourglass"></i></span>
                                    </div>
                                    <input type="text" name="horario_curso" id="horario_curso" class="form-control border border-success rounded-0" required placeholder="Ejemplo: Todos los dias de 6 p.m. a 10p.m.">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                <label for="precio_curso"> Precio del curso:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-success rounded-0 "><i class="fas fa-text-height"></i></span>
                                    </div>
                                    <input type="number" class="form-control border-success rounded-0" name="precio_curso" id="precio_curso" placeholder="Precio del Curso" required></input>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                <label for="duracion_educacion"> Duración en horas:</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-success rounded-0 "><i class="fas fa-text-height"></i></span>
                                    </div>
                                    <input type="number" class="form-control border-success rounded-0" name="duracion_educacion" id="duracion_educacion" placeholder="Duración del Curso (HORAS)" required></input>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                <label for="descripcion_curso"> Descripción del curso:</label>

                                <textarea rows="3" name="descripcion_curso" id="descripcion_curso" placeholder="Descripción del Curso" required style="width: 100%; padding: 8px; border: 1px solid #000; border-radius: 4px;"></textarea>

                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-12">
                                <label> Imagen: </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="imagen_curso" id="imagen_curso">
                                        <label class="custom-file-label bg-white border-success rounded-0" for="imagen_curso">Selecciona archivo</label>
                                        <input type="hidden" name="imagenactual" id="imagenactual">
                                    </div>
                                </div>
                                <img src="" width="150px" height="120px" id="imagenmuestra">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn bg-success guardar_curso rounded-0 text-white"> Guardar </button>
                                <button type="button" class="btn btn-danger rounded-0 text-white" onclick="mostrar_form(false)"> Cancelar </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/gestion_cursos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
