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
            <form class="needs-validation" action="index.php?action=Examen/Add_EstudianteExamen" method="post" novalidate>
                <div class="form-row">

                    <!--info oculta
            onkeypress="return ValidacionLetra(event);"
            -->
                    <!--input type="text" style="display: none" id="activo" name="activo" value="<?php //echo $activo=0;
                                                                                                    ?>" readonly="true"  required /-->

                    <?php $examen = ExamenData::getAll(); ?>

                    <div class="col-md-6 mb-3">
                        <p>Examen</p>
                        <select class="selectpicker form-control" data-hide-disabled="true" data-live-search="true" name="examen" id="examen" id="inputGroupSelect01" required>
                            <option> </option>

                            <?php foreach ($examen as $examens) : ?>
                                <option value="<?php echo $examens->id; ?>"><?php echo $examens->nombre; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>


                    <?php $estudiante = UserData::getAll();

                    ?>

                    <div class="col-md-6 mb-3">
                        <p>estudiante</p>
                        <select class="selectpicker form-control" data-hide-disabled="true" data-live-search="true" name="estudiante[]" id="estudiante" id="inputGroupSelect01" required multiple>
                            <option> </option>

                          
                            <?php foreach ($estudiante as $estudiantes) :
                                if ($estudiantes->is_admin == 0) {
                            ?>
                                    <option  value="<?php echo $estudiantes->id; ?>"><?php echo $estudiantes->nombre; ?></option>
                            <?php
                                }
                            endforeach; ?>
                           
                        </select>
                    </div>


                </div>
                <button class="btn btn-custom-primary" type="submit">Enviar</button>
            </form>
        </div>
    </div>
</div>