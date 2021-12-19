<?php
$user = UserData::getById($_SESSION["user_id"]);

$usuario_examen= $_POST["usuarioExamen"];

$respuestas = $_POST["respuesta"];
$preguntas = $_POST["preguntas"];
$idExamen = $_POST["id_examen"];

$usuarioRespuesta = new RespuestaUsuarioData();

foreach ($respuestas as $key => $val) {
    
    echo $usuarioRespuesta->id_usuario = $user->id;
    echo "<br>";
    echo $usuarioRespuesta->id_usuario_examen = $usuario_examen;
    echo "<br>";
    echo $usuarioRespuesta->id_pregunta = $preguntas[$key];
    echo "<br>";
    echo $usuarioRespuesta->id_respuesta = $val;
    
   $aux= $usuarioRespuesta->add();
   echo "<br>";
   echo $aux[0];
   echo "<br>";
   echo $aux[1];
    echo "<br>";

    echo "<br>";



   echo "<br>";

   

   echo "<br>";

   
    //echo "Pregunta: ". $preguntas[$key] ." respuesta: ". $val ."<br>";





}
