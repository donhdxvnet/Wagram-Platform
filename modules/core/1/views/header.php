<?php

//Security::checkAdminByPass(); TODO

$name = $_SESSION['oUser']->prenom.' '.$_SESSION['oUser']->nom;
?>
<div id="header_info" class="color_gray_dark">
        <?php echo BackendTexts::get('auth_welcome').' '.$name.', <img class="img_bottom" src="assets/images/cadena_close.png" /> <a class="color_gray_dark" href="?action=logout">'.BackendTexts::get('auth_logout').'</a>';?>
</div>
<?php
if(!$_SESSION['oUser']->isClient){
?>
<div id="global_menu">
    <?php include realpath(Context::getModulePath("menu") . "/views/menu.php"); ?>
</div>
<?php
}
?>
