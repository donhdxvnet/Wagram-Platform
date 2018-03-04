<?php 

class Db implements IDb
{
    protected static $instance = null;
    private $connect = null;   
    private $select = null;

    private $Cfg = null;
    private $Log = null;
    
  public function __construct($Cfg, ILog $Log) {
    $this->Cfg = $Cfg;
    $this->Log = $Log;
  }
  
  public static function getSingleton($DbCfg, ILog $Log){
    if (is_null(self::$instance)){
      self::$instance = new Db($DbCfg, $Log);
    }
    return self::$instance;
  }
  
  public function query($sql){
  //mysql_real_escape_string
    $query = mysql_query($sql);
    if (!$query){
      $this->Log->add('SQL errors'.mysql_error());
      return false;
    }
      return $query;
  }
  
  public function connect()
  {
    $this->connect = mysql_connect($this->Cfg->getHost(), $this->Cfg->getUserName(), $this->Cfg->getPassword());
    // if (!$this->connect){  
     // $this->Log->add('Impossible de se connecter : ' . mysql_error());
    // }
      
// Rendre la base de données foo, la base courante
    $this->select = mysql_select_db($this->Cfg->getDbName(), $this->connect);
    // if (!$this->select){
      //$this->Log->add('Impossible de sélectionner la base de données : ' . mysql_error());
    // }      
  }

  public function close(){
    mysql_close($this->connect);
  }

}

?>