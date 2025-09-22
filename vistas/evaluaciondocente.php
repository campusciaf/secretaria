<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
	$menu=1;
    require 'header_estudiante.php';
	if($_SESSION['status_titulaciones'] == 1){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Evaluación Docente</span><br>
                      <span class="fs-14 f-montserrat-regular">Tu participación es confidencial y anónima.</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-xl-10 col-lg-10 col-md-6 col-12 pt-4">
                 <div class="py-3 " >
                      <span class="coin" id="coin-seres"><img src="../public/img/coin.webp"> <span class="text-danger"> 100 pts </span></span>
                      <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-user"></i> </span>
                      <a onclick="mostrarform(2), listarPreguntas()" class="fs-16 pointer font-weight-bolder">
                          Haz tu evaluación y recibe 100 puntos como recompensa.
                      </a>
                  </div>
              </div>
              <div class="col-xl-2 col-lg-10 col-md-6 col-4 text-right pt-4">
                  <a href="ayuda.php" class="btn btn-danger"> Reportar falla aquí.</a>           
              </div>

          </div>
        </div>
    </div>
    <section class="content">
        <div class="row mx-0">
            <div class="col-md-12">
                <div class="" style="padding: 0% 1%">
				    <div class="box-header with-border">
				        <div class="row" id="listar"></div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="modalpreguntas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tu opinión es muy importante para que sigamos creciendo juntos.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="form_preguntas" method="POST">
        <div id="preguntas"></div>
      </form>
      </div>

    </div>
  </div>
</div>


<?php
}else{
        require 'noacceso.php';
}	
require 'footer_estudiante.php';
ob_end_flush();
?>
<script type="text/javascript" src="scripts/evaluaciondocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>