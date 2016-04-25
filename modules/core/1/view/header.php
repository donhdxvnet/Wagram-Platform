<?php
	//Security::checkAdminByPass(); TODO	
?>

<div style="
	border:1px solid black;
	margin-bottom:10px;
	padding:5px;
">	
	<strong>
    <?= $_SESSION['oUser']->firstname ?>/<?= $_SESSION['oUser']->lastname ?>
    </strong>
    
	<a class="color_gray_dark" href="?action=logout">
    	<?= BackendTexts::get('baseLogout')?>
    </a>
</div>

<div id="menu">
    <?php require_once("menu.php"); ?>
</div>