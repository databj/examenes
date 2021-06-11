<?php


$respuestas=$_POST["field_name"];
$tema=TemaData::getById($_POST["tema"]);

$pregunta=new PreguntaData();
$respuesta=new RespuestaData();

$pregunta->id_tema=$tema->id;

$pregunta->pregunta= $_POST["nombre"];


 $auxPregunta=$pregunta->add();



 $correcta=$_POST["correcta"];


foreach ($respuestas as $key => $respuestas) {



        if($key==$correcta){
            

           $respuesta->id_pregunta=$auxPregunta[1];
            $respuesta->estado=1;
            
            $respuesta->nombre=strval($respuestas);
           
        $respuesta->add();
        }else{
            $respuesta->id_pregunta=$auxPregunta[1];
            $respuesta->estado=0;
            
            $respuesta->nombre=$respuestas;
     
            $respuesta->add();
        }



}   


print "<script>window.location='index.php?view=Card';</script>";


/*
foreach ($correcta as $key => $correcta) {
    echo $correcta."<br>";
}
*/

?>