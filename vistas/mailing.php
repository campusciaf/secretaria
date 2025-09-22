<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 12;
	$submenu = 1202;
    require 'header.php';
	if ($_SESSION['usuario_nombre']){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Email marketing</span><br>
                        <span class="fs-16 f-montserrat-regular">Fideliza colaboradores, clientes y empleados</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Email</li>
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
            <div class="col-md-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <div class="col-md-12" id="capture">
                        <div class="">
                                <h2>¿Qué quieres diseñar?</h2>
                                <p class="small">Dales calidad. Es el mejor tipo de publicidad que existe.</p>
                        </div>
                        <div class="box">
                            <div class="box-header with-border">						
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 plantillas">
                                </div>                        
                                <div class="col-md-12 conte"></div>
                            </div>
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<!-- modal de preview de las plantillas -->
<div class="modal" id="modal_vi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vista Previa Correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body conte_estruc">   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal para enviar mensajeria -->
<div class="modal" id="m_enviar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CIAF - Usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <label>Asunto</label>
                            <input type="text" name="asunto" class="form-control" required>
                            <input type="hidden" name="id" id="id_p">
                        </div>
                        <div class="col-12">
                            <label>Destinatarios</label>
                            <textarea name="correos" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="col-12"></div> 
                        <div class="col-12"></br>
                            <button type="submit" class="btn btn-success btn-block">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script src="../public/canvas/html2canvas.min.js"></script>
<script type="text/javascript" src="scripts/mailing.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>