<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=41;
require 'header.php';


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
                    <h1 class="m-0"><small id="nombre_programa"></small>Plataformas <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-plus-circle"></i> Agregar plataforma
                    </button>
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Gestión plataformas</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    <!-- /.container-fluid -->
    </div>
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-primary" style="padding: 2%">
                    <div class="col-12 panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover ">
                            <thead>
                                <th>Opciones</th>
                                <th>Plataforma</th>
                                <th>Link plataforma</th>
                                <th>Usuario</th>
                                <th>Clave</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

    <div class="modal fade" id="ModalEditarPlataforma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Salón </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="formularioeditarplataforma" id="formularioeditarplataforma" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label class="control-label">Plataforma</label>
                                <input type="text" class="form-control" name="clave_plataforma_m" placeholder="Nombre plataforma"  id="clave_plataforma_m" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">URL Plataforma</label>
                                <input type="text" class="form-control" name="clave_url_m" placeholder="Link Plataforma" id="clave_url_m" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">Usuario</label>
                                <input type="text" class="form-control" name="clave_usuario_m" placeholder="Clave Plataforma" id="clave_usuario_m" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">Clave Acceso</label>
                                <input type="text" class="form-control" name="clave_contrasena_m" placeholder="Clave de acceso" id="clave_contrasena_m" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">Descripción</label>
                                <textarea class="form-control" name="clave_descripcion_m" placeholder="Descripción" id="clave_descripcion_m"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                            <input type="text" class="d-none" id="id_clave" name="id_clave">
                            <button type="submit" class="btn btn-primary mt-4"> <i class="fa fa-save"></i> Guardar </button>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
        </div>
    </div>

    <!-- Modal agregarSalon-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Plataforma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="guardarDatos" id="form2" method="POST">
                        <div class="row">
                            <div class="form-group col-xl-12">
                                <label class="control-label">Plataforma</label>
                                <input type="text" class="form-control" name="clave_plataforma" placeholder="Nombre plataforma"  id="clave_plataforma" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">URL Plataforma</label>
                                <input type="text" class="form-control" name="clave_url" placeholder="Link Plataforma" id="clave_url" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">Usuario</label>
                                <input type="text" class="form-control" name="clave_usuario" placeholder="Clave Plataforma" id="clave_usuario" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">Clave Acceso</label>
                                <input type="text" class="form-control" name="clave_contrasena" placeholder="Clave de acceso" id="clave_contrasena" required>
                            </div>
                            <div class="form-group col-xl-12">
                                <label class=" control-label">Descripción</label>
                                <textarea class="form-control" name="clave_descripcion" placeholder="Descripción" id="clave_descripcion"></textarea>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success guardarDatos"><i class="fas fa-plus-circle"></i> Agregar plataforma </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


                  

<?php
require 'footer.php';
?>

<script type="text/javascript" src="scripts/claves.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>

