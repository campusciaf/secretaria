<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    require 'header.php';
    if ($_SESSION['sofipanel'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content p-0">
                <div class="row p-0 m-0">
                    <div class="col-12 p-0 m-0 migas pb-2 pt-3 pl-4 ml-0 mr-0 mt-2">
                        <h1 class="m-0 titulo-4">Interés mora <button class="btn btn-success btn-sm btn-flat" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar </button></h1>
                    </div>
                </div>
            </div>
            <section class="contenido ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <div class="row" id="tablaregistros">
                                <div class="col-sm-12">
                                    <table id="tabla_intereses" class="table table-hover search_cuota">
                                        <thead>
                                            <th>Opciones</th>
                                            <th>Mes</th>
                                            <th>Aplica hasta </th>
                                            <th>Porcentaje</th>
                                        </thead>
                                        <tbody>
                                            <th colspan="11">
                                                <div class='jumbotron text-center bg-green' style="margin:0px !important">
                                                    <h3>Aquí aparecerán los datos sobre el interés mora.</h3>
                                                </div>
                                            </th>
                                        </tbody>
                                        <tfoot>
                                            <th>Opciones</th>
                                            <th>Mes</th>
                                            <th>Aplica hasta </th>
                                            <th>Porcentaje</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12" id="formularioregistros">
                                <form name="formulario_interes_mora" class="row" id="formulario_interes_mora" method="POST">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="hidden" name="id_interes" id="id_interes">
                                        <label>Selecciona un mes(*):</label>
                                        <select class="form-control select-picker" name="mes_anio" id="mes_anio">
                                            <option disabled selected value="">-- Selecciona un mes --</option>
                                            <option value="Enero"> Enero</option>
                                            <option value="Febrero"> Febrero </option>
                                            <option value="Marzo"> Marzo </option>
                                            <option value="Abril"> Abril </option>
                                            <option value="Mayo"> Mayo </option>
                                            <option value="Junio"> Junio </option>
                                            <option value="Julio"> Julio </option>
                                            <option value="Agosto"> Agosto </option>
                                            <option value="Septiembre"> Septiembre </option>
                                            <option value="Octubre"> Octubre </option>
                                            <option value="Noviembre"> Noviembre </option>
                                            <option value="Diciembre"> Diciembre </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>El interés aplica hasta :(*):</label>
                                        <input type="date" class="form-control" name="aplica_hasta" id="aplica_hasta" required="">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Porcentaje:</label>
                                        <input type="number" step="any" class="form-control" name="porcentaje" id="porcentaje" placeholder="Porcentaje que se aplica para el mes indicado">
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- /.content-wrapper -->
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script src="scripts/sofi_interes_mora.js"></script>