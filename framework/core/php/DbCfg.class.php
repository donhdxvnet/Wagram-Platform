<?php 

	
	class DbCfg {

	  private static $instance;
	  private $host;
	  private $username;
	  private $password;
	  private $dbname;

	  private function __construct(){

	       $this->host = "localhost";
	      $this->username = "root";
	      $this->password = "";
	      $this->dbname = "test";
	    
	  }

	    public function getHost(){
	      return $this->host;
	    }

	    public function getUserName(){
	      return $this->username;
	    }

	   public function getPassword(){
	      return $this->password;
	    }

	public function getDbName(){
	      return $this->dbname;
	    }

	  public static function getSingleton(){
	    if (is_null(self::$instance)){
	      self::$instance = new DbCfg();
	    }
	    return self::$instance;
	  }

	}

?>