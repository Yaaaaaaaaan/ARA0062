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
			$this->render('painel');
		}
		public function clientes(){
						$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();
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
			$usuario=Container::getModel('usuario');
	 		$usuario->__set('id', $_SESSION['id']);
	 		$this->view->infoUsuario=$usuario->pegaInfoUsuarioLog(); // editar usuario pegaInfoUsuario
			$usuario->__set('nomeUsuario', $_POST['nomeUsuario']);
			$usuario->__set('emailUsuario', $_POST['emailUsuario']);
			$usuario->__set('nickUsuario', $_POST['nickUsuario']);
			$usuario->__set('cpfUsuario', $_POST['cpfUsuario']);
			$usuario->__set('rgUsuario', $_POST['rgUsuario']);
			$usuario->__set('nascUsuario', $_POST['nascUsuario']);
			$usuario->__set('naciUsuario', $_POST['naciUsuario']);
			$usuario->__set('cepUsuario', $_POST['cepUsuario']);
			$usuario->__set('endUsuario', $_POST['endUsuario']);
			$usuario->__set('rank', $_POST['rank']);
			$usuario->__set('senhaUsuario',md5($_POST['senhaUsuario']));
			if($usuario->validarcadastro() && count($usuario->getUsuarioPorEmail())==0){
				$usuario->salvar();	
				$this->render('clientes');
			}else {
				$this->view->usuario=array('nome'=>$_POST['nome'],'email'=>$_POST['email'],'senha'=>$_POST['senha'],);
				$this->view->erroCadastro=true;
				$this->render('novocliente');
			}
			$this->render('novocliente');
		}
		public function inicial(){
			$this->render('inicial');
		}
		public function tweet(){
			$this->validaAutenticacao();
				$tweet = container::getModel('tweet');
				$tweet-> __set('tweet',$_POST['tweet']);
				$tweet-> __set('id_usuario',$_SESSION['id']);
				$tweet->salvar();
				header("Location: /timeline");
		}
		public function validaAutenticacao(){
			session_start();
			if(!isset($_SESSION['id'])||$_SESSION['id'] =='' || !isset($_SESSION['nome'])||$_SESSION['nome'] ==''){
				header("Location: /?login=erro");
			}
		}
		public function quemSeguir(){
			$this->validaAutenticacao();
			
			$pesquisarPor =isset($_GET['pesquisarPor'])? $_GET['pesquisarPor']: '';
			$usuarios= array();

			if($pesquisarPor != '' ){
				$usuario = Container::getModel('usuario');
				$usuario->__set('nome', $pesquisarPor);
				$usuario->__set('id', $_SESSION['id']);
				$usuarios=$usuario->getAll();
			}else{
				$usuario = container::getModel('usuario');
			}
			$this->view->usuarios =$usuarios;
				$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->getInfoUsuario();
	 			$this->view->totalTweets=$usuario->getTotalTweets();
	 			$this->view->totalSeguindo=$usuario->getTotalSeguindo();
	 			$this->view->totalSeguidores=$usuario->getTotalSeguidores();
			$this->render('quemSeguir');
		}
		public function acao(){
			$this->validaAutenticacao();
			$acao = isset($_GET['acao']) ? $_GET['acao'] :'';
			$idUsuarioSeguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] :'';
			$usuario = Container::getModel("usuario");
			$usuario->__set('id', $_SESSION['id']);
			if($acao== 'seguir'){
				$usuario->seguirUsuario($idUsuarioSeguindo);
			}else if($acao == 'deixarDeSeguir'){
				$usuario->deixarSeguirUsuario($idUsuarioSeguindo);
			}
			header('location:/quemSeguir');
		}
		public function rtweet(){
			$this->validaAutenticacao();
			$rtweet = isset($_GET['rtweet']) ? $_GET['rtweet'] :'';
			$idtweet = isset($_GET['idtweet']) ? $_GET['idtweet'] :'';
			$usuario = Container::getModel("tweet");
			$usuario->__set('id', $_SESSION['id']);
			if($rtweet== 'deleta'){
				$usuario->deleta($idtweet);
			}
			header('location:/timeline');
		}
	}
?>