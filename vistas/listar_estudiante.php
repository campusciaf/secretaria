<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 1;
    $submenu = 14;
    require 'header.php';
    if ($_SESSION['listarestudiante'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <!--Contenido-->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Seres Originales</span><br>
                                <span class="fs-16 f-montserrat-regular">Da un vistazo a la información de nuestros seres originales</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Seres Originales</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 p-4 tono-3">
                                    <div class="row align-items-center">
                                        <div class="pl-4">
                                            <span class="rounded bg-light-blue p-3 text-primary ">
                                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="col-10">
                                            <div class="col-5 fs-14 line-height-18">
                                                <span class="">Seres</span> <br>
                                                <span class="text-semibold fs-20">Originales</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 py-4 pr-4 text-right tono-3">
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card card-primary" style="padding: 2%">
                                            <div>
                                                <?php
                                                $botones = array("Identificación", "Apellidos", "Nombre", "Correo Institucional", "Correo Personal", "Celular", "Dirección", "Foto", "Estado", "Género", "Fecha Nacimiento", "Departamento Nacimiento", "Lugar Nacimiento", "Estado Civil", "Municipio", "Departamento Residencia", "Tipo Documento", "Expedido En", "Fecha Expedición", "ID Municipio Nacimiento", "Grupo Étnico", "Nombre Étnico", "Desplazado", "Conflicto", "Departamento", "Tipo Residencia", "Zona Residencia", "Dirección", "Latitud", "Longitud", "Código Postal", "Estrato", "WhatsApp", "Instagram", "Facebook", "Twitter", "Tipo Sangre");
                                                for ($i = 0; $i < count($botones); $i++) {
                                                ?>
                                                    <a data-column="<?= $i ?>" onclick="activarBotonDt(this)" class="toggle-vis btn btn-info btn-flat btn-xs mt-2 mx-1 <?= ($i >= 9)?"btn-danger":"" ?>">
                                                        <i class="text-white"> <?= $botones[$i] ?></i>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </div><br>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" id="table_datos" style="padding-top: 10px;">
                                                <table class="table table-striped compact table-sm" id="dtl_estudiantes">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Identificación</th>
                                                            <th scope="col">Apellidos</th>
                                                            <th scope="col">Nombres</th>
                                                            <th scope="col">Correo institucional</th>
                                                            <th scope="col">Correo personal</th>
                                                            <th scope="col">Celular</th>
                                                            <th scope="col">Dirección</th>
                                                            <th scope="col">Foto</th>
                                                            <th scope="col">Estado</th>
                                                            <th scope="col">Genero</th>
                                                            <th scope="col">Fecha Nacimiento</th>
                                                            <th scope="col">Departamento Nacimiento</th>
                                                            <th scope="col">Lugar Nacimiento</th>
                                                            <th scope="col">Estado Civil</th>
                                                            <th scope="col">Municipio</th>
                                                            <th scope="col">Departamento Residencia</th>
                                                            <th scope="col">Tipo Documento</th>
                                                            <th scope="col">Expedido En</th>
                                                            <th scope="col">Fecha Expedición</th>
                                                            <th scope="col">Id Municipio Nacimiento</th>
                                                            <th scope="col">Grupo Etnico</th>
                                                            <th scope="col">Nombre Etnico</th>
                                                            <th scope="col">Desplazado Violencia</th>
                                                            <th scope="col">Conflicto Armado</th>
                                                            <th scope="col">Departamento Residencia</th>
                                                            <th scope="col">Tipo Residencia</th>
                                                            <th scope="col">Zona Residencia</th>
                                                            <th scope="col">Direccion</th>
                                                            <th scope="col">Latitud</th>
                                                            <th scope="col">Longitud</th>
                                                            <th scope="col">Cod Postal</th>
                                                            <th scope="col">Estrato</th>
                                                            <th scope="col">Whatsapp</th>
                                                            <th scope="col">Instagram</th>
                                                            <th scope="col">Facebook</th>
                                                            <th scope="col">Twiter</th>
                                                            <th scope="col">Tipo Sangre</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="forDatos" style="padding-top: 10px;">
                                                <h2 class="text-center">Formulario editar estudiante</h2>
                                                <form class="guardarDatos" id="form2" method="POST">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Tipo de documento</label>
                                                            <select class="form-control" name="tipo_docu" id="tipo">
                                                                <option selected>Tipo de documento</option>
                                                                <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                                                                <option value="Pasaporte">Pasaporte</option>
                                                                <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                                                <option value="ppt">Pasporte protección temporal</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Identificación</label>
                                                            <input type="text" class="form-control" name="identificacion" id="identi" disabled>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Lugar de expedición</label>
                                                            <input type="text" class="form-control" name="lugar_expe" id="lu_expe">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Fecha de expedición</label>
                                                            <input type="date" class="form-control" name="fecha_expe" id="fe_expe">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Primer nombre</label>
                                                            <input type="text" class="form-control" name="nombre_1" id="nombre_1">
                                                            <input type="hidden" class="form-control" name="id" id="credencial">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Segundo nombre</label>
                                                            <input type="text" class="form-control" name="nombre_2" id="nombre_2">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Primer apellido</label>
                                                            <input type="text" class="form-control" name="apellido_1" id="apellido_1">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Segundo apellido</label>
                                                            <input type="text" class="form-control" name="apellido_2" id="apellido_2">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Fecha de nacimiento</label>
                                                            <input type="date" class="form-control" name="fe_naci" id="fe_na">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Departamento nacimiento</label>
                                                            <input type="text" class="form-control" name="de_na" id="de_na">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Municipio nacimiento</label>
                                                            <input type="text" class="form-control" name="mu_na" id="mu_na">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Correo CIAF</label>
                                                            <input type="email" class="form-control" name="co_ciaf" id="correo">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Correo personal</label>
                                                            <input type="email" class="form-control" name="co_per" id="correo_p">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Celular</label>
                                                            <input type="number" class="form-control" name="cel" id="celular">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Teléfono</label>
                                                            <input type="number" class="form-control" name="tele" id="telefo">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Municipio</label>
                                                            <input type="text" class="form-control" name="muni" id="municipio">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Dirección</label>
                                                            <input type="text" class="form-control" name="dire" id="direccion">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Barrio</label>
                                                            <input type="text" class="form-control" name="barrio" id="barri">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Tipo de residencia</label>
                                                            <input type="text" class="form-control" name="tipo_resi" id="tipo_resi">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Zona de residencia</label>
                                                            <input type="text" class="form-control" name="zo_re" id="zo_re">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Whatsapp</label>
                                                            <input type="number" class="form-control" name="what" id="wha">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Instagram</label>
                                                            <input type="text" class="form-control" name="ins" id="ins">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Facebook</label>
                                                            <input type="text" class="form-control" name="face" id="faceb">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                                            <label for="exampleInputEmail1">Twitter</label>
                                                            <input type="text" class="form-control" name="twi" id="twi">
                                                        </div>
                                                    </div>
                                                    <br> <br>
                                                    <div class="col">
                                                        <button type="button" class="btn btn-danger" onclick="cancelar()">Cancelar</button>
                                                        <button type="submit" class="btn btn-success guardarDatos">Guardar datos</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal fade" id="ModalEliminarFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Eliminar Imagen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center" id="imagenmuestra"></div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <input type="number" class="d-none id_programas" id="id_programas" name="id_programas">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
        ?>
        <script type="text/javascript" src="scripts/listar_estudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
    <?php
}
ob_end_flush();
    ?>