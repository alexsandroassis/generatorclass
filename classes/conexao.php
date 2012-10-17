<?php

	final class Connection extends PDO{
	        
	    public function __construct(){
	        try{
	        parent::__construct('pgsql:host=localhost;port=5432;dbname=finPessoal;user=alexsandro;password=ala6122');
	    }catch(PDOException $e){
	        echo 'Error: '.$e->getMessage();
	    }
	    }
	}

?>