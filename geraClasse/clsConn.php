<?php

Class Postgresql{
	
	protected $pg;

    public function __construct(){
		try {
        	$this->pg = @pg_connect("host=localhost port=5432 dbname=finPessoal user=alexsandro password=ala6122");
            if( pg_connection_status($this->pg) !== 0 ) {
            	throw new Exception("Conexao Falhou");                                  
			}       
		} catch(Exception $erro) {
			echo $erro->getMessage();
            	exit;
            }               
		return false;           
	}       
        
	
    public function __destruct(){
		return pg_connection_status($this->pg) === 0 ? (!pg_connection_busy($this->pg) ? @pg_close($this->pg) : false) : false;
	}       
        
    public function query($sql){
		if(pg_connection_status($this->pg) === 0) { 
			if($this->re = @pg_query($this->pg, $sql)) {                    
				if(preg_match("#^\s?(select)#i", $sql)) {
					if(pg_num_rows($this->re) > 0) {
                    	return $this->re;
					}
				} else {
					return pg_affected_rows($$this->re);
				}                       
			} else {
				echo pg_last_error(); 
				exit;
			}                       
		}       
	}
}

?>
