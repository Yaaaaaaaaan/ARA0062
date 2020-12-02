<?php
namespace App\Models;
use MF\Model\Model;
class Cliente extends Model{
	private $id;
	private $email;
	private $nome;
	private $senha;

	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo,$valor){
		$this->$atributo=$valor;
	}
	public function salvarCliente(){
		$rank=0;
		$query="insert into usuario (nomeUsuario,emailUsuario,nickUsuario,senhaUsuario, rank) values (:nomeUsuario,:emailUsuario,:nickUsuario,:senhaUsuario, :rank)";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':nomeUsuario', $this->__get("nomeUsuario"));
		$stmt->bindValue(':nickUsuario', $this->__get("nickUsuario"));
		$stmt->bindValue(':emailUsuario', $this->__get("emailUsuario"));
		$stmt->bindValue(':senhaUsuario', $this->__get("senhaUsuario"));
		$stmt->bindValue(':rank', $this->__get("rank"));
		$stmt->execute();
		return $this;
		/**/
	}
	public function pSalvarDadosCliente(){
		$query="select idUsuario from usuario where emailUsuario= :emailUsuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':emailUsuario', $this->__get('emailUsuario'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function salvarDadosCliente(){	
		$query="insert into dadosusuario(idUsuarioFk,cpfUsuario,rgUsuario,cepUsuario,endUsuario,nascUsuario,naciUsuario) values (:idUsuarioFk,:cpfUsuario,:rgUsuario,:cepUsuario,:endUsuario,:nascUsuario,:naciUsuario)";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':idUsuarioFk', $this->__get("idUsuario"));
		$stmt->bindValue(':cpfUsuario', $this->__get("cpfUsuario"));
		$stmt->bindValue(':rgUsuario', $this->__get("rgUsuario"));
		$stmt->bindValue(':cepUsuario', $this->__get("cepUsuario"));
		$stmt->bindValue(':endUsuario', $this->__get("endUsuario"));
		$stmt->bindValue(':nascUsuario', $this->__get("nascUsuario"));
		$stmt->bindValue(':naciUsuario', $this->__get("naciUsuario"));
		$stmt->execute();
		return $this;
	}
	public function validarNovoCliente(){
		$valido = true;
		if(strlen($this->__get('nomeUsuario')) <3){
			$valido=false;
		}
		if(strlen($this->__get('emailUsuario')) <3){
			$valido=false;
		}
		if(strlen($this->__get('senhaUsuario')) <3){
			$valido=false;
		}
		return $valido;
	}
	public function validarDadosNovoCliente(){
		$valido = true;
		if(strlen($this->__get('cpfUsuario')) <3){
			$valido=false;
		}
		if(strlen($this->__get('rgUsuario')) <3){
			$valido=false;
		}
		return $valido;
	}
	public function getClientePorEmail(){
		$query = "select nomeUsuario, emailUsuario,idUsuario from usuario where emailUsuario= :emailUsuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':emailUsuario', $this->__get('emailUsuario'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getClientePorCpf(){
		$query = "select idUsuarioFk, cpfUsuario from dadosusuario where idUsuario= :idUsuarioFk";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':idUsuarioFk', $this->__get('idUsuarioFk'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>