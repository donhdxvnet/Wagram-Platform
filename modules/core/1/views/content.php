<?php

Security::checkAdminByPass();
// $is_login provient de main.php
if(isset($is_login) && $_SESSION['oUser']->isClient && $_SESSION['oClient']) $bReload = true;
else $bReload = false;
?>
<div id="global_content">
	<?php
	if($bReload) include realpath(Context::getModulePath("menu") . '/views/client_content.php');
	?>
</div>
