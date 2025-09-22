$(document).ready(inicio);
function inicio() {
    mostrarJornada();
    semestre();
    listarProgramas();
    $("#formulario").on("submit", function (e) {
        e.preventDefault();
        consulta();
		
    });
	$("#precarga").hide();
	$("#cortes").hide();

    $.post("../controlador/gestionparciales.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
}

function mostrarJornada() {

    $.post("../controlador/verificardiciones.php?op=mostrarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $('.jornada').html(opti);
        $('.jornada').selectpicker();
        $('.jornada').selectpicker('refresh');
    });

}

function semestre() {
    var opti = "";
    opti += '<option selected></option>';
    opti += '<option value="Ninguno">Ninguno</option>';
    for (let i = 1; i <= 12; i++) {
        opti += '<option value="' + i + '">' + i + '</option>';
    }
    $('.semestre').html(opti);
    $('.semestre').selectpicker();
    $('.semestre').selectpicker('refresh');
}

function listarProgramas() {
    $.post("../controlador/listarcategoria.php?op=listarProgra", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
        }
        $(".programa").append(opti);
        $('.programa').selectpicker();
        $('.programa').selectpicker('refresh');
    });
}

function consulta() {
    $("#precarga").show();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/gestionparciales.php?op=consulta",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".conte").html(r.conte);
            $(".table").DataTable({
                'initComplete': function (settings, json) {
                    $("#precarga").hide();
                },

            });
            $("#cortes").show();
        }
    });
}

function cambiarestado(id_docente,medio,columna) {
    //console.log(medio);
    
    if (medio == "1") {
        titulo = " Activar corte";
        titulo2 = " ¿Desea activar el corte?";
    } else {
        titulo = " Desactivar corte";
        titulo2 = " ¿Desea desactivar el corte?";
    }

    alertify.confirm(titulo, titulo2, function () {
        var data = ({
            'docente': id_docente,
            'medio': medio,
            'columna': columna
        });
        $.post("../controlador/gestionparciales.php?op=cambiarestado", data, function (datos) {
            // console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success('Ok');
                consulta();
            } else {
                alertify.error(r.status)
            }
        });
         
    }
        , function () { alertify.error('Cancel') }).set({ labels: { ok: 'Si', cancel: 'No' }, padding: false });
    
}

function estadoTodos() {
    //$("#precarga").removeClass("hide");
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/gestionparciales.php?op=cambiartodo",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                consulta();
                //$("#precarga").addClass('hide');
                alertify.success("El estado cambio con exito");
                $(".val").val("Estado...");
            } else {
                alertify.error(r.status);
            }
        }
    });

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
				title: 'Gestión de parciales',
				intro: "Bienvenido a nuestra gestión de parciales de todos nuestros programas activos en nuestra institución"
			},
		
		
			
		]
			
	},
	// console.log()
	
	).start();

}