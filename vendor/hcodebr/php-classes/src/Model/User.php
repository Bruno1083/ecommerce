<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model{

	const SESSION = "User";

	public static function login($login, $password)
	{
		$sql = new Sql();
		//Tras os usuários do banco de dados
		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));
		if (count($results) === 0)//verificando se tem usuarios
		{
			throw new \Exception("Usuário inexistente ou senha inválida.");
		}	

		$data = $results[0];
		if (password_verify($password, $data["despassword"]) === true)
		{

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {
			throw new \Exception("Usuário inexistente ou senha inválida.");
		}
	}

	public static function verifyLogin($inadmin = true)
	{	
		if (
			!isset($_SESSION[User::SESSION])//VERIFICA SE A SESSAO FOI DEFINIDA
			||
			!$_SESSION[User::SESSION]// verifica se não é vasia
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin//não pode acessar a administração
		) {
			
			header("location: /admin/login");
			exit;
		}
	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;
	}
}
?>