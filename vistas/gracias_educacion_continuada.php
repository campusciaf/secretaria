<?php
session_start();
$panel = ($_SESSION["roll"] == "Continuada") ? "panel_continuada.php" : (($_SESSION["roll"] == "Funcionario") ? "panel_admin.php" : (($_SESSION["roll"] == "Docente") ? "panel_docente.php" : "panel_estudiante.php"));
echo $_SESSION["roll"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Compra realizada con exito </title>
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
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="apple-touch-icon" sizes="57x57" href="../public/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../public/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../public/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../public/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../public/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../public/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../public/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../public/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../public/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="../public/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../public/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../public/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../public/favicon/favicon-16x16.png">
	<link rel="manifest" href="../public/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../public/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image:url(../public/img/fondo_gracias_ec.webp) ; background-size: cover;">
	<div class="vh-100 d-flex justify-content-center align-items-center">
		<div class="col-md-4">
			<div class="border border-3 border-success"></div>
			<div class="card  bg-white shadow p-5">
				<div class="mb-4 text-center">
					<svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
						<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
						<path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
					</svg>
				</div>
				<div class="text-center">
					<h1>¡Muchas Gracias por tu compra!</h1>
					<p> En <span id="segundos"> 5 </span> segundos serás redireccionado automáticamente al panel.</p>
					<a href="<?= $panel ?>" class="btn btn-outline-success">Volver a la web.</a>
				</div>
			</div>
		</div>
	</div>
	<script>
		
		function restarSegundos() {
			div_segundos = document.getElementById("segundos");
			segundos = parseInt(div_segundos.textContent);
			segundos--;
			if (segundos == 0) {
				window.location.href = "<?="https://ciaf.digital/vistas/".$panel?>";
			}
			div_segundos.innerHTML = segundos;
		}

		setInterval("restarSegundos()", 1000);
	</script>
</body>

</html>