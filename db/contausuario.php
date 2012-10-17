<?php

class contausuario{

	private $idcontausuario;
	private $nome;
	private $dtcriacao;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'contausuario';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_nome($nome){
		$this->nome = $nome;
	}

	public function get_nome(){
		return $this->nome;
	}

	public function set_dtcriacao($dtcriacao){
		$this->dtcriacao = $dtcriacao;
	}

	public function get_dtcriacao(){
		return $this->dtcriacao;
	}

}


class dbcontausuario extends contausuario{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO contausuario (idcontausuario, nome, dtcriacao) VALUES (?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_nome(),PDO::PARAM_STR);
		$stmt->bindParam(3,$this->get_dtcriacao(),PDO::PARAM_STR);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE contausuario set nome = ?, dtcriacao = ? WHERE 1=1 AND idcontausuario = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_nome(),PDO::PARAM_STR);
		$stmt->bindParam(2,$this->get_dtcriacao(),PDO::PARAM_STR);
		$stmt->bindParam(3,$this->get_idcontausuario(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM contausuario WHERE 1=1 AND idcontausuario = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, nome, dtcriacao FROM contausuario WHERE 1=1 AND idcontausuario = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_nome($rs->nome);
			$this->set_dtcriacao($rs->dtcriacao);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, nome, dtcriacao FROM contausuario';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$contausuario = new contausuario();
				$contausuario->set_idcontausuario($ln->idcontausuario);
				$contausuario->set_nome($ln->nome);
				$contausuario->set_dtcriacao($ln->dtcriacao);
				$contausuarios[] = $contausuario;
			}
			return $contausuarios;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, nome, dtcriacao FROM contausuario WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_nome != '') $sql .= ' AND nome = ?';
		if($this->get_dtcriacao != '') $sql .= ' AND dtcriacao = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_nome != ''){
			$stmt->bindParam($i++,$this->get_nome(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_dtcriacao != ''){
			$stmt->bindParam($i++,$this->get_dtcriacao(),PDO::PARAM_STR);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$contausuario = new contausuario();
				$contausuario->set_idcontausuario($ln->idcontausuario);
				$contausuario->set_nome($ln->nome);
				$contausuario->set_dtcriacao($ln->dtcriacao);
				$contausuarios[] = $contausuario;
			}
			return $contausuarios;
		}else return false;
	}


}

?>