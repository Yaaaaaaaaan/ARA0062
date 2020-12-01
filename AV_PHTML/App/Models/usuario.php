<?php
namespace App\Models;
use MF\Model\Model;
class Usuario extends Model{
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

	public function salvar(){
		$query="insert into usuario (nomeUsuario,emailUsuario,nickUsuario,senhaUsuario) values (:nome,:email,:nick,:senha)";
		$stmt= $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get("nome"));
		$stmt->bindValue(':nick', $this->__get("nick"));
		$stmt->bindValue(':email', $this->__get("email"));
		$stmt->bindValue(':senha', $this->__get("senha"));
		$stmt->execute();
		return $this;
	}
	public function validarcadastro(){
		$valido = true;
		if(strlen($this->__get('nome')) <3){
			$valido=false;
		}
		if(strlen($this->__get('email')) <3){
			$valido=false;
		}
		if(strlen($this->__get('senha')) <3){
			$valido=false;
		}
		return $valido;
	}
	public function getUsuarioPorEmail(){
		$query = "select nome, email from usuarios where email= :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function autenticar(){
		$query= "select u.idUsuario, u.nomeUsuario, u.nickUsuario, u.emailUsuario, d.idUsuarioFk, d.rank
		 from usuario as u inner join dadosUsuario as d on u.idUsuario = d.idUsuarioFk where :email in (u.nickUsuario , u.emailUsuario) and u.senhaUsuario = :senha";
		$stmt=$this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();
		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
		if($usuario['idUsuario'] !='' && $usuario['nomeUsuario'] != ''){
			$this->__set('id', $usuario['idUsuario']);
			$this->__set('nome', $usuario['nomeUsuario']);
			$this->__set('rank', $usuario['rank']);
		}
		return $this;
	}
	public function pegaInfoUsuario(){
		$query = "select u.idUsuario, u.nomeUsuario, u.nickUsuario, u.emailUsuario, d.idUsuarioFk, d.rank,d.rgUsuario,d.cpfUsuario,d.endUsuario,d.nascUsuario,d.naciUsuario,d.cepUsuario
		 from usuario as u inner join dadosUsuario as d on u.idUsuario = d.idUsuarioFk where idUsuario= :id_usuario";
		$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function pegaInfoUsuarioLog(){
		$query = "select idUsuario, nomeUsuario, nickUsuario
		 from usuario where idUsuario= :id_usuario";
		$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function getAll(){
		$query = "
		select 
			u.id, u.nome, u.email,
			(
				select 
					count(*) 
				from 
					usuarios_seguidores as us 
				where
					us.id_usuario= :id_usuario and us.id_usuario_seguindo = u.id
			) as seguindo_sn
		from 
			usuarios as u
		where 
			u.nome like :nome and u.id != :id_usuario
		";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getAllUsers(){ // Para exibir todos os usuários seguindo sem fazer pesquisa
		$query = "
		select 
			u.id, u.nome, u.email,
			(
				select 
					count(*) 
				from 
					usuarios_seguidores as us 
				where
					us.id_usuario= :id_usuario and us.id_usuario_seguindo = u.id
			) as seguindo_sn
		from 
			usuarios as u
		where 
			u.nome like :nome and u.id != :id_usuario
		";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function seguirUsuario($idUsuarioSeguindo){
			$query = "insert into usuarios_seguidores(id_usuario, id_usuario_seguindo)values(:id_usuario, :idUsuarioSeguindo)";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':idUsuarioSeguindo', $idUsuarioSeguindo);
			$stmt->execute();
			return true;
	}
	public function deixarSeguirUsuario($idUsuarioSeguindo){
		$query = "delete from usuarios_seguidores where id_usuario = :id_usuario and id_usuario_seguindo = :idUsuarioSeguindo";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':idUsuarioSeguindo', $idUsuarioSeguindo);
			$stmt->execute();
			return true;
	}
	public function getInfoUsuario(){
		$query = "select nome from usuarios where id= :id_usuario";
		$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function getTotalTweets(){
		$query = "select count(*) as totalTweet from tweets where id_usuario= :id_usuario";
		$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function getTotalSeguindo(){
		$query = "select count(*) as totalSeguindo from usuarios_seguidores where id_usuario= :id_usuario";
		$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
	public function getTotalSeguidores(){
		$query = "select count(*) as totalSeguidores from usuarios_seguidores where id_usuario_seguindo= :id_usuario";
		$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
}
?>