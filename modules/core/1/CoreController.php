<?php

class CoreController extends Controller
{
    public static function process($params)    
    { 
        if (!isset($params['action']))
        {        	
            include 'core.php';
            exit;
		}

        try
        {
            switch ($params['action'])
            {
                case 'login':
                    if (empty($_REQUEST['in_login']) || empty($_REQUEST['in_password']))
                            throw new Exception(BackendTexts::get('auth_rs_empty_field'));
                    $model = Context::getModel('core');
                    $model::login($_REQUEST['in_login'],$_REQUEST['in_password']);
					$msg = BackendTexts::get('core_session_opened');												
                break;

                case 'retrievepassword':
                    
                    if (empty($_REQUEST['in_username']))
                        throw new Exception(BackendTexts::get('lostpwd_username_empty'));

                    $model = Context::getModel('core');
                    if ( ! $model::retrievepassword($_REQUEST['in_username']))
                        throw new Exception(BackendTexts::get('lostpwd_username_unknown'));

                    $msg = BackendTexts::get('lostpwd_rs_ok');
                break;

                case 'logout':
                									
                    if (isset($_SESSION['oUser']))
					{
						$id = $_SESSION['oUser']->id;						
						$msg = BackendTexts::get('core_session_closed');
						//self::log('core', $msg, $id); //TODO						
						$model = Context::getModel('core');
						$model::logout();
                    }
                    
                break;

                case 'lostpassword':
                    include 'view/lostpassword.php';
                    exit;
                break;

                case 'updatelogin':
                    include 'view/login.php';
                    exit;
                break;

                case 'updateheader':
					include 'view/header.php';
                    exit;
                break;

                case 'home':
                    include 'view/content.php';
                    exit;
                break;

            }
            //self::log('core', $msg);
            self::createAjaxResponse(1,$msg);
        }catch (Exception $e){
            self::createAjaxResponse(0, $e->getMessage());
        }
    }
}
?>
