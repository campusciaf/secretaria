<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 1;
    $submenu = 1;
    require 'header.php';
    if ($_SESSION['usuario'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Usuarios</span><br>
                                <span class="fs-16 f-montserrat-regular">Gestione los usuarios y sus permisos</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Gestión usuario</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row">
                            <div class="col-12 card">
                                <div class="row">
                                    <div class="col-6 p-2 tono-3">
                                        <div class="row align-items-center">
                                            <div class="pl-3">
                                                <span class="rounded bg-light-blue p-3 text-primary ">
                                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="col-10">
                                                <div class="col-5 fs-14 line-height-18">
                                                    <span class="">Usuarios plataforma</span> <br>
                                                    <span class="text-semibold fs-20">Campus virtual</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-6 tono-3 text-right py-4 pr-4">
                                        <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar usuario</button>
                                    </div>
                                    <div class="col-12 table-responsive p-2" id="listadoregistros">
                                        <table id="tbllistado" class="table" style="width: 100%;">
                                            <thead>
                                                <th>Opciones</th>
                                                <th>Foto</th>
                                                <th>Nombre</th>
                                                <th>Documento</th>
                                                <th>Correo CIAF</th>
                                                <th>Cargo</th>
                                                <th>Celular</th>
                                                <th>Estado</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12 panel-body" id="formularioregistros">
                                        <form name="formulario" id="formulario" method="POST">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="title">Datos Personales</h6>
                                                </div>
                                                <input type="hidden" name="id_usuario" id="id_usuario">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_nombre" id="usuario_nombre" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Primer Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="usuario_nombre_2" id="usuario_nombre_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Segundo Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_apellido" id="usuario_apellido" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Primer Apellido</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0" name="usuario_apellido_2" id="usuario_apellido_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Segundo Apellido</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_tipo_documento" id="usuario_tipo_documento"></select>
                                                            <label>Tipo Documento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" required class="form-control border-start-0" name="usuario_identificacion" id="usuario_identificacion" maxlength="20" required>
                                                            <label>Número Identificación</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="date" placeholder="" value="" required class="form-control border-start-0" name="usuario_fecha_nacimiento" id="usuario_fecha_nacimiento" required>
                                                            <label>Fecha de Nacimiento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_tipo_sangre" id="usuario_tipo_sangre"></select>
                                                            <label>Tipo de Sangre</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="title">Datos de Contacto</h6>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_departamento_nacimiento" id="usuario_departamento_nacimiento" onChange="mostrarmunicipio(this.value)"></select>
                                                            <label>Departamento Nacimiento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_municipio_nacimiento" id="usuario_municipio_nacimiento"></select>
                                                            <label>Municipio Nacimiento</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-6 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" required class="form-control border-start-0 usuario_direccion" name="usuario_direccion" id="usuario_direccion" maxlength="70" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                            <label>Dirección de Residencia</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_telefono" name="usuario_telefono" id="usuario_telefono" maxlength="20">
                                                            <label>Teléfono Fijo</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="text" placeholder="" value="" required class="form-control border-start-0 usuario_celular" name="usuario_celular" id="usuario_celular" maxlength="20" required>
                                                            <label>Número Celular</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="email" placeholder="" value="" required class="form-control border-start-0 usuario_email" name="usuario_email" id="usuario_email" maxlength="50" required>
                                                            <label>Correo Personal</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="title">Datos CIAF</h6>
                                                </div>
                                                <div class="col-xl-4 col-lg-3 col-md-3 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <input type="email" placeholder="" value="" required class="form-control border-start-0" name="usuario_login" id="usuario_login" maxlength="50" required>
                                                            <label>Correo CIAF</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-5 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_cargo" id="usuario_cargo"></select>
                                                            <label>Cargo CIAF</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="usuario_poa" id="usuario_poa"></select>
                                                            <label>Tiene POA</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0" data-live-search="true" name="pagina_web" id="pagina_web">
                                                                <option value="" selected disabled>Selecciona una opción</option>
                                                                <option value="1">No</option>
                                                                <option value="0">Si</option>
                                                            </select>
                                                            <label>Página Web</label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="form-floating">
                                                            <select value="" required class="form-control border-start-0" data-live-search="true" name="al_lado" id="al_lado">
                                                                <option value="" selected disabled>Selecciona una opción</option>
                                                                <option value="a">A</option>
                                                                <option value="b">B</option>
                                                            </select>
                                                            <label>Usuario Lado </label>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter valid input</div>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="title">Fotografia</h6>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                    <label>Imagen:</label>
                                                    <input type="file" class="form-control" name="usuario_imagen" id="usuario_imagen">
                                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                                    <img src="" width="150px" height="120px" id="imagenmuestra">
                                                </div>
                                                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-12">
                                                        <h6 class="title">Permisos</h6>
                                                    </div>
                                                    <ul style="list-style: none;" id="permisos">
                                                    </ul>
                                                </div>
                                                <div class="col-xl-10 text-right p-2" style="z-index: 1; position:fixed; bottom:0px;">
                                                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Atras</button>
                                                    <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <style>
            td{
                vertical-align: middle !important;
                text-align: center !important;
            }
        </style>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/usuario.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>