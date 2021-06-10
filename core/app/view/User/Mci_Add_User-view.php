<div class="col-md-12 col-lg-12">
    <div class="card mg-b-20">
        <div class="card-header">
            <h4 class="card-header-title">
                Añadir Usuario
            </h4>
            <div class="card-header-btn">
                <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse4" aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                <a href="#" data-toggle="refresh" class="btn card-refresh"><i class="ion-android-refresh"></i></a>
                <a href="#" data-toggle="expand" class="btn card-expand"><i class="ion-android-expand"></i></a>
                <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
            </div>
        </div>




        <div class="card-body collapse show" id="collapse4">


            <form class="form-horizontal" method="post" id="addproduct" action="index.php?action=User/AddUser" role="form">



                <div class="row">

                    <div class="col-md-6 mb-3">
                        <p>Nombre Completo</p>
                        <div class="input-group mb-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Username" aria-label="Username" aria-describedby="basic-addon3" required>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <p>Numero de Cedula</p>
                        <div class="input-group mb-6">
                            <input type="text" class="form-control" name="cedula" id="cedula" aria-label="Amount (to the nearest dollar)" required>
                            <div class="input-group-append">
                                <span class="input-group-text">#</span>
                            </div>

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">
                        <p>Email</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Email" name="email" id="email" aria-label="email" aria-describedby="basic-addon1" required>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <p>Telefono</p>
                        <div class="input-group mb-6">
                            <input type="text" class="form-control" name="telefono" id="telefono" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">#</span>
                            </div>

                        </div>

                    </div>



                    <div class="col-md-6 mb-3">
                        <p>Rol</p>

                        <select class="custom-select" name="rol" id="rol" id="inputGroupSelect01">
                            <option selected>ADMINISTRADOR</option>
                            <option>EMPRESA</option>
                            <option>GERENTE</option>
                            <option>GERENTE OPERACIONES</option>
                            <option>SUPERVISOR DE ALMACEN</option>
                            <option>SUPERVISOR DE OPERACIONES LAVADO</option>
                            <option>JEFE DE TALLER</option>
                            <option>JEFE DE FACTURACION</option>
                            <option>ASESOR VIP</option>
                            <option>CONCIERGE</option>
                            <option>EMPRESA</option>
                        </select>
                    </div>


                    <div class="col-md-6 mb-3">
                        <p>User</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">UserName</span>
                            </div>
                            <input type="text" class="form-control" placeholder="User" name="username" id="username" aria-label="User" aria-describedby="basic-addon1" required>
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">
                        <p>Password</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Password</span>
                            </div>
                            <input type="Password" class="form-control" placeholder="Password" name="password1" id="password1" aria-label="Password" aria-describedby="basic-addon1" required>
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <p>Password</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Confirm Password</span>
                            </div>
                            <input type="Password" class="form-control" placeholder="Password" name="password2" id="password2" aria-label="Password" aria-describedby="basic-addon1" required>
                        </div>

                    </div>



                    <div class="col-md-6 mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="">Admin</label>
                        </div>

                        <div class="col-md-4 mg-t-20 mg-lg-t-0">
                            <div class="custom-control custom-radio">
                                <input name="admin" type="radio" value="si">
                                <label>Si</label>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="custom-control custom-radio">
                                <input name="admin" checked="" type="radio" value="no">
                                <label>No</label>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="col-md-4 mb-3">
                            <label>Activo</label>
                        </div>

                        <div class="col-md-4 mg-t-20 mg-lg-t-0">
                            <div class="custom-control custom-radio">
                                <input name="activo" checked="" type="radio" value="si">
                                <label>Si</label>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="custom-control custom-radio">
                                <input name="activo" type="radio" value="no">
                                <label>No</label>
                            </div>
                        </div>

                    </div>


                    <!--   ---------------------------                         ----------------------     -->
                    <?php
                    $clientes = EmpresaData::getAll();
                    ?>

                    <div class="col-md-6 mb-3">
                        <p>Dueño de Empresa</p>

                        <select class="selectpicker form-control" data-hide-disabled="true" data-live-search="true" name="empresa" id="empresa" id="inputGroupSelect01">
                            <option selected> </option>

                            <?php
                            if (count($clientes) > 0) {
                            ?>



                                <?php foreach ($clientes as $cliente) : ?>

                                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nombre; ?></option>

                                <?php endforeach; ?>
                            <?php } ?>


                        </select>
                    </div>

                    <!--   ---------------------------                         ----------------------     -->



                    <div class="col-md-6 mb-3">
                        <p>Confirmar </p>
                        <button class="btn btn-custom-primary" onclick="return pregunta2()" type="submit">Confirmar</button>
                    </div>





                </div>

            </form>

        </div>
    </div>


</div>
