


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
            <form class="needs-validation" action="index.php?action=Examen/Add_Examen" method="post" novalidate>
                <div class="form-row">

                       <input  type="hidden" id="nombre" name="nombre" value="<?php echo $_POST["nombre"] ;?>" required>
                       
                       <input type="hidden" name="fechainicio" id="fechainicio" value="<?php echo $_POST["fechainicio"];?>" readonly="true" required />
                                       
                       <input type="hidden" name="fechafin" id="fechafin" value="<?php echo $_POST["fechafin"]; ?>" readonly="true" required />
                                       
                       <input type="hidden" name="tema" id="tema" value="<?php echo $_POST["tema"]; ?>" readonly="true" required />
                      
                      

                    <!--info oculta
            onkeypress="return ValidacionLetra(event);"
            -->
                    <!--input type="text" style="display: none" id="activo" name="activo" value="<?php //echo $activo=0;
                                                                                                    ?>" readonly="true"  required /-->


                    <?php $pregunta = PreguntaData::getByIdTema($_POST["tema"]); ?>

                    <div class="col-md-6 mb-3">
                        <p>Tema</p>
                        <select class="selectpicker form-control" data-hide-disabled="true" data-live-search="true" name="preguntas[]" id="preguntas" id="inputGroupSelect01" required  multiple >
                            <option> </option>

                            <?php
                            if (count($pregunta) > 0) {
                            ?>
                                <?php foreach ($pregunta as $pregunta) : ?>
                                    <option value="<?php echo $pregunta->id; ?>"><?php echo $pregunta->pregunta; ?></option>
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