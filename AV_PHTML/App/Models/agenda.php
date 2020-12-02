<?php
/*namespace App\Models;
use MF\Model\Model;
	class agenda extends Model{
		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo,$valor){
			$this->$atributo=$valor;
		}
		public function criarDataHorario(){
			$query="insert into dataagend (dataDispo) values (:dataDispo)";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':dataDispo', $this->__get("dataDispo"));
			$stmt->execute();
			return $this;
		}
		public function novoAgendamento(){
			$query="insert into agendamento (descAgend,idUsuarioFk,dataTreino) values (:descAgend,:idUsuarioFk,:dataTreino)";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':descAgend', $this->__get("descAgend"));
			$stmt->bindValue(':idUsuarioFk', $this->__get("idUsuarioFk"));
			$stmt->bindValue(':dataTreino', $this->__get("dataTreino"));
			$stmt->execute();
			return $this;
		}
	}*/
?>