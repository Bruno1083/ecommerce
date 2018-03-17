<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();//chama o construct e adiciona o heder na tela
	$page->setTpl("index");

});

$app->get('/admin', function() {
    
    User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("index");

});

$app->get('/admin/login', function(){//rota login administração

	$page = new PageAdmin([
		"header"=>false,//Desabilitando o header e o footer padrão
		"footer"=>false
	]);
	$page->setTpl('login');

});

//Validação login administração
$app->post('/admin/login', function(){

	user::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

//Rota para logout
$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;
	
});

$app->run();

?>