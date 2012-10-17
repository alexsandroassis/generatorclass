<?php

class lancto{

	private $idcontausuario;
	private $idlancto;
	private $idmarcador;
	private $idclifor;
	private $saldo;
	private $vlorig;
	private $flfixo;
	private $dtvencimento;
	private $diavencimento;
	private $totalparcelas;
	private $parcela;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'lancto';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_idlancto($idlancto){
		$this->idlancto = $idlancto;
	}

	public function get_idlancto(){
		return $this->idlancto;
	}

	public function set_idmarcador($idmarcador){
		$this->idmarcador = $idmarcador;
	}

	public function get_idmarcador(){
		return $this->idmarcador;
	}

	public function set_idclifor($idclifor){
		$this->idclifor = $idclifor;
	}

	public function get_idclifor(){
		return $this->idclifor;
	}

	public function set_saldo($saldo){
		$this->saldo = $saldo;
	}

	public function get_saldo(){
		return $this->saldo;
	}

	public function set_vlorig($vlorig){
		$this->vlorig = $vlorig;
	}

	public function get_vlorig(){
		return $this->vlorig;
	}

	public function set_flfixo($flfixo){
		$this->flfixo = $flfixo;
	}

	public function get_flfixo(){
		return $this->flfixo;
	}

	public function set_dtvencimento($dtvencimento){
		$this->dtvencimento = $dtvencimento;
	}

	public function get_dtvencimento(){
		return $this->dtvencimento;
	}

	public function set_diavencimento($diavencimento){
		$this->diavencimento = $diavencimento;
	}

	public function get_diavencimento(){
		return $this->diavencimento;
	}

	public function set_totalparcelas($totalparcelas){
		$this->totalparcelas = $totalparcelas;
	}

	public function get_totalparcelas(){
		return $this->totalparcelas;
	}

	public function set_parcela($parcela){
		$this->parcela = $parcela;
	}

	public function get_parcela(){
		return $this->parcela;
	}

}


