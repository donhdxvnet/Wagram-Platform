<?php

class CoreController  extends BaseController
{
    public static function process($params)    
    { 
        if ( ! isset($params['action']))
        {        	
            include 'views/index.php';
            exit;
		}

        try{
            switch ($params['action']){
                case 'login':
                    if (empty($_REQUEST['in_login']) || empty($_REQUEST['in_password']))
                            throw new Exception(BackendTexts::get('auth_rs_empty_field'));
                    $model = Context::getModel('core');
                    if ( ($oUser = $model::getUser($_REQUEST['in_login'],$_REQUEST['in_password'])) == null )
                            throw new Exception(BackendTexts::get('auth_rs_error'));
                    $_SESSION['oUser'] = $oUser;	
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
                    if ( isset($_SESSION['oUser']))
					{
						$id = $_SESSION['oUser']->id;						
						$msg = BackendTexts::get('core_session_closed');
						self::log('core', $msg, $id);
						
						$_SESSION = array();
						if (isset($_COOKIE[session_name()]))
						{
							setcookie(session_name(), '', time()-42000, '/');
						}
						session_destroy();
                    }
                    header('location:index.php');
                break;

                case 'lostpassword':
                    include 'views/lostpassword.php';
                    exit;
                break;

                case 'updatelogin':
                    include 'views/login.php';
                    exit;
                break;

                case 'updateheader':
					include 'views/header.php';
                    exit;
                break;

                case 'home':
                    include 'views/content.php';
                        if(!$_SESSION['oUser']->isClient) exit;

                        $m = Context::getModel('user');
                        $idClient = $m::getIdClientForUser($_SESSION['oUser']->id);
                        $m = Context::getModel('client');
                        if(isset($_SESSION['oEvent']))
                                unset($_SESSION['oEvent']);
                        $_SESSION['oClient'] = $m::getById($idClient);

						include realpath(Context::getModulePath("menu") . "/views/client_content.php");
                        exit;
                break;

            }

            self::log('core', $msg);
            self::createAjaxResponse(1,$msg);
        }catch (Exception $e){
            self::createAjaxResponse(0, $e->getMessage());
        }
    }
}
?>
