<?php
	
	/*
	 * ADAPTER
	 */
	 
	class Sas
	{
		public $sas;
		
		public function __construct(SasConfig $config)
		{
			//echo $config->engine; //debug
			$className = sprintf("%sSas", $config->engine);			
			if (class_exists($className))
			{
				//echo $className; //debug				
				$this->sas = new $className();				
			}
		}
		
		public function login()
		{
			$this->sas->login();
		}
	}
	
	interface ISas
	{
		public function login();		 
	}
	
	class PrivateSas implements ISas
	{
		public function __construct()
		{
			echo "PrivateSas construct";
		}
		
		public function login()
		{
			echo "PrivateSas login";	
		}
	} 
	
	class PublicSas implements ISas
	{
		public function __construct()
		{
			echo "PublicSas construct";
		}
		
		public function login()
		{
			echo "PublicSas login";
		}
	}
	
	/*
	 * TEST
	 */
	
	class SasConfig
	{
		public $engine = "Private";
	}
	$config = new SasConfig();	
	
	$obj = new Sas($config);
	$obj->login();
?>