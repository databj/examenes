<?php

$examen= ExamenData::getbyId($_POST["examen"]);

$estudiantes= $_POST["estudiante"];


foreach($estudiantes as $estudiantes){

$usuario_Examen=new UsuarioExamenData();

echo $usuario_Examen->id_examen=$examen->id;
echo $usuario_Examen->id_usuario=$estudiantes;

$usuario_Examen->add();

  
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

 


