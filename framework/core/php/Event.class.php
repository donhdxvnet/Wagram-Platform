<?php 

    class Event {
   
    private static $instance = null;
    private $events = [];

     public static function getInstance($Cfg){
         if (is_null(self::$instance)){
             self::$instance = new Event($Cfg);    
         } 
         return self::$instance; 
     }
    
    public function listen($name, $callback){
        $this->events[$name][] = $callback;
    }

    public function trigger($name, $argument = null){
        foreach ($this->events[$name] as $event => $callback){
            if ($argument && is_array($argument)){
                call_user_func_array($callback, $argument);
            }elseif($argument && !is_array($argument)){
                call_user_func($callback, $argument);
            }else{
                call_user_func($callback);
            }
        }
    }
}

/*

    // Usage with param as array
    // ==================================

    Event::listen('updated', function($param1, $param2){
        echo 'Event ('. $param1 .', '. $param2 .') updated fired! <br>';
    });

    if($user->updated()) {
        Event::trigger('updated', ['param1', 'param2']);
    }

*/

?>