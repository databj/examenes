<?php

echo $_POST["id"];
$temas=TemaData::getById($_POST["id"]);
echo $temas->nombre = $_POST["nombre"];
$aux=$temas->update();
/*$temas=TemaData::getById($_POST["id"]);



echo $_POST["id"];

echo $temas->nombre = $_POST["nombre"];

$aux=$temas->update();*/

/*
if($aux[0]==1){

    core::alert("Tema Modificado");
   
    //core::redir("./?view=Tema/View_Tema");
 
}else{
 
    core::alert("Error al Modificar Tema");
 
    //core::redir("./?view=Tema/View_Tema");
}*/

?>