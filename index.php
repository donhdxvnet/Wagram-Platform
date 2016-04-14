<?php
	
try
{

	require_once("lib/php/core/BaseController.class.php"); //Context
	require_once("lib/php/core/Context.class.php"); //Context
	require_once("lib/php/core/Config.class.php");//Config
	require_once("lib/php/core/BackendTexts.class.php"); //Texts

	//Langue
	if (!isset($_SESSION['langue'])){
		$_SESSION['langue'] = 'fr';
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
	if (!isset($_SESSION["cc_version"])){
		$_SESSION["cc_version"] = Config::getCurrentCCVersion();
	}
	if (isset($_REQUEST["datas_version"])){
		$_SESSION["datas_version"] = $_REQUEST["datas_version"];
	}
	if (isset($_REQUEST["cc_version"])){
		$_SESSION["cc_version"] = $_REQUEST["cc_version"];
	}
	trigger_error("<pre>" . print_r($_SESSION, true) . "</pre>"); //DEBUG
	
	//BackendTexts
	$textPath = "config/backend_texts.xml";
	BackendTexts::getInstance($textPath, $_SESSION['langue']);
	
	$className = "CoreController";
	$modPath = Context::getModulePath("core");
	$classPath = $modPath . $className . ".class.php";
	
	//DEBUG
	/*
	echo $modPath;
	echo "<br/>";
	echo $classPath;
	*/
		
	if (isset($_REQUEST['mod']) &&(isset($_REQUEST['action']) || isset($_REQUEST['ajax'])))
	{
		$sLastModule = (isset($_SESSION['oModule']))? $_SESSION['oModule'] : null;
		//$mDAO = new ModuleDAO();
		//$oModule = $mDAO->getByName($_REQUEST['mod']);
		$oModule = $_REQUEST['mod']; //Simplifier la recuperation du module
		if(!empty($oModule)) $_SESSION['oModule'] = $oModule;
		$className = ucfirst($_REQUEST['mod']) . 'Controller';
	
		$modPath = Context::getModulePath($_REQUEST['mod']);
		$classPath = $modPath . $className . '.class.php';
		if (isset($_SESSION['oModule']) && $sLastModule != $_SESSION['oModule'])
		{
			//Assets
			$sModuleAssetsPath = Context::getModuleUrl($_REQUEST['mod']) . 'assets/';
			
			//Textes			
			BackendTexts::loadModuleText($sModuleAssetsPath . 'textes.xml');
			ob_start();
			
			//CSS
			if (!isset($_REQUEST['raw']) || (isset($_REQUEST['raw']) && ($_REQUEST['raw'] != 'true')) ) {
				echo CSSManager::writeScript($sModuleAssetsPath);
			}
		}
	}
	
	if (!file_exists($classPath))
	{
		throw new Exception(__METHOD__.' : Controller ' . $classPath . ' not found');
	}
	
	//Class
	require_once $classPath;
	
	//Process
	call_user_func(array($className, 'process'), $_REQUEST);
	trigger_error('<pre>' . print_r($_SESSION, true) . '</pre>');
	
}
catch (Exception $e)
{
	echo '<pre>';
	print_r($e);
	echo '</pre>';
}	
	
?>