<?php




$user = new UserData(); //CREAMOS EL OBJETO DEL CUAL SE LLAMARA EL METODO PARA ELIMINAR 

$var = $user->delById($_POST["id"]); //METODO DEL OBJETO DE LA CLASE USER PARA ELIMINAR PASANDO COMO PARAMETRO EL ID QUE SE TRAE DESDE LA VISTA 



if ($var[0] == 1) {
    core::alert("Eliminado con exito"); //MENSAJE DE CONFIRMACION
    print "<script>window.location='index.php?view=User/Mci_View_User';</script>"; //NOS LLEVA AL INICIO

} else {
    core::alert("Error al Eliminar"); //MENSAJE DE CONFIRMACION
    print "<script>window.location='index.php?view=User/Mci_View_User';</script>"; //NOS LLEVA AL INICIO

}
