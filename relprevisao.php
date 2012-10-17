<?php
	
	require_once 'classes/conexao.php';
	require_once 'classes/Template.class.php';
	
	if(isset($_GET['o']) || $_GET['o'] != "") $definida = true;
	else  $definida = false;

	$dbconn = new Connection();
	$t = new Template('tema/relprevmensal.html');
	$t->TITLE = 'Previsão Mensal | Finanças Pessoais';
	$totalEntradas = 0;
	$totalSaidas = 0;
	$dtIni = '2012-10-01';
	$dtFinal = '2012-10-31';
	$numMeses = 1;
	
	$meses = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
	$indice = date("m") - 1;
	
	$i = 0;
	for($i = 0; $i <= 11; $i++){
		if($i == 0 && !$definida) $t->MESATIVO = ' class="active"';
		else if($definida && $_GET['o'] == 'm' && $_GET['m'] == ($indice+1)) $t->MESATIVO = ' class="active"';
		else $t->MESATIVO = '';
		$t->MES = $meses[$indice];
		$t->MESLINK = $indice + 1;
		$t->block("BLOCK_MESES");
		if($indice == 11) $indice = -1;
		$indice++;
	}
	
	$t->S1ATIVO = '';
	$t->S2ATIVO = '';
	$t->A1ATIVO = '';
	$t->A2ATIVO = '';
	$t->A3ATIVO = '';
	$t->A5ATIVO = '';
	
	if($_GET["o"] == 's'){
		if($_GET["s"] == 1){
			$t->S1ATIVO = ' class="active"';
			$dtIni = '2013-01-01';
			$dtFinal = '2013-06-30';
			$numMeses = 6;	
		}
		if($_GET["s"] == 2){
			$t->S2ATIVO = ' class="active"';
			$dtIni = '2012-07-01';
			$dtFinal = '2012-12-31';
			$numMeses = 6;
		}
	}	
	if($_GET["o"] == 'a'){
		if($_GET["a"] == 1){
			$t->A1ATIVO = ' class="active"';
			$dtIni = '2012-10-01';
			$dtFinal = '2013-09-30';
			$numMeses = 12;				
		}
		if($_GET["a"] == 2){
			$t->A2ATIVO = ' class="active"';
			$dtIni = '2012-10-01';
			$dtFinal = '2014-09-30';
			$numMeses = 25;			
		}
		if($_GET["a"] == 5){
			$t->A3ATIVO = ' class="active"';
			$dtIni = '2012-10-01';
			$dtFinal = '2017-09-30';
			$numMeses = 60;			
		}
		if($_GET["a"] == 10){
			$t->A5ATIVO = ' class="active"';
			$dtIni = '2012-10-01';
			$dtFinal = '2022-09-30';
			$numMeses = 120;			
		}
	}
	
	
	#-----------------------------------------------------------------------------------------------------------------------
	
	# G R Á F I C O S : : G R Á F I C O S : : G R Á F I C O S : :
	getGraficoEntradas($dbconn, $t, $dtIni, $dtFinal, $numMeses);
	getGraficoSaidas($dbconn, $t, $dtIni, $dtFinal, $numMeses);
	
	# R E C E I T A S : : R E C E I T A S : : R E C E I T A S : :
	getEntradasFixas($dbconn, $t, $numMeses);
	getSomaEntradasFixas($dbconn, $t, $numMeses);
	getEntradas($dbconn, $t, $dtIni, $dtFinal);
	getSomaEntradas($dbconn, $t, $dtIni, $dtFinal);
	$totalEntradas = getSomaReceitas($dbconn, $t, $dtIni, $dtFinal, $numMeses);

	# D E S P E S A S : : D E S P E S A S : : D E S P E S A S : :	
	getSaidasFixas($dbconn, $t, $numMeses);
	getSomaSaidasFixas($dbconn, $t, $numMeses);
	getSaidas($dbconn, $t, $dtIni, $dtFinal);
	getSomaSaidas($dbconn, $t, $dtIni, $dtFinal);
	$totalSaidas = getSomaDespesas($dbconn, $t, $dtIni, $dtFinal, $numMeses);
	
	#-----------------------------------------------------------------------------------------------------------------------	
	
	$t->TOTALGERAL = ($totalEntradas - $totalSaidas);

	$t->show();	
	
	# ======================================================================================================================
	# G R Á F I C O S : : G R Á F I C O S : : G R Á F I C O S : :   
	# ======================================================================================================================
	# Função para gerar Gráfico ( De onde vem o dinheiro ) 
	# ======================================================================================================================
	function getGraficoEntradas($conn, $tema, $dtInicio, $dtFim, $qtdMeses ){
		$sql  = "select descricao, COALESCE(sum(vlorig),0.00) as total from ";
		$sql .= "(select marcador.descricao, (sum(lancto.vlorig) * $qtdMeses) as vlorig from lancto, marcador, clifor ";
		$sql .= "	where 1=1 and lancto.flfixo = 'S' and marcador.debcred = 'C' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "		group by marcador.descricao ";
		$sql .= "union all ";
		$sql .= "select marcador.descricao, sum(lancto.vlorig) as vlorig from lancto, clifor, marcador ";
		$sql .= "	where 1=1 and lancto.flfixo = 'N' and marcador.debcred = 'C' ";
		$sql .= "		and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "		and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "		group by marcador.descricao) as receitas ";
		$sql .= "group by descricao ";
		$sql .= "order by descricao ";	
		
		$rs = $conn->query($sql);
		if($rs){
			$i = 0;
			$tema->NOMEMARCADORES = "";
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				if($i == 0){
					$tema->NOMEMARCADORES .= "['" . $ln->descricao . "'," . $ln->total . "]";
					$i = 1;
				}else $tema->NOMEMARCADORES .= ", ['" . $ln->descricao . "'," . $ln->total . "]";				
			}
		}
	}	

	# ======================================================================================================================
	# Função para gerar Gráfico ( Pra onde vai o dinheiro )
	# ======================================================================================================================
	function getGraficoSaidas($conn, $tema, $dtInicio, $dtFim, $qtdMeses){
		$sql  = "select descricao, COALESCE(sum(vlorig),0.00) as total from ";
		$sql .= "(select marcador.descricao, (sum(lancto.vlorig) * $qtdMeses) as vlorig from lancto, marcador, clifor ";
		$sql .= "	where 1=1 and lancto.flfixo = 'S' and marcador.debcred = 'D' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "		group by marcador.descricao ";
		$sql .= "union all ";
		$sql .= "select marcador.descricao, sum(lancto.vlorig) as vlorig from lancto, clifor, marcador ";
		$sql .= "	where 1=1 and lancto.flfixo = 'N' and marcador.debcred = 'D' ";
		$sql .= "		and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "		and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "		group by marcador.descricao) as receitas ";
		$sql .= "group by descricao ";
		$sql .= "order by descricao ";
		$rs = $conn->query($sql);
		if($rs){
			$i = 0;
			$tema->MARCADORDESP = "";
			$tema->VALORDESP = "";
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				if($i == 0){
					$tema->MARCADORDESP .= "'" . $ln->descricao . "'";
					$tema->VALORDESP .= $ln->total;
					$i = 1;
				}else{
					$tema->MARCADORDESP .= ", '" . $ln->descricao . "'";
					$tema->VALORDESP .= ", " . $ln->total;
				}
			}
		}
	}

	
	
	# ======================================================================================================================
	# R E C E I T A S : : R E C E I T A S : : R E C E I T A S : : 
	# ======================================================================================================================
	# Função para pegar Receitas Fixas
	# ======================================================================================================================
	function getEntradasFixas($conn, $tema, $numMeses){
		$sql  = "select clifor.nome, marcador.descricao, lancto.diavencimento, (lancto.vlorig * $numMeses ) as vlorig ";
		$sql .= "from lancto, clifor, marcador where 1=1 ";
		$sql .= "	and lancto.flfixo = 'S' and marcador.debcred = 'C' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "	and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "order by lancto.diavencimento ";
		$rs = $conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				#Linhas da tabela
				$tema->CREDFIXASCLIFOR = $ln->nome; 
				$tema->CREDFIXASMARCADOR = $ln->descricao;
				$tema->CREDFIXASDIA = $ln->diavencimento;
				$tema->CREDFIXASVALOR = $ln->vlorig;
				$tema->block("BLOCK_CREDFIXAS");			
			}
		}
	}	

	# ======================================================================================================================
	# Função para pegar a Soma das Receitas Fixas
	# ======================================================================================================================
	function getSomaEntradasFixas($conn, $tema, $numMeses){	
		$sql  = "select (COALESCE(sum(lancto.vlorig),0.00) * $numMeses) as total from lancto, clifor, marcador ";
		$sql .= "where 1=1 and lancto.flfixo = 'S' and marcador.debcred = 'C' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
	
		$rs = $conn->query($sql);
		$ln = $rs->fetch(PDO::FETCH_OBJ);
		$tema->CREDFIXASTOTAL = $ln->total;
	}
	
	# ======================================================================================================================
	# Função para pegar outras Receitas
	# ======================================================================================================================
	function getEntradas($conn, $tema, $dtInicio, $dtFim){
		$sql  = "select clifor.nome, marcador.descricao, Extract('Day' From lancto.dtvencimento) as diavencimento, lancto.vlorig ";
		$sql .= "from lancto, clifor, marcador where 1=1 and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "	and lancto.flfixo = 'N' and marcador.debcred = 'C' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "	and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "order by lancto.dtvencimento ";
		$rs = $conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				#Linhas da tabela
				$tema->CREDCLIFOR = $ln->nome;
				$tema->CREDMARCADOR = $ln->descricao;
				$tema->CREDDIA = $ln->diavencimento;
				$tema->CREDVALOR = $ln->vlorig;
				$tema->block("BLOCK_CRED");
			}
		}
	}	

	# ======================================================================================================================
	# Função para pegar a Soma de Outras Receitas
	# ======================================================================================================================
	function getSomaEntradas($conn, $tema, $dtInicio, $dtFim){
		$sql  = "select COALESCE(sum(lancto.vlorig),0.00) as total from lancto, clifor, marcador ";
		$sql .= "where 1=1 and lancto.flfixo = 'N' and marcador.debcred = 'C' ";
		$sql .= "	and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "	and lancto.idcontausuario = clifor.idcontausuario "; 
		$sql .= "	and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
	
		$rs = $conn->query($sql);
		$ln = $rs->fetch(PDO::FETCH_OBJ);
		$tema->CREDTOTAL = $ln->total;
	}

	# ======================================================================================================================
	# Função para pegar a Soma das Receitas
	# ======================================================================================================================
	function getSomaReceitas($conn, $tema, $dtInicio, $dtFim, $numMeses){
		$sql  = "select COALESCE(sum(vlorig),0.00) as total from "; 
		$sql .= "	(select (sum(lancto.vlorig) * $numMeses ) as vlorig from lancto, marcador, clifor ";
		$sql .= "		where 1=1 and lancto.flfixo = 'S' and marcador.debcred = 'C' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "	union all ";
		$sql .= "	select sum(lancto.vlorig) as vlorig from lancto, clifor, marcador ";
		$sql .= "		where 1=1 and lancto.flfixo = 'N' and marcador.debcred = 'C' ";
		$sql .= "		and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "		and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador) as receitas ";	
		
		$rs = $conn->query($sql);
		$ln = $rs->fetch(PDO::FETCH_OBJ);
		$tema->TOTALENTRADAS = $ln->total;
		return $ln->total;
	}
		

			
	# ======================================================================================================================
	# D E S P E S A S : : D E S P E S A S : : D E S P E S A S : : 
	# ======================================================================================================================
	# Função para pegar despesas Fixas
	# ======================================================================================================================
	function getSaidasFixas($conn, $tema, $numMeses){
		$sql  = "select clifor.nome, marcador.descricao, lancto.diavencimento, (lancto.vlorig * $numMeses ) as vlorig ";
		$sql .= "from lancto, clifor, marcador where 1=1 ";
		$sql .= "	and lancto.flfixo = 'S' and marcador.debcred = 'D' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "	and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "order by lancto.diavencimento ";
		$rs = $conn->query($sql);
		if($rs){
			while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				#Linhas da tabela
				$tema->DESPFIXASCLIFOR = $ln->nome;
				$tema->DESPFIXASMARCADOR = $ln->descricao;
				$tema->DESPFIXASDIA = $ln->diavencimento;
				$tema->DESPFIXASVALOR = $ln->vlorig;
				$tema->block("BLOCK_DESPFIXAS");
			}
		}
	}
	
	# ======================================================================================================================
	# Função para pegar a Soma das Saidas Fixas
	# ======================================================================================================================
	function getSomaSaidasFixas($conn, $tema, $numMeses){	
		$sql  = "select (COALESCE(sum(lancto.vlorig),0.00) * $numMeses ) as total from lancto, clifor, marcador ";
		$sql .= "where 1=1 and lancto.flfixo = 'S' and marcador.debcred = 'D' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		
		$rs = $conn->query($sql);
		$ln = $rs->fetch(PDO::FETCH_OBJ);
		$tema->DESPFIXASTOTAL = $ln->total;
	}

	# ======================================================================================================================
	# Função para pegar outras Saidas
	# ======================================================================================================================
	function getSaidas($conn, $tema, $dtInicio, $dtFim){
		$sql  = "select clifor.nome, marcador.descricao, Extract('Day' From lancto.dtvencimento) as diavencimento, lancto.vlorig ";
		$sql .= "from lancto, clifor, marcador where 1=1 and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "	and lancto.flfixo = 'N' and marcador.debcred = 'D' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "	and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "order by lancto.dtvencimento ";
		$rs = $conn->query($sql);
			if($rs){
				while($ln = $rs->fetch(PDO::FETCH_OBJ)){
				#Linhas da tabela
				$tema->DESPCLIFOR = $ln->nome;
				$tema->DESPMARCADOR = $ln->descricao;
				$tema->DESPDIA = $ln->diavencimento;
				$tema->DESPVALOR = $ln->vlorig;
				$tema->block("BLOCK_DESP");
			}
		}
	}

	# ======================================================================================================================
	# Função para pegar a Soma de Outras Saidas
	# ======================================================================================================================
	function getSomaSaidas($conn, $tema, $dtInicio, $dtFim){
		$sql  = "select COALESCE(sum(lancto.vlorig),0.00) as total from lancto, clifor, marcador ";
		$sql .= "where 1=1 and lancto.flfixo = 'N' and marcador.debcred = 'D' ";
		$sql .= "	and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "	and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "	and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		
		$rs = $conn->query($sql);
		$ln = $rs->fetch(PDO::FETCH_OBJ);
		$tema->DESPTOTAL = $ln->total;
	}
	
	# ======================================================================================================================
	# Função para pegar a Soma das Receitas
	# ======================================================================================================================
	function getSomaDespesas($conn, $tema, $dtInicio, $dtFim, $numMeses){
		$sql  = "select COALESCE(sum(vlorig),0.00) as total from ";
		$sql .= "	(select (sum(lancto.vlorig) * $numMeses ) as vlorig from lancto, marcador, clifor ";
		$sql .= "		where 1=1 and lancto.flfixo = 'S' and marcador.debcred = 'D' and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador ";
		$sql .= "	union all ";
		$sql .= "	select sum(lancto.vlorig) as vlorig from lancto, clifor, marcador ";
		$sql .= "		where 1=1 and lancto.flfixo = 'N' and marcador.debcred = 'D' ";
		$sql .= "		and lancto.dtvencimento between '$dtInicio' and '$dtFim' ";
		$sql .= "		and lancto.idcontausuario = clifor.idcontausuario ";
		$sql .= "		and lancto.idclifor = clifor.idclifor and lancto.idmarcador = marcador.idmarcador) as receitas ";
		
		$rs = $conn->query($sql);
		$ln = $rs->fetch(PDO::FETCH_OBJ);
		$tema->TOTALSAIDAS = $ln->total;
		return $ln->total; 
	}	
	
?>