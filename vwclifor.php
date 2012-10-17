<?php

	header('Content-type: application/json');

	require_once 'classes/conexao.php';
	require_once 'db/clifor.php';

	$dbconn = new Connection();
	
	$sql = 'SELECT idcontausuario, idclifor, nome, CASE WHEN tipo = \'C\' THEN \'Cliente\' WHEN tipo = \'F\' THEN \'Fornecedor\' ELSE \'Ambos\' END as tipo, fone, celular FROM clifor ORDER BY nome limit 10 offset 0';
	$rs = $dbconn->query($sql);
	if($rs){
		while($ln = $rs->fetch(PDO::FETCH_ASSOC)){
			$clifors[] = array('idcontausuario' => $ln['idcontausuario'], 
								'idclifor' => $ln['idclifor'],
								'nome' => $ln['nome'],
								'tipo' => $ln['tipo'],
								'fone' => $ln['fone'],
								'celular' => $ln['celular']);
								
		}
	}
	
	echo json_encode(array ('d' => $clifors));
	
	
	/*$t = new Template('tema/view.html');
	$t->TITLE = 'FINANPESSOAL | Finanças pessoais';
	$t->show();
	
	$db = new dbclifor();
	$rs = $db->listarTodos();
	#print_r($rs);
	echo json_encode($rs[0]);*/
	
	

?>

<?php 
/*header('Content-type: application/json');
$clifor = array( 'd' => array('idcontausuario' => '1', 'idclifor' => '3', "nome" => 'Grupo Zema' , 'tipo' => 'C' )
				);
echo json_encode($clifor);

Resultado: [{ idcontausuario: "1", idclifor: "1", nome: "Grupo Zema",  tipo: "C" },
{ idcontausuario: "1", idclifor: "3", nome: "munidade Verdade e Graça",  tipo: "C" },
{ idcontausuario: "1", idclifor: "4", nome: "Lojas Micalce",  tipo: "C"},
{ idcontausuario: "1", idclifor: "5", nome: "Mundo Mágico",  tipo: "C" },
{ idcontausuario: "1", idclifor: "6", nome: "S&S Projetos",  tipo: "C" },
{ idcontausuario: "1", idclifor: "7", nome: "Colchões Araxá",  tipo: "C" }
];
*/
?>