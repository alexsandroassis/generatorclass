<?php

	abstract class banco{

		# Propriedades
		protected $server;
		protected $user;
		protected $password;
		protected $banco;			
		protected $conn;
		
		# Metodos Publicos
		public function __construct(){
			$this->server = SERVER;
			$this->user = USER;
			$this->password = SENHA;
			$this->banco = BANCO;
			$this->conectar();			
		}

		public function conectar(){
			$this->conn = mysql_connect($this->server, $this->user, $this->password);
			if ($this->conn){		
				if( !mysql_select_db($this->banco,$this->conn) ) echo "Erro ao conectar ao banco de dados";	
			}else{
				echo "Erro ao se conectar ao servidor de banco de dados";
			}
		}
		
		public function selecionar($sql){		
			!$seleciona = mysql_query($sql, $this->conn);
			return $seleciona;
		}

	}

?> 