<?php 
	
//	Root
	define("ROOT", "/var/www/html/Rocket");		
	require_once(ROOT . "/lib/php/Parser.php");
	
	class ParserTest extends PHPUnit_Framework_TestCase
	{	
		public function testResult()
		{
			//Expected
			$result = new stdClass();
			$result->user = new stdClass();
			$result->user->id = "123";
			$result->user->number = new stdClass();
			$result->user->number->telephone = "01abc";
			$result->user->number->cellphone = "06abc";
			print_r($result);
			
			//Test			
			$file = ROOT . "/test/Parser/file.json";
			//echo $file; //debug
			$obj = (object)ParserFactory::getParser($file);
			print_r($obj->parseFile());
			
			//Assert
			//$this->assertEquals($obj, $result);
		}
	}
	
?>