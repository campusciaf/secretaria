<?php
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 43;
    $submenu = 4304;
    require 'header.php';
    if ($_SESSION['puntos']) {
?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 mx-0">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Gráficas de Puntos colaboradores</span><br>
                            <span class="fs-14 f-montserrat-regular">Visualización de puntos otorgados en los últimos 15 días</span>
                        </h2>
                    </div>

                    

            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gráficas de puntos colaborades</li>
                    </ol>
            </div>
            </div>
            
        
        
    

 <div class="row mt-3">
  
  <div class="col-xl-3 col-lg-6 col-md-6 col-12 card py-2">
    <div class="">
      <div class="row align-items-center">
        <div class="col-auto">
          
          <div class="avatar avatar-50 rounded bg-light-yellow">
            <i class="fa-solid fa-coins text-warning fa-2x"></i>
          </div>
        </div>
        <div class="col">
          <p class="small  mb-0">Total de puntos otorgados colaborades</p>
          <h4 class="fw-medium text-secondary mb-0">
            <span id="puntos_totales"></span>
          </h4>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
    <div class="d-flex flex-wrap gap-2" id="categorias_superiores"></div>
  </div>
</div>

<div class="row mb-3" id="categorias_container"></div>

            
            



           
            <div class="row">
                <div class="col-md-12">
                    <canvas id="canvas_puntos" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Modal -->
       <div class="modal fade" id="modalListado" tabindex="-1" role="dialog" aria-labelledby="modalListadoLabel" aria-hidden="true"> 
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListadoLabel">Listado de personas por categoría</h5>
        
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-sm" id="tablaListado" style="border: none;">
            <thead>
              <tr>
                <th>Identificación</th>
                <th>Nombre completo</th>
                <th>Fecha</th>
                <th>Puntos</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
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
}
ob_end_flush();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script type="text/javascript" src="scripts/puntos_colaborador.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>


