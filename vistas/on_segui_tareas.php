<div id="ingreso" class="col-12 text-center" ></div>
<div id="agregarContenido" class="row m-0 p-0 mb-4"></div>

<div class="row">
<div class="col-xl-6 col-lg-6 col-md-12 col-12">
    <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST" class="card p-0 m-0">
        <div class="col-12">
            <div class="row p-0 borde-bottom">
                <div class="col-12 p-2">
                    <div class="row align-items-center">
                        <div class="pl-4">
                            <span class="rounded bg-light-green p-2 text-success ">
                                <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Registrar un</span> <br>
                                <span class="text-semibold fs-20">Seguimiento</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id_estudiante_agregar" id="id_estudiante_agregar" value="">
        <div class="form-group col-lg-12 p-4">
            <span id="contador">150 Caracteres permitidos</span>
            <textarea class="form-control" name="mensaje_seguimiento" id="mensaje_seguimiento" maxlength="150" placeholder="Escribir Seguimiento" rows="6" required onKeyUp="cuenta()"></textarea>
        </div>
        <div class="form-group col-lg-12 px-4">
            <div class="radio">
                <label><input type="radio" name="motivo_seguimiento" id="motivo_seguimiento" value="Cita" required>Cita</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="motivo_seguimiento" value="Llamada">Llamada</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="motivo_seguimiento" value="Seguimiento">Seguimiento</label>
            </div>


            <!-- <div class="radio">
                <label><input type="radio" name="motivo_seguimiento" value="Compromiso" >Compromiso</label>
            </div> -->
        </div>
        <div class="col-12 p-4">
            <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save"></i> Registrar</button>
        </div>
    </form>
</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12">
    <form name="formularioTarea" id="formularioTarea" method="POST" class="card  m-0 p-0">

        <div class="col-12">
            <div class="row p-0 borde-bottom">
                <div class="col-12 p-2">
                    <div class="row align-items-center">
                        <div class="pl-4">
                            <span class="rounded bg-light-red p-2 text-danger ">
                                <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Programar una</span> <br>
                                <span class="text-semibold fs-20">Tarea</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="id_estudiante_tarea" id="id_estudiante_tarea" value="">
        <div class="col-12 pt-4" id="contadortarea">
            150 Caracteres permitidos
        </div>
        <div class="col-12">
            <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="150" placeholder="Escribir Mensaje" rows="6" required="" onkeyup="cuentatarea()"></textarea>
        </div>
        <div class="col-12 px-4">
            <div class="row col-12 m-0 p-0">
                <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                    <label>Dia:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                        </div>
                        <input type="date" name="fecha_programada" id="fecha_programada" class="form-control" required="">
                    </div>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                    <label>Hora:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                        </div>
                        <input type="time" name="hora_programada" id="hora_programada" class="form-control" required="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 px-4">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="customRadio4" name="motivo_tarea" value="cita" required="">
                <label class="custom-control-label" for="customRadio4">Cita</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="customRadio5" name="motivo_tarea" value="llamada" required="">
                <label class="custom-control-label" for="customRadio5">Llamada</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="customRadio6" name="motivo_tarea" value="seguimiento" required="">
                <label class="custom-control-label" for="customRadio6">Seguimiento</label>
            </div>
        </div>

        <div class="col-12 p-4">
            <input type="submit" value="Programar Tarea" id="btnGuardarTarea" name="enviar tareas" class="btn btn-danger">
        </div>

    </form>
</div>

</div>