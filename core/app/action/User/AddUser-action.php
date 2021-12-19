<?php


//CREAMOS EL OBJETO "USUARIO" PARA LUEGO PASARLE LOS PARAMETROS DEL POST
$user = new UserData();

//INSERCION DE LOS DATOS AL OBJETO 
ECHO $user->nombre = $_POST["nombre"];
echo $user->cc = $_POST["cedula"];

echo $user->user = $_POST["username"];
echo $user->pass = sha1(md5($_POST["password1"]));

if ($_POST["admin"] == "si") {
       echo  $user->is_admin = 1;
} else {
      echo  $user->is_admin = 0;
}



//$val = UserData::getByIdCC($_POST["cedula"]);



     $aux=   $user->add(); //METODO PARA AÑADIR LOS DATOS A LA BD
     echo $aux[1]; 
    //    print "<script>window.location='index.php?view=User/Mci_View_User';</script>"; //redireccion al index



     // core::alert("Añadido con exito");//mensaje de confirmacion
     // print "<script>window.location='index.php?view=Mci_View_User';</script>";//redireccion al index
