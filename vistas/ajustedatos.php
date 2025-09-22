<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 1;
    $submenu = 113;
    require 'header.php';
    if ($_SESSION['ajustedatos'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Ajustar metricas</span><br>
                                <span class="fs-14 f-montserrat-regular">Universitarios CIAF en la era digital</span>
                            </h2>
                        </div>
                        <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Ajuste datos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="row">
                        <div class="col-12" id="panelcontrol">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>Activos</h3>
                                            <p>Estudiantes que estan activos, pero que estan sin materias</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(1)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>Materias</h3>
                                            <p>Estudiantes que no estan activo, pero que tienen materias matriculadas</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(2)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>Renovar</h3>
                                            <p>Marcar los estudiantes que deben renovar matricula</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(3)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-indigo">
                                        <div class="inner">
                                            <h3>Tabla activos </h3>
                                            <p>Agregar estudiantes activos a la tabla activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(4)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-indigo">
                                        <div class="inner">
                                            <h3>Tabla activos </h3>
                                            <p>Verificar quien esta en la tabla activo que no esta en estudiantes activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(7)">Ejecutar <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-indigo">
                                        <div class="inner">
                                            <h3>Tabla activos </h3>
                                            <p>Marcar quien es egresado en la tabla activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(11)">Ejecutar <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-indigo">
                                        <div class="inner">
                                            <h3>Tabla activos </h3>
                                            <p>Marcar si es nuevo, homologado, interno o renovación</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(12)">Ejecutar <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-indigo">
                                        <div class="inner">
                                            <h3>Tabla activos </h3>
                                            <p>Marcar si renovo academicamente, incluso cambio de nivel</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(21)">Ejecutar <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3>Egresados</h3>
                                            <p>Marcar como egresados en la tabla estudiantes</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(5)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>Nivelatorios</h3>
                                            <p>Marcar como pago nivelatorio</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="#" class="small-box-footer" onclick="opcion(6)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>Datos personales</h3>
                                            <p>Quien esta registrado sin datos personales</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(8)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>Ajustar Semestres</h3>
                                            <p>Mirar quien tiene el semestre mal calculado</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(9)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-pink">
                                        <div class="inner">
                                            <h3>Cuadrar sexo</h3>
                                            <p>Quien no tiene sexo para ajustar</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(10)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>SOFI</h3>
                                            <p>Agregar credencial sofi_persona</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(13)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>SOFI</h3>
                                            <p>Agregar credencial sofi_tareas</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(14)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>Sofi_Matricula</h3>
                                            <p>Actualizar credito_finalizado</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(15)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>Sofi_seguimientos</h3>
                                            <p>Actualizar seguimientos whatsapp</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(16)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-light">
                                        <div class="inner">
                                            <h3>Marcar pagos</h3>
                                            <p>Con financiación, estudiantes_activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(17)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-light">
                                        <div class="inner">
                                            <h3>Marcar pagos</h3>
                                            <p>Pagos sin crédito, estudiantes_activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(18)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-light">
                                        <div class="inner">
                                            <h3>Marcar pagos</h3>
                                            <p>por pagina web</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(19)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>Renovación</h3>
                                            <p>Control</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(20)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>Segmen. Estu</h3>
                                            <p>Segmentación estudiantes</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(22)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3>Ajuste % cv</h3>
                                            <p>Ajuste porcentaje hoja de vida</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(23)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-olive">
                                        <div class="inner">
                                            <h3>Ajuste ia data</h3>
                                            <p>Analisis data</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(24)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-6">
                                    <div class="small-box bg-indigo">
                                        <div class="inner">
                                            <h3>Resultado Docente</h3>
                                            <p>Antes de clic colocar periodo</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a class="small-box-footer" onclick="opcion(25)">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="resultados">
                            <div class="col-12 text-right"><a onclick="volver()" class="btn btn-primary">Volver</a></div>
                            <div class="" id="opciones">
                                
                            </div>
                            <div class="row" id="activos"></div>
                        </div>
                    </div>
            </section>
        </div>
        <div class="modal fade" id="renovaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="resultado_renovaciones"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal nivelatorio -->
        <div class="modal fade" id="nivelatorio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="resultado_nivelatorio"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <script type="text/javascript" src="scripts/ajustedatos.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>
<script>
</script>