<?php
	
	/*
	 * ADAPTER
	*/

	class SasConfig 
	{
		public $config = array();
		
		public function __construct()
		{	
			$this->sas["SitemapSas"] = array("sitemap");
			$this->sas["InformationSas"] = array("authentication");
			$this->sas["PublicSas"] = array("public");
			$this->sas["PrivateSas"] = array("private");
			$this->sas["InformationSas"] = array("information");
		}
		
		public function addConfig($cfg)
		{
			$this->sas[$cfg[0]] = array($cfg[1]);
			//echo "<pre>"; print_r($this->sas); echo "<pre>";	
		}
	}

	class Sas
	{
		public $config;
		public $sas;
		
		public function __construct($config, $cfg)
		{		
			$this->config = $config;
			foreach ($this->config->sas as $key => $tags)
			{	 
				if ($cfg == $tags) $this->sas = new $key();
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
		public function login()
		{
			echo "PrivateSas login";	
		}
	} 
	
	class PublicSas implements ISas
	{
		public function login()
		{
			echo "PublicSas login";
		}
	}
		
	$sasConfig = new SasConfig();
	$sasConfig->addConfig(array("SpecialSas", "special"));
	
	//echo "<pre>"; print_r($sasConfig); echo "<pre>";	
	$sasFactory = new Sas($sasConfig, array("public"));
	$sasFactory->login();
?>