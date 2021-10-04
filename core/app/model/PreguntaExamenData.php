<?php
class PreguntaExamenData
{
	public static $tablename = "preguntas_examen"; //id_examen EN LA BASE DE DATOS 


	public function PreguntaExamenData()
	{
		$this->id = "";
		$this->id_examen = null;
        $this->id_pregunta = null;
	
		
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (id_examen,id_pregunta) ";
		$sql .= "value (\"$this->id_examen\",\"$this->id_pregunta\")";
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
		return Model::one($query[0], new PreguntaExamenData());
	}

	public static function getByIdCC($id)
	{
		$sql = "select * from " . self::$tablename . " where cc='" . $id . "'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new PreguntaExamenData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new PreguntaExamenData());
	}


	public static function getLike($q)
	{
		$sql = "select * from " . self::$tablename . " where id_examen like '%$q%' or cc like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PreguntaExamenData());
	}

	public static function getByIdExamen($id)
	{
		$sql = "select * from " . self::$tablename . " where id_examen=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new PreguntaExamenData());
	}
}
