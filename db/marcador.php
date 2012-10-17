<?php

class marcador{

	private $idmarcador;
	private $idmarcadorpai;
	private $descricao;
	private $debcred;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'marcador';
	}

	public function set_idmarcador($idmarcador){
		$this->idmarcador = $idmarcador;
	}

	public function get_idmarcador(){
		return $this->idmarcador;
	}

	public function set_idmarcadorpai($idmarcadorpai){
		$this->idmarcadorpai = $idmarcadorpai;
	}

	public function get_idmarcadorpai(){
		return $this->idmarcadorpai;
	}

	public function set_descricao($descricao){
		$this->descricao = $descricao;
	}

	public function get_descricao(){
		return $this->descricao;
	}

	public function set_debcred($debcred){
		$this->debcred = $debcred;
	}

	public function get_debcred(){
		return $this->debcred;
	}

}


class dbmarcador extends marcador{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO marcador (idmarcador, idmarcadorpai, descricao, debcred) VALUES (?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idmarcador(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idmarcadorpai(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_descricao(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_debcred(),PDO::PARAM_STR);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE marcador set idmarcadorpai = ?, descricao = ?, debcred = ? WHERE 1=1 AND idmarcador = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idmarcadorpai(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_descricao(),PDO::PARAM_STR);
		$stmt->bindParam(3,$this->get_debcred(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_idmarcador(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM marcador WHERE 1=1 AND idmarcador = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idmarcador(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idmarcador, idmarcadorpai, descricao, debcred FROM marcador WHERE 1=1  AND idmarcador = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idmarcador(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idmarcador($rs->idmarcador);
			$this->set_idmarcadorpai($rs->idmarcadorpai);
			$this->set_descricao($rs->descricao);
			$this->set_debcred($rs->debcred);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idmarcador, idmarcadorpai, descricao, debcred FROM marcador';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$marcador = new marcador();
				$marcador->set_idmarcador($ln->idmarcador);
				$marcador->set_idmarcadorpai($ln->idmarcadorpai);
				$marcador->set_descricao($ln->descricao);
				$marcador->set_debcred($ln->debcred);
				$marcadors[] = $marcador;
			}
			return $marcadors;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idmarcador, idmarcadorpai, descricao, debcred FROM marcador WHERE 1=1';
		if($this->get_idmarcador != '') $sql .= ' AND idmarcador = ?';
		if($this->get_idmarcadorpai != '') $sql .= ' AND idmarcadorpai = ?';
		if($this->get_descricao != '') $sql .= ' AND descricao = ?';
		if($this->get_debcred != '') $sql .= ' AND debcred = ?';
		$i = 0;
		if($this->get_idmarcador != ''){
			$stmt->bindParam($i++,$this->get_idmarcador(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idmarcadorpai != ''){
			$stmt->bindParam($i++,$this->get_idmarcadorpai(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_descricao != ''){
			$stmt->bindParam($i++,$this->get_descricao(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_debcred != ''){
			$stmt->bindParam($i++,$this->get_debcred(),PDO::PARAM_STR);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$marcador = new marcador();
				$marcador->set_idmarcador($ln->idmarcador);
				$marcador->set_idmarcadorpai($ln->idmarcadorpai);
				$marcador->set_descricao($ln->descricao);
				$marcador->set_debcred($ln->debcred);
				$marcadors[] = $marcador;
			}
			return $marcadors;
		}else return false;
	}

}

?>