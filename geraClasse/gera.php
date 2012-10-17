<?php 

    require("../classes/Template.class.php");
    require("clsConn.php");
    $tabela = $_GET['tb'];

    $tpl = new Template("classe.html");
    $tpl->addFile("ENTIDADE","interface.html"); 
    $tpl->addFile("BANCODEDADOS","banco.html");
    $tpl->addFile("DBCLASSE","classePersonaliza.html");
     
	$db = new Postgresql();

	$sql .= " SELECT * FROM ";
	$sql .= "   (SELECT DISTINCT ";
	$sql .= "     columns.table_name, columns.column_name, columns.ordinal_position, columns.data_type, 1 as pk ";
	$sql .= "   FROM information_schema.columns, information_schema.constraint_column_usage ";
	$sql .= "   WHERE columns.table_catalog = constraint_column_usage.table_catalog AND columns.table_schema = constraint_column_usage.table_schema AND ";
	$sql .= " 	  columns.table_name = constraint_column_usage.table_name AND columns.column_name = constraint_column_usage.column_name ";
	$sql .= "   UNION ALL ";
	$sql .= "   SELECT ";
	$sql .= "     columns.table_name, columns.column_name, columns.ordinal_position, columns.data_type, 0 as pk ";
	$sql .= "   FROM ";
	$sql .= "     information_schema.columns ";
	$sql .= "   WHERE NOT EXISTS ";
	$sql .= "     (SELECT (1) FROM information_schema.columns col, information_schema.constraint_column_usage ";
	$sql .= "   WHERE col.table_catalog = constraint_column_usage.table_catalog AND col.table_schema = constraint_column_usage.table_schema AND ";
	$sql .= "     col.table_name = constraint_column_usage.table_name AND col.column_name = constraint_column_usage.column_name AND ";
	$sql .= "     columns.table_catalog = col.table_catalog AND columns.table_schema = col.table_schema AND ";
	$sql .= "     columns.table_name = col.table_name AND columns.column_name = col.column_name) ";
	$sql .= "   ) as tb ";
	$sql .= " WHERE ";
	$sql .= "   1=1 AND table_name = '$tabela' ORDER BY 3 ";
	$rs = $db->query($sql);
	
	$tpl->TABLE = $tabela;

	/* =========================== */	
	/* Gera atributos da Interface */
	/* =========================== */
	while ($data = pg_fetch_object($rs)){
		$tpl->COLUNA = $data->column_name;
		$tpl->block("BLOCK_COLUNA");
	}
	pg_result_seek($rs, 0);
	
    /* =========================== */
    /* Gera metodos da Interface   */
    /* =========================== */    
	while ($data = pg_fetch_object($rs)){
		$tpl->COLUNAMETODO = $data->column_name;
		$tpl->block("BLOCK_METODO");
	}
	pg_result_seek($rs, 0);
     
    /* =============================== */
    /* Gera metodos da base de dados   */
    /* =============================== */
    $tpl->COLUNASSQL = '';
    $tpl->COLUNASPARAM = '';
    $j = 0;
    while ($data = pg_fetch_object($rs)){
    	if ($j == 0){ 
    		$tpl->COLUNASSQL .= $data->column_name;
    		$tpl->COLUNASPARAM .= '?';
    		$j=1;
    	}else{
    		$tpl->COLUNASSQL .= ', ' . $data->column_name;
    		$tpl->COLUNASPARAM .= ', ?';
    	}
    }
    pg_result_seek($rs, 0);
    
    /* =========================== */
    /* Gera metodo insert		   */
    /* =========================== */
    $j = 1;
    while ($data = pg_fetch_object($rs)){
    	$tpl->ID = $j;
    	$tpl->COLPARAM = $data->column_name;
    	$tpl->TIPOPARAM = tipoParam( $data->data_type );
    	$tpl->block("BLOCK_PARAMINSERT");
    	$j++;
    }
    pg_result_seek($rs, 0);

    /* =================================== */
    /* Gera colunas para o metodo Update   */
    /* =================================== */
    $tpl->COLUNASUPDATE = '';
    $tpl->COLUNASCLAUSULA = '';
    $j = 0;
    while ($data = pg_fetch_object($rs)){
    	if ($j == 0) {
    		if ($data->pk != 1){
    			$tpl->COLUNASUPDATE .= $data->column_name . ' = ?';
    			$j++;
    		}else $tpl->COLUNASCLAUSULA .= ' AND ' . $data->column_name . ' = ?';
    	}else{
    		if ($data->pk != 1){
    			$tpl->COLUNASUPDATE .= ', ' . $data->column_name . ' = ?';
    		}else $tpl->COLUNASCLAUSULA .= ' AND ' . $data->column_name . ' = ?';
    	}
    }
    pg_result_seek($rs, 0);
    
    
    /* =========================== */
    /* Gera metodo update		   */
    /* =========================== */
    $i = 1;
    while ($data = pg_fetch_object($rs)){
    	if ($data->pk != 1){
    		$tpl->IDUPDATE = $i;
	    	$tpl->COLPARAMUPDATE = $data->column_name;
	    	$tpl->TIPOPARAMUPDATE = tipoParam( $data->data_type );
	    	$tpl->block("BLOCK_PARAMUPDATE");
	    	$i++;
    	}
    }
    pg_result_seek($rs, 0);    
    while ($data = pg_fetch_object($rs)){
    	if ($data->pk == 1){
    		$tpl->IDUPDATE = $i;
    		$tpl->COLPARAMUPDATE = $data->column_name;
    		$tpl->TIPOPARAMUPDATE = tipoParam( $data->data_type );
    		$tpl->block("BLOCK_PARAMUPDATE");
    		$i++;
    	}
    }
    pg_result_seek($rs, 0);    
    
    /* =================================== */
    /* Gera colunas para o metodo Delete   */
    /* =================================== */
    $tpl->COLUNASCLAUSULADELETE = '';
    while ($data = pg_fetch_object($rs)){
    	if ($data->pk == 1){
			$tpl->COLUNASCLAUSULADELETE .= ' AND ' . $data->column_name . ' = ?';
    	}
    }
    pg_result_seek($rs, 0);
    
    
    /* =========================== */
    /* Gera metodo delete		   */
    /* =========================== */
    $i = 1;
    while ($data = pg_fetch_object($rs)){
    	if ($data->pk == 1){
    		$tpl->IDDELETE = $i;
    		$tpl->COLPARAMDELETE = $data->column_name;
    		$tpl->TIPOPARAMDELETE = tipoParam( $data->data_type );
    		$tpl->block("BLOCK_PARAMDELETE");
    		$i++;
    	}
    }
    pg_result_seek($rs, 0);

    /* =============================== */
    /* Gera metodo listar Um           */
    /* =============================== */
    $tpl->COLUNASLISTASUM = '';
    $j = 0;
    while ($data = pg_fetch_object($rs)){
    	if ($j == 0){
    		$tpl->COLUNASLISTASUM .= $data->column_name;
    		$j=1;
    	}else{
    		$tpl->COLUNASLISTASUM .= ', ' . $data->column_name;
    	}
    }
    pg_result_seek($rs, 0);
    $tpl->COLCLAUSULALISTARUM = '';
    while ($data = pg_fetch_object($rs)){
    	if ($data->pk == 1){
    		$tpl->COLCLAUSULALISTARUM .= ' AND ' . $data->column_name . ' = ?';
    	}
    }
    pg_result_seek($rs, 0);
    
    /* =========================== */
    /* Gera metodo listar UM	   */
    /* =========================== */
    $i = 1;
    while ($data = pg_fetch_object($rs)){
    	if ($data->pk == 1){
    		$tpl->IDLISTARUM = $i;
    		$tpl->COLPARAMLISTARUM = $data->column_name;
    		$tpl->TIPOPARAMLISTARUM = tipoParam( $data->data_type );
    		$tpl->block("BLOCK_PARAMLISTARUM");
    		$i++;
    	}
    }
    pg_result_seek($rs, 0);

    /* ================================= */
    /* Seta valores atributos Listar UM  */
    /* ================================= */
    while ($data = pg_fetch_object($rs)){
    	$tpl->METODOSET = $data->column_name;
    	$tpl->COLLISTARUM = $data->column_name;
    	$tpl->block("BLOCK_SETVALORES");
    }
    pg_result_seek($rs, 0);
    
    
    /* =============================== */
    /* Gera metodo listar Um           */
    /* =============================== */
    $tpl->COLUNASLISTASTODOS = '';
    $j = 0;
    while ($data = pg_fetch_object($rs)){
    	if ($j == 0){
    		$tpl->COLUNASLISTASTODOS .= $data->column_name;
    		$j=1;
    	}else{
    		$tpl->COLUNASLISTASTODOS .= ', ' . $data->column_name;
    	}
    }
    pg_result_seek($rs, 0);
    
    
    /* ==================================== */
    /* Seta valores atributos Listar Todos  */
    /* ==================================== */
    while ($data = pg_fetch_object($rs)){
    	$tpl->METODOLISTARTODOS = $data->column_name;
    	$tpl->COLLISTARTODOS = $data->column_name;
    	$tpl->block("BLOCK_SETVALORESTODOS");
    }
    pg_result_seek($rs, 0);

    /* =============================== */
    /* Gera metodo listar por Atributo */
    /* =============================== */
    $tpl->COLUNASLISTARATRIBUTO = '';
    $j = 0;
    while ($data = pg_fetch_object($rs)){
    	if ($j == 0){
    		$tpl->COLUNASLISTARATRIBUTO .= $data->column_name;
    		$j=1;
    	}else{
    		$tpl->COLUNASLISTARATRIBUTO .= ', ' . $data->column_name;
    	}
    }
    pg_result_seek($rs, 0);
    
    /* ================================= */
    /* Gera clausula listar atributos    */
    /* ================================= */
    while ($data = pg_fetch_object($rs)){
    	$tpl->CLAUSULAATRIBUTO = $data->column_name;
    	$tpl->block("BLOCK_PORATRIBUTO");
    }
    pg_result_seek($rs, 0);
    
    /* =================================== */
    /* Valida clausula listar atributos    */
    /* =================================== */
    while ($data = pg_fetch_object($rs)){
    	$tpl->CLAUSULAATRIBUTOVALIDA = $data->column_name;
    	$tpl->COLPARAMLISTARUM = $data->column_name;
    	$tpl->TIPOPARAMATRIBUTO = tipoParam( $data->data_type );
    	$tpl->block("BLOCK_PARAMLISTARATRIBUTO");
    }
    pg_result_seek($rs, 0);
    
    /* ================================= */
    /* Gera clausula listar atributos    */
    /* ================================= */
    while ($data = pg_fetch_object($rs)){
    	$tpl->METODOLISTARATRIBUTO = $data->column_name;
    	$tpl->COLLISTARATRIBUTO = $data->column_name;
    	$tpl->block("BLOCK_SETVALORESATRIBUTO");
    }
    pg_result_seek($rs, 0);
    
    
    function tipoParam($tipo){
		$vl = '';    	

    	switch ($tipo){
    	case 'int4':
    	case 'numeric':
    	case 'integer':
    		$vl = 'PARAM_INT';
    		break;
    	case 'varchar':
    	case 'bpchar':
    	case 'date':
    	case 'character varying':
    	case 'character':
    		$vl = 'PARAM_STR';
    		break;
    	default :
    		$vl = $tipo;			
    	}
    	return $vl;
    }
    
    
    $tpl->show(); 
     
?>