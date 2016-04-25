<?php

	require_once(LIB_PHP . "/utils/FSUtils.class.php");
	
	class BaseModel 
	{		
		//PUBLIC
		public static function create($id)
		{
			self::createDirectory($id); //OK
			//self::createDatabase($id); //OK
			self::startServer($id);			
		}
		
		//PRIVATE		
		
		private static function startServer($id)
		{
			$path = BASE_DEST . "/" .  $id;
			$command = "php";
			$server = "server.php";
			exec($command . " " . $path . "/" . $server);
		}		
		
		private static function createDatabase($id)
		{
			$con = ConnectionHelper::getConnection();
			$sql = "
				CREATE DATABASE IF NOT EXISTS `".$id."`
				CHARACTER SET utf8
				COLLATE utf8_general_ci
			";
			$stmt = $con->prepare($sql);						
			$stmt->execute();
		}

		private static function createDirectory($id)
		{
			//Create
			$path = BASE_DEST . "/" . $id;
			if (!is_dir($path)) FSUtils::mkdir($path, 0777);
						
			//Recursive copy
			FSUtils::copy_rec(BASE_SRC . "/" . $_SESSION["ROOT_VERSION"], BASE_DEST . "/" .  $id);
			//trigger_error("VERSION mod BASE " . );
		}
	}

?>