<div class="col-md-12 col-lg-12">
    <div class="card mg-b-20">
        <div class="card-header">
            <h4 class="card-header-title">
                Editar Usuario
            </h4>
            <div class="card-header-btn">
                <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse4" aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                <a href="#" data-toggle="refresh" class="btn card-refresh"><i class="ion-android-refresh"></i></a>
                <a href="#" data-toggle="expand" class="btn card-expand"><i class="ion-android-expand"></i></a>
                <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
            </div>
        </div>




        <div class="card-body collapse show" id="collapse4">
            <?php
            $clientes = UserData::getById($_POST["id"]);
            ?>

            <form class="form-horizontal" method="post" id="addproduct" action="index.php?action=User/EditUser" role="form">

                <input type="hidden" name="id" id="id" value="<?php echo $clientes->id; ?>" readonly="true" required />

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <p>Nombre Completo</p>
                        <div class="input-group mb-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><i class="fa fa-user"></i></span>
                            </div>
                            <input disabled type="text" class="form-control" name="nombre" id="nombre" placeholder="Username" value="<?php echo $clientes->nombre; ?>" aria-label="Username" aria-describedby="basic-addon3">
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <p>Numero de Cedula</p>
                        <div class="input-group mb-6">
                            <input disabled type="text" class="form-control" name="cedula" value="<?php echo $clientes->cc; ?>" id="cedula" aria-label="Amount (to the nearest dollar)">
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
                            <input disabled type="text" class="form-control" placeholder="Email" name="email" value="<?php echo $clientes->email; ?>" id="email" aria-label="email" aria-describedby="basic-addon1">
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <p>Telefono</p>
                        <div class="input-group mb-6">
                            <input disabled type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $clientes->telefono; ?>" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">#</span>
                            </div>

                        </div>

                    </div>



                    <div class="col-md-6 mb-3">
                        <p>Rol</p>

                        <select disabled class="custom-select" name="rol" id="rol" id="inputGroupSelect01">
                            <option selected>Administrador</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>


                    <div class="col-md-6 mb-3">
                        <p>User</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">UserName</span>
                            </div>
                            <input disabled type="text" class="form-control" placeholder="User" name="username" value="<?php echo $clientes->user; ?>" id="username" aria-label="User" aria-describedby="basic-addon1">
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">
                        <p>Password</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Password</span>
                            </div>
                            <input type="Password" class="form-control" placeholder="Password" name="password1" id="password1" aria-label="Password" aria-describedby="basic-addon1">
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">
                        <p>Password</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Confirm Password</span>
                            </div>
                            <input type="Password" class="form-control" placeholder="Password" name="password2" id="password2" aria-label="Password" aria-describedby="basic-addon1">
                        </div>

                    </div>



                    <div class="col-md-6 mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom03">Admin</label>
                        </div>

                        <div class="col-md-4 mg-t-20 mg-lg-t-0">
                            <div class="custom-control custom-radio">
                                <input disabled name="rdio2" type="radio" class="custom-control-input" checked="" id="radio1">
                                <label class="custom-control-label" for="radio1">Si</label>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="custom-control custom-radio">
                                <input disabled name="rdio2" type="radio" class="custom-control-input" id="radio2">
                                <label class="custom-control-label" for="radio2">No</label>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom03">Activo</label>
                        </div>

                        <div class="col-md-4 mg-t-20 mg-lg-t-0">
                            <div class="custom-control custom-radio">
                                <input disabled name="rdio" type="radio" class="custom-control-input" checked="" id="radio3">
                                <label class="custom-control-label" for="radio3">Si</label>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="custom-control custom-radio">
                                <input disabled name="rdio" type="radio" class="custom-control-input" id="radio4">
                                <label class="custom-control-label" for="radio4">No</label>
                            </div>
                        </div>

                    </div>





                    <div class="col-md-6 mb-3">
                        <button class="btn btn-custom-primary" type="submit">Confirmar</button>
                    </div>





                </div>

            </form>

        </div>
    </div>


</div>
