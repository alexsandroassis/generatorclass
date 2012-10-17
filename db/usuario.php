<?php

class usuario{

	private $idcontausuario;
	private $idusuario;
	private $email;
	private $nome;
	private $senha;
	private $tabela;

	public function __construct(){
		$this->tabela  = 'usuario';
	}

	public function set_idcontausuario($idcontausuario){
		$this->idcontausuario = $idcontausuario;
	}

	public function get_idcontausuario(){
		return $this->idcontausuario;
	}

	public function set_idusuario($idusuario){
		$this->idusuario = $idusuario;
	}

	public function get_idusuario(){
		return $this->idusuario;
	}

	public function set_email($email){
		$this->email = $email;
	}

	public function get_email(){
		return $this->email;
	}

	public function set_nome($nome){
		$this->nome = $nome;
	}

	public function get_nome(){
		return $this->nome;
	}

	public function set_senha($senha){
		$this->senha = $senha;
	}

	public function get_senha(){
		return $this->senha;
	}

}


class dbusuario extends usuario{

	private $conn;

	public function __construct(){
		$this->conn = new Connection();
	}

	public function insert(){
		$sql = 'INSERT INTO usuario (idcontausuario, idusuario, email, nome, senha) VALUES (?, ?, ?, ?, ?)';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idusuario(),PDO::PARAM_INT);
		$stmt->bindParam(3,$this->get_email(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_nome(),PDO::PARAM_STR);
		$stmt->bindParam(5,$this->get_senha(),PDO::PARAM_STR);
		$rs = $stmt->execute();
		return $rs;
	}

	public function update(){
		$sql = 'UPDATE usuario set email = ?, nome = ?, senha = ? WHERE 1=1 AND idcontausuario = ? AND idusuario = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_email(),PDO::PARAM_STR);
		$stmt->bindParam(2,$this->get_nome(),PDO::PARAM_STR);
		$stmt->bindParam(3,$this->get_senha(),PDO::PARAM_STR);
		$stmt->bindParam(4,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(5,$this->get_idusuario(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function delete(){
		$sql = 'DELETE FROM usuario WHERE 1=1 AND idcontausuario = ? AND idusuario = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idusuario(),PDO::PARAM_INT);
		$rs = $stmt->execute();
		return $rs;
	}

	public function listarUm(){
		$sql = 'SELECT idcontausuario, idusuario, email, nome, senha FROM usuario WHERE 1=1  AND idcontausuario = ? AND idusuario = ?';
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(1,$this->get_idcontausuario(),PDO::PARAM_INT);
		$stmt->bindParam(2,$this->get_idusuario(),PDO::PARAM_INT);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_OBJ);
		if(is_object($rs)){
			$this->set_idcontausuario($rs->idcontausuario);
			$this->set_idusuario($rs->idusuario);
			$this->set_email($rs->email);
			$this->set_nome($rs->nome);
			$this->set_senha($rs->senha);
		}
	}

	public function listarTodos(){
		$sql = 'SELECT idcontausuario, idusuario, email, nome, senha FROM usuario';
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$usuario = new usuario();
				$usuario->set_idcontausuario($ln->idcontausuario);
				$usuario->set_idusuario($ln->idusuario);
				$usuario->set_email($ln->email);
				$usuario->set_nome($ln->nome);
				$usuario->set_senha($ln->senha);
				$usuarios[] = $usuario;
			}
			return $usuarios;
		}else return false;
	}

	public function listarPorAtributo(){
		$sql = 'SELECT idcontausuario, idusuario, email, nome, senha FROM usuario WHERE 1=1';
		if($this->get_idcontausuario != '') $sql .= ' AND idcontausuario = ?';
		if($this->get_idusuario != '') $sql .= ' AND idusuario = ?';
		if($this->get_email != '') $sql .= ' AND email = ?';
		if($this->get_nome != '') $sql .= ' AND nome = ?';
		if($this->get_senha != '') $sql .= ' AND senha = ?';
		$i = 0;
		if($this->get_idcontausuario != ''){
			$stmt->bindParam($i++,$this->get_idcontausuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_idusuario != ''){
			$stmt->bindParam($i++,$this->get_idusuario(),PDO::PARAM_INT);
			$i++;
		}
		if($this->get_email != ''){
			$stmt->bindParam($i++,$this->get_email(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_nome != ''){
			$stmt->bindParam($i++,$this->get_nome(),PDO::PARAM_STR);
			$i++;
		}
		if($this->get_senha != ''){
			$stmt->bindParam($i++,$this->get_senha(),PDO::PARAM_STR);
			$i++;
		}
		$rs = $this->conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				$usuario = new usuario();
				$usuario->set_idcontausuario($ln->idcontausuario);
				$usuario->set_idusuario($ln->idusuario);
				$usuario->set_email($ln->email);
				$usuario->set_nome($ln->nome);
				$usuario->set_senha($ln->senha);
				$usuarios[] = $usuario;
			}
			return $usuarios;
		}else return false;
	}


}


?>