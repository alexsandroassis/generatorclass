<?php

class extrato{

	private $idcontausuario;
	private $idextrato;
	private $idmarcador;
	private $idconta;
	private $historico;
	private $data;
	private $debcred;
	private $valor;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'extrato';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_idextrato($idextrato){
		$this->idextrato = $idextrato;
	}

	public function get_idextrato(){
		return $this->idextrato;
	}

	public function set_idmarcador($idmarcador){
		$this->idmarcador = $idmarcador;
	}

	public function get_idmarcador(){
		return $this->idmarcador;
	}

	public function set_idconta($idconta){
		$this->idconta = $idconta;
	}

	public function get_idconta(){
		return $this->idconta;
	}

	public function set_historico($historico){
		$this->historico = $historico;
	}

	public function get_historico(){
		return $this->historico;
	}

	public function set_data($data){
		$this->data = $data;
	}

	public function get_data(){
		return $this->data;
	}

	public function set_debcred($debcred){
		$this->debcred = $debcred;
	}

	public function get_debcred(){
		return $this->debcred;
	}

	public function set_valor($valor){
		$this->valor = $valor;
	}

	public function get_valor(){
		return $this->valor;
	}

}


class dbextrato extends extrato{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO extrato (idcontausuario, idextrato, idmarcador, idconta, historico, data, debcred, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idextrato(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_idmarcador(),PDO::PARAM_INT);
		$stmt->bindParam(4,$this->get_idconta(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_historico(),PDO::PARAM_STR);
		$stmt->bindParam(6,$this->get_data(),PDO::PARAM_STR);
		$stmt->bindParam(7,$this->get_debcred(),PDO::PARAM_STR);
		$stmt->bindParam(8,$this->get_valor(),PDO::PARAM_STR);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE extrato set idmarcador = ?, idconta = ?, historico = ?, data = ?, debcred = ?, valor = ? WHERE 1=1 AND idcontausuario = ? AND idextrato = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idmarcador(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idconta(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_historico(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_data(),PDO::PARAM_STR);
		$stmt->bindParam(5,$this->get_debcred(),PDO::PARAM_STR);
		$stmt->bindParam(6,$this->get_valor(),PDO::PARAM_STR);
		$stmt->bindParam(7,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(8,$this->get_idextrato(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM extrato WHERE 1=1 AND idcontausuario = ? AND idextrato = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idextrato(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, idextrato, idmarcador, idconta, historico, data, debcred, valor FROM extrato WHERE 1=1  AND idcontausuario = ? AND idextrato = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idextrato(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_idextrato($rs->idextrato);
			$this->set_idmarcador($rs->idmarcador);
			$this->set_idconta($rs->idconta);
			$this->set_historico($rs->historico);
			$this->set_data($rs->data);
			$this->set_debcred($rs->debcred);
			$this->set_valor($rs->valor);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, idextrato, idmarcador, idconta, historico, data, debcred, valor FROM extrato';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$extrato = new extrato();
				$extrato->set_idcontausuario($ln->idcontausuario);
				$extrato->set_idextrato($ln->idextrato);
				$extrato->set_idmarcador($ln->idmarcador);
				$extrato->set_idconta($ln->idconta);
				$extrato->set_historico($ln->historico);
				$extrato->set_data($ln->data);
				$extrato->set_debcred($ln->debcred);
				$extrato->set_valor($ln->valor);
				$extratos[] = $extrato;
			}
			return $extratos;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, idextrato, idmarcador, idconta, historico, data, debcred, valor FROM extrato WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_idextrato != '') $sql .= ' AND idextrato = ?';
		if($this->get_idmarcador != '') $sql .= ' AND idmarcador = ?';
		if($this->get_idconta != '') $sql .= ' AND idconta = ?';
		if($this->get_historico != '') $sql .= ' AND historico = ?';
		if($this->get_data != '') $sql .= ' AND data = ?';
		if($this->get_debcred != '') $sql .= ' AND debcred = ?';
		if($this->get_valor != '') $sql .= ' AND valor = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idextrato != ''){
			$stmt->bindParam($i++,$this->get_idextrato(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idmarcador != ''){
			$stmt->bindParam($i++,$this->get_idmarcador(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idconta != ''){
			$stmt->bindParam($i++,$this->get_idconta(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_historico != ''){
			$stmt->bindParam($i++,$this->get_historico(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_data != ''){
			$stmt->bindParam($i++,$this->get_data(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_debcred != ''){
			$stmt->bindParam($i++,$this->get_debcred(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_valor != ''){
			$stmt->bindParam($i++,$this->get_valor(),PDO::PARAM_STR);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$extrato = new extrato();
				$extrato->set_idcontausuario($ln->idcontausuario);
				$extrato->set_idextrato($ln->idextrato);
				$extrato->set_idmarcador($ln->idmarcador);
				$extrato->set_idconta($ln->idconta);
				$extrato->set_historico($ln->historico);
				$extrato->set_data($ln->data);
				$extrato->set_debcred($ln->debcred);
				$extrato->set_valor($ln->valor);
				$extratos[] = $extrato;
			}
			return $extratos;
		}else return false;
	}


}

?>