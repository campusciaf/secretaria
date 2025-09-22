<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
    $menu = 27;
    require 'header.php';
    if($_SESSION['guiavercaso']==1){
        $caso_id = isset($_GET["caso"])?$_GET["caso"]:"2";
?>
<link rel="stylesheet" href="../public/css/bootstrap-datetimepicker.min.css">
<div id="precarga" class="precarga" style="display: none;"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ver Caso</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Ver Caso</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary" style="padding: 1% 1%">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-pills ml-auto pb-2">
                                        <input type="hidden" id="caso_id" value="<?php echo $caso_id?>">
                                        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Caso #<?php echo $caso_id?></a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Docente</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="tab-content-header cabecera_seguimientos row"></div>
                                        <div class="col-12">
                                            <div class="timeline">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane card" id="tab_2">
                                        <div class="card-header border-1">
                                            <h3 class="card-title">Datos Docente</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body box-profile-mat" aria-expanded="true" id="buscar_docente">
                                            <div class="row box-profile">
                                                <div class="col-md-4 text-center">
                                                    <img class="profile-user-img img-responsive img-circle img_docente" style="height: 100px;" src="../files/null.jpg" alt="User profile picture">
                                                    <h3 class="usuario_nombre box-profiledates text-center">Nombre del Docente</h3>
                                                    <p class="text-muted usuario_apellido box-profiledates text-center"> ---------------- </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <ul class="list-group list-group-unbordered" style="padding-right: 8px;padding-left: 8px; background: white; color: black">
                                                        <li class="list-group-item">
                                                            <b class="usuario_tipo_documento"> --------------- </b> <a class="pull-right box-profiledates usuario_identificacion"> ---------------- </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Dirección:</b> <a class="pull-right box-profiledates usuario_direccion"> ---------------- </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Cel:</b> <a class="pull-right box-profiledates usuario_celular"> ---------------- </a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Email:</b><a class="box-profiledates pull-right usuario_email_ciaf "> -------------- </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <div class="box-primary acordion-matricula">
                                                        <div class="box-header with-border collapsed" href="#" >
                                                            <h3 class="box-title col-lg-12 col-md-12 col-sm-12" >
                                                            Programas
                                                            </h3>
                                                        </div>
                                                        <div id="matriculaccordion">
                                                            <div class="box-body" style="background: white">
                                                                <ul class="list-group list-group-bordered lista_programas">
                                                                    <li class="list-group-item">
                                                                    <b>Programa:</b> <br> <a class=" box-profiledates profile-programa">----------------</a>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                    <b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">----------------</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal seguimiento-->
<div class="modal fade" id="modal_seguimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Seguimiento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_seguimiento">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Descripción</label>
                        <textarea class="form-control" rows="3" placeholder="Contenido del Seguimiento" name="descripcion" required></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $caso_id?>">
                    <div class="form-group">
                        <label>Encuentro</label>
                        <select class="form-control" name="encuentro" required>
                            <option value="" selected disabled>-Encuentro-</option>
                            <option value="Llamada">Llamada</option>
                            <option value="Reunión">Reunión</option>
                            <option value="Visita">Visita</option>
                            <option value="Correo">Correo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Docentes</label>
                        <select class="form-control select_docente" name="docente" data-live-search="true" data-style="border"></select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Recomendación</label>
                        <textarea type="text" class="form-control" row=3 name="recomendacion" id="exampleInputPassword1"></textarea>
                        <small id="emailHelp" class="form-text text-muted">Si no, deje el campo vacío.</small>
                    </div>
                    <div class="form-group">
                        <label>Evidencia</label>
                        <input type="file" class="form-control-file" name="evidencia">
                        <small id="emailHelp" class="form-text text-muted">Solo imagenes o PDF, No incluir tildes ni ñ en los nombres de los archivos porque se perderán</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-enviar btn-block">Agregar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal tarea-->
<div class="modal fade" id="modal_tarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_tarea">
                    <div class="form-group">
                        <label>Asunto corto</label>
                        <input type="text" class="form-control" name="asunto" placeholder="Asunto" required>
                        <small id="emailHelp" class="form-text text-muted">Max. 80 caracteres</small>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $caso_id?>">
                    <div class="form-group">
                        <label>Fecha y hora</label>
                        <input type="text" name="fecha" class="form-control datepicker" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción (opcional)</label>
                        <textarea class="form-control" rows="3" placeholder="descripción" name="descripcion"></textarea>
                        <small id="emailHelp" name="descripcion" class="form-text text-muted">Opcional.</small>
                    </div>
                    <div class="form-group">
                        <label>Guardar referencia para</label>
                        <select class="form-control" name="referencia" required>
                            <option value="" selected disabled>-Referencia-</option>
                            <option value="Caso">Caso</option>
                            <option value="Docente">Docente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Docente</label>
                        <select class="form-control select_docente" name="docente" data-style="border" data-live-search="true"></select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-enviar btn-block">Agregar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal remitir-->
<div class="modal fade" id="modal_remitir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Remitir a dependencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_guia_remision">
                    <div class="form-group">
                        <label>Observación</label>
                        <input type="hidden" name="caso_id" value="<?php echo $caso_id?>">
                        <textarea class="form-control" rows="3" placeholder="observacion" name="observacion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Dependencia</label>
                        <select class="form-control select_dependencia" name="dependencia" data-style="border" data-live-search="true" required></select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-enviar btn-block">Agregar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal cerrar-->
<div class="modal fade" id="modal_cerrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cerrar caso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_guia_cerrar" method="post">
                    <h4 class="text-danger" >
                        <B>¿Quieres cerrar este caso definitivamente?</B> <br>
                        Al confirmar aceptas que se dió por terminado este proceso. Ya nadie podra agregar seguimientos o participar de este
                        caso.
                    </h4>
                    <div class="form-group">
                        <label>Observación</label>
                        <input type="hidden" name="caso_id" value="<?php echo $caso_id?>">
                        <textarea class="form-control" rows="3" placeholder="observacion" name="observacion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Evidencia</label>
                        <input type="file" name="evidencia" class="form-control-file" required>
                    </div>
                    <div class="form-group">
                        <label>¿Que se logro?</label>
                        <input type="text" class="form-control" placeholder="Que se logro" name="logro"/>
                    </div>

                    <div class="form-group">
                        <label>Categoria caso cerrado</label>
                        <select class="form-control mb-3" id="categoria_cerrar" name="categoria_cerrar" required></select>
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                        <label class="form-check-label text-danger" for="exampleCheck1">Me hago responsable al cerrar el caso por el motivo que se encuentra arriba descrito.</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-enviar btn-block">Cerrar el caso </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php
	}else{
	    require 'noacceso.php';
	}
    require 'footer.php';
}
    ob_end_flush();
?>
<script src="../public/js/bootstrap-datetimepicker.min.js"></script>
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<script src="scripts/guiavercaso.js"></script>