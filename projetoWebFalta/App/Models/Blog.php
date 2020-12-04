<?php
namespace App\Models;
use MF\Model\Model;

	class Blog extends Model{

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo,$valor){
			$this->$atributo=$valor;
		}

		public function getAllBlog(){
			$query="
				select codTexto,titulo,texto
					from 
						blog codTexto order by codTexto asc
			";
			$stmt=$this->db->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

	}
?>