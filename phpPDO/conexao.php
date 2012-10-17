<?php

	final class Connection extends PDO{
	        
	    public function __construct(){
	        try{
	        parent::__construct('mysql:host=localhost;port=3306;dbname=teste', 'root', '');
	    }catch(PDOException $e){
	        echo 'Error: '.$e->getMessage();
	    }
	    }
	}

?>