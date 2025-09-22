<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
  header("Location: ../");
} else {
  $menu = 4;
  // $seccion = "Otros Pagos";
  require 'header_estudiante.php';
?>


  <div class="content-wrapper" style="background-color: #f8f9fa; font-size: 14px;">
    <div class="container py-5">
      <div class="text-center mb-5">
        <h2 class="font-weight-bold text-primary">
          <i class="fas fa-comments"></i> Centro de Atención PQRS
        </h2>
        <p class="text-muted">Envía tus solicitudes, preguntas o sugerencias y haz el seguimiento</p>
      </div>
      <div class="row" style="min-height: 500px;">
        <div class="col-lg-12 mb-4">
          <div class="card shadow-sm border-0 w-100 d-flex flex-column">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title text-primary mb-0">
                  <i class="fas fa-inbox"></i> Tus PQRS
                </h5>
                <button id="btnAbrirModalPQRS" class="btn btn-sm btn-primary px-3 py-1" style="font-size: 13px;">
                  <i class="fas fa-plus-circle"></i> Agregar nueva PQRS
                </button>
              </div>
              <div id="listadoregistros" style="max-height: 400px; overflow-y: auto;">
                <div class="text-center text-muted">No hay activos aún.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalPQRS" tabindex="-1" role="dialog" aria-labelledby="modalPQRSLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="modalPQRSLabel"><i class="fas fa-comments"></i> Nuevo caso PQRS</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formulario" method="POST">
              <div class="modal-body">
                <input type="hidden" id="id_credencial" name="id_credencial">
                <div class="form-group">
                  <label for="id_asunto"><i class="fas fa-message"></i> Asunto</label>
                  <select class="form-control" id="id_asunto" name="id_asunto" onchange="listaropciones(this.value)" required></select>
                </div>
                <div id="listar_opciones" class="mb-3"></div>
                <div class="form-group">
                  <label for="mensaje"><i class="fas fa-keyboard"></i> Detalles</label>
                  <textarea id="mensaje" name="mensaje" class="form-control" rows="4"
                    placeholder="Describe tu situación claramente..." required></textarea>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-success btn-sm">
                  <i class="fas fa-paper-plane"></i> Enviar
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">
                  <i class="fas fa-times"></i> Cancelar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php
    require 'footer_estudiante.php';
  }
  ob_end_flush();
    ?>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->


    <script src="scripts/ayuda.js?<?php echo date('Y-m-d-H:i:s'); ?>"></script>
    <script src="scripts/modal_pqrs.js?<?php echo date('Y-m-d-H:i:s'); ?>"></script>