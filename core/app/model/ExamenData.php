<?php
class ExamenData
{
	public static $tablename = "Examen"; //fecha_inicio EN LA BASE DE DATOS 


	public function ExamenData()
	{
		$this->id = "";
		$this->fecha_inicio = null;
		$this->fecha_fin = null;
		$this->nombre = null;

		
	}



	public function add()
	{
		$sql = "insert into " . self::$tablename . " (fecha_inicio,fecha_fin,nombre) ";
		$sql .= "value (\"$this->fecha_inicio\",\"$this->fecha_fin\",\"$this->nombre\")";
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
		return Model::one($query[0], new ExamenData());
	}



	public static function getAll()
	{
		$sql = "select * from " . self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0], new ExamenData());
	}



}
