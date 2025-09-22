$(document).ready(incio);
function incio() {
$("#precarga").hide();	
$("#programas").hide();	
	
}

function buscar() {
    var data = ({
        'cedula': $("#identificacion").val()
    });

    $.ajax({
        url: "../controlador/eliminar_estudiante.php?op=buscar",
        type: "POST",
        data: data,
        cdataType: 'json',
        success: function (datos) {
            var r = JSON.parse(datos);
            if (r.status == 'ok') {
                alertify.success("Estudiante encontrado con exito");
                if (r.tipo == '1') {
                    $("#precarga").hide();
                    $("#programas").hide();
                    $("#imprime").html(r.result);
                    $('#tbl_notas').removeClass("hide");
                    /* imprimimos las columnas de la tabla dependiendo de la cantidad de corte */
                    if (r.todo.ciclo == "1" || r.todo.ciclo == "2") {
                        $("#aggCortes").html('<th scope="col">Asignatura</th><th scope = "col" > Nota1</th ><th scope="col">Nota2</th><th scope="col">Nota3</th><th scope="col">Final</th><th scope="col">Periodo</th>');
                        console.log(12);
                    } else {
                        if (r.todo.ciclo == "4") {
                            $("#aggCortes").html('<th scope="col">Asignatura</th><th scope = "col" > Nota1</th ><th scope="col">Final</th><th scope="col">Periodo</th>');
                            console.log(4);
                        }
                    }
                    /* ------------------------------------------------------------------------------- */
                    consultaMateria(r.todo.id_estudiante, r.todo.ciclo);
                } else {
                    var html = "";
                    $("#programas").show();
                    $("#tbl_notas").addClass("hide");
                    $("#imprime").html("");
                    for (var index = 0; index < r.todo.length; index++) {
                        html += '<option value="' + r.todo[index].id_estudiante +'" >' + r.todo[index].fo_programa+'</option>';
                        //$('#ButtonName').attr('onClick', 'FunctionName(this);');
                    }
                    $(".aggProgramas").html(html);
                }
                
            } else {
                alertify.error("Error al encontrar el estudiante");
                $("#imprime").html("");
                $("#informacion").html("");
            }
        }
    });
}

function consultaPrograma() {
    var data = ({
        'id': $(".aggProgramas").val()
    });

    $("#precarga").show();
    $.ajax({
        url: "../controlador/eliminar_estudiante.php?op=consultaPrograma",
        type: "POST",
        data: data,
        cdataType: 'json',
        success: function (datos) {
            var r = JSON.parse(datos);
            if (r.status == 'ok') {
                alertify.success("Estudiante encontrado con exito");
                $("#precarga").hide();
                $("#programas").show();
                $("#imprime").html(r.result);
                $('#tbl_notas').removeClass("hide");

                if (r.todo.ciclo == "1" || r.todo.ciclo == "2") {
                    $("#aggCortes").html('<th scope="col">Asignatura</th>< th scope = "col" > Nota1</th ><th scope="col">Nota2</th><th scope="col">Nota3</th><th scope="col">Final</th><th scope="col">Periodo</th>');
                } else {
                    if (r.todo.ciclo == "4") {
                        $("#aggCortes").html('<th scope="col">Asignatura</th><th scope = "col" > Nota1</th ><th scope="col">Final</th><th scope="col">Periodo</th>');
                    }
                }
                consultaMateria(r.todo.id_estudiante, r.todo.ciclo);


            } else {
                alertify.error("Error al encontrar el estudiante");
                $("#imprime").html("");
            }
        }

        
    });


}

function consultaMateria(id,ciclo) {
    $('#tbl_notas').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            "dom": "tp",
            "ajax":
            {
                url: '../controlador/eliminar_estudiante.php?op=listarMateria&id='+id+'&ciclo='+ciclo,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
			
		"bDestroy": true,
		"iDisplayLength": 20,//Paginación

	// funcion para cambiar el responsive del data table	

         'select': 'single',

         'drawCallback': function (settings) {
            api = this.api();
            var $table = $(api.table().node());
            
            if ($table.hasClass('cards')) {

               // Create an array of labels containing all table headers
               var labels = [];
               $('thead th', $table).each(function () {
                  labels.push($(this).text());
               });

               // Add data-label attribute to each cell
               $('tbody tr', $table).each(function () {
                  $(this).find('td').each(function (column) {
                     $(this).attr('data-label', labels[column]);
                  });
               });

               var max = 0;
               $('tbody tr', $table).each(function () {
                  max = Math.max($(this).height(), max);
               }).height(max);

            } else {
               // Remove data-label attribute from each cell
               $('tbody td', $table).each(function () {
                  $(this).removeAttr('data-label');
               });

               $('tbody tr', $table).each(function () {
                  $(this).height('auto');
               });
            }
         }
		
		
		
      });
	
	
		var width = $(window).width();
		if(width <= 750){
			$(api.table().node()).toggleClass('cards');
			api.draw('page');
		}
		window.onresize = function(){

			 anchoVentana = window.innerWidth;
				if(anchoVentana > 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else if(anchoVentana > 750 && anchoVentana < 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else{
				  $(api.table().node()).toggleClass('cards');
					api.draw('page');
				}
		}
		// ****************************** //
	
$("#precarga").hide();		
		
}

function eliminarEstudiante(id, ciclo, cedula, id_programa_ac) {
    /* console.log("EStudiante: " + id + " ciclo: "+ciclo); */

    var data = ({
        'id':id,
        'ciclo':ciclo,
        'cedula':cedula,
        'programa': id_programa_ac
    });

    alertify.confirm('Eliminar Estudiante', 'Desea Eliminar al estudiante. Se eliminaran notas, datos personales y programa.', function () {
        $.ajax({
            url: "../controlador/eliminar_estudiante.php?op=deleteEstudiante",
            type: "POST",
            data: data,
            cdataType: 'json',
            success: function (datos) {
                //console.log(datos);
                var r = JSON.parse(datos);
                if (r.status == 'ok') {
                    alertify.success("Programa del estudiante eliminada con exito");
                    //$("#precarga").addClass("hide");
                    buscar();
                } else {
                    alertify.error("Error al eliminar el programa del estudiante");
                }
            }
        });
    }
    ,function () { alertify.error('Cancel') });
}

function eliminarPrograma(id, ciclo) {
    /* console.log("Programa: " + id + " ciclo: " + ciclo); */
    var data = ({
        'id':id,
        'ciclo':ciclo
    });
    alertify.confirm('Eliminar programa del estudiante', 'Desea elimnar el programa del estudiante. Se eliminaran notas y el programa seleccionado.', function () {
        $.ajax({
            url: "../controlador/eliminar_estudiante.php?op=deletePrograma",
            type: "POST",
            data: data,
            cdataType: 'json',
            success: function (datos) {
                var r = JSON.parse(datos);
                if (r.status == 'ok') {
                    alertify.success("Programa del estudiante eliminada con exito");
                    //$("#precarga").addClass("hide");
                    buscar();
                } else {
                    alertify.error("Error al eliminar el programa del estudiante");
                }
            }
        });

        alertify.success('Ok') 
    }
    ,function () { alertify.error('Cancel') });



   
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
                title: 'Eliminar Estudiante',
                intro: "Bienvenido a nuestro modulo donde podrás eliminar definitivamente a un ser original de todo nuestro sistema"
            },
          
            
            
            
            

        ]
            
    },
    console.log()
    
    ).start();

}