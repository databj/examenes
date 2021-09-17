<?php

$tema=TemaData::getById($_POST["tema"]);

echo $_POST["tema"];

$examen=new examenData();

$examen->examen= $_POST["nombre"];
$examen->examen= $_POST["fechainicio"];
$examen->examen= $_POST["fechafin"];

echo $_POST["nombre"];
echo $_POST["fechainicio"];
echo $_POST["fechafin"];

/*
$aux=$examen->add();

$examen->id_tema=$tema->id;


if($aux[0]==1){

    core::alert("Creacion de axamen exitosa");
   
    core::redir("./?view=Examen/View_ExamenPreguntas");
 
 }else{
 
    core::alert("Error al Modificar");
 
    core::redir("./?view=Examen/Add_Examen");
 }

?>*/

 


