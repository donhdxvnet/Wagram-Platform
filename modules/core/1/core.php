<?php

//Security::checkAdminByPass(); //TODO
$is_login = isset($_SESSION['oUser']);

//if(isset($_SESSION['oEvent']))
//	unset($_SESSION['oEvent']);

function langsChoose()
{
    $langs = array('fr', 'en');

    $url = '?';

    parse_str($_SERVER["QUERY_STRING"],$url_params);
    if ( isset($url_params['langue']))
            unset($url_params['langue']);

    if ( isset($url_params['action']) && $url_params['action'] == 'login' )
            unset($url_params['action']);

    if ( isset($url_params['action']) && $url_params['action'] == 'retrievepassword')
            $url_params['action'] = 'lostpassword';

    $query = http_build_query($url_params);
    $url  .= ( ! empty($query))? $query.'&': '';


    $str = '';
    for($i = 0, $size = sizeof($langs); $i < $size; $i++){
            $l = $langs[$i];
            if ( $_SESSION['langue'] != $l) $str .= '<a href="'.$url.'langue='.$l.'">'.strtoupper($l).'</a>';
            else $str .= '<span class="color_blue">'.strtoupper($l).'</span>';
            if($i != count($langs)-1) $str .= ' | ';
    }
    return $str;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<noscript>
		<meta http-equiv="Refresh" content="0; URL=nojs.html"/>
	</noscript>
    <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Test A</title>        		
        <script src="lib/js/jquery-1.11.0.min.js" type="text/javascript"></script>        
        <script src="lib/js/helper.js" type="text/javascript"></script>
        <script src="lib/js/sha512.js" type="text/javascript"></script>
    </head>
    <body>
	<div id="page">
            <div id="header" class="color_white <?=Config::getStage()?>">
                <?php if ( $is_login){
                    require_once("view/header.php");
                } ?>
            </div>
            <div id="content">
                <?php 
                if (!$is_login){
                    require_once("view/login.php");
				}
                ?>
            </div>
            <div id="footer">
                <?php require_once("view/footer.php"); ?>
            </div>
        </div>
    </body>
</html>