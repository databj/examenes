<?php

// define('LBROOT',getcwd()); // LegoBox Root ... the server root
// include("core/controller/Database.php");

if(!isset($_SESSION["user_id"])) {//SI SE CREA UNA INSTANCIA DE UNA SESION 


                         
			$user = $_POST['username'];//TRAEMOS LO DIGITADO EN EL CAMPO DE USUARIO
			$pass = sha1(md5($_POST['password']));  //PARA CODIFICAR LA CONTRASEÑA
			//$pass=$_POST['password'];//TRAEMOS LOS DATOS DEL CAMPO DE LA CONTRASEÑA 

			$base = new Database();//CREAMOS UN OBJETO DE LA CONEXION A LA BASE DE DATOS 

			$con = $base->connect();// HACEMOS LA CONEXION 

			$sql = "select * from usuario where user=\"".$user."\" and pass= \"".$pass."\" ";
			//VERIFICAMOS QUE SE ENCUENTRE EN LA BASE DE DATOS 

			//print $sql;
			$query = $con->query($sql);
			$found = false;
			$userid = null;
			while($r = $query->fetch_array()){
				$found = true ;
				$userid = $r['id'];//AÑADIMOS EL ID DE LA BD AL ID DE LA VARIABLE LOCAL PARA CREAR LA SESION 
				
			}
		


				if($found==true) {
					$userRevisar = UserData::getById($userid);
					//	session_start();
					//	print $userid;
						$_SESSION['user_id']=$userid ;
					//	setcookie('userid',$userid);
					//	print $_SESSION['userid'];
					print "<script>window.location='index.php?view=Card';</script>";

				}else {
				
					?>
					<script>alert("USUARIO O CONTRASEÑA INCORRECTA");</script>
					<?php
				
						print "<script>window.location='index.php?view=Card';</script>";
				

				}

}else{
	
		print "<script>window.location='index.php?view=Card';</script>";
	
}
?>