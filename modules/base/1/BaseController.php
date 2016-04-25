<?php

class BaseController extends Controller
{
    public static function process($params)    
    { 
        if (!isset($params['action']))
        {        	
            require_once("base.php");
            exit;
		}

        try
        {
            switch ($params['action'])
            {
            	case "create" :            	
            		$model = Context::getModel($params['mod']);
            		$model::create($params['id']);
            		$msg = "";            		
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