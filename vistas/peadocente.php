<?php
ob_start();

require_once "../modelos/PeaDocente.php";
$peadocente = new PeaDocente(); // no se inicia session en este archivo porque esta dentro del modelo.

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 1;
    require 'header_docente.php';
    if (!empty($_SESSION['id_usuario'])) {

?>


    <div id="precarga" class="precarga"></div>

    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Proyecto Educativo de Aula</span><br>
                            <span class="fs-14 f-montserrat-regular">Ofrece experiencias de aprendizaje dinámicas a cada estudiante, en cualquier lugar</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                    <div class="col-12 migas mb-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_docente.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="docentegrupos.php">Clases</a></li>
                            <li class="breadcrumb-item active">Gestión PEA</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content" style="padding-top: 0px;">
            <div class="card card-primary col-12 m-0" style="padding: 2%" id="lista_programas">
                <div class="row">
                    <div id="listadopea" class="col-12"></div>
                    <div id="descripcion" class="col-12"></div>
                    <div id="documentos" class="col-12"></div>
                    <div id="enlaces" class="col-12"></div>
                    <div id="ejercicios" class="col-12"></div>  
                    <div id="glosario" class="col-12">
                        <div class="row">
                            <div class="col-12" id="glosariocabecera"></div>
                            <div class="col-12">
                                <table id="tblglosario" class="table table-hover" style="width:100%">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Palabra</th>
                                        <th>Definición</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="programaractividades">

                        <div class="row">
                            <div class="col-12">
                                <div class="dropdown float-left">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Agregar Actividad
                                    </button>
                                    <div class="dropdown-menu" id="tipo_archivo">
                                        <a class="dropdown-item" href="#">Link 1</a>
                                        <a class="dropdown-item" href="#">Link 2</a>
                                        <a class="dropdown-item" href="#">Link 3</a>
                                    </div>
                                </div>


                                <button class="btn btn-info float-right" onclick="volver()" type="button">
                                    <i class="fa fa-arrow-circle-left"></i> Volver
                                </button>

                            </div><br><br>

                            <div class="col-12">
                                <div id="listadosactividades"></div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>

    <div id="panelRecursos" class="offcanvas-custom">
        <div class="offcanvas-header-custom">
            <h5>Añade actividad o recursos</h5>
            <button class="btn btn-sm btn-light" onclick="cerrarPanel()">×</button>
        </div>
        <div id="contenidoPanelRecursos">
            <p class="text-muted">Cargando contenido...</p>
        </div>
    </div>





        <!-- Modal -->
        <div id="myModalActividad" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar Actividad</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">

                        <form name="formulario" id="formulario" method="POST">

                            <input type="hidden" name="id_pea_actividades" id="id_pea_actividades">
                            <input type="hidden" name="id_tema" id="id_tema">
                            <input type="hidden" name="id_docente_grupo" id="id_docente_grupo">
                            <input type="hidden" name="tipo_archivo_id" id="tipo_archivo_id">

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Nombre de la Actividad(*):</label>
                                <input type="text" class="form-control" name="nombre_actividad" id="nombre_actividad" maxlength="60" placeholder="Nombre Actividad" required onchange="javascript:this.value=this.value.toUpperCase();">
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Descripción de la Actividad(*):</label>
                                <textarea class="form-control" name="descripcion_actividad" id="descripcion_actividad" maxlength="60" row="6"></textarea>
                            </div>


                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="campo">

                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                <button class="btn btn-danger" data-dismiss="modal" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="carpetadocumento">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carpeta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariocrearcarpeta" id="formulariocrearcarpeta" method="POST">

                            <input type="hidden" id="id_pea_docentes" name="id_pea_docentes">
                            <input type="hidden" id="id_pea_documento_carpeta" name="id_pea_documento_carpeta">


                            <div class="group col-xl-12">
                                <input type="text" name="carpeta" id="carpeta" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre Carpeta</label>
                            </div>
                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearCarpeta"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="subirdocumento">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form name="formulariocreardocumento" id="formulariocreardocumento" method="POST">

                            <input type="hidden" id="id_pea_documento" name="id_pea_documento">
                            <input type="hidden" id="id_pea_docentes_subir" name="id_pea_docentes_subir">
                            <input type="hidden" id="id_tema_documento" name="id_tema_documento">
                            
                            <input type="hidden" id="tipo" name="tipo">

                            <input type="hidden" id="ciclo_documento" name="ciclo_documento">
                            <input type="hidden" id="id_programa_documento" name="id_programa_documento">
                            <input type="hidden" id="id_materia_documento" name="id_materia_documento">


                            <div class="group col-xl-12">
                                <input type="text" name="nombre_documento" id="nombre_documento" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre</label>
                            </div>
                            <div class="col-xl-12">
                                <label>Descripción</label>
                                <textarea name="descripcion_documento" id="descripcion_documento" required maxlength="98" class="form-control" rows="5" /></textarea>
                            </div>

                            <div class="form-group">
                                <div id="imagenmuestra">....</div>
                                <label for="archivo_documento">Archivo</label>
                                <input type="file" name="archivo_documento" class="form-control-file" id="archivo_documento">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                            </div>

                             <!-- Condición de finalización -->
                            <div class="form-group col-xl-12">
                                <label>Condición de finalización</label>
                                <select name="condicion_finalizacion_documento" id="condicion_finalizacion_documento" class="form-control" onchange="mostrarTipoCondicionDocumento()">
                                    <option value="1">Nada</option>
                                    <option value="2">Estudiantes marcan como terminada</option>
                                    <option value="3">Añadir requisito</option>
                                </select>
                            </div>

                            <!-- Campo condicional: tipo_condicion -->
                            <div class="form-group col-xl-12" id="contenedor_tipo_condicion_documento" style="display: none;">
                                <label>Tipo de condición</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_documento" id="cond_archivo_documento" value="1" >
                                    <label class="form-check-label" for="cond_archivo_documento">Subir archivo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_documento" id="cond_link_documento" value="2">
                                    <label class="form-check-label" for="cond_link_documento">Colocar link evidencia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_documento" id="cond_mensaje_documento" value="3">
                                    <label class="form-check-label" for="cond_mensaje_documento">Mensaje</label>
                                </div>
                            </div>

                            <!-- NUEVO: Campos adicionales -->
                             <div class="group col-xl-12">
                                <input type="date" name="fecha_inicio_documento" id="fecha_inicio_documento" />
                                <label>Fecha Inicio</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="date" name="fecha_limite_documento" id="fecha_limite_documento" />
                                <label>Fecha límite</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="number" name="porcentaje_documento" id="porcentaje_documento" min="0" max="100" />
                                <label>Porcentaje actividad (0-100)</label>
                            </div>

                            <!-- NUEVO: ¿Quiere otorgar puntos? -->
                            <div class="form-group col-xl-12">
                                <label>¿Quiere otorgar puntos?</label>
                                <select name="otorgar_puntos_documento" id="otorgar_puntos_documento"   class="form-control" onchange="toggleCampoPuntosDocumento()">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>

                            <!-- Campo oculto por defecto -->
                            <div class="group col-xl-12" id="campo_puntos_documento" style="display: none;">
                                <input value="0" type="number" name="puntos_actividad_documento" id="puntos_actividad_documento" min="0" step="1" require />
                                <label>Puntos de la actividad</label>
                            </div>



                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearDocumento"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>
                        <script>
                            function mostrarTipoCondicionDocumento() {
                                const select = document.getElementById("condicion_finalizacion_documento");
                                const contenedor = document.getElementById("contenedor_tipo_condicion_documento");

                                if (select.value === "3") {
                                    contenedor.style.display = "block";
                                } else {
                                    contenedor.style.display = "none";
                                    // Limpia selección previa si se cambia a otra opción
                                    const radios = document.getElementsByName("tipo_condicion_documento");
                                    radios.forEach(radio => radio.checked = false);
                                }
                            }

                            function toggleCampoPuntosDocumento() {
                                const select = document.getElementById("otorgar_puntos_documento");
                                const campo = document.getElementById("campo_puntos_documento");
                                campo.style.display = select.value === "1" ? "block" : "none";
                            }
                        </script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="subirdocumentolink">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form name="formulariocreardocumentolink" id="formulariocreardocumentolink" method="POST">

                            <input type="hiddens" id="id_pea_documentolink" name="id_pea_documentolink">
                            <input type="hiddens" id="id_pea_docentes_subirlink" name="id_pea_docentes_subirlink">
                            <input type="hiddens" id="id_tema_subirlink" name="id_tema_subirlink">
                            <input type="hiddens" id="tipolink" name="tipolink">

                            <input type="hiddens" id="ciclo_subirlink" name="ciclo_subirlink">
                            <input type="hiddens" id="id_programa_subirlink" name="id_programa_subirlink">
                            <input type="hiddens" id="id_materia_subirlink" name="id_materia_subirlink">


                            <div class="group col-xl-12">
                                <input type="text" name="nombre_documentolink" id="nombre_documentolink" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre</label>
                            </div>
                            <div class="col-xl-12">
                                <label>Descripción</label>
                                <textarea name="descripcion_documentolink" id="descripcion_documentolink" required maxlength="98" class="form-control" rows="5" /></textarea>
                            </div><br>

                            <div class="group col-xl-12">
                                <input type="text" name="archivo_documentolink" id="archivo_documentolink" required />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Link o URL (https://)</label>
                            </div>


                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearDocumentolink"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="subirvideo">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form name="formulariocrearvideo" id="formulariocrearvideo" method="POST">

                            <input type="hidden" id="id_pea_video" name="id_pea_video">
                            <input type="hidden" id="id_pea_docentes_video" name="id_pea_docentes_video">
                            <input type="hidden" id="id_tema_video" name="id_tema_video">
                            
                            <input type="hidden" id="tipo_video" name="tipo_video">

                            <input type="hidden" id="ciclo_video" name="ciclo_video">
                            <input type="hidden" id="id_programa_video" name="id_programa_video">
                            <input type="hidden" id="id_materia_video" name="id_materia_video">


                            <div class="group col-xl-12">
                                <input type="text" name="titulo_video" id="titulo_video" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre para el taller</label>
                            </div>
                            <div class="col-xl-12">
                                <label>Descripción</label>
                                <textarea name="descripcion_video" id="descripcion_video" required maxlength="98" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="col-xl-12">
                                <label>Descripción</label>
                                <input type="text" name="url_video" id="url_video"  class="form-control"
                                        placeholder="Pega la URL de YouTube" oninput="mostrarMiniatura()" required />
                                
                                <!-- Aquí saldrá la miniatura -->
                                <div id="preview" style="margin-top:10px;"></div>
                            </div>


                             <!-- Condición de finalización -->
                            <div class="form-group col-xl-12">
                                <label>Condición de finalización</label>
                                <select name="condicion_finalizacion_video" id="condicion_finalizacion_video" class="form-control" onchange="mostrarTipoCondicionVideo()">
                                    <option value="1">Nada</option>
                                    <option value="2">Estudiantes marcan como terminada</option>
                                    <option value="3">Añadir requisito</option>
                                </select>
                            </div>

                            <!-- Campo condicional: tipo_condicion -->
                            <div class="form-group col-xl-12" id="contenedor_tipo_condicion_video" style="display: none;">
                                <label>Tipo de condición</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_video" id="cond_archivo_video" value="1" >
                                    <label class="form-check-label" for="cond_archivo_video">Subir archivo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_video" id="cond_link_video" value="2">
                                    <label class="form-check-label" for="cond_link_video">Colocar link evidencia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_video" id="cond_mensaje_video" value="3">
                                    <label class="form-check-label" for="cond_mensaje_video">Mensaje</label>
                                </div>
                            </div>

                            <!-- NUEVO: Campos adicionales -->
                             <div class="group col-xl-12">
                                <input type="date" name="fecha_inicio_video" id="fecha_inicio_video" />
                                <label>Fecha Inicio</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="date" name="fecha_limite_video" id="fecha_limite_video" />
                                <label>Fecha límite</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="number" name="porcentaje_video" id="porcentaje_video" min="0" max="100" />
                                <label>Porcentaje actividad (0-100)</label>
                            </div>

                            <!-- NUEVO: ¿Quiere otorgar puntos? -->
                            <div class="form-group col-xl-12">
                                <label>¿Quiere otorgar puntos?</label>
                                <select name="otorgar_puntos_video" id="otorgar_puntos_video"   class="form-control" onchange="toggleCampoPuntosVideo()">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>

                            <!-- Campo oculto por defecto -->
                            <div class="group col-xl-12" id="campo_puntos_video" style="display: none;">
                                <input type="number" name="puntos_actividad_video" id="puntos_actividad_video" min="0" step="1" />
                                <label>Puntos de la actividad</label>
                            </div>



                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearVideo"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>
                        <script>
                            function mostrarTipoCondicionVideo() {
                                const select = document.getElementById("condicion_finalizacion_video");
                                const contenedor = document.getElementById("contenedor_tipo_condicion_video");

                                if (select.value === "3") {
                                    contenedor.style.display = "block";
                                } else {
                                    contenedor.style.display = "none";
                                    // Limpia selección previa si se cambia a otra opción
                                    const radios = document.getElementsByName("tipo_condicion_video");
                                    radios.forEach(radio => radio.checked = false);
                                }
                            }

                            function toggleCampoPuntosVideo() {
                                const select = document.getElementById("otorgar_puntos_video");
                                const campo = document.getElementById("campo_puntos_video");
                                 if (select.value === "1") {
                                    campo.style.display = "block";
                                } else {
                                    campo.style.display = "none";
                                     document.getElementById("puntos_actividad_video").value = "0";
                                }
                            }
                        </script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
     

        <!-- Modal -->
       <!--   
        <div class="modal" id="subirejercicios">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ejercicios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form name="formulariocrearejercicios" id="formulariocrearejercicios" method="POST">

                            <input type="hidden" id="id_pea_ejercicios" name="id_pea_ejercicios">
                            <input type="hidden" id="id_pea_ejercicios_carpeta_subir" name="id_pea_ejercicios_carpeta_subir">
                            <input type="hidden" id="id_pea_docente_subir_ejercicios" name="id_pea_docente_subir_ejercicios">
                            <input type="hidden" id="tipo_archivo_ejercicios" name="tipo_archivo_ejercicios">


                            <div class="group col-xl-12">
                                <input type="text" name="nombre_ejercicios" id="nombre_ejercicios" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre</label>
                            </div>
                            <div class="col-xl-12">
                                <label>Descripción</label>
                                <textarea name="descripcion_ejercicios" id="descripcion_ejercicios" required maxlength="98" class="form-control" rows="5" /></textarea>
                            </div>

                            <div class="form-group">
                                <div id="imagenmuestra_ejercicios">....</div>
                                <label for="archivo_documento_ejercicios">Archivo</label>
                                <input type="file" name="archivo_ejercicios" class="form-control-file" id="archivo_ejercicios">
                                <input type="hidden" name="imagenactual_ejercicios" id="imagenactual_ejercicios">
                            </div>

                            <div class="group col-xl-12">
                                <input type="date" name="fecha_inicio" id="fecha_inicio" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Fecha de inicio</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="date" name="fecha_entrega" id="fecha_entrega" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Fecha entrega</label>
                            </div>
                            <div class="group col-xl-12">
                                <input type="number" name="por_ejercicios" id="por_ejercicios" min="1" max="100" required />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Porcentaje</label>
                            </div>


                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearEjercicios"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
-->
        <!-- Modal -->
        <div class="modal fade" id="verDescargas">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Historia de descargas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12">
                                <table id="tbllistado" class="table table-bordered compact table-sm table-hover" style="width:100%">
                                    <thead>
                                        <th>Identificacion</th>
                                        <th>Nombre estudiante</th>
                                        <th>Correo CIAF</th>
                                        <th>Nombre Documento</th>
                                        <th>Fecha des.</th>
                                        <th>Hora des.</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="crearEnlaces">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enlace</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form name="formulariocrearenlace" id="formulariocrearenlace" method="POST">

                            <!-- Campos ocultos existentes -->
                            <input type="hidden" id="id_pea_enlaces" name="id_pea_enlaces">
                            <input type="hidden" id="id_pea_docentes_enlace" name="id_pea_docentes_enlace">
                            <input type="hidden" id="id_tema_enlace" name="id_tema_enlace">
                            <input type="hidden" id="ciclo_enlace" name="ciclo_enlace">
                            <input type="hidden" id="id_programa_enlace" name="id_programa_enlace">
                            <input type="hidden" id="id_materia_enlace" name="id_materia_enlace">

                            <!-- Titulo -->
                            <div class="group col-xl-12">
                                <input type="text" name="titulo_enlace" id="titulo_enlace" required maxlength="30" />
                                <label>Titulo enlace</label>
                            </div>

                            <!-- Descripción -->
                            <div class="col-xl-12">
                                <label>Descripción enlace</label>
                                <textarea name="descripcion_enlace" id="descripcion_enlace" required maxlength="90" rows="4" class="form-control"></textarea>
                            </div><br>

                            <!-- Enlace -->
                            <div class="group col-xl-12">
                                <input type="text" name="enlace" id="enlace" required maxlength="90" />
                                <label>Enlace</label>
                            </div>

                            <!-- Condición de finalización -->
                            <div class="form-group col-xl-12">
                                <label>Condición de finalización</label>
                                <select name="condicion_finalizacion_enlace" id="condicion_finalizacion_enlace" class="form-control" onchange="mostrarTipoCondicionEnlace()">
                                    <option value="1">Nada</option>
                                    <option value="2">Estudiantes marcan como terminada</option>
                                    <option value="3">Añadir requisito</option>
                                </select>
                            </div>

                            <!-- Campo condicional: tipo_condicion -->
                            <div class="form-group col-xl-12" id="contenedor_tipo_condicion_enlace" style="display: none;">
                                <label>Tipo de condición</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_enlace" id="cond_archivo_enlace" value="1" >
                                    <label class="form-check-label" for="cond_archivo_enlace">Subir archivo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_enlace" id="cond_link_enlace" value="2">
                                    <label class="form-check-label" for="cond_link_enlace">Colocar link evidencia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_enlace" id="cond_mensaje_enlace" value="3">
                                    <label class="form-check-label" for="cond_mensaje_enlace">Mensaje</label>
                                </div>
                            </div>

                            <!-- NUEVO: Campos adicionales -->
                             <div class="group col-xl-12">
                                <input type="date" name="fecha_inicio_enlace" id="fecha_inicio_enlace" />
                                <label>Fecha Inicio</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="date" name="fecha_limite_enlace" id="fecha_limite_enlace" />
                                <label>Fecha límite</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="number" name="porcentaje_enlace" id="porcentaje_enlace" min="0" max="100" />
                                <label>Porcentaje actividad (0-100)</label>
                            </div>

                            <!-- NUEVO: ¿Quiere otorgar puntos? -->
                            <div class="form-group col-xl-12">
                                <label>¿Quiere otorgar puntos?</label>
                                <select name="otorgar_puntos_enlace" id="otorgar_puntos_enlace"   class="form-control" onchange="toggleCampoPuntosEnlace()">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>

                            <!-- Campo oculto por defecto -->
                            <div class="group col-xl-12" id="campo_puntos_enlace" style="display: none;">
                                <input type="number" name="puntos_actividad_enlace" id="puntos_actividad_enlace" min="0" step="1" />
                                <label>Puntos de la actividad</label>
                            </div>

                            <!-- Botón de envío -->
                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearEnlace"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>

                        <script>
                            function mostrarTipoCondicionEnlace() {
                                const select = document.getElementById("condicion_finalizacion_enlace");
                                const contenedor = document.getElementById("contenedor_tipo_condicion_enlace");

                                if (select.value === "3") {
                                    contenedor.style.display = "block";
                                } else {
                                    contenedor.style.display = "none";
                                    // Limpia selección previa si se cambia a otra opción
                                    const radios = document.getElementsByName("tipo_condicion_enlace");
                                    radios.forEach(radio => radio.checked = false);
                                }
                            }

                            function toggleCampoPuntosEnlace() {
                                const select = document.getElementById("otorgar_puntos_enlace");
                                const campo = document.getElementById("campo_puntos_enlace");
                                campo.style.display = select.value === "1" ? "block" : "none";
                            }
                        </script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="crearVideo">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar video</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form name="formulariocrearenlace" id="formulariocrearenlace" method="POST">

                            <!-- Campos ocultos existentes -->
                            <input type="hidden" id="id_pea_enlaces" name="id_pea_enlaces">
                            <input type="hidden" id="id_pea_docentes_enlace" name="id_pea_docentes_enlace">
                            <input type="hidden" id="id_tema_enlace" name="id_tema_enlace">
                            <input type="hidden" id="ciclo_enlace" name="ciclo_enlace">
                            <input type="hidden" id="id_programa_enlace" name="id_programa_enlace">
                            <input type="hidden" id="id_materia_enlace" name="id_materia_enlace">

                            <!-- Titulo -->
                            <div class="group col-xl-12">
                                <input type="text" name="titulo_enlace" id="titulo_enlace" required maxlength="30" />
                                <label>Titulo enlace</label>
                            </div>

                            <!-- Descripción -->
                            <div class="col-xl-12">
                                <label>Descripción enlace</label>
                                <textarea name="descripcion_enlace" id="descripcion_enlace" required maxlength="90" rows="4" class="form-control"></textarea>
                            </div><br>

                            <!-- Enlace -->
                            <div class="group col-xl-12">
                                <input type="text" name="enlace" id="enlace" required maxlength="90" />
                                <label>Enlace</label>
                            </div>

                            <!-- Condición de finalización -->
                            <div class="form-group col-xl-12">
                                <label>Condición de finalización</label>
                                <select name="condicion_finalizacion_enlace" id="condicion_finalizacion_enlace" class="form-control" onchange="mostrarTipoCondicionEnlace()">
                                    <option value="1">Nada</option>
                                    <option value="2">Estudiantes marcan como terminada</option>
                                    <option value="3">Añadir requisito</option>
                                </select>
                            </div>

                            <!-- Campo condicional: tipo_condicion -->
                            <div class="form-group col-xl-12" id="contenedor_tipo_condicion_enlace" style="display: none;">
                                <label>Tipo de condición</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_enlace" id="cond_archivo_enlace" value="1" >
                                    <label class="form-check-label" for="cond_archivo_enlace">Subir archivo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_enlace" id="cond_link_enlace" value="2">
                                    <label class="form-check-label" for="cond_link_enlace">Colocar link evidencia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_condicion_enlace" id="cond_mensaje_enlace" value="3">
                                    <label class="form-check-label" for="cond_mensaje_enlace">Mensaje</label>
                                </div>
                            </div>

                            <!-- NUEVO: Campos adicionales -->
                             <div class="group col-xl-12">
                                <input type="date" name="fecha_inicio_enlace" id="fecha_inicio_enlace" />
                                <label>Fecha Inicio</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="date" name="fecha_limite_enlace" id="fecha_limite_enlace" />
                                <label>Fecha límite</label>
                            </div>

                            <div class="group col-xl-12">
                                <input type="number" name="porcentaje_enlace" id="porcentaje_enlace" min="0" max="100" />
                                <label>Porcentaje actividad (0-100)</label>
                            </div>

                            <!-- NUEVO: ¿Quiere otorgar puntos? -->
                            <div class="form-group col-xl-12">
                                <label>¿Quiere otorgar puntos?</label>
                                <select name="otorgar_puntos_enlace" id="otorgar_puntos_enlace"   class="form-control" onchange="toggleCampoPuntosEnlace()">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>

                            <!-- Campo oculto por defecto -->
                            <div class="group col-xl-12" id="campo_puntos_enlace" style="display: none;">
                                <input type="number" name="puntos_actividad_enlace" id="puntos_actividad_enlace" min="0" step="1" />
                                <label>Puntos de la actividad</label>
                            </div>

                            <!-- Botón de envío -->
                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearEnlace"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>

                        <script>
                            function mostrarTipoCondicionEnlace() {
                                const select = document.getElementById("condicion_finalizacion_enlace");
                                const contenedor = document.getElementById("contenedor_tipo_condicion_enlace");

                                if (select.value === "3") {
                                    contenedor.style.display = "block";
                                } else {
                                    contenedor.style.display = "none";
                                    // Limpia selección previa si se cambia a otra opción
                                    const radios = document.getElementsByName("tipo_condicion_enlace");
                                    radios.forEach(radio => radio.checked = false);
                                }
                            }

                            function toggleCampoPuntosEnlace() {
                                const select = document.getElementById("otorgar_puntos_enlace");
                                const campo = document.getElementById("campo_puntos_enlace");
                                campo.style.display = select.value === "1" ? "block" : "none";
                            }
                        </script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="carpetaejercicios">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carpeta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariocrearcarpetaejercicios" id="formulariocrearcarpetaejercicios" method="POST">


                            <input type="hidden" id="id_pea_ejercicios_carpeta" name="id_pea_ejercicios_carpeta">
                            <input type="hidden" id="id_pea_docentes_ejercicios_carpeta" name="id_pea_docentes_ejercicios_carpeta">

                            <div class="group col-xl-12">
                                <input type="text" name="carpeta_ejercicios" id="carpeta_ejercicios" required maxlength="28" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre Carpeta</label>
                            </div>
                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearCarpetaEjercicios"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="crearGlosario">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Glosario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulariocrearglosario" id="formulariocrearglosario" method="POST">

                            <input type="hidden" id="id_pea_glosario" name="id_pea_glosario">
                            <input type="hidden" id="id_pea_docentes_glosario" name="id_pea_docentes_glosario">
                            <input type="hidden" id="id_tema_glosario" name="id_tema_glosario">
                            <input type="hidden" id="ciclo_glosario" name="ciclo_glosario">
                            <input type="hidden" id="id_programa_glosario" name="id_programa_glosario">
                            <input type="hidden" id="id_materia_glosario" name="id_materia_glosario">

                            <div class="group col-xl-12">
                                <input type="text" name="titulo_glosario" id="titulo_glosario" required maxlength="30" />
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Titulo glosario</label>
                            </div>

                            <div class="col-xl-12">
                                <label>Definición glosario</label>
                                <textarea name="definicion_glosario" id="definicion_glosario" required maxlength="240" rows="4" class="form-control"></textarea>
                            </div>

                              <!-- NUEVO: ¿Quiere otorgar puntos? -->
                            <div class="form-group col-xl-12">
                                <label>¿Quiere otorgar puntos?</label>
                                <select name="otorgar_puntos_glosario" id="otorgar_puntos_glosario"   class="form-control" onchange="toggleCampoPuntos()">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>

                            <!-- Campo oculto por defecto -->
                            <div class="group col-xl-12" id="campo_puntos_glosario" style="display: none;">
                                <input type="number" name="puntos_actividad_glosario" id="puntos_actividad_glosario" min="0" step="1" />
                                <label>Puntos de la actividad</label>
                            </div>

                            <div class="form-group col-12">
                                <button class="btn btn-primary btn-block" type="submit" id="btnCrearGlosario"><i class="fa fa-save"></i> Publicar </button>
                            </div>
                        </form>
                         <script>

                            function toggleCampoPuntos() {
                                const select = document.getElementById("otorgar_puntos_glosario");
                                const campo = document.getElementById("campo_puntos_glosario");
                                campo.style.display = select.value === "1" ? "block" : "none";
                            }
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="listadoCalificar">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Calificar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-12 table-responsive">
                            <table id="listadoCalificarDatos" class="table table-bordered table-sm compact" width="100%">
                                <thead>
                                    <th>Foto</th>
                                    <th>Identificación</th>
                                    <th>Nombre completo</th>
                                    <th>Taller</th>
                                    <th>Fecha subida</th>
                                    <th width="60px">Calificar</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="listadoCalificarCompleto">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Calificar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-12 table-responsive">
                            <table id="listadoCalificarDatosCompleto" class="table table-bordered table-sm compact" width="100%">

                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="informacionDoc">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Información general</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="resultadodoc"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="respuestasEstudianteVideo">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Respuesta Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="revertirInfoVideo()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="resultadoRespuestasEstudiante"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="revertirInfoVideo()" >Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

         <div class="modal" id="verDocumentoMensajeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mensaje Enviado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea name="comentario_documento_archivo_ver" id="comentario_documento_archivo_ver" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="verEnlaceMensajeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mensaje Enviado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea name="comentario_enlace_archivo_ver" id="comentario_enlace_archivo_ver" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer_docente.php';
    ?>


    <script type="text/javascript" src="scripts/peadocente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

    <?php
    $id_docente_grupo = isset($_GET["id"]) ? $_GET["id"] : "";
    if (!empty($id_docente_grupo)) {

        $rspta2 = $peadocente->comprobar($id_docente_grupo);
        $id_materia = $rspta2["id_materia"];
        $id_programa = $rspta2["id_programa"];

        echo "<script>listar($id_materia, $id_programa, $id_docente_grupo);</script>";
    }
    ?>
    <script src="https://www.youtube.com/iframe_api"></script>

<?php
}
ob_end_flush();
?>