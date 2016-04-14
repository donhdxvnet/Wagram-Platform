<?php

	require_once('lib/php/core/Context.php');	
	class ContextTest extends PHPUnit_Framework_TestCase
	{
		public function setUp(){ }
		public function tearDown(){ }
		
		public function testConnectionIsValid()
		{
			// test to ensure that the object from an fsockopen is valid
			$connObj = new RemoteConnect();
		    $serverName = 'www.google.com';
		    $this->assertTrue($connObj->connectToServer($serverName) !== false);
		}
	}

?>