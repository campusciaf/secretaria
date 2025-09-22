var programa_seleccionado;

function init() {
    $("#precarga").hide();

    $.post("../controlador/micarnet.php?op=selectProgramaCarnet", function (r) {
        $("#programa_carnet").html(r);
        $('#programa_carnet').selectpicker('refresh');
        programa_seleccionado = $("#programa_carnet").val();
        buscar(programa_seleccionado);
    });

    $('#programa_carnet').on('changed.bs.select', function () {
        programa_seleccionado = $(this).val();
        buscar(programa_seleccionado);
    });
}

function buscar() {
    $.post("../controlador/micarnet.php?op=buscar", { programa_seleccionado: programa_seleccionado }, function (e) {
        var r = JSON.parse(e);

        if (r.status === "ok") {
            $(".carnets").html(r.carnets);
            $(".convenios").html(r.convenios);

            setTimeout(() => {
                if (document.querySelector("#convenios-slider")) {
                    new Swiper("#convenios-slider", {
                        slidesPerView: 2,
                        spaceBetween: 20,
                        loop: true,
                        autoplay: {
                            delay: 2500,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            0: { slidesPerView: 1 },
                            768: { slidesPerView: 2 }
                        }
                    });
                }
            }, 100);
        } else {
            $(".carnets").html("");
            $(".convenios").html("");
            alertify.error("Error, no se encuentra el estudiante");
        }
    });
}

function imprime() {
    printJS({
        printable: 'carnet',
        type: 'html',
        targetStyles: ['*']
    });
}

function imprime2() {
    printJS({
        printable: 'carnet2',
        type: 'html',
        targetStyles: ['*']
    });
}

init();
