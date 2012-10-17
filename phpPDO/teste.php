<?php 

//inserindo os dados:
$pessoa = new Pessoa();
$pessoa->setNome('Tiago Temporim');
$pessoa->setEndereco('Rua da minha casa');
$pessoa->setSexo('M');

$dbPessoa = new DBPessoa();
$dbPessoa->insert($pessoa);

//atualizando:
$pessoa = new Pessoa();
$pessoa->setIdPessoa(1);
$pessoa->setNome('Tiago');
$pessoa->setEndereco('Rua casa');
$pessoa->setSexo('M');

$dbPessoa = new DBPessoa();
$dbPessoa->update($pessoa);

//selecionando 1 registro
$pessoa = new Pessoa();
$pessoa->setIdPessoa(1);

$dbPessoa = new DBPessoa();
$dbPessoa->select($pessoa);

print_r($pessoa);

//selecionando todos os registros
$dbPessoa = new DBPessoa();

try{
    foreach($dbPessoa->selectAll() as $pessoa){
    print_r($pessoa);
    echo '<br />';
    }
}catch(PDOException $e){
    echo $e->getMessage();
}

?>