<?php
class TemaData
{
	public static $tablename = "tema"; //NOMBRE EN LA BASE DE DATOS 


	public function TemaData()
	{
		$this->id = "";
		$this->nombre = null;
	
		
	}



	public function add()
	{
		$sql = "insert into tema (nombre) ";
		$sql .= "value (\"$this->nombre\")";
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
    public function update(){
		$sql = "update ".self::$tablename." set 
        nombre=\"$this->nombre\" 
        where id=$this->id";
		return Executor::doit($sql);
	}




	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new TemaData());
	}

	public static function getByIdCC($id)
	{
		$sql = "select * from " . self::$tablename . " where cc='" . $id . "'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new TemaData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new TemaData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where nombre like '%$q%' or cc like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new TemaData());
	}
}
