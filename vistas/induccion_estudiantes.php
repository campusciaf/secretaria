<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inducción Estudiantes</title>
    <link rel="stylesheet" href="../public/css/main.css" />
    <link rel="stylesheet" href="../public/css/main2.css"/>
    <link rel="icon" type="image/png" href="../public/favicon/favicon-96x96.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/alertify/css/themes/default.css" />
	<link rel="stylesheet" href="../public/alertify/css/alertify.min.css" />
    <script src="../public/alertify/alertify.min.js"></script>
    <!-- jQuery -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
</head>
<body class="precarga">
    <!-- Wrapper -->
	<div id="wrapper">
    <!-- Principal -->
        <section id="principal">
            <header>
                <h1>CIAF</h1>
                <p>Inducción Estudiantil</p>
            </header>
            <hr />
            <h2>Comencemos</h2>
            <form id="form_induccion" method="post" action="#">
                <div class="fields">
                    <div class="field">
                        <input type="text" style="text-align: center; text-transform: capitalize;" name="identificacion" id="identificacion" placeholder="Identificación" required/>
                    </div>
                    <div class="field">
                        <input type="text" style="text-align: center; text-transform: capitalize;" name="nombre" id="nombre" placeholder="Nombre Completo" required/>
                    </div>
                    <div class="field">
                        <select style="text-align-last: center; text-transform: capitalize;" name="programa" id="programa" required>
                            <option value="soft">Ingeniería de Software</option>
                            <option value="sst">Seguridad y Salud en el Trabajo</option>
                            <option value="admon">Administración de Empresas</option>
                            <option value="cont">Contaduría Pública</option>
                        </select>
                    </div>
                    <div class="field">
                        <input type="text" style="text-align: center; text-transform: capitalize;" name="inspirador" id="inspirador" placeholder="Nombre de quién te inspiró" required/>
                    </div>
                    <div class="field">
                        <input type="text" style="text-align: center; text-transform: capitalize;" name="parentesco" id="parentesco" placeholder="Parentesco con tu inspirador" required />
                    </div>
                </div>
                <ul class="actions special">
                    <li><input type="submit" class="button" name="boton_inducciones" value="INICIAR" id="boton_inducciones"></a></li>
                </ul>
            </form>
            <hr />
        </section>
        <footer class="principal-footer" style="color: white;">
            <strong style="color: white;">Copyright © 2019-2022 <a href="https://www.ciaf.edu.co">CIAF</a>.</strong> All rights reserved.
        </footer>
</div>
<script src="../vistas/scripts/induccion_estudiantes.js"></script>
</body>
</html>


