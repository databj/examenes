<?php
class UsuarioExamenData
{
	public static $tablename = "usuarios_examen"; //id_examen EN LA BASE DE DATOS 


	public function UsuarioExamenData()
	{
		$this->id = "";
		$this->id_examen = null;
        $this->id_usuario = null;
	
		
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (id_examen,id_usuario) ";
		$sql .= "value (\"$this->id_examen\",\"$this->id_usuario\")";
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
		return Model::one($query[0], new UsuarioExamenData());
	}

	public static function getByIdCC($id)
	{
		$sql = "select * from " . self::$tablename . " where cc='" . $id . "'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new UsuarioExamenData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new UsuarioExamenData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where id_examen like '%$q%' or cc like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new UsuarioExamenData());
	}
}
