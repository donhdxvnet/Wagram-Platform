<?php 

	/*
	 * FACTORY
	 */

	interface IParser
	{
		//Read
		public function readFile($file);
		//Parse file content
		public function parseFile();
	}	

	class JsonParser implements IParser
	{
		public $content;
		
		public function __construct($file)
		{
			$this->readFile($file);
		}
		
		public function readFile($file)
		{
			if (file_exists($file))
			{
				$this->content = file_get_contents($file);
				//echo $this->content; //debug
			}
		}
		
		public function parseFile()
		{
			return json_decode($this->content);
		}
	}
	
	class YamlParser implements IParser 
	{
		public $content;
		
		public function __construct($file)
		{
			$this->readFile($file);
		}
		
		public function readFile($file)
		{
			if (file_exists($files))
			{
				$this->content = file_get_contents($file);				
			}
		}
		
		public function parseFile()
		{
			return yaml_parse($this->content);
		}
	}
	
	class XmlParser implements IParser	
	{	
		public $content;
	
		public function __construct($file)
		{
			$this->readFile($file);
		}
	
		public function readFile($file)
		{
			if (file_exists($file)) {
				$this->content = file_get_contents($file);
			}
		}
	
		public function parseFile()
		{
			return simplexml_load_string($this->content);
		}
	
	}
	
	class ParserFactory  
	{
		public static function getParser($file)
		{
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			//echo $ext; //debug
			switch ($ext)
			{
				case "json" :
					return new JsonParser($file);
				break;
				case "xml" :
					return new XmlParser($file);
				break;
				case "yml" :
					return new YamlParser($file);
				break;
				default:
					throw new Exception("File type not supported");
			}
		}
	}
		
?>