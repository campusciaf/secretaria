<!DOCTYPE html>
<?php
require "config/Conexion.php";
//consulta para colocarle la credencial a la tabla estudiante
// nota para esta consulta debemos quitarle las d a las cédulas
global $mbd;
$stmt = $mbd->prepare('SELECT * FROM videos_intro WHERE estado= "1"');
$stmt->execute();
$videos = array();
while ($datos = $stmt->fetch()) {
    $nombre = $datos["nombre"];
    array_push($videos, $nombre);
}
$maximo = (count($videos));
$limite = rand(0, $maximo - 1);
?>
<!-- Google Tag Manager -->
<script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-M9V2KQ4');
</script>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Virtual</title>
    <link rel="icon" href="public/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" media="all" href="public/css/particulas.css" /> <!-- estilo para las particulas -->
    <link rel="stylesheet" href="public/dist/css/adminlte.min.css?001">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="public/css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }
    </style>
    <script type="text/javascript">
        // Please don't use this code on your site, use your own GA code
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-7243260-2']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <style>
        .button {
            display: inline-block;
            border-radius: 7px;
            border: none;
            background: #001550;
            color: white;
            font-family: inherit;
            text-align: center;
            font-size: 18px;
            width: 100%;
            padding: 10px;
            transition: all 0.4s;
            cursor: pointer;
        }

        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.4s;
        }

        .button span:after {
            content: 'al campus';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.7s;
        }

        .button:hover span {
            padding-right: 90px;
        }

        .button:hover span:after {
            opacity: 4;
            right: 0;
        }
    </style>
</head>

