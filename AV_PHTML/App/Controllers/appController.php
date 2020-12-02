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
				$_SESSION['emailUsuario']=$cliente->__get('emailUsuario'); //criar um select p/ atribuir a idUsuario
				$cliente->salvarCliente();
	 			$this->view->infoUsuario=$cliente->getClientePorEmail();
	 			$_SESSION['idUsuario']=$this->view->cliente['idUsuario'];
	 		$this->render('concluirNovoCliente');	
				header('Location: /concluirNovoCliente');
			}else {
				$this->view->cliente=array('nomeUsuario'=>$_POST['nomeUsuario'],'emailUsuario'=>$_POST['emailUsuario'],'senhaUsuario'=>$_POST['senhaUsuario'],'nickUsuario'=>$_POST['nickUsuario'],'rank'=>$_POST['rank'],);
				$this->view->erroCadastro=true;
				$this->render('novocliente');
			}
		}
		public function concluirnovocliente(){
			$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();
			$this->view->cliente=array('cpfUsuario'=>'','rgUsuario'=>'','nascUsuario'=>'','naciUsuario'=>'','cepUsuario'=>'','endUsuario'=>'',);
	 		$this->view->erroCadastro=false;
		}
		public function finalizarnovocliente(){
			$this->validaAutenticacao();
			$usuario=Container::getModel('usuario');
	 			$usuario->__set('id', $_SESSION['id']);
	 			$this->view->infoUsuario=$usuario->pegaInfoUsuario();
			$cliente=Container::getModel('Cliente');
			$cliente->__set('idUsuario', $_POST['idUsuario']);
			$cliente->__set('cpfUsuario', $_POST['cpfUsuario']);
			$cliente->__set('rgUsuario', $_POST['rgUsuario']);
			$cliente->__set('nascUsuario', $_POST['nascUsuario']);
			$cliente->__set('naciUsuario', $_POST['naciUsuario']);
			$cliente->__set('endUsuario',md5($_POST['endUsuario']));
			$cliente->__set('cepUsuario',md5($_POST['cepUsuario']));
			if($cliente->validarDadosNovoCliente() && count($cliente->getClientePorEmail())==0){
				$cliente->pSalvarDadosCliente();
				$cliente->salvarDadosCliente();	
				header('/clientes');
			}else {
				$this->view->cliente=array('cpfUsuario'=>$_POST['cpfUsuario'],'rgUsuario'=>$_POST['rgUsuario'],'nascUsuario'=>$_POST['nascUsuario'],'naciUsuario'=>$_POST['naciUsuario'],'endUsuario'=>$_POST['endUsuario'],'cepUsuario'=>$_POST['cepUsuario'],);
				$this->view->erroCadastro=true;
				$this->render('concluirNovoCliente');
			}
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