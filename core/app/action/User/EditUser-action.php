<?php



$user = UserData::getById($_POST["id"]); //LLAMAMOS AL CONSTRUCTOR PARA CREAR EL OBJETO DE LA CLASE "USER"

//PASAMOS LOS PARAMETROS DE CADA UNO DE LOS POST QUE SE TRAEN DESDE LA VISTA 


$user->pass = sha1(md5($_POST["password1"]));


$var =   $user->update(); //LLAMAMOS AL METODO QUE HACE LA ACTUALIZACION DE LOS DATOS 



core::alert("Añadido con exito"); //mensaje de confirmacion
print "<script>window.location='index.php?view=Card';</script>";//redireccion al index
