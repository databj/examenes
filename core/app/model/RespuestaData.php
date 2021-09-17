<?php
class RespuestaData
{
	public static $tablename = "respuesta"; //id_pregunta EN LA BASE DE DATOS 


	public function RespuestaData()
	{
		$this->id = "";
		$this->id_pregunta = null;
		$this->estado = null;
		$this->nombre = null;

		
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (id_pregunta,estado,nombre) ";
		$sql .= "value (\"$this->id_pregunta\",\"$this->estado\",\"$this->nombre\")";
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
		return Model::one($query[0], new RespuestaData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new RespuestaData());
	}

	public static function getByIdPregunta($id)
	{
		$sql = "select * from " . self::$tablename . " where id_pregunta=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new RespuestaData());
	}


}
