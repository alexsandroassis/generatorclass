<?php

	require_once 'classes/conexao.php';
	require_once 'db/contausuario.php';
	

	$db = new dbcontausuario();

	$db->set_dtcriacao('2012-09-26');
	$ct = $db->listarPorAtributo();
	echo $ct[1]->get_nome();
	
?>