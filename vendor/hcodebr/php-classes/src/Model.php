<?php

namespace Hcode;

class Model {

	private $values = [];

	public function __call($name, $args)// Metodo para saber foi passado um SET ou GET
	{

		$method = substr($name, 0, 3);// para pegar os tres primeiros algarismos do metodo
		$fieldName = substr($name, 3, strlen($name));// para descobrir o nome do campo chamado
		
		switch ($method) 
		{
			case "get":
				return $this->values[$fieldName];
			break;
			
			case "set":
				$this->values[$fieldName] = $args[0];	
			break;
		}
	}

	public function setData($data = array())
	{

		foreach ($data as $key => $value) {

			$this->{"set".$key}($value);//chama cada um dos metodos automaticamente ex: set iduser

		}
	}

	public function getValues()
	{

		return $this->values;
	}

}

?>