<?php

class clifor{

	private $idcontausuario;
	private $idclifor;
	private $nome;
	private $tipo;
	private $fone;
	private $celular;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'clifor';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_idclifor($idclifor){
		$this->idclifor = $idclifor;
	}

	public function get_idclifor(){
		return $this->idclifor;
	}

	public function set_nome($nome){
		$this->nome = $nome;
	}

	public function get_nome(){
		return $this->nome;
	}

	public function set_tipo($tipo){
		$this->tipo = $tipo;
	}

	public function get_tipo(){
		return $this->tipo;
	}

	public function set_fone($fone){
		$this->fone = $fone;
	}

	public function get_fone(){
		return $this->fone;
	}

	public function set_celular($celular){
		$this->celular = $celular;
	}

	public function get_celular(){
		return $this->celular;
	}

}


class dbclifor extends clifor{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO clifor (idcontausuario, idclifor, nome, tipo, fone, celular) VALUES (?, ?, ?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idclifor(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_nome(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_tipo(),PDO::character);
		$stmt->bindParam(5,$this->get_fone(),PDO::PARAM_STR);
		$stmt->bindParam(6,$this->get_celular(),PDO::PARAM_STR);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE clifor set nome = ?, tipo = ?, fone = ?, celular = ? WHERE 1=1 AND idcontausuario = ? AND idclifor = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_nome(),PDO::PARAM_STR);
		$stmt->bindParam(2,$this->get_tipo(),PDO::character);
		$stmt->bindParam(3,$this->get_fone(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_celular(),PDO::PARAM_STR);
		$stmt->bindParam(5,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(6,$this->get_idclifor(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM clifor WHERE 1=1 AND idcontausuario = ? AND idclifor = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idclifor(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, idclifor, nome, tipo, fone, celular FROM clifor WHERE 1=1  AND idcontausuario = ? AND idclifor = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idclifor(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_idclifor($rs->idclifor);
			$this->set_nome($rs->nome);
			$this->set_tipo($rs->tipo);
			$this->set_fone($rs->fone);
			$this->set_celular($rs->celular);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, idclifor, nome, tipo, fone, celular FROM clifor';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$clifor = new clifor();
				$clifor->set_idcontausuario($ln->idcontausuario);
				$clifor->set_idclifor($ln->idclifor);
				$clifor->set_nome($ln->nome);
				$clifor->set_tipo($ln->tipo);
				$clifor->set_fone($ln->fone);
				$clifor->set_celular($ln->celular);
				$clifors[] = $clifor;
			}
			return $clifors;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, idclifor, nome, tipo, fone, celular FROM clifor WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_idclifor != '') $sql .= ' AND idclifor = ?';
		if($this->get_nome != '') $sql .= ' AND nome = ?';
		if($this->get_tipo != '') $sql .= ' AND tipo = ?';
		if($this->get_fone != '') $sql .= ' AND fone = ?';
		if($this->get_celular != '') $sql .= ' AND celular = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idclifor != ''){
			$stmt->bindParam($i++,$this->get_idclifor(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_nome != ''){
			$stmt->bindParam($i++,$this->get_nome(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_tipo != ''){
			$stmt->bindParam($i++,$this->get_tipo(),PDO::character);
			$i++;
		}
		if($this->get_fone != ''){
			$stmt->bindParam($i++,$this->get_fone(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_celular != ''){
			$stmt->bindParam($i++,$this->get_celular(),PDO::PARAM_STR);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$clifor = new clifor();
				$clifor->set_idcontausuario($ln->idcontausuario);
				$clifor->set_idclifor($ln->idclifor);
				$clifor->set_nome($ln->nome);
				$clifor->set_tipo($ln->tipo);
				$clifor->set_fone($ln->fone);
				$clifor->set_celular($ln->celular);
				$clifors[] = $clifor;
			}
			return $clifors;
		}else return false;
	}


}

?>