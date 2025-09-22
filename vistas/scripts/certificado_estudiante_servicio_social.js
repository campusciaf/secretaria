$(document).ready(incio);
function incio() {
  disableRightClickAndKeys();
  detectDevToolsAndResize();
  printOnLoadBackgroundImage();


}

function disableRightClickAndKeys() {
  // Bloquear clic derecho para inspección
  $(document).on("contextmenu", function (e) {
    e.preventDefault();
  });

  // Bloquear teclas relacionadas con inspección
  $(document).on("keydown", function (e) {
    if (
      e.keyCode === 123 || // F12
      (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
      (e.ctrlKey && e.shiftKey && e.keyCode === 74) || // Ctrl+Shift+J
      (e.ctrlKey && e.keyCode === 85) // Ctrl+U
    ) {
      e.preventDefault();
    }
  });
}

function detectDevToolsAndResize() {
  // Detectar si el usuario abre las herramientas de desarrollo
  const threshold = 160;
  setInterval(() => {
    if (
      window.outerWidth - window.innerWidth > threshold ||
      window.outerHeight - window.innerHeight > threshold
    ) {
      window.close();
    }
  }, 1000);

  // Detectar cambios de tamaño en el viewport
  let previousWidth = window.innerWidth;
  let previousHeight = window.innerHeight;
  setInterval(() => {
    if (
      window.innerWidth !== previousWidth ||
      window.innerHeight !== previousHeight
    ) {
      window.close();
    }
  }, 1000);
}
function printOnLoadBackgroundImage() {
  const backgroundImageUrl = "../public/img/fondo_servicios_social.png";
  $("<img/>")
    .attr("src", backgroundImageUrl)
    .on("load", function () {
      $(this).remove();
      window.print();
    })
    .on("error", function () {
      window.print();
    });

  // Detectar si el cuadro de impresión se cierra
  window.onafterprint = function () {
    setTimeout(() => {
      window.close();
    }, 100);
  };
}

// function buscar_contrato_docente(usuario_identificacion) {

//     console.log(usuario_identificacion);
// 	$.post("../controlador/contratacion_docente.php?op=buscar_contrato_docente", { "usuario_identificacion": usuario_identificacion }, function (data) {
//         console.log(data);
// 		data = JSON.parse(data);
// 	});
// }

