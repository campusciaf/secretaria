const formatter = new Intl.NumberFormat('en-US', { "style": 'currency', "currency": 'USD', "minimumFractionDigits": 0 });
//Función que se ejecuta al inicio
function init() {
    listarConceptos();
    $('#gestionPago').on('hidden.bs.modal', function (event) {
        $(".conceptos_pago_nombre").text("");
        $(".conceptos_pago_valor").text("");
        $(".conceptos_pago_nombre").text("");
        $(".id_conceptos_pago").text("");
    })
}
function listarConceptos() {
    $.post("../controlador/pagogeneral.php?op=listarConceptos", function (datos) {
        datos = JSON.parse(datos);
        html = "";
        datos.forEach(element => {
            html += `
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="card mb-4 text-center border-0">
                            <div class="card-body p-xl-3 p-xxl-4">
                                <h4 class="mb-1 fs-14">`+ element.conceptos_pago_nombre + `</h4>
                                <h1 class="fs-24 titulo-2 text-semibold line-height-16"> `+ formatter.format(element.conceptos_pago_valor) + `</h1>
                                <p class="text-secondary fs-12">C/U</p>
                                <br>
                                <button class="btn btn-outline-success" onclick="gestionPago('`+ element.id_conceptos_pago + `')">Pagar</button>
                            </div>
                        </div>
                    </div>`;
        });
        $(".listadoConceptos").html(html);
        $(".precarga").hide();
    });
}
function gestionPago(id_conceptos_pago) {
    $(".precarga").show();
    $.post("../controlador/pagogeneral.php?op=gestionPago", {"id_conceptos_pago": id_conceptos_pago},function (element) {
        element = JSON.parse(element);
        $(".conceptos_pago_nombre").val(element.conceptos_pago_nombre);
        $(".conceptos_pago_valor").val(formatter.format(element.conceptos_pago_valor));
        $(".id_conceptos_pago").val(element.id_conceptos_pago);
        $('.cantidad_productos').attr('onchange', 'calcularValor(`' + element.id_conceptos_pago +'`, this.value)');
        $("#gestionPago").modal("show");
        $(".precarga").hide();
    });
}
function calcularValor(id_conceptos_pago, cantidad_productos) {
    $.post("../controlador/pagogeneral.php?op=calcularValor", { "id_conceptos_pago": id_conceptos_pago, "cantidad_productos" : cantidad_productos }, function (element) {
        element = JSON.parse(element);
        $(".conceptos_pago_valor").val(formatter.format(element.conceptos_pago_valor));
        mostrarBotonesEpayco();
    });
}
function mostrarBotonesEpayco(){
    var medio_pago = $('#medio_pago').val();
    if (medio_pago == 'pse' || medio_pago == 'efectivo') {
        $(".precarga").show();
        var formData = new FormData($("#datos_boton_epayco")[0]);
        $.ajax({
            "url": "../controlador/pagogeneral.php?op=mostrarBotonesEpayco",
            "type": "POST",
            "data": formData,
            "contentType": false,
            "processData": false,
            success: function (element) {
                element = JSON.parse(element);
                $('.boton_epayco').html(element.boton_epayco);
                $(".precarga").hide();
            }
        });
    }
}

function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Horarios',
				intro: 'Módulo para consultar los horarios por salones creados en el periodo actual.'
			},
			{
				title: 'Docente',
				element: document.querySelector('#t-programa'),
				intro: "Campo de opciones que contiene los nombres de los salones activos en plataforma para consultar."
			},

		]
			
	},
	console.log()
	
	).start();

}
init();