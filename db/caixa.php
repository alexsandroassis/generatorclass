<?php

class caixa{

	private $idcontausuario;
	private $idcaixa;
	private $idlancto;
	private $idstrato;
	private $vllancto;
	private $dtlancto;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'caixa';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_idcaixa($idcaixa){
		$this->idcaixa = $idcaixa;
	}

	public function get_idcaixa(){
		return $this->idcaixa;
	}

	public function set_idlancto($idlancto){
		$this->idlancto = $idlancto;
	}

	public function get_idlancto(){
		return $this->idlancto;
	}

	public function set_idstrato($idstrato){
		$this->idstrato = $idstrato;
	}

	public function get_idstrato(){
		return $this->idstrato;
	}

	public function set_vllancto($vllancto){
		$this->vllancto = $vllancto;
	}

	public function get_vllancto(){
		return $this->vllancto;
	}

	public function set_dtlancto($dtlancto){
		$this->dtlancto = $dtlancto;
	}

	public function get_dtlancto(){
		return $this->dtlancto;
	}

}


class dbcaixa extends caixa{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO caixa (idcontausuario, idcaixa, idlancto, idstrato, vllancto, dtlancto) VALUES (?, ?, ?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idcaixa(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_idlancto(),PDO::PARAM_INT);
		$stmt->bindParam(4,$this->get_idstrato(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_vllancto(),PDO::PARAM_INT);
		$stmt->bindParam(6,$this->get_dtlancto(),PDO::PARAM_STR);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE caixa set idlancto = ?, idstrato = ?, vllancto = ?, dtlancto = ? WHERE 1=1 AND idcontausuario = ? AND idcaixa = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idlancto(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idstrato(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_vllancto(),PDO::PARAM_INT);
		$stmt->bindParam(4,$this->get_dtlancto(),PDO::PARAM_STR);
		$stmt->bindParam(5,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(6,$this->get_idcaixa(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM caixa WHERE 1=1 AND idcontausuario = ? AND idcaixa = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idcaixa(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, idcaixa, idlancto, idstrato, vllancto, dtlancto FROM caixa WHERE 1=1  AND idcontausuario = ? AND idcaixa = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idcaixa(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_idcaixa($rs->idcaixa);
			$this->set_idlancto($rs->idlancto);
			$this->set_idstrato($rs->idstrato);
			$this->set_vllancto($rs->vllancto);
			$this->set_dtlancto($rs->dtlancto);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, idcaixa, idlancto, idstrato, vllancto, dtlancto FROM caixa';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$caixa = new caixa();
				$caixa->set_idcontausuario($ln->idcontausuario);
				$caixa->set_idcaixa($ln->idcaixa);
				$caixa->set_idlancto($ln->idlancto);
				$caixa->set_idstrato($ln->idstrato);
				$caixa->set_vllancto($ln->vllancto);
				$caixa->set_dtlancto($ln->dtlancto);
				$caixas[] = $caixa;
			}
			return $caixas;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, idcaixa, idlancto, idstrato, vllancto, dtlancto FROM caixa WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_idcaixa != '') $sql .= ' AND idcaixa = ?';
		if($this->get_idlancto != '') $sql .= ' AND idlancto = ?';
		if($this->get_idstrato != '') $sql .= ' AND idstrato = ?';
		if($this->get_vllancto != '') $sql .= ' AND vllancto = ?';
		if($this->get_dtlancto != '') $sql .= ' AND dtlancto = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idcaixa != ''){
			$stmt->bindParam($i++,$this->get_idcaixa(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idlancto != ''){
			$stmt->bindParam($i++,$this->get_idlancto(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idstrato != ''){
			$stmt->bindParam($i++,$this->get_idstrato(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_vllancto != ''){
			$stmt->bindParam($i++,$this->get_vllancto(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_dtlancto != ''){
			$stmt->bindParam($i++,$this->get_dtlancto(),PDO::PARAM_STR);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$caixa = new caixa();
				$caixa->set_idcontausuario($ln->idcontausuario);
				$caixa->set_idcaixa($ln->idcaixa);
				$caixa->set_idlancto($ln->idlancto);
				$caixa->set_idstrato($ln->idstrato);
				$caixa->set_vllancto($ln->vllancto);
				$caixa->set_dtlancto($ln->dtlancto);
				$caixas[] = $caixa;
			}
			return $caixas;
		}else return false;
	}


}

?>