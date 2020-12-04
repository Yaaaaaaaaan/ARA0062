<?php
 	namespace App\Controllers;
	use MF\Controller\Action;
	use MF\Model\Container;
	
	 class authController extends Action{
	 	public function autenticar(){
	 		$usuario= Container::getModel('Usuario');
	 		$usuario->__set('emailUsuario',$_POST['emailUsuario']);
	 		$usuario->__set('senhaUsuario',md5($_POST['senhaUsuario']));
	 		$usuario->autenticar();
	 		if($usuario->__get('idUsuario') != '' && $usuario->__get('nomeUsuario')){
	 			session_start();
	 			$_SESSION['id'] = $usuario->__get('idUsuario');
	 			$_SESSION['nome'] = $usuario->__get('nomeUsuario');
	 			if($usuario->__get('rank')==9){
	 				header('Location: /painel');
	 			}else{
	 				header('Location: /inicial');
	 			}
	 			
	 		}else{
	 			header('Location:/login?login=erro');
	 		}
	 	}
	 	public function login(){
	 		$this->render('login');
	 	}
	 	public function sair(){
	 			session_start();
	 			session_destroy();
	 			header('Location: /');
	 		}
	 }