<?php 

class DbApp implements IDb
{
    protected static $instance = null;
    private $connect = null;   
    private $select = null;

    private $Cfg = null;
     
  public function __construct($Cfg) {
    $this->Cfg = $Cfg;
  }
  
  public static function getSingleton($DbCfg){
    if (is_null(self::$instance)){
      self::$instance = new DbApp($DbCfg);
    }
    return self::$instance;
  }
  
  public function query($sql){
  //mysql_real_escape_string
    $query = mysql_query($sql);
    if (!$query){
      return false;
    }
      return $query;
  }
  
  public function connect()
  {
    $this->connect = mysql_connect($this->Cfg->getHost(), $this->Cfg->getUserName(), $this->Cfg->getPassword());  
    // Rendre la base de données foo, la base courante
    $this->select = mysql_select_db($this->Cfg->getDbName(), $this->connect);    
  }

  public function close(){
    mysql_close($this->connect);
  }

}

?>