class dblancto extends lancto{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO lancto (idcontausuario, idlancto, idmarcador, idclifor, saldo, vlorig, flfixo, dtvencimento, diavencimento, totalparcelas, parcela) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idlancto(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_idmarcador(),PDO::PARAM_INT);
		$stmt->bindParam(4,$this->get_idclifor(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_saldo(),PDO::PARAM_INT);
		$stmt->bindParam(6,$this->get_vlorig(),PDO::PARAM_INT);
		$stmt->bindParam(7,$this->get_flfixo(),PDO::character);
		$stmt->bindParam(8,$this->get_dtvencimento(),PDO::PARAM_STR);
		$stmt->bindParam(9,$this->get_diavencimento(),PDO::PARAM_INT);
		$stmt->bindParam(10,$this->get_totalparcelas(),PDO::PARAM_INT);
		$stmt->bindParam(11,$this->get_parcela(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE lancto set idmarcador = ?, idclifor = ?, saldo = ?, vlorig = ?, flfixo = ?, dtvencimento = ?, diavencimento = ?, totalparcelas = ?, parcela = ? WHERE 1=1 AND idcontausuario = ? AND idlancto = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idmarcador(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idclifor(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_saldo(),PDO::PARAM_INT);
		$stmt->bindParam(4,$this->get_vlorig(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_flfixo(),PDO::character);
		$stmt->bindParam(6,$this->get_dtvencimento(),PDO::PARAM_STR);
		$stmt->bindParam(7,$this->get_diavencimento(),PDO::PARAM_INT);
		$stmt->bindParam(8,$this->get_totalparcelas(),PDO::PARAM_INT);
		$stmt->bindParam(9,$this->get_parcela(),PDO::PARAM_INT);
		$stmt->bindParam(10,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(11,$this->get_idlancto(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM lancto WHERE 1=1 AND idcontausuario = ? AND idlancto = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idlancto(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, idlancto, idmarcador, idclifor, saldo, vlorig, flfixo, dtvencimento, diavencimento, totalparcelas, parcela FROM lancto WHERE 1=1  AND idcontausuario = ? AND idlancto = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idlancto(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_idlancto($rs->idlancto);
			$this->set_idmarcador($rs->idmarcador);
			$this->set_idclifor($rs->idclifor);
			$this->set_saldo($rs->saldo);
			$this->set_vlorig($rs->vlorig);
			$this->set_flfixo($rs->flfixo);
			$this->set_dtvencimento($rs->dtvencimento);
			$this->set_diavencimento($rs->diavencimento);
			$this->set_totalparcelas($rs->totalparcelas);
			$this->set_parcela($rs->parcela);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, idlancto, idmarcador, idclifor, saldo, vlorig, flfixo, dtvencimento, diavencimento, totalparcelas, parcela FROM lancto';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$lancto = new lancto();
				$lancto->set_idcontausuario($ln->idcontausuario);
				$lancto->set_idlancto($ln->idlancto);
				$lancto->set_idmarcador($ln->idmarcador);
				$lancto->set_idclifor($ln->idclifor);
				$lancto->set_saldo($ln->saldo);
				$lancto->set_vlorig($ln->vlorig);
				$lancto->set_flfixo($ln->flfixo);
				$lancto->set_dtvencimento($ln->dtvencimento);
				$lancto->set_diavencimento($ln->diavencimento);
				$lancto->set_totalparcelas($ln->totalparcelas);
				$lancto->set_parcela($ln->parcela);
				$lanctos[] = $lancto;
			}
			return $lanctos;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, idlancto, idmarcador, idclifor, saldo, vlorig, flfixo, dtvencimento, diavencimento, totalparcelas, parcela FROM lancto WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_idlancto != '') $sql .= ' AND idlancto = ?';
		if($this->get_idmarcador != '') $sql .= ' AND idmarcador = ?';
		if($this->get_idclifor != '') $sql .= ' AND idclifor = ?';
		if($this->get_saldo != '') $sql .= ' AND saldo = ?';
		if($this->get_vlorig != '') $sql .= ' AND vlorig = ?';
		if($this->get_flfixo != '') $sql .= ' AND flfixo = ?';
		if($this->get_dtvencimento != '') $sql .= ' AND dtvencimento = ?';
		if($this->get_diavencimento != '') $sql .= ' AND diavencimento = ?';
		if($this->get_totalparcelas != '') $sql .= ' AND totalparcelas = ?';
		if($this->get_parcela != '') $sql .= ' AND parcela = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idlancto != ''){
			$stmt->bindParam($i++,$this->get_idlancto(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idmarcador != ''){
			$stmt->bindParam($i++,$this->get_idmarcador(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idclifor != ''){
			$stmt->bindParam($i++,$this->get_idclifor(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_saldo != ''){
			$stmt->bindParam($i++,$this->get_saldo(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_vlorig != ''){
			$stmt->bindParam($i++,$this->get_vlorig(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_flfixo != ''){
			$stmt->bindParam($i++,$this->get_flfixo(),PDO::character);
			$i++;
		}
		if($this->get_dtvencimento != ''){
			$stmt->bindParam($i++,$this->get_dtvencimento(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_diavencimento != ''){
			$stmt->bindParam($i++,$this->get_diavencimento(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_totalparcelas != ''){
			$stmt->bindParam($i++,$this->get_totalparcelas(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_parcela != ''){
			$stmt->bindParam($i++,$this->get_parcela(),PDO::PARAM_INT);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$lancto = new lancto();
				$lancto->set_idcontausuario($ln->idcontausuario);
				$lancto->set_idlancto($ln->idlancto);
				$lancto->set_idmarcador($ln->idmarcador);
				$lancto->set_idclifor($ln->idclifor);
				$lancto->set_saldo($ln->saldo);
				$lancto->set_vlorig($ln->vlorig);
				$lancto->set_flfixo($ln->flfixo);
				$lancto->set_dtvencimento($ln->dtvencimento);
				$lancto->set_diavencimento($ln->diavencimento);
				$lancto->set_totalparcelas($ln->totalparcelas);
				$lancto->set_parcela($ln->parcela);
				$lanctos[] = $lancto;
			}
			return $lanctos;
		}else return false;
	}


}

?>