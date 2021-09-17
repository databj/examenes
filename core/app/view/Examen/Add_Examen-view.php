<div class="col-md-12 col-lg-12">
    <div class="card mg-b-20">
        <div class="card-header">
            <h4 class="card-header-title">
                Registre Los Datos Del Cliente
            </h4>
            <div class="card-header-btn">
                <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse7" aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                <a href="#" data-toggle="refresh" class="btn card-refresh"><i class="ion-android-refresh"></i></a>
                <a href="#" data-toggle="expand" class="btn card-expand"><i class="ion-android-expand"></i></a>
                <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
            </div>
        </div>
        <div class="card-body collapse show" id="collapse7">
            <form class="needs-validation" action="index.php?view=Examen/Select_Preguntas" method="post" novalidate>
                <div class="form-row">

                    <!--info oculta
            onkeypress="return ValidacionLetra(event);"
            -->
                    <!--input type="text" style="display: none" id="activo" name="activo" value="<?php //echo $activo=0;
                                                                                                    ?>" readonly="true"  required /-->

                    <div class="col-md-6 mb-3">
                        <label for="nombre">Examen</label>
                        <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" value="" required>
                        <div class="valid-feedback">
                            Examen valido
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese un Examen
                        </div>
                    </div>


                    <div class="col-md-4 mb-4" id=fecha name=fecha>
                        <label for="cc">Ingrese Fecha inicio </label>
                        <div class="input-group">
                            <div class="input-group-prepend" class="accordion-icon fa fa-calendar-o">
                            </div>
                            <input type="text" id="fechainicio" name="fechainicio" class="form-control datepicker-here" placeholder="Ingrese fecha" data-timepicker="true" data-time-format="hh:ii ">
                            <div class="invalid-feedback">
                                por favor ingrese una fecha.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4" id=fecha name=fecha>
                        <label for="cc">Ingrese Fecha fechafin </label>
                        <div class="input-group">
                            <div class="input-group-prepend" class="accordion-icon fa fa-calendar-o">
                            </div>
                            <input  type="text" id="fechafin" name="fechafin" class="form-control datepicker-here" placeholder="Ingrese fecha" data-timepicker="true" data-time-format="hh:ii ">
                            <div class="invalid-feedback">
                                por favor ingrese una fecha.
                            </div>
                        </div> 
                    </div>


                    <?php $tema = TemaData::getAll(); ?>

                    <div class="col-md-6 mb-3">
                        <p>Tema</p>
                        <select class="selectpicker form-control" data-hide-disabled="true" data-live-search="true" name="tema" id="tema" id="inputGroupSelect01" required>
                            <option> </option>

                            <?php
                            if (count($tema) > 0) {
                            ?>
                                <?php foreach ($tema as $tema) : ?>
                                    <option style="width: 1px;" value="<?php echo $tema->id; ?>"><?php echo $tema->nombre; ?></option>
                                <?php endforeach; ?>
                            <?php } ?>
                        </select>
                    </div>


                </div>
                <button class="btn btn-custom-primary" type="submit">Enviar</button>
            </form>
        </div>
    </div>
</div>