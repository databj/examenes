<?php
class PreguntaData
{
	public static $tablename = "pregunta"; //id_tema EN LA BASE DE DATOS 


	public function PreguntaData()
	{
		$this->id = "";
		$this->id_tema = null;
        $this->pregunta = null;
	
		
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (id_tema,pregunta) ";
		$sql .= "value (\"$this->id_tema\",\"$this->pregunta\")";
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
	public function update()
	{
		$sql = "update pregunta set pass='" . $this->pass . "' where id='" . $this->id . "'";
		return	Executor::doit($sql);
	}




	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PreguntaData());
	}

	public static function getByIdCC($id)
	{
		$sql = "select * from " . self::$tablename . " where cc='" . $id . "'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PreguntaData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new PreguntaData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where id_tema like '%$q%' or cc like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PreguntaData());
	}
}
