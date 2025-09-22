<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 8;
    $submenu = 805;
    require 'header.php';
    if ($_SESSION['reportesnies'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper ">
            <div class="content-header">
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-6 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Reportes SNIES</span><br>
                            <span class="fs-14 f-montserrat-regular"> Sistema Nacional de Información de Educación Superior</span>
                        </h2>
                    </div>
                    <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                    </div>
                    <div class="col-12 migas">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Snies</li>
                            </ol>
                    </div>
                </div>
                </div>
            </div>
            <section class="content" style="padding-top: 0px;">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card card-primary" style="padding: 2% 1%">
                            <!-- formulario donde mandamos por metodo post; el tipo de reporte que queremos generar -->

                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6 mx-0 px-0">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="form-floating">
                                            <select value="" required="" class="form-control border-start-0 selectpicker" data-live-search="true" name="snies" id="snies">
                                                <option value="Admitidos">Admitidos</option>
                                                <option value="Estudiantes de primer curso">Estudiantes de primer curso</option>
                                                <option value="Graduados">Graduados</option>
                                                <option value="Inscrito Programa">Inscrito Programa </option>
                                                <option value="Inscritos - Relación de Inscritos">Inscritos - Relación de Inscritos</option>
                                                <option value="Materias Matriculado">Materias Matriculado</option>
                                                <option value="Matriculados">Matriculados</option>
                                                <option value="Participante">Participante</option>
                                            </select>
                                            <label>Tipo de reporte</label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please enter valid input</div>
                                </div>
                                <div class="col-xl-2 mx-0 px-0">
                                    <button class="btn btn-success input-group-text py-3" title='Generar reporte' onclick="generar_reporte()"> 
                                        <i class="fa fa-print"></i> &nbsp; Generar reporte 
                                    </button>
                                </div>
                            </div>


                            <div class="box" id="datos_inscritos_relacion" hidden="true">
                                <div class="box-header with-border">
                                    <h4>INSCRITOS - RELACIÓN DE INSCRITOS</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_relacion_inscritos">
                                        <table id="inscritos_relacion" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> PRIMER_NOMBRE </th>
                                                    <th> SEGUNDO_NOMBRE </th>
                                                    <th> PRIMER_APELLIDO </th>
                                                    <th> SEGUNDO_APELLIDO </th>
                                                    <th> ID_SEXO_BIOLOGICO </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="box" id="datos_inscritos_programa" hidden="true">
                                <div class="box-header with-border">
                                    <h4>INSCRITO PROGRAMA</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_inscritos_programa">
                                        <table id="inscritos_programa" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> PRO_CONSECUTIVO </th>
                                                    <th> ID_MUNICIPIO </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                            <div class="box" id="datos_admitidos" hidden="true">
                                <div class="box-header with-border">
                                    <h4>ADMITIDOS</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_admitidos">
                                        <table id="admitidos" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> PRO_CONSECUTIVO </th>
                                                    <th> ID_MUNICIPIO </th>
                                                    <th> TELEFONO_CONTACTO </th>
                                                    <th> EMAIL_PERSONAL </th>
                                                    <th> FECHA_NACIMIENTO </th>
                                                    <th> ID_ESTRATO </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                            <div class="box" id="datos_participante" hidden="true">
                                <div class="box-header with-border">
                                    <h4>PARTICIPANTES</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_participante">
                                        <table id="participante" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> FECHA_EXPEDICION </th>
                                                    <th> PRIMER_NOMBRE </th>
                                                    <th> SEGUNDO_NOMBRE </th>
                                                    <th> PRIMER_APELLIDO </th>
                                                    <th> SEGUNDO_APELLIDO </th>
                                                    <th> ID_SEXO_BIOLOGICO </th>
                                                    <th> ID_ESTADO_CIVIL </th>
                                                    <th> FECHA_NACIMIENTO </th>
                                                    <th> ID_PAIS </th>
                                                    <th> ID_MUNICIPIO </th>
                                                    <th> TELEFONO_CONTACTO </th>
                                                    <th> EMAIL_PERSONAL </th>
                                                    <th> EMAIL_INSTITUCIONAL </th>
                                                    <th> DIRECCION_INSTITUCIONAL </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                            <div class="box" id="datos_primer_curso" hidden="true">
                                <div class="box-header with-border">
                                    <h4>ESTUDIANTES DE PRIMER CURSO</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_primer_curso">
                                        <table id="primer_curso" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> PRO_CONSECUTIVO </th>
                                                    <th> ID_MUNICIPIO_PROGRAMA </th>
                                                    <th> ID_TIPO_VINCULACION </th>
                                                    <th> ID_GRUPO_ETNICO </th>
                                                    <th> ID_PUEBLO_INDIGENA </th>
                                                    <th> ID_COMUNIDAD_NEGRA </th>
                                                    <th> PERSONA_CON_DISCAPACIDAD </th>
                                                    <th> ID_TIPO_DISCAPACIDAD </th>
                                                    <th> ID_CAPACIDAD_EXCEPCIONAL </th>
                                                    <th> COD_PRUEBA_SABER_11 </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                            <div class="box" id="datos_matriculados" hidden="true">
                                <div class="box-header with-border">
                                    <h4>MATRICULADOS</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_matriculados">
                                        <table id="matriculados" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> CODIGO_ESTUDIANTE </th>
                                                    <th> PRO_CONSECUTIVO </th>
                                                    <th> ID_MUNICIPIO </th>
                                                    <th> FECHA_NACIMIENTO </th>
                                                    <th> ID_PAIS_NACIMIENTO </th>
                                                    <th> ID_MUNICIPIO_NACIMIENTO </th>
                                                    <th> ID_ZONA_RESIDENCIA </th>
                                                    <th> ID_ESTRATO </th>
                                                    <th> ES_REINTEGRO_ANTES_DE1998 </th>
                                                    <th> AÑO_PRIMER_CURSO </th>
                                                    <th> SEMESTRE_PRIMER_CURSO </th>
                                                    <th> VALOR_DERECHOS_MATRICULA </th>
                                                    <th> TELEFONO_CONTACTO </th>
                                                    <th> EMAIL_PERSONAL </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                            <div class="box" id="datos_materias_matriculado" hidden="true">
                                <div class="box-header with-border">
                                    <h4>MATERIAS MATRICULADO</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_materias_matriculado">
                                        <table id="materias_matriculado" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> PRO_CONSECUTIVO </th>
                                                    <th> ID_MUNICIPIO </th>
                                                    <th> NUM_MATERIAS_INSCRITAS </th>
                                                    <th> NUM_MATERIAS_APROBADAS </th>
                                                    <th style="width:250px"> PROGRAMA </th>
                                                    <th> JORNADA </th>
                                                    <th> SEMESTRE ESTUDIANTE </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                            <div class="box" id="datos_graduados" hidden="true">
                                <div class="box-header with-border">
                                    <h4>GRADUADOS</h4>
                                </div>
                                <div class="box-body">
                                    <div id="contenedor_tabla_graduados">
                                        <table id="graduados" class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th></th>
                                                    <th> AÑO </th>
                                                    <th> SEMESTRE </th>
                                                    <th> ID_TIPO_DOCUMENTO </th>
                                                    <th> NUM_DOCUMENTO </th>
                                                    <th> PRO_CONSECUTIVO </th>
                                                    <th> ID_MUNICIPIO </th>
                                                    <th> EMAIL_PERSONAL </th>
                                                    <th> TELEFONO_CONTACTO </th>
                                                    <th> SNP_SABER_PRO </th>
                                                    <th> NUM_ACTA_GRADO </th>
                                                    <th> FECHA_GRADO </th>
                                                    <th> NUM_FOLIO </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- /:box -->
                        </div>
                    </div>
            </section>
        </div>
        <style>
            .btn.btn-flat {
                border-radius: 0;
                border-width: 1px;
                box-shadow: none;
            }
        </style>
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/reporte_snies.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
</body>

</html>