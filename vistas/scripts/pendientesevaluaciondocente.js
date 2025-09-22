$(document).ready(inicio);
function inicio() {
    listarescuelas()
}
function listarescuelas(){
    $("#precarga").show();

           
           $.post("../controlador/pendientesevaluaciondocente.php?op=listarescuelas",{}, function(r){
               var e = JSON.parse(r);

               $("#escuelas").html(e.mostrar);
               $("#precarga").hide();
           });
}

function listar(id_escuela,boton) {
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

    $("#precarga").show();
    $.post("../controlador/pendientesevaluaciondocente.php?op=listar&id_escuela="+id_escuela, function (datos) {
        var r = JSON.parse(datos);
        $("#listar").html(r.conte);
        $("#tbl_listar").DataTable({
            "dom": 'Bfrtip',
            buttons: [{
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel" style="color: green"></i>',
                titleAttr: 'Excel',
                title: 'Reporte Septiembre',
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-alt"></i>',
                titleAttr: 'CSV'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                title: 'Estudiantes Pendientes',
                titleAttr: 'Print'
            },],
            "pageLength": 20,
            //"order": false,
            'initComplete': function (settings,json) {
                $("#precarga").hide();
                var contador=0;
                while(contador < 6){
                    if(boton==0){$("#boton0").addClass('button-active')}else{$("#boton0").removeClass('button-active');};
                    if(boton==1){$("#boton1").addClass('button-active')}else{$("#boton1").removeClass('button-active');};
                    if(boton==2){$("#boton2").addClass('button-active')}else{$("#boton2").removeClass('button-active');};
                    if(boton==3){$("#boton3").addClass('button-active')}else{$("#boton3").removeClass('button-active');};
                    if(boton==4){$("#boton4").addClass('button-active')}else{$("#boton4").removeClass('button-active');};
                    if(boton==5){$("#boton5").addClass('button-active')}else{$("#boton5").removeClass('button-active');};
                    if(boton==6){$("#boton6").addClass('button-active')}else{$("#boton6").removeClass('button-active');};
                    contador++;
                }
                
            },
        });
    });
}