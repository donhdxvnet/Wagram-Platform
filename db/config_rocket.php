<?php
	# Configuration BDD 'rocket'	
	# resolution du profil ($switch_host_profile)
	include("switch_host.php");	
		
	$db_host = null;
	$db_console_host = null;
	$db_name = null;
	$db_user = null;
	$db_passwd = null;
	
	# parametres bdd suivant la plateforme
	switch ($switch_host_profile)
	{	
        # Devpt
        case "devpt":
			$db_host = "localhost";
            $db_console_host = "localhost";
            $db_name = "rocket";
            $db_user = "root";
            $db_passwd = "root";
		break;	
	}
?>
