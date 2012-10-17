<?php 

class DBPessoa{
    
    private $conex;
    
    public function __construct(){
        $this->conex = new Connection();
   }
    
    public function insert(Pessoa $pessoa){
        $sql = 'INSERT INTO pessoa (nome,endereco,sexo) VALUES (?,?,?)';
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(1,$pessoa->getNome(),PDO::PARAM_STR);
    $stmt->bindParam(2,$pessoa->getEndereco(),PDO::PARAM_STR);
    $stmt->bindParam(3,$pessoa->getSexo(),PDO::PARAM_STR);
    $rs = $stmt->execute();
    $msg = $rs === TRUE ? 'Cliente cadastrado com sucesso!' : 'Falha ao tentar cadastrar cliente'; //simples comparação para saber se deu certo ou não a execução do sql
    self::message($msg);
    }
    
    public function update(Pessoa $pessoa){
    $sql = 'UPDATE pessoa set nome = ?,endereco = ?,sexo = ? WHERE idPessoa = ?';
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(1,$pessoa->getNome(),PDO::PARAM_STR);
    $stmt->bindParam(2,$pessoa->getEndereco(),PDO::PARAM_STR);
    $stmt->bindParam(3,$pessoa->getSexo(),PDO::PARAM_STR);
    $stmt->bindParam(4,$pessoa->getIdPessoa(),PDO::PARAM_);
    $rs = $stmt->execute();
    $msg = $rs === TRUE ? 'Cliente atualizado com sucesso!' : 'Falha ao tentar atualizar cliente'; //simples comparação para saber se deu certo ou não a execução do sql
    self::message($msg);
    }

    public function delete(Pessoa $pessoa){
    $sql = 'DELETE FROM pessoa WHERE idPessoa = ?';
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(1,$pessoa->getIdPessoa(),PDO::PARAM_INT);
    $rs = $stmt->execute();
    $msg = $rs === TRUE ? 'Cliente deletado com sucesso!' : 'Falha na exclusão do cliente.';
    self::message($msg);
    }
    
    public function select(Pessoa $pessoa){
    $sql = 'SELECT nome,endereco,sexo FROM pessoa WHERE idPessoa = ?';
    $stmt = $this->conex->prepare($sql);
    $stmt->bindParam(1,$pessoa->getIdPessoa(),PDO::PARAM_INT);
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_OBJ);
    if(is_object($rs)){
        $pessoa->setNome($rs->nome);
        $pessoa->setEndereco($rs->endereco);
        $pessoa->setSexo($rs->sexo);
    }
    return $pessoa;
    }
    
    public function selectAll(){
    $sql = 'SELECT idPessoa,nome,endereco,sexo FROM pessoa';
    $rs = $this->conex->query($sql);
    if($rs){
        while($ln = $rs->fetch(PDO::FETCH_OBJ)){
            $pessoa = new Pessoa();
        $pessoa->setIdPessoa($ln->idPessoa);
        $pessoa->setNome($ln->nome);
        $pessoa->setEndereco($ln->endereco);
        $pessoa->setSexo($ln->sexo);
        $pessoas[] = $pessoa;
        }
    }
    if(!is_array($pessoas)){ throw new PDOException('Nenhum registro foi encontrado');}
    return $pessoas;
    }
    
    private function message($msg){ //imprime a mensagem na tela
    echo '<script type="text/javascript">
               alert(\''.$msg.'\')
           </script>';
    }
}

?>