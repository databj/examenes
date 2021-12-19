<?php
class RespuestaUsuarioData
{
	public static $tablename = "respuesta_usuario"; //id_pregunta EN LA BASE DE DATOS 


	public function RespuestaUsuarioData()
	{
		$this->id = "";
		$this->id_pregunta = null;
		$this->id_usuario_examen = null;
		$this->id_respuesta = null;
	
		
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (id_pregunta,id_usuario_examen,id_respuesta) ";
		$sql .= "value (\"$this->id_pregunta\",\"$this->id_usuario_examen\",\"$this->id_respuesta\")";
		return Executor::doit($sql);
	}



	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		return	Executor::doit($sql);
	}
	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id=$this->id";
		return	Executor::doit($sql);
	}

	// partiendo de que ya tenemos creado un objecto ClienteData previamente utilizamos el contexto


	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new RespuestaUsuarioData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new RespuestaUsuarioData());
	}



}
