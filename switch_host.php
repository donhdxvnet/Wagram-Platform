<?php
	//resolution du hostname
	//(necessaire pour que le script soit multi-serveur)
	$switch_host_profile = null;
	switch (php_uname("n"))
	{	
        # Devpt
        case "bolderiz":
        	$switch_host_profile = "devpt";
        break;  
	}		
?>