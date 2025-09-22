<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = "16";
    require 'header_estudiante.php';
?>
    <div id="precarga" class="precarga"></div>


<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16 pl-4">
                        <span class="titulo-2 fs-18 text-semibold">Mi perfil</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>

            </div>
        </div>
    </div>
    <section class="content mx-2">
        
            <div class="row m-0">

            

                <div class="mostrar-uno col-xl-12"></div>

                <div class="col-xl-3 pl-4" id="ajuste"></div>
            

                <div class="col-xl-3 pl-4 tono-2 borde-right pt-4 " id="menuperfil">

                    <div class="row">
                        <div class="col-12 timeline align-items-center">
                            <div class="py-3 pl-3" id="caract-1">
                                <span class="coin" id="coin-perfil"><img src="../public/img/coin.webp"> <span class="text-danger"> 40 pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-address-card"></i> </span>
                                <a onclick="mostrarform(1)" class="fs-16 pointer font-weight-bolder">
                                    Mis datos de contacto  
                                </a>
                            </div>
                            <div class="py-3 pl-3" id="caract-2">
                                <span class="coin" id="coin-seres"><img src="../public/img/coin.webp"> <span class="text-danger"> 30 pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-user"></i> </span>
                                <a onclick="mostrarform(2), listarPreguntas()" class="fs-16 pointer font-weight-bolder">
                                    Mis datos personales 
                                </a>
                            </div>
                            <div class="py-3 pl-3" id="caract-3">
                                <span class="coin" id="coin-empleo"><img src="../public/img/coin.webp"> <span class="text-danger"> 30 pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-briefcase"></i> </span>
                                <a onclick="mostrarform(3), listarPreguntas3()" class="fs-16 pointer font-weight-bolder">
                                    Empleabilidad 
                                </a>
                            </div>
                            <div class="py-3 pl-3" id="caract-4">
                                <span class="coin" id="coin-ingresos"><img src="../public/img/coin.webp"> <span class="text-danger"> 30 pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-money-bill"></i> </span>
                                <a onclick="mostrarform(4), listarPreguntas4()" class="fs-16 pointer font-weight-bolder">
                                    Mis ingresos 
                                </a>
                            </div>
                            <div class="py-3 pl-3" id="caract-5">
                                <span class="coin" id="coin-academica"><img src="../public/img/coin.webp"> <span class="text-danger"> 30pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-school"></i></span>
                                <a onclick="mostrarform(5), listarPreguntas5()" class="fs-16 pointer font-weight-bolder">
                                    Información académica 
                                </a>
                            </div>
                            <div class="py-3 pl-3" id="caract-6">
                                <span class="coin" id="coin-bienestar"><img src="../public/img/coin.webp"> <span class="text-danger"> 40pts </span></span>
                                <span class="bg-8 p-2 rounded-circle mr-2"><i class="fa-solid fa-heart-pulse"></i> </span>
                                <a onclick="mostrarform(6), listarPreguntas6()" class="fs-16 pointer font-weight-bolder">
                                    Bienestar institucional
                                </a>
                            </div>

                        </div>
                    </div>
                            

                </div>

                <div class="col-xl-9 px-4 tono-2 pt-4" id="form1">
                    <form class="guardarDatosPersonales" id="guardarDatosPersonales" method="POST"></form>
                </div>

                

                <div class="col-xl-9 px-4 tono-2 pt-4" id="form2">
                    <form name="formulariodatos" id="formulariodatos" method="POST" class="row">
                        <div class="col-xl-12" id="preguntas"></div>
                    </form>
                </div>

                <div class="col-xl-9 px-4 tono-2 pt-4" id="form3">
                    <form name="formulariodatos3" id="formulariodatos3" method="POST" class="row">
                        <div class="col-xl-12" id="preguntas3"></div>
                    </form>
                </div>

                <div class="col-xl-9 px-4 tono-2 pt-4" id="form4">
                    <form name="formulariodatos4" id="formulariodatos4" method="POST" class="row">
                        <div class="col-xl-12" id="preguntas4"></div>
                    </form>
                </div>

                <div class="col-xl-9 px-4 tono-2 pt-4" id="form5">
                    <form name="formulariodatos5" id="formulariodatos5" method="POST" class="row">
                        <div class="col-xl-12" id="preguntas5"></div>
                    </form>
                </div>

                <div class="col-xl-9 px-4 tono-2 pt-4" id="form6">
                    <form name="formulariodatos6" id="formulariodatos6" method="POST" class="row">
                        <div class="col-xl-12" id="preguntas6"></div>
                    </form>
                </div>

        </div>
    </section>

</div>



    <!-- modal restablecer contraseña -->
    <div class="modal" id="restrablecer" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm "role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestionar la contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="guardarDatos" id="form2" method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Contraseña anterior</label>
                            <input type="password" name="anterior" id="anterior" class="form-control" required>
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="form-group confirmaCampodos">
                            <label for="exampleInputPassword1">Nueva contraseña</label>
                            <input type="password" name="nueva" id="nueva" class="form-control" required>
                        </div>
                        <div class="form-group confirmaCampo">
                            <label for="exampleInputPassword1">Confirmar contraseña</label>
                            <input type="password" name="confirma" id="confirma" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success guardarDatos btn-block">Cambiar contraseña</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<!--Fin-Contenido-->
<?php
    require 'footer_estudiante.php';
}
ob_end_flush();
?>
<script src='../public/js/sly.min.js'></script> <!-- calendario de ventos -->
<script type="text/javascript" src="scripts/configurarcuentaestudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>