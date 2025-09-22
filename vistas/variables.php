<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: login.html");
}
else
{
$menu=13;
$submenu=1300;
require 'header.php';
	if ($_SESSION['variables']==1)
	{
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Caracterización</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione las categorias de nuestra caracterización
                        </span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Categorias</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                <div class="row">
                    <div class="col-12 card">
                        <div class="row">

                            <div class="col-6 p-2 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">caracterización</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 tono-3 text-right py-4 pr-4">
                                <button class="btn btn-success pull-right" id="btnagregar"
                                    onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar
                                    Categoría</button></h1>
                            </div>


                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tbllistado" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Acciones</th>
                                        <th>Nombre Categoría</th>
                                        <th>Imagen</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>






                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <input type="hidden" name="id_categoria_principal" id="id_categoria_principal">
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <label>Nombre Categoria(*):</label>
                                            <input type="text" class="form-control" name="categoria_nombre"
                                                id="categoria_nombre" maxlength="100" placeholder="Nombre Categoria"
                                                required>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <label>Publico(*):</label>
                                            <select name="categoria_publico" id="categoria_publico" required
                                                class="form-control">
                                                <option value="0">Ambos</option>
                                                <option value="0">Masculino</option>
                                                <option value="0">Femenino</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <label>Imagen:</label>
                                            <input type="file" class="form-control" name="categoria_imagen"
                                                id="categoria_imagen">
                                            <input type="hidden" name="imagenactual" id="imagenactual">
                                            <img src="" width="150px" height="120px" id="imagenmuestra">
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <label>Estado(*):</label>
                                            <select name="categoria_estado" id="categoria_estado" required
                                                class="form-control">
                                                <option value="1">Activado</option>
                                                <option value="0">Desactivado</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save"></i> Guardar</button>
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal para crear una variable-->
                            <div class="modal" id="myModalCrearVariable">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Crear Variable</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div id="resultadocrearvariable"></div>
                                            <br>
                                            <div class="panel-body" id="formularioregistroscrearvariableuno"
                                                style="display: none">
                                                <form name="formulariocrearvariableuno" id="formulariocrearvariableuno"
                                                    method="POST">
                                                    <div class="row">
                                                        <input type="hidden" name="id_categoria" id="id_categoria"
                                                            value="">
                                                        <input type="hidden" name="id_tipo_pregunta"
                                                            id="id_tipo_pregunta" value="">
                                                        <input type="text" name="variable" id="variable"
                                                            placeholder="Pregunta sin titulo" class="form-control"
                                                            required>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje1">Texto de respuesta corta </div>
                                                        <div class="alert col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje2">Texto de respuesta larga </div>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje3">Mes, Dia, Año <i
                                                                class="far fa-calendar-alt"></i></div>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje4">Lista de Opciones <i
                                                                class="fas fa-caret-square-down"></i></div>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje5">Lista departamentos <i
                                                                class="fas fa-caret-square-down"></i></div>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje6">Lista municipios <i
                                                                class="fas fa-caret-square-down"></i></div>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje7">
                                                            Lista condiciones <i class="fas fa-caret-square-down"></i>
                                                            <img src="../public/img/if_else.png" width="150px">
                                                        </div>
                                                        <div class="alert col-lg-6 col-md-6 col-sm-6 col-xs-6"
                                                            style="border-bottom: 1px dashed #7E7E7E; display: none;"
                                                            id="mensaje8">Correo <i class="fas fa-envelope-square"></i>
                                                        </div>
                                                        <br><br>
                                                        <div class="checkbox col-lg-12">
                                                            <label>
                                                                <input type="radio" name="obligatorio"
                                                                    id="obligatorio_no" value="0"> Campo no
                                                                Obligatorio<br>
                                                                <input type="radio" name="obligatorio"
                                                                    id="obligatorio_si" checked value="1"> Campo
                                                                Obligatorio
                                                            </label>
                                                        </div>
                                                        <div class="alert col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <button class="btn btn-primary" type="submit"><i
                                                                    class="fa fa-save"></i> Guardar</button>
                                                            <button class="btn btn-danger" onclick="cancelarform()"
                                                                type="button"><i class="fa fa-arrow-circle-left"></i>
                                                                Cancelar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal para listar variable-->
                            <div class="modal" id="myModalListarVariable">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Lista Preguntas</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div id="resultadolistarvariable"></div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal para crear opciones-->
                            <div id="myModalOpcion" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Variables</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form name="formularioopcion" id="formularioopcion" method="POST">
                                                <div class="input-group input-group-sm">
                                                    <input type="hidden" name="id_variable" id="id_variable">
                                                    <input type="hidden" name="camponumerodiv" id="camponumerodiv">
                                                    <input type="text" class="form-control" name="nombre_opcion"
                                                        id="nombre_opcion" required placeholder="Añadir Opción">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info btn-flat" type="submit"
                                                            id="btnGuardarOpcion">Añadir!</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal para combinar opciones-->
                            <div id="myModalCondicion" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Variables</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form name="formulariocondicion" id="formulariocondicion" method="POST">
                                                <div class="input-group input-group-sm">
                                                    <input type="hidden" name="id_variable_pre" id="id_variable_pre">
                                                    <input type="hidden" name="camponumerodivpre"
                                                        id="camponumerodivpre">
                                                    <select class="form-control" name="prerequisito" id="prerequisito"
                                                        required>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info btn-flat" type="submit"
                                                            id="btnGuardarCondicion">validar!</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin centro -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->

<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/variables.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>