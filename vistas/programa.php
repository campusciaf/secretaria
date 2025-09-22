<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   if ($_SESSION['usuario_cargo'] == "Docente" or $_SESSION['usuario_cargo'] == "Estudiante") {
      header("Location: ../");
   } else {
      $menu = 1;
      $submenu = 3;
      require 'header.php';
   }
   if ($_SESSION['programa'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper ">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-6 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Gestión programas</span><br>
                        <span class="fs-14 f-montserrat-regular">Espacio para la creación de programas académicos.</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas mb-0">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Programas</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="container-fluid px-4">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="row">
                     <div class="col-12 card">
                        <div class="row">
                           <div class="col-12" id="filaagregar">
                              <div class="row">
                                 <div class="col-6 p-4 tono-3">
                                    <div class="row align-items-center">
                                       <div class="pl-3">
                                          <span class="rounded bg-light-blue p-3 text-primary ">
                                             <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                          </span>
                                       </div>
                                       <div class="col-10">
                                          <div class="col-5 fs-14 line-height-18">
                                             <span class="">Resultados</span> <br>
                                             <span class="text-semibold fs-20">Programa</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-6 tono-3 text-right py-4 pr-4">
                                    <button class="btn btn-success pull-right" id="btnagregar" onclick="mostrarform(true);mostrar_agregar_programa()"><i class="fa fa-plus-circle"></i> Agregar Programa</button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 p-4 table-responsive" id="listadoregistros">
                              <table id="tbllistado" class="table table-hover table-sm" style="width:100%">
                                 <thead>
                                    <th>Acciones</th>
                                    <th width="180px">Nombre</th>
                                    <th>Cod PEA</th>
                                    <th>Ciclo o Nivel</th>
                                    <th>Sniess</th>
                                    <th>#Asig</th>
                                    <th>#Sem</th>
                                    <th>Cortes</th>
                                    <th>Ini. Sem</th>
                                    <th>Escuela</th>
                                    <th>Estado</th>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                           <!-- formulario para agregar el programa academico -->
                           <div class="col-12 panel-body" id="formularioregistros">
                              <form name="formulario" id="formulario" method="POST">
                                 <div class="row">
                                    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                       <label>Nombre Programa(*):</label>
                                       <input type="hidden" name="id_programa" id="id_programa">
                                       <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre Programa" required>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Codigo PEA:</label>
                                       <input type="number" class="form-control" name="cod_programa_pea" id="cod_programa_pea">
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Ciclo:</label>
                                       <select class="form-control" name="ciclo" id="ciclo"></select>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Cod Snies</label>
                                       <input type="number" class="form-control" name="cod_snies" id="cod_snies">
                                    </div>

                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Pertenece</label>
                                       <select class="form-control" id="pertenece" name="pertenece">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Si</option>
                                          <option value="0">No</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Cant. Asig</label>
                                       <input type="number" class="form-control" name="cant_asignaturas" id="cant_asignaturas">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Semestres</label>
                                       <input type="number" class="form-control" name="semestres" id="semestres">
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Ini. Semestre</label>
                                       <input type="number" class="form-control" name="inicio_semestre" id="inicio_semestre">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                       <label>Nombre real Programa</label>
                                       <input type="text" class="form-control" name="original" id="original" maxlength="100" placeholder="Nombre Programa" required>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Activado</label>
                                       <select class="form-control" id="estado" name="estado">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Estado Nuevos</label>
                                       <select class="form-control" id="estado_nuevos" name="estado_nuevos">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Estado Activo</label>
                                       <select class="form-control" id="estado_activos" name="estado_activos">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Estado Graduados</label>
                                       <select class="form-control" id="estado_graduados" name="estado_graduados">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Panel Academico</label>
                                       <select class="form-control" id="panel_academico" name="panel_academico">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Por Renovar</label>
                                       <select class="form-control" id="por_renovar" name="por_renovar">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Otra Universidad</label>
                                       <select class="form-control" id="universidad" name="universidad">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="INTEP">INTEP</option>
                                          <option value="1">CIAF</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Programa Termial</label>
                                       <select class="form-control" id="terminal" name="terminal">
                                          <option value="" selected disabled>Selecciona una opción</option>
                                          <option value="1">No es terminal</option>
                                          <option value="0">Si es terminal</option>
                                       </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Escuela:</label>
                                       <select class="form-control" name="escuela" id="escuela"></select>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label>Relación:</label>
                                       <select class="form-control" name="relacion" id="relacion"></select>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-3 col-xs-3">
                                       <label>Nombre carnet</label>
                                       <input type="text" class="form-control" name="carnet" id="carnet" maxlength="100" placeholder="Nombre Titulo de Programa">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-3 col-xs-3">
                                       <label>Director del programa</label>
                                       <select class="form-control selectpicker" data-live-search="true" name="programa_director" id="programa_director"></select>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-3 col-xs-3">
                                       <label>Centro de costos(Yeminus)</label>
                                       <input type="text" class="form-control" name="centro_costo_yeminus" id="centro_costo_yeminus" required />
                                    </div>
                                    <div class="form-group col-lg-4 col-md-4 col-sm-3 col-xs-3">
                                       <label> Codigo de Producto(Yeminus) </label>
                                       <input type="text" class="form-control" name="codigo_producto" id="codigo_producto" required />
                                    </div>
                                    <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                       <label> Cortes </label>
                                       <input type="number" class="form-control quitar-editar" value="1" id="corte" name="corte" onchange="cantidad_cortes(this.value)">
                                    </div>
                                 </div>
                                 <div class="form-group" id="div_cortes"></div>
                                 <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar">
                                       <i class="fa fa-save"></i>
                                       Guardar
                                    </button>
                                    <button class="btn btn-danger" onclick="cancelarform()" type="button">
                                       <i class="fa fa-arrow-circle-left"></i>
                                       Cancelar
                                    </button>
                                 </div>
                              </form>
                           </div>
                           <div class="col-12" id="monetizar">
                              <div class="row">
                                 <div class="col-6 p-4 tono-3">
                                    <div class="row align-items-center">
                                       <div class="col-auto pl-1">
                                          <span class="rounded bg-light-blue p-2 text-primary ">
                                             <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                          </span>
                                       </div>
                                       <div class="col-10 line-height-18">
                                          <span class="">Programa consultado</span> <br>
                                          <span class="text-semibold fs-16 line-height-16 titulo-2" id="titulo"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-6 p-4 tono-3"><a onclick="volver()" class="btn btn-primary float-right">Volver</a></div>
                                 <form name="formulariomonetizar" id="formulariomonetizar" method="POST" class="col-12 p-4 borde-bottom">
                                    <div class="row">
                                       <input type="hidden" name="id_programa_monetizar" id="id_programa_monetizar" class="form-control">
                                       <div class="col-3 m-0 p-0">
                                          <div class="form-group mb-3 position-relative check-valid">
                                             <div class="form-floating">
                                                <input type="text" placeholder="" value="" required class="form-control border-start-0" name="valor_pecuniario" id="valor_pecuniario" maxlength="20">
                                                <label>Valor derecho pecuniario</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-3 m-0 p-0">
                                          <a onclick="actualizarpecuniario()" id="btnGuardarEditarPecuniario" class="btn btn-primary text-white py-3"><i class="fa fa-save"></i> Editar valor</a>
                                          <button class="btn btn-success py-3" type="submit" id="btnGuardarPrecioPecuniario">
                                             <i class="fa fa-save"></i> Guardar Valor
                                          </button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="row col-12" id="monetizarsemestres">
                              <form name="formulariomonetizarsemestres" id="formulariomonetizarsemestres" method="POST" class="col-12">
                                 <div class="row col-12">
                                    <input type="hidden" name="id_programa_monetizar_semestres" id="id_programa_monetizar_semestres" class="form-control">
                                    <div class="col-xl-2 col-lg-6 col-md-12 col-12">
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <input type="number" placeholder="" value="" required class="form-control border-start-0" name="semestre" id="semestre" maxlength="20" required>
                                             <label>Semestre</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-12 col-12">
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <input type="number" placeholder="" value="" required class="form-control border-start-0" name="matricula_ordinaria" id="matricula_ordinaria" maxlength="20" required>
                                             <label>Valor ordinaria</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-12 col-12">
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <input type="number" placeholder="" value="" step="0.01" required class="form-control border-start-0" name="aporte_social" id="aporte_social" maxlength="20" required>
                                             <label>Aporte social</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-12 col-12">
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <input type="number" placeholder="" value="" required class="form-control border-start-0" name="matricula_extraordinaria" id="matricula_extraordinaria" maxlength="20" required>
                                             <label>Valor extraordinaria</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-12 col-12">
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <input type="number" placeholder="" value="" required class="form-control border-start-0" name="valor_por_credito" id="valor_por_credito" maxlength="20" required>
                                             <label>Valor créditos</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-12 col-12">
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="pago_renovar" id="pago_renovar">
                                                <option value="1">Normal</option>
                                                <option value="0">Con Nivelatorio </option>
                                             </select>
                                             <label>Tipo de pago</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12 px-4 text-center">
                                       <button class="btn btn-success " type="submit"><i class="fa fa-save"></i> Guardar valor</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                           <div class="row col-12" id="tabla_precios"></div>
                        </div>
                     </div>
                  </div>
               </div>
         </section>
      </div>
      <!-- The Modal -->
      <div class="modal" id="aggcortes">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modal-title">Gestión cortes</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
               <div class="modal-body">
                  <form class="conte" id="form2" method="POST"></form>
               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      </div>
      <div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editar Valor Semestre </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form name="formularioeditarvalores" id="formularioeditarvalores" method="POST" enctype="multipart/form-data">
                     <div class="form-group col-12">
                        <label>Semestre:</label><br>
                        <input type="text" class="form-control" name="semestre_m" id="semestre_m" maxlength="100" placeholder="Nombre Salón" required>
                     </div>
                     <div class="form-group col-12">
                        <label>Matricula ordinaria:</label><br>
                        <input type="text" class="form-control" name="ordinaria_m" id="ordinaria_m" maxlength="100" placeholder="Capacidad Salón" required>
                     </div>
                     <div class="form-group col-12">
                        <label>Aporte social:</label><br>
                        <input type="text" class="form-control" name="aporte_m" id="aporte_m" maxlength="100" placeholder="Capacidad Salón" required>
                     </div>
                     <div class="form-group col-12">
                        <label>Extraordinaria:</label><br>
                        <input type="text" class="form-control" name="extra_m" id="extra_m" maxlength="100" placeholder="Capacidad Salón" required>
                     </div>
                     <div class="form-group col-12">
                        <label>Valor por crédito:</label><br>
                        <input type="text" class="form-control" name="valor_credito_m" id="valor_credito_m" maxlength="100" placeholder="Capacidad Salón" required>
                     </div>
                     <div class="form-group col-12">
                        <label>Pago renovar:</label><br>
                        <select class="form-control selectpicker" name="pago_renovar_m" id="pago_renovar_m" required>
                           <option value="1">Normal</option>
                           <option value="0">Con Nivelatorio</option>
                        </select>
                     </div>
                     <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                        <input type="text" class="d-none" id="id_lista_precio_programa_m" name="id_lista_precio_programa_m">
                        <input type="text" class="d-none" id="id_programa_m" name="id_programa_m">
                        <button type="submit" class="btn btn-primary mt-4 btn-block"> <i class="fa fa-save"></i> Editar </button>
                     </div>
                  </form>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<script type="text/javascript" src="scripts/programa.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>