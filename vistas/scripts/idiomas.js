$(document).ready(inicio);
var nivel_global;
var valor_global;
var texto_materias_global;
function inicio() {
    listar_niveles();
    $("#formularionovedadjornada").on("submit", function (e2) {
        actualizarCambioJornada(e2);
    });
    $.post("../controlador/idiomas.php?op=selectJornada", function (r) {
        $("#jornada_e").html(r);
        $("#jornada_e").selectpicker("refresh");
    });
    $("#precarga").hide();
}
function listar_niveles() {
    $.post("../controlador/idiomas.php?op=listar", function (dato) {
        var r = JSON.parse(dato);
        $(".card-title").html(r.nivel);
        nivel_global = r.nivel;
        valor_global = r.valor;
        texto_materias_global = r.texto_materias_g;
        $("#conte").html(r.conte);
        /* $("#conte_modales").html(r.modal); */
        seleccionarchexbox();
        $('[data-toggle="tooltip"]').tooltip();
        $("#checkbox_1").attr("disabled", false);
    });
}
function seleccionarchexbox() {
    let checkboxes = document.querySelectorAll(".nivel-checkbox");
    let lastPaidCheckboxIndex = -1;
    checkboxes.forEach((checkbox, index) => {
        let isPaid = checkbox.getAttribute("data-paid") === "true";
        if (isPaid) {
            checkbox.disabled = true;
            lastPaidCheckboxIndex = index;
        }
        checkbox.addEventListener("change", function () {
            actualizarValorTotal();
            // Si el checkbox actual está marcado y no es el último, habilita el siguiente
            if (checkbox.checked && index < checkboxes.length - 1) {
                checkboxes[index + 1].disabled = false;
            }
            // Si desmarcas cualquier checkbox, desmarca y deshabilita todos los siguientes
            if (!checkbox.checked) {
                for (let i = index + 1; i < checkboxes.length; i++) {
                    checkboxes[i].checked = false;
                    checkboxes[i].disabled = true;
                    $("#nivel_cantidad").val(0);
                }
            }
            // Actualiza el estado del botón de pagar basado en el estado del primer checkbox
            $("#btnPagar").attr("disabled", !checkboxes[0].checked);
            // Actualiza el listado marcado
            let listado_marcado = "";
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    let materiaParts = checkboxes[i]
                        .getAttribute("data-materia")
                        .split(" ");
                    let materia = materiaParts[materiaParts.length - 1];
                    listado_marcado += materia + ", ";
                }
            }
            listado_marcado = listado_marcado.substring(
                0,
                listado_marcado.length - 2
            );
            $("#texto_materias").val(listado_marcado);
        });
    });
}

function generarBotones() {
    $("#precarga").show();
    nivel_cantidad = $("#nivel_cantidad").val();
    texto_materias = $("#texto_materias").val();
    jornada = $("#jornada_e").val();
    texto_materias_global = texto_materias;
    $("#modulos_seleccionados").html(texto_materias);
    $("#nivel_globalid").html("$ " + valor_global * nivel_cantidad);
    $.post(
        "../controlador/idiomas.php?op=generarBotones",
        {
            nivel_cantidad: nivel_cantidad,
            texto_materias: texto_materias,
            nivel_global: nivel_global,
            valor_global: valor_global,
            jornada: jornada,
        },
        function (e) {
            datos = JSON.parse(e);
            $(".botones_epayco").html(datos.info);
            $("#precarga").hide();
        }
    );
}
function actualizarValorTotal() {
    let total = 0;
    cantidadMarcados = 0;
    let checkboxes = document.querySelectorAll(".nivel-checkbox");
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            total += parseFloat(checkbox.getAttribute("data-valor"));
            cantidadMarcados++;
        }
    });
    document.getElementById("checkbox_indices").textContent =
        cantidadMarcados > 0 ? cantidadMarcados : "";
    $("#nivel_cantidad").val(cantidadMarcados);
}

//funcion para darle el valor a la posicion de la tabla del modal de pagos
function mostrarValorNivel(levelId) {
    $("#nivel_ingles").text(levelId);
}

//Función actualizar la jornada
function cambiarJornadaEpayco(jornada) {
    generarBotones();
}
