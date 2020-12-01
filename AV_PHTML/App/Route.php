<?php
	namespace App;
	
	use MF\Init\Bootstrap;

	class Route extends Bootstrap{
		protected function initRoutes(){
			$routes['home'] = array(
				'route' =>'/',
				'controller'=>'indexController',
				'action'=>'index'
			);
			$routes['criarnovo'] = array(
				'route' =>'/criaruser',
				'controller'=>'appController',
				'action'=>'criarnovo'
			);
			$routes['painel'] = array(
				'route' =>'/painel',
				'controller'=>'appController',
				'action'=>'painel'
			);
			$routes['horarios'] = array(
				'route' =>'/horarios',
				'controller'=>'appController',
				'action'=>'horarios'
			);
			$routes['novocliente'] = array(
				'route' =>'/novocliente',
				'controller'=>'appController',
				'action'=>'novocliente'
			);
			$routes['inicial'] = array(
				'route' =>'/inicial',
				'controller'=>'appController',
				'action'=>'inicial'
			);
			$routes['clientes'] = array(
				'route' =>'/clientes',
				'controller'=>'appController',
				'action'=>'clientes'
			);
			$routes['configs'] = array(
				'route' =>'/configs',
				'controller'=>'appController',
				'action'=>'configs'
			);
			$routes['inscreverse'] = array(
				'route' =>'/inscreverse',
				'controller'=>'indexController',
				'action'=>'inscreverse'
			);
			$routes['unidades'] = array(
				'route' =>'/units',
				'controller'=>'indexController',
				'action'=>'units'
			);
			$routes['registrar'] = array(
				'route' =>'/registrar',
				'controller'=>'indexController',
				'action'=>'registrar'
			);
			$routes['login'] = array(
				'route'=> '/login',
				'controller'=>'indexController',
				'action'=>'login'
			);
			$routes['autenticar'] = array(
				'route' =>'/autenticar',
				'controller'=>'authController',
				'action'=>'autenticar'
			);
			$routes['timeline'] = array(
				'route' =>'/timeline',
				'controller'=>'appController',
				'action'=>'timeline'
			);
			$routes['sair'] = array(
				'route' =>'/sair',
				'controller'=>'authController',
				'action'=>'sair'
			);
			$routes['tweet'] = array(
				'route' =>'/tweet',
				'controller'=>'appController',
				'action'=>'tweet'
			);
			$routes['quemSeguir'] = array(
				'route' =>'/quemSeguir',
				'controller'=>'appController',
				'action'=>'quemSeguir'
			);
			$routes['acao'] = array(
				'route' =>'/acao',
				'controller'=>'appController',
				'action'=>'acao'
			);
			$routes['rtweet'] = array(
				'route' =>'/rtweet',
				'controller'=>'appController',
				'action'=>'rtweet'
			);
			$this->setRoutes($routes);
		}
	}
 ?>