<body>
    <div id="precarga" class="precarga"></div>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M9V2KQ4" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- muestra la imagen del banner en el campus -->
    <div class="lado-a">
        <div class="lado-a-mostrar-banner">
        </div>
        <div class="container">
            <div>
                <?php
                for ($i = 0; $i < 100; $i++) {
                ?>
                    <div class="circle-container">
                        <div class="circle"></div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="lado-a-pie d-none">
            <p class="" style="color: #fff;">
                <img src="public/img/logo-cc.png" style="width: 30px"> Creatividad para un mundo en evolución<br><br>
                <img src="public/img/vigilado-horizontal.webp" width="80px">
            </p>
        </div>
    </div>
    <div class="row login-lado-b">
        <div class="formulario-login">
            <div class="col-xl-12 text-center mb-4 line-height-24 ">
                <a href="index.php" class="logo text-1 fs-48">
                    <div><img src="public/img/logo-azul.png" width="100px" alt=""></div>
                </a>
            </div>
            <form method="post" id="frmAcceso" name="frmAcceso" class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="email" name="logina" id="logina" placeholder="" required="" class="form-control border-start-0">
                                <label>Correo CIAF</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="password" name="clavea" id="clavea" placeholder="" required="" class="form-control border-start-0" autocomplete="on">
                                <label>Clave</label>
                                <div class="mostrar">
                                    <!-- <span toggle="#clavea" class="fa fa-fw fa-eye field-icon toggle-password" title="Mostrar contraseña"></span> -->
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select name="roll" id="roll" required="" class="form-control border-start-0 selectpicker" data-live-search="true">
                                    <option value="Funcionario">Funcionario</option>
                                    <option value="Docente">Docente</option>
                                    <option value="Estudiante">Estudiante</option>
                                </select>
                                <label>Entrar como:</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-xl-12 mt-2">
                        <button type="submit" class="button" style="vertical-align:middle"><span>Ingresar</span></button>
                    </div>
                    <div class="col-xl-12 pt-2">
                        <div class="row">
                            <div class="col-6">
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-link text-azul">
                                    <i class="fas fa-caret-right text-azul"></i> Recuperar clave
                                </a>
                            </div>
                            <div class="col-6">
                                <a onclick="mostrarmodalsolicitarayuda()" href="#" class="btn btn-link"><u>Solicitar ayuda</u></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <!-- <a onclick="mostrar_video_induccion()" href="#">¿Como ingresar?</a> -->
                        <button type="button" class="btn bg-7 text-white" data-toggle="modal" data-target="#modal_video">
                            <i class="fab fa-youtube"></i> ¿Como ingresar?
                        </button>
                    </div>
                </div>
            </form>
            <div class="redes col-12">
                <p>Estamos en </p>
                <a href="https://api.whatsapp.com/send?phone=573143400100" target="_blank">
                    <i class="fab fa-whatsapp text-success"></i>
                </a>
                <a href="https://www.instagram.com/comunidadciaf/" target="_blank">
                    <i class="fab fa-instagram text-azul"></i>
                </a>
                <a href="https://www.facebook.com/ComunidadCIAF" target="_blank">
                    <i class="fab fa-facebook text-azul"></i>
                </a>
                <a href="https://twitter.com/ComunidadCIAF" target="_blank">
                    <i class="fab fa-twitter text-azul"></i>
                </a>
                <a href="https://www.youtube.com/channel/UCgaRVYt3yzzlhbLZ1vhxCUQ" target="_blank">
                    <i class="fab fa-youtube  text-azul"></i>
                </a>
                <a href="#" target="_blank">
                    <i class="fab fa-linkedin-in  text-azul"></i>
                </a>
                <a href="https://mail.google.com/a/ciaf.edu.co" target="_blank">
                    <i class="far fa-envelope  text-azul"></i>
                </a>
                <hr>
                <img src="public/img/colombia.webp"> <span class="fs-12">Cra. 6 No.24 - 56 - Pereira - Colombia</span>
            </div>
        </div>
    </div>
    <!-- Modal recuperar contraseña-->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Recuperar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="formulario_clave">
                        <form method="post" id="formularioenviarlink" name="formularioenviarlink">
                            <div class="row">
                                <div class="group col-xl-12">
                                    <input maxlength="60" name="email_link" id="email_link" type="email" required />
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Correo CIAF</label>
                                </div>
                                <div class="campo-select col-xl-12">
                                    <select name="roll_link" id="roll_link" class="campo">
                                        <option value="funcionario"> Funcionario </option>
                                        <option value="docente"> Docente </option>
                                        <option value="estudiante"> Estudiante </option>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Soy:</label>
                                </div>
                                <div class="col-12">
                                    <input type="submit" value="Recuperar clave" class="btn bg-1 text-white btn-block">
                                </div>
                                <div class="col-12 text-center">
                                    <span class="text-info small">* Revisar el Spam para recuperar la clave </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalSolicitarAyuda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: scroll ;">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Solicitar Ayuda</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formulariosolicitarayuda" name="formulariosolicitarayuda">
                        <div class="group col-xl-12">
                            <input maxlength="60" name="correo_ciaf" id="correo_ciaf" type="email" required />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Correo CIAF</label>
                        </div>
                        <div class="group col-xl-12">
                            <input maxlength="60" name="celular" id="celular" type="number" required />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Celular</label>
                        </div>
                        <div class="group col-xl-12">
                            <input maxlength="60" name="asunto" id="asunto" type="text" required />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Asunto</label>
                        </div>
                        <label for="exampleFormControlTextarea1">Breve descripción del problema</label>
                        <div class="group col-xl-12">
                            <textarea class="form-control" name="mensaje" id="mensaje" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <input type="submit" value="Enviar Mensaje" class="btn bg-1 text-white btn-block">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_video" tabindex="-1" aria-labelledby="modal_video" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_video">¿Como ingresar al campus virtual?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="formulariovervideo" id="formulariovervideo" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <iframe src="https://www.youtube.com/embed/dLMKugcQRhE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width: 780px; height: 450px;"></iframe>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="public/plugins/jquery/jquery.min.js"></script>
    <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/dist/js/adminlte.js"></script>
    <script type="text/javascript" src="vistas/scripts/login.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
</body>

</html>