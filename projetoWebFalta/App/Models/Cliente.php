<?php
namespace App\Models;
use MF\Model\Model;
class Cliente extends Model{
	private $id;
	private $id_usuario;
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
	public function getAllUsuarios(){
		$query="
			select idUsuario,nomeUsuario,nickUsuario,emailUsuario,rank
				from 
				usuario idUsuario order by idUsuario asc
		";
		$stmt=$this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function deletaUsuario($idUsuario){
		$query = "delete from usuario where idUsuario = :idUsuario";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':idUsuario', $idUsuario);
			$stmt->execute();
			return true;
	}
	public function editaUsuario($idUsuario){
		//criar query para select
		$query="
			select idUsuario,nomeUsuario,nickUsuario,senhaUsuario,emailUsuario,rank,senhaUsuario,dataAlt,dataCad
				from 
				usuario where idUsuario = :idUsuario";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':idUsuario', $idUsuario);
			$stmt->execute();
			return true;

	}
	public function pesquisaUsuario($idUsuario){
		//criar query para select
		$query="
			select idUsuario,nomeUsuario,nickUsuario,senhaUsuario,emailUsuario,rank,senhaUsuario,dataAlt,dataCad
				from 
				usuario where idUsuario = :idUsuario";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':idUsuario', $idUsuario);
			$stmt->execute();
			return true;

	}
}
?>