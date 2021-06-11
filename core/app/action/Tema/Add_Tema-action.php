<?php

$tema= new TemaData();

$tema->nombre=$_POST["nombre"];

$aux=$tema->add();


if($aux[0]==1){

    core::alert("Tema Registrado");
   
    core::redir("./?view=Tema/View_Tema");
 
}else{
 
    core::alert("Error al Registrar Tema");
 
    core::redir("./?view=Tema/View_Tema");
}

?>