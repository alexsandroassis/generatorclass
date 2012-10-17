<?php

	require_once 'classes/Template.class.php';
	require_once 'classes/conexao.php';
	require_once 'db/clifor.php';
	
	$t = new Template('tema/view.html');
	$t->TITLE = 'FINANPESSOAL | Finanças pessoais';
	$t->show();
	
	/*$db = new dbclifor();
	$rs = $db->listarTodos();
	#print_r($rs);
	echo json_encode($rs[0]);*/
	
	

?>