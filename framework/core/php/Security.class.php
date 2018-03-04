<?php 

class Security {
	
	private static $instance = null;
	private $authorized = true;
	public $env = null;

	public function __construct(){
		if (
			isset($_SERVER['SERVER_SIGNATURE'])
			&& $_SERVER['SERVER_SIGNATURE'] != ""
			&& isset($_SERVER['SERVER_NAME'])
			&& $_SERVER['SERVER_NAME'] != ""
			&& isset($_SERVER['SERVER_ADDR'])
			&& $_SERVER['SERVER_ADDR'] != ""
			&& isset($_SERVER['SERVER_PORT'])
			&& $_SERVER['SERVER_PORT'] != ""
		){
			$this->env = "www";
		}else{
			$this->env = "cli";
		}
	}

	public static function getSingleton(){
		if (is_null(self::$instance)){
			self::$instance = new Security();
		}
		return self::$instance;
	}

}

?>