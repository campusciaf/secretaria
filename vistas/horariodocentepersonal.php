<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
   if($_SESSION['usuario_cargo']!="Docente"){
      header("Location: ../");
  }else{
      $menu = 1;
      require 'header_docente.php';
  }
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                      <span class="titulo-2 fs-18 text-semibold">Horario docente</span><br>
                      <span class="fs-14 f-montserrat-regular">Visualice el horario académico en formato calendario</span>
                </h2>
              </div>
              <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
              </div>
              <div class="col-12 migas">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                      <li class="breadcrumb-item active">Horario docente</li>
                    </ol>
              </div>
          </div>
        </div>
    </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">

         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="card card-primary" style="padding: 2%" id="lista_programas">
              
				<div class="col-xl-12">
					<div class="card" id="calendar" style="width: 100%"></div>
				</div>

            </div>

         </div>

      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->





      <div class="modal" id="myModalEvento">
         <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h6 class="modalTitulo">Información</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <p id="modalDia"></p>
                  <p id="modalTitle"></p>
               </div>

            </div>
         </div>
      </div>





<?php
    require 'footer_docente.php';
}
ob_end_flush();
?>

<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>


<script type="text/javascript" src="scripts/horariodocentepersonal.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>




