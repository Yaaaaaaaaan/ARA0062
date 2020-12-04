<?php
 	namespace App\Controllers;
	use MF\Controller\Action;
	use MF\Model\Container;
	
	 class IndexController extends Action{
	 	public function index(){
	 		$this->render('index');
	 	}

	 	public function login(){
	 		$this->view->login =isset($_GET['login']) ? $_GET['login'] : '';
	 		$this->render('login');
	 	}

	 	public function units(){
	 		$this->render('units');
	 	}

	 	public function inscreverse(){
			$this->view->cliente=array('nomeUsuario'=>'','emailUsuario'=>'','nickUsuario'=>'','senhaUsuario'=>'','rank'=>'');
	 		$this->view->erroCadastro=false;
			$this->render('inscreverse');
		}

		public function registrar(){
			$usuario= Container::getModel('Usuario');
			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('email', $_POST['email']);
			$usuario->__set('nick', $_POST['nick']);
			$usuario->__set('senha',md5($_POST['senha']));
			if($usuario->validarcadastro() && count($usuario->getUsuarioPorEmail())==0){
				$usuario->salvar();	
				$this->render('cadastro');
			}else {
				$this->view->usuario=array('nome'=>$_POST['nome'],'email'=>$_POST['email'],'senha'=>$_POST['senha'],);
				$this->view->erroCadastro=true;
				$this->render('inscreverse');
			}
		}
 	}
?>