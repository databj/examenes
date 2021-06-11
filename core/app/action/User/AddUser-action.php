<?php


//CREAMOS EL OBJETO "USUARIO" PARA LUEGO PASARLE LOS PARAMETROS DEL POST
$user = new UserData();

//INSERCION DE LOS DATOS AL OBJETO 
$user->nombre = $_POST["nombre"];
$user->cc = $_POST["cedula"];

$user->user = $_POST["username"];
$user->pass = sha1(md5($_POST["password1"]));

if ($_POST["admin"] == "si") {
        $user->is_admin = 1;
} else {
        $user->is_admin = 0;
}



$val = UserData::getByIdCC($_POST["cedula"]);

if ($val == null) {


        $user->add(); //METODO PARA AÑADIR LOS DATOS A LA BD
        core::alert("Añadido con exito"); //mensaje de confirmacion
        print "<script>window.location='index.php?view=User/Mci_View_User';</script>"; //redireccion al index

} else {
        core::alert("EXISTE UN USUARIO CON ESTA IDENTIFICACION");
        print "<script>window.location='index.php?view=User/Mci_View_User';</script>"; //redireccion al index

}
       // $user->add();//METODO PARA AÑADIR LOS DATOS A LA BD
   




     // core::alert("Añadido con exito");//mensaje de confirmacion
     // print "<script>window.location='index.php?view=Mci_View_User';</script>";//redireccion al index
