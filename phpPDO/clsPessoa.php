<?php

class Pessoa{
    
    private $idPessoa;
    private $nome;
    private $endereco;
    private $sexo;
    
    public function __construct(){
        
    }

    public function setIdPessoa($idPessoa){
        $this->idPessoa = $idPessoa;
    }
    
    public function getIdPessoa(){
        return $this->idPessoa;
    }
    
    public function setNome($nome){
    $this->nome = $nome;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function setEndereco($endereco){
        $this->endereco = $endereco;
    }
    
    public function getEndereco(){
        return $this->endereco;
    }
    
    public function setSexo($sexo){
        $this->sexo = $sexo;
    }
    
    public function getSexo(){
        return $this->sexo;
    }
}

?>