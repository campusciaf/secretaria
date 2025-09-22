function init() {
  $("#precarga").show();
  //cargarTablero();// carga tablero powerbi
}

function cargarTablero() {
  $.post("../controlador/pb-rematricula.php?op=cargar", function (r) {
    let json;
    try {
      json = (typeof r === "string") ? JSON.parse(r) : r;
    } catch (e) {
      console.error("Respuesta no JSON:", r);
      $("#precarga").hide();
      return alert("Error: respuesta inválida del servidor.");
    }

    if (!json.ok) {
      $("#precarga").hide();
      return alert(json.msg || "No se pudo cargar el tablero.");
    }

    const { embedUrl, embedToken } = json.data || {};
    if (!embedUrl || !embedToken) {
      $("#precarga").hide();
      return alert("Configuración incompleta para embeber Power BI.");
    }

    const models = window['powerbi-client'].models;
    const config = {
      type: 'report',
      tokenType: models.TokenType.Embed,
      accessToken: embedToken,
      embedUrl: embedUrl,
      settings: {
        panes: {
          filters: { visible: false },
          pageNavigation: { visible: true }
        }
      }
    };

    const container = document.getElementById('reportContainer');
    const report = powerbi.embed(container, config);

    report.on('loaded',  () => $("#precarga").hide());
    report.on('error',   (ev) => {
      console.error(ev.detail);
      $("#precarga").hide();
      alert('Ocurrió un error al renderizar el reporte.');
    });
  })
  .fail(function(xhr) {
    console.error("Fail:", xhr?.responseText || xhr);
    $("#precarga").hide();
    alert("No se pudo comunicar con el servidor.");
  });
}

init();
