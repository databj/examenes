<!-- Scrollable Table Start -->
<!--================================-->
<div class="col-md-12 col-lg-12">
   <div class="card mg-b-12">
      <div class="card-header">
         <h4 class="card-header-title">
            Usuarios
         </h4>
         <div class="card-header-btn">
            <a href="new-vendedor.html" data-toggle="añadir" class="btn card-add"><i class="ion-android-add"></i></a>
            <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse7" aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
            <a href="#" data-toggle="refresh" class="btn card-refresh"><i class="ion-android-refresh"></i></a>
            <a href="#" data-toggle="expand" class="btn card-expand"><i class="ion-android-expand"></i></a>
            <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
         </div>
      </div>
      <div class="card-body pd-0 collapse show" id="productSalesDetails">
         <div>
            <div class="table-responsive">


               <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm " cellspacing="0" width="100%">
                  <thead class="tx-dark tx-uppercase tx-10 tx-bold">
                     <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cedula</th>
                      
                        <th>User</th>
                        <th>Acciones</th>

                     </tr>

                  </thead>
                  <tbody>
                     <?php
                     $clientes = UserData::getAll();
                     ?>

                     <?php
                     if (count($clientes) > 0) {
                     ?>


                        <?php foreach ($clientes as $cliente) : ?>

                           <tr>

                              <td><?php echo $cliente->id; ?></td>
                              <td><?php echo $cliente->nombre; ?></td>
                              <td><?php echo $cliente->cc; ?></td>
                             
                              <td><?php echo $cliente->user; ?></td>

                              <td class="text-center table-actions">
                                 <div class="btn-group mg-t-10">

                                    <form action="index.php?view=User/Mci_Edit_User" method="post">
                                       <input type="hidden" name="id" value=<?php echo $cliente->id; ?>>
                                       <button class="btn btn-secondary" type="submit"><i class="fa fa-pencil" style="color: yellow"></i></button>
                                    </form>


                                    <form action="index.php?action=User/DelUser" method="post">
                                       <input type="hidden" name="id" value=<?php echo $cliente->id; ?>>
                                       <button class="btn btn-secondary" onclick="return pregunta()" style="color: red"><i class="fa fa-trash"></i></button>
                                    </form>

                                    <form action="index.php?view=User/View_Profile" method="post">
                                       <input type="hidden" name="id" value=<?php echo $cliente->id; ?>>
                                       <button class="btn btn-secondary" style="color: white"><i class="fa fa-eye"></i></button>
                                    </form>

                                 </div>
                              </td>




                           </tr>
                        <?php endforeach; ?>
                     <?php } ?>

                  </tbody>

                  <tfoot>
                     <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cedula</th>
                      
                        <th>User</th>

                        <th>Acciones</th>

                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>





</div>
<!--/ Scrollable Table End -->

