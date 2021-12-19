<?php

$tema=TemaData::getById($_POST["tema"]);

$examen=new examenData();

$examen->nombre= $_POST["nombre"];
$examen->fecha_inicio=date_format(date_create($_POST["fechainicio"]), 'Y-m-d H:i:s');
$examen->fecha_fin= date_format(date_create($_POST["fechafin"]), 'Y-m-d H:i:s');



$idExamen=$examen->add();

 $idExamen[1];

$preguntas= $_POST["preguntas"];

foreach($preguntas as $preguntas){

   $preguntasExamen=new PreguntaExamenData();
   $preguntasExamen->id_examen= $idExamen[1];
   $preguntasExamen->id_pregunta=$preguntas;

   $aux=$preguntasExamen->add();

  
}

/*

if($aux[0]==1){

    core::alert("Creacion de axamen exitosa");
   
    core::redir("./?view=Examen/View_ExamenPreguntas");
 
 }else{
 
    core::alert("Error al Modificar");
 
    core::redir("./?view=Examen/Add_Examen");
 }

?>*/

core::redir("./?view=Card");
 


