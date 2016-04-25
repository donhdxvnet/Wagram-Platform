<?php

	try
	{	
		//Session
		session_start();
		
		//Constants	
		//TODO : A stocker dans la session	
		define("ROOT", "Ai");
		define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/" . ROOT);	
		define("LIB_PHP", ROOT_PATH . "/lib/php"); 
		define("LIB_JS", ROOT_PATH . "/lib/js");

		define("BASE", "AiBases");
		define("BASE_SRC", ROOT_PATH . "/bases");
		define("BASE_DEST", ROOT_PATH . "/" . BASE);
		
		//Libs
		require_once(LIB_PHP . "/core/Controller.class.php");
		require_once(LIB_PHP . "/core/Context.class.php"); 
		require_once(LIB_PHP . "/core/Config.class.php");
		require_once(LIB_PHP . "/core/BackendTexts.class.php");
		require_once(LIB_PHP . "/core/ConnectionHelper.class.php"); 
	
		//Langue
		if (!isset($_SESSION['langue'])){
			$_SESSION['langue'] = 'en';
		}
		if (isset($_REQUEST['langue'])){
			$_SESSION['langue'] = $_REQUEST['langue'];
		}
		
		//Module
		if (isset($_SESSION['oModule'])){
			unset($_SESSION['oModule']);
		}
		
		//Version
		if (!isset($_SESSION["datas_version"])){
			$_SESSION["datas_version"] = Config::getCurrentDatasVersion();
		}
		if (!isset($_SESSION["ROOT_VERSION"])){
			$_SESSION["ROOT_VERSION"] = Config::getCurrentCCVersion();
		}
		
//TEST
//print_r($_SESSION);
		
		//BackendTexts
		$textPath = "config/backend_texts.xml";
		BackendTexts::getInstance($textPath, $_SESSION['langue']);
		
		//Class
		if (isset($_REQUEST['mod']) && isset($_REQUEST['action']) || isset($_REQUEST['ajax']))
		{	
			$oModule = $_REQUEST['mod'];
			if (!empty($oModule)) $_SESSION['oModule'] = $oModule;
		}else{
			$sLastModule = (isset($_SESSION['oModule']))? $_SESSION['oModule'] : null;
			$oModule = "core";
		}	
		$className = ucfirst($oModule) . "Controller";
		$modPath = Context::getModulePath($oModule);
		
		//ClassPath
		$classPath = $modPath . $className . ".php";
		if (!file_exists($classPath)){
			throw new Exception(__METHOD__.' : Controller ' . $classPath . ' not found');
		}else{
			require_once $classPath;
		}
		
		//Process
		call_user_func(array($className, 'process'), $_REQUEST);		
		
	}
	catch (Exception $e)
	{
		echo '<pre>';
		print_r($e);
		echo '</pre>';
	}
	
?>