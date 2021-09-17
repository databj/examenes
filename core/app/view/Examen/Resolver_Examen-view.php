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
                    <?php
                    $user = UserData::getById($_SESSION["user_id"]);


                    $usuarioExamen = UsuarioExamenData::getByIdUser($user->id);
                    if ($usuarioExamen) {
                        echo $usuarioExamen->id;
                        $examen = ExamenData::getById($usuarioExamen->id);
                        $preguntas_examen = PreguntaExamenData::getByIdExamen($examen->id);
                    }
                    ?>
                    <!--info oculta
            onkeypress="return ValidacionLetra(event);"
            -->
                    <!--input type="text" style="display: none" id="activo" name="activo" value="<?php //echo $activo=0;
                                                                                                    ?>" readonly="true"  required /-->
                    <?php
                    if ($usuarioExamen) {

                        foreach ($preguntas_examen as $preguntas_examen) {

                            $pregunta = PreguntaData::getById($preguntas_examen->id_pregunta);





                    ?>
                            <div class="col-md-6 mb-3">
                                <label for="nombre">Pregunta</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="pregunta" name="pregunta" placeholder="Ingrese su nombre" value="<?php echo $pregunta->pregunta; ?>" required disabled>
                                <div class="valid-feedback">
                                   preguntas
                                </div>
                                <div class="invalid-feedback">
                                preguntas
                                </div>
                            </div>


                            <?php $respuesta = RespuestaData::getByIdPregunta($pregunta->id); ?>

                            <div class="col-md-6 mb-3">
                                <p>Seleccion Respuesta</p>
                                <select class="selectpicker form-control" data-hide-disabled="true" data-live-search="true" name="respuesta" id="respuesta" id="inputGroupSelect01" required>
                                    <option> </option>

                                    <?php
                                    if (count($respuesta) > 0) {
                                    ?>
                                        <?php foreach ($respuesta as $respuesta) : ?>
                                            <option style="width: 1px;" value="<?php ?>"><?php $respuesta->nombre;  ?></option>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </select>
                            </div>



                    <?php
                        }
                    }
                    ?>


                </div>
                <button class="btn btn-custom-primary" type="submit">Enviar</button>
            </form>
        </div>
    </div>
</div>