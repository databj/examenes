<div class="col-md-12 col-lg-12">
    <div class="card mg-b-20">
        <div class="card-header">
            <h4 class="card-header-title">
                Ingrese una pregunta
            </h4>
            <div class="card-header-btn">
                <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse7" aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                <a href="#" data-toggle="refresh" class="btn card-refresh"><i class="ion-android-refresh"></i></a>
                <a href="#" data-toggle="expand" class="btn card-expand"><i class="ion-android-expand"></i></a>
                <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
            </div>
        </div>
        <div class="card-body collapse show" id="collapse7">
            <form class="needs-validation" action="index.php?action=Pregunta/Add" method="post" novalidate>
                <div class="form-row">

                    <!--info oculta-->
                    <!--input type="text" style="display: none" id="activo" name="activo" value="<?php //echo $activo=0;?>" readonly="true"  required /-->
                    <!--   ---------------------------                         ----------------------     -->
                    <?php
                    $tema = TemaData::getAll();
                    ?>

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

                    <!--   ---------------------------                         ----------------------     -->

                    <div class="col-md-6 mb-3">
                        <p>Pregunta</p>
                        <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese Pregunta " value="" required>
                        <div class="valid-feedback">
                            Tema valido
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese un tema
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <a href="javascript:void(0);" id="add" class="btn btn-secondary" title="Add field">Añadir Mas Respuestas</a>

                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="card mg-b-20">


                            <div class="card-body collapse show" id="collapse4">


                                <div class="col-md-12 mb-3" name="listar">

                                    <div>
                                        <center>

                                            <div class="col-md-12 mb-3">

                                                <div class="custom-control custom-radio">
                                                    <input name="correcta" type="radio" value="0">
                                                    <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="preguntas" name="field_name[]" placeholder="Ingrese Respuesta " value="" required>
                                                </div>
                                            </div>
                                    </div>
                                </div>          
                            </div>


                        </div>
                    </div>
                </div>
                <button class="btn btn-custom-primary" type="submit">Enviar</button>
            </form>
        </div>
    </div>
</div>