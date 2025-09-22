<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 12;
    require 'header_estudiante.php';
?>
    <div id="precarga" class="precarga"></div>
    <div class="content-wrapper ">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-xl-10 col-9">
                        <h2 class="m-0 line-height-16">
                            <span class="titulo-2 fs-18 text-semibold">Feria de emprendimientos</span><br>
                            <span class="fs-14 f-montserrat-regular">Hemos creado un espacio para todos nuestros estudiantes emprendedores</span>
                        </h2>
                    </div>
                    <div class="col-xl-2 col-3 pt-4 pr-4 text-right">
                        <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'> <i class="fa-solid fa-play"></i> Tour </button>
                    </div>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Feria</li>
                    </ol>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="row">

            <div class="col-12 text-center py-4">
                    <h3 class="titulo-3 text-bold fs-24">Ofrece tus <span class="text-gradient"> productos </span> y servicios <span class="text-gradient">en un espacio </span> creativo e innovador </h3>
                    <span class="fs-14 f-montserrat-regular">Si quieres ser parte de este espacio de manera permanente durante todo el semestre, inscribe tu emprendimiento aquí</span>
                </div>
                
                <div class="col-12 text-center pb-2"> <a class="btn btn-success text-white" onclick="participar()" id="btn-iniciar"><i class="fa-solid fa-user-plus"></i> Iniciar proceso</a></div>
                <div class="w-100 pt-5 position-relative bg-dark text-white z-index-0">
                    <div class="coverimg" style="background-image: url(../public/img/feria_bg.webp);">
                        <img src="../public/img/feria_bg.webp" class="" alt="" style="display: none;">
                    </div>
                    <div class="container my-3 my-md-5 pt-0 pb-lg-5 z-index-1 position-relative" id="proceso">
                        <div class="row">
                            <div class="col-xl-7 col-12">
                                <div class="col-12">
                                    <h6 class="title">Vista previa</h6>
                                </div>
                                <div class="col-auto py-2">
                                    <div>
                                        <div class="" id="shopping_participar">------</div>
                                    </div>
                                </div>

                                <div class="row mb-4 mb-lg-5 align-items-start">
                                    <div class="col-auto position-relative shopping_img"></div>
                                    <div class="col py-2">
                                        <div class="mb-3 fs-18 shopping_nombre line-height-16" id="animacion1">Nombre de tu stand</div>
                                        <p class="shopping_descripcion line-height-16">Describe brevemente que productos o servicios ofrecerías</p>
                                        <span><i class="fa-solid fa-plus"></i> Estamos en</span>
                                        <div class="pt-2 row">
                                            <div class="shopping_facebook" id="animacion_facebook">Facebook</div>
                                            <div class="shopping_instagram" id="animacion_instagram">Instagram</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-white gx-md-4 gx-lg-5">
                                    <div class="col-auto py-2">
                                        <p class="fs-14 opacity-1 line-height-16">Sitio Web</p>
                                        <p class="line-height-16">https://tuemprendimiento.com</p>
                                    </div>

                                    <div class="col-auto py-2">
                                        <p class="fs-14 opacity-1 line-height-16">Ayuda CIAF</p>
                                        <p>
                                            <i class="fa-solid fa-triangle-exclamation text-yellow"></i> Eliminar
                                            <span class="mx-1 opacity-1">|</span>
                                            <a href="" class="text-white"><i class="fa-solid fa-heart text-danger"></i> Necesita ayuda <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        </p>
                                    </div>
                                    <div class="col-auto py-2">
                                        <p class="fs-14 opacity-1 line-height-16">Publicar en redes</p>
                                        <span id="publicarCIAF"></span>
                                    </div>
                                </div>
                                <div class="">
                                    <button class="btn btn-success" onclick="enviar()" id="btn2_participar"><i class="fa-solid fa-user-plus"></i> Quiero participar en la feria </button>
                                </div>
                            </div>

                            <div class="col-xl-5 col-12 mt-xl-0 mt-4">
                                <div class="row p-4" style="background-color: rgba(0,0,0,0.2)" id="formulario_emprendimiento">

                                <div class="col-12 mb-2 pb-2 borde-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="rounded bg-light-orange p-2 text-orange">
                                                <i class="fa-brands fa-wpforms"></i>
                                            </span> 
                                        
                                        </div>
                                        <div class="col-10 line-height-16">
                                            <span class="line-height-16">Formulario</span> <br>
                                            <span class="text-semibold fs-18">Emprendimiento</span> 
                                        </div>
                                    </div>
                                </div>

  
                                    <div class="col-12 p-0">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required class="form-control border-start-0 shopping_nombre" name="shopping_nombre" id="shopping_nombre" maxlength="40" onchange="javascript:this.value=this.value.toUpperCase();">
                                                <label>Nombre de tu stand</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-12 p-0">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating areatexto">
                                                <textarea placeholder="" class="form-control border-start-0 h-auto shopping_descripcion" rows="4" maxlength="150" name="shopping_descripcion" id="shopping_descripcion"></textarea>
                                                <label>Describe que productos o servicios ofrecerías</label>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right pb-4">
                                        <a onclick="editar('1')" class="btn btn-success ">Guardar</a>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="title">Agregar imagen (jpg) peso max 5mb</h6>
                                    </div>
                                    <form action="../controlador/shopping.php?op=subirArchivo" class="dropzone col-12" id="my-awesome-dropzone">
                                    </form>
                                    <div class="col-12">
                                        <h6 class="title">Agregar redes sociales</h6>
                                    </div>
                                    <div class="col-xl-9 col-8 p-0 m-0">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required class="form-control border-start-0" name="shopping_facebook" id="shopping_facebook" maxlength="40">
                                                <label>Facebook</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-3 col-4 m-0 p-0">
                                        <button class="btn btn-outline-light py-3" onclick="redes('1')"><i class="fa-solid fa-plus"></i> Facebook </button>
                                    </div>
                                    <div class="col-xl-9 col-8 p-0 m-0">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required class="form-control border-start-0" name="shopping_instagram" id="shopping_instagram" maxlength="40">
                                                <label>Instagram</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-3 col-4 m-0 p-0">
                                        <button class="btn btn-outline-light py-3" onclick="redes('2')"><i class="fa-solid fa-plus"></i> Instagram </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="col-12">
                    <div class="row listadoConceptos">

                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal" id="myModalEditar">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modalTitulo">Información</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resultado_editar"></div>
                </div>
            </div>
        </div>
    </div>
<?php
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<!-- Incluir Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<script src="scripts/shopping.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>