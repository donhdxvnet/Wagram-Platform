<?php
	class ConnectionHelper
	{
		private static $_instance;
		private static $_dbName;
		private function __construct(){}
		private function __clone(){}
		
		public static function getConnection($dbName = 'test')
		{	
			if ( is_null(self::$_instance) || ($dbName != self::$_dbName) )
			{	
				include("db/config_rocket.php");				
								
				//db_host, $db_name, $db_user, $db_passwd
				self::$_dbName = $dbName;		
				$dsn = 'mysql:host=' . $db_host .';dbname=' . self::$_dbName;		
				self::$_instance = new PDO($dsn, $db_user, $db_passwd);
				self::$_instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );			
			}
			return self::$_instance;
		}
	}
?>
