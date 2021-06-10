<?php
class CalificacionData
{
	public static $tablename = "calificacion"; //nota EN LA BASE DE DATOS 


	public function CalificacionData()
	{
		$this->id = "";
		$this->nota = null;
        $this->id_examen = null;

	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (nota,id_examen) ";
		$sql .= "value (\"$this->nota\",\"$this->id_examen\")";
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
		$sql = "update calificacion set pass='" . $this->pass . "' where id='" . $this->id . "'";
		return	Executor::doit($sql);
	}




	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new CalificacionData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificacionData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where nota like '%$q%' or cc like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new CalificacionData());
	}
}
