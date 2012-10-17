<?php

	/**
	* @Descriчуo		Responsavel por abstrair as operaчѕes com o banco de dados
	* @autor            Alexsandro Luiz de Assis
	* @email            admin@pointdainformacao.com.br
	* @copyright        www.pointdainformacao.com.br
	*/

	require_once( "clsBanco.php" );

	abstract class abstrair extends banco {

		protected $sql;			#Armazena a string Sql
		protected $tabela;		#Armazena o nome da tabela
		protected $campos;		#Armazena campos 
		protected $criterio;	#Armazena o criterio
		protected $limite;		#Armazena o limite
		protected $joinTabela; 	#Armazena as tabelas que vуo participar		
		protected $ordem; 		#Armazena a ordenaчуo
		protected $grupo; 		#Armazena a agrupamento

		# Metodo executado a ser criado um novo objeto
		public function __construct($tabela){
			$this->tabela = $tabela;
			parent::__construct();
			$this->sql = "";
			$this->campos = "";
			$this->criterio = "";
			$this->limite = "";
			$this->joinTabela = "";
			$this->ordem = "";
			$this->grupo = "";
		}
		
		# Metodo para montar a string com os campos		
		public function setFiltrarCampos($campos, $tab = "", $novoNome = ""){
			if ($tab == "") $tab = $this->tabela;
			if (is_array($campos)){
				foreach ($campos as $col){
					if ($this->campos != "") $this->campos .= ", ";					
					$this->campos .= "`" . $tab . "`.`" . $col . "`";  
				}
			}else{
				if ($this->campos != "") $this->campos .= ", ";		
				$this->campos .= "`" . $tab . "`.`" . $campos . "`";
				if ($novoNome != "") $this->campos .= " as " . $novoNome;
			}
		}

		# Metodo para montar a string com funчѕes dos campos		
		public function setFuncaoCampos($funcao, $campos, $apelido, $tab = ""){
			if ($tab == "") $tab = $this->tabela;
			if (is_array($campos)){
				foreach ($campos as $col){
					if ($this->campos != "") $this->campos .= ", ";					
					$this->campos .= " " . $funcao . "(`" . $tab . "`.`" . $col . "`) as " . $apelido;  
				}
			}else{
				if ($this->campos != "") $this->campos .= ", ";	
				$this->campos .=  " " . $funcao . "(`" . $tab . "`.`" . $campos . "`) as " . $apelido;
			}
		}	
			
		# Metodo para setar novas tabelas em caso de select com Join		
		public function randomico(){
			$this->ordem .= ", RAND() ";
		}			
		
		# Metodo para setar novas tabelas em caso de select com Join		
		public function setTabela($tab){
			$this->joinTabela .= ", `" . $tab . "`";
		}		
		
		# Metodo para montar string com os criterios de seleчуo		
		public function setCriterio($op, $campos, $operador, $valor, $tab = ""){
			if ($tab == "") $tab = $this->tabela;	
			$this->criterio .= " " . $op . " `" . $tab . "`.`" . $campos . "` " . $operador . " " .  $valor;
		}

		# Metodo para montar string com os criterios de seleчуo		
		public function setLimite($ini, $qtde){
			$this->limite = " LIMIT " . $ini . ", " . $qtde;
		}
				
		# Metodo para montar string com as Join entre as tabelas (tabela.campo)
		public function setJoin($tabela, $campo, $tbJoin, $campoJoin){
			$this->criterio .= " and `" . $tabela . "`.`" . $campo . "` = `" . $tbJoin . "`.`" .  $campoJoin . "`";
		}				

		# Monta a parte de ordenaчуo		
		public function setOrdem($campos, $tab = "", $desc=""){
			if ($tab == "") $tab = $this->tabela;
			if ($this->ordem == "") $this->ordem .= " ORDER BY ";
			if (is_array($campos)){
				foreach ($campos as $col){
					if ($this->ordem != " ORDER BY ") $this->ordem .= ", ";					
					$this->ordem .= "`" . $tab . "`.`" . $col . "`" . $desc;  
				}
			}else{
				$this->ordem .= "`" . $tab . "`.`" . $campos . "`" . $desc;
			} 
		}			

		# Monta a parte de agrupamento
		public function setGroup($campos, $tab = ""){
			if ($tab == "") $tab = $this->tabela;
			if ($this->grupo == "") $this->grupo .= " GROUP BY ";
			if (is_array($campos)){
				foreach ($campos as $col){
					if ($this->grupo != " GROUP BY ") $this->grupo .= ", ";					
					$this->grupo .= "`" . $tab . "`.`" . $col . "`";  
				}
			}else{
				$this->grupo .= "`" . $tab . "`.`" . $campos . "`";
			} 
		}			
		
		# Monta o SQL para listar os dados		
		private function montaLista(){
			$this->sql = "SELECT " . $this->campos . " FROM `" . $this->tabela . "` " . $this->joinTabela . " WHERE 1=1 " . $this->criterio . $this->ordem . $this->grupo . $this->limite;
		}			
		
		# Pega o SQL montado		
		public function getLista(){
			$this->montaLista();
			die($this->sql);
			return $this->sql;
		}	

		# Lista dados
		public function lista(){
			$this->montaLista();
			return $this->selecionar($this->sql);
		}
	}	

?>