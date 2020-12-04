<?php
 	namespace App\Controllers;
	use MF\Controller\Action;
	use MF\Model\Container;
	
	class appController extends Action{
	 	public function timeline(){
	 		$this->validaAutenticacao();
	 			$tweet =Container::getModel('tweet');
	 			$tweet->__set('id_usuario', $_SESSION['id']);
	 		$totalRegistrosPagina = 10;
	 		$deslocamento = 0;
	 		$pagina =isset($_GET['pagina']) ? $_GET['pagina'] :1;
	 		$deslocamento=($pagina -1)*$totalRegistrosPagina;
	 		$tweets = $tweet->getPorPagina($totalRegistrosPagina, $deslocamento);
	 		$totalTweets=$tweet->getTotalRegistros();
			$this->view->totalPaginas=ceil($totalTweets['total']/$totalRegistrosPagina);
			$this->view->paginaAtiva=$pagina;
	 		$this->view->tweets=$tweets;
	 			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->getInfoUsuario();
	 			$this->view->totalTweets=$usuario->getTotalTweets();
	 			$this->view->totalSeguindo=$usuario->getTotalSeguindo();
	 			$this->view->totalSeguidores=$usuario->getTotalSeguidores();
	 		$this->render('timeline');
		}
		public function painel(){
			$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();

				$blog=Container::getModel('Blog');
				$exibeBlog=$blog->getAllblog();
				$this->view->exibeBlog=$exibeBlog;


			$this->render('painel');
		}
		public function clientes(){
						$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();
	 			$this->view->usuario =$usuario;

				$usuarios=Container::getModel('cliente');
				$exibeclientes=$usuarios->getAllUsuarios();
				$this->view->exibeclientes =$exibeclientes;

				$this->render('clientes');
		}
		public function horarios(){
						$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();
			$this->render('horarios');
		}
		public function configs(){
			$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 		$usuario->__set('id', $_SESSION['id']);
	 		$this->view->infoUsuario=$usuario->pegaInfoUsuario();
			$this->render('configs');
		}
		public function novocliente(){
			$this->validaAutenticacao();
			$this->view->cliente=array('nomeUsuario'=>'','emailUsuario'=>'','nickUsuario'=>'','senhaUsuario'=>'','cpfUsuario'=>'','rgUsuario'=>'','nascUsuario'=>'','rank'=>'','naciUsuario'=>'','cepUsuario'=>'','endUsuario'=>'',);
	 		$this->view->erroCadastro=false;
			$usuario=Container::getModel('usuario');
	 		$usuario->__set('id', $_SESSION['id']);
	 		$this->view->infoUsuario=$usuario->pegaInfoUsuarionovo();
	 		$this->render('novocliente');
		}
		public function cadastroCliente(){
			$this->validaAutenticacao();
			$cliente=Container::getModel('cliente');
			$cliente->__set('nomeUsuario', $_POST['nomeUsuario']);
			$cliente->__set('emailUsuario', $_POST['emailUsuario']);
			$cliente->__set('nickUsuario', $_POST['nickUsuario']);
			$cliente->__set('rank', $_POST['rank']);
			$cliente->__set('senhaUsuario',md5($_POST['senhaUsuario']));
			if($cliente->validarNovoCliente() && count($cliente->getClientePorEmail())==0){
				$_SESSION['emailUsuario']=$cliente->__get('emailUsuario');
				$cliente->salvarCliente();
	 			$this->view->infoUsuario=$cliente->getClientePorEmail();
	 			$_SESSION['idUsuario']=$this->view->cliente['idUsuario'];
	 			header('Location: /clientes');
			}else {
				$this->view->cliente=array('nomeUsuario'=>$_POST['nomeUsuario'],'emailUsuario'=>$_POST['emailUsuario'],'senhaUsuario'=>$_POST['senhaUsuario'],'nickUsuario'=>$_POST['nickUsuario'],'rank'=>$_POST['rank'],);
				$this->view->erroCadastro=true;
				$this->render('novocliente');
			}
		}
		public function funcao(){
				$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();
			$funcao=isset($_GET['funcao']) ? $_GET['funcao'] :'';
			$idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] :'';
			$cliente = Container::getModel("Cliente");

			if($funcao== 'deletaUsuario'){
				$cliente->deletaUsuario($idUsuario);
				header('location:/clientes');
			}if($funcao== 'editaUsuario'){
				$exibecliente=$cliente->pesquisaUsuario($idUsuario);
				$this->view->exibecliente=$exibecliente;
				$this->render('editaUsuario');
				
			}
			
		}




		public function inicial(){
			$this->render('inicial');
		}
		
		public function validaAutenticacao(){
			session_start();
			if(!isset($_SESSION['id'])||$_SESSION['id'] =='' || !isset($_SESSION['nome'])||$_SESSION['nome'] ==''){
				header("Location: /?login=erro");
			}
		}
	}
?>