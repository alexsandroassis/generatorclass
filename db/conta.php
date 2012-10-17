<?php

class conta{

	private $idcontausuario;
	private $idconta;
	private $descricao;
	private $vlinicial;
	private $saldo;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'conta';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_idconta($idconta){
		$this->idconta = $idconta;
	}

	public function get_idconta(){
		return $this->idconta;
	}

	public function set_descricao($descricao){
		$this->descricao = $descricao;
	}

	public function get_descricao(){
		return $this->descricao;
	}

	public function set_vlinicial($vlinicial){
		$this->vlinicial = $vlinicial;
	}

	public function get_vlinicial(){
		return $this->vlinicial;
	}

	public function set_saldo($saldo){
		$this->saldo = $saldo;
	}

	public function get_saldo(){
		return $this->saldo;
	}

}


class dbconta extends conta{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO conta (idcontausuario, idconta, descricao, vlinicial, saldo) VALUES (?, ?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idconta(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_descricao(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_vlinicial(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_saldo(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE conta set descricao = ?, vlinicial = ?, saldo = ? WHERE 1=1 AND idcontausuario = ? AND idconta = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_descricao(),PDO::PARAM_STR);
		$stmt->bindParam(2,$this->get_vlinicial(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_saldo(),PDO::PARAM_INT);
		$stmt->bindParam(4,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_idconta(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM conta WHERE 1=1 AND idcontausuario = ? AND idconta = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idconta(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, idconta, descricao, vlinicial, saldo FROM conta WHERE 1=1  AND idcontausuario = ? AND idconta = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idconta(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_idconta($rs->idconta);
			$this->set_descricao($rs->descricao);
			$this->set_vlinicial($rs->vlinicial);
			$this->set_saldo($rs->saldo);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, idconta, descricao, vlinicial, saldo FROM conta';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$conta = new conta();
				$conta->set_idcontausuario($ln->idcontausuario);
				$conta->set_idconta($ln->idconta);
				$conta->set_descricao($ln->descricao);
				$conta->set_vlinicial($ln->vlinicial);
				$conta->set_saldo($ln->saldo);
				$contas[] = $conta;
			}
			return $contas;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, idconta, descricao, vlinicial, saldo FROM conta WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_idconta != '') $sql .= ' AND idconta = ?';
		if($this->get_descricao != '') $sql .= ' AND descricao = ?';
		if($this->get_vlinicial != '') $sql .= ' AND vlinicial = ?';
		if($this->get_saldo != '') $sql .= ' AND saldo = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idconta != ''){
			$stmt->bindParam($i++,$this->get_idconta(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_descricao != ''){
			$stmt->bindParam($i++,$this->get_descricao(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_vlinicial != ''){
			$stmt->bindParam($i++,$this->get_vlinicial(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_saldo != ''){
			$stmt->bindParam($i++,$this->get_saldo(),PDO::PARAM_INT);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$conta = new conta();
				$conta->set_idcontausuario($ln->idcontausuario);
				$conta->set_idconta($ln->idconta);
				$conta->set_descricao($ln->descricao);
				$conta->set_vlinicial($ln->vlinicial);
				$conta->set_saldo($ln->saldo);
				$contas[] = $conta;
			}
			return $contas;
		}else return false;
	}


}

?>