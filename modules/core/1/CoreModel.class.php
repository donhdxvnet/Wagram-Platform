<?php

require_once('/ICoreModel.php');
require_once('../../../utils/Crypt.class.php');

class CoreModel implements ICoreModel{
	
	public static function getGlobalMenu($oUser)
	{
		$dao = new ModuleDAO();
		return $dao->getGlobalModules($oUser);
	}
	
	public static function getClientMenu($oUser)
	{
		$dao = new ModuleDAO();
		return $dao->getClientModules($oUser);
	}
	
	public static function getEventMenu($oUser, $idOp, $idClient)
	{
		$dao = new ModuleDAO();
		return $dao->getEventModules($oUser, $idOp, $idClient);
	}
	
	public static function getContentMenu($oUser, $idOp, $idClient)
	{
		$dao = new ModuleDAO();
		return $dao->getContentModules($oUser, $idOp, $idClient);
	}
	
	public static function getStatsMenu($oUser, $idOp, $idClient)
	{
		$dao = new ModuleDAO();
		return $dao->getStatsModules($oUser, $idOp, $idClient);
	}
	
	public static function getGlobalClientsMenu()
	{
		$dao = new ClientDAO();
		return $dao->getAllActive();
	}
	
	public static function log(Log $l)
	{
		$dao = new LogDAO();
		$dao->insert($l);
	}
	
	public static function getIdModuleByName($name)
	{
		$mdao = new ModuleDAO();
		return $mdao->getIdByName($name);
	}

	public static function getUser($login, $password)
	{
		$con = ConnectionHelper::getConnection($this->_oClient->dbName);
		$sql = "SELECT id FROM Users WHERE is_active = 1"; //SQL
		$stmt = $con->prepare($sql);
		//$stmt->bindParam(':eventId', $eventId); //BIND
		$stmt->execute();
		$su = $stmt->fetch(PDO::FETCH_OBJ);
		
		//Comparaison
		$result = null;
		foreach ($datas as $data)
		{
			if ( 
				//username SHA512 == login 
				hash("sha512", $data->login) == $login
				&&
				//password décrypté et SHA512 == password
				hash("sha512", Crypt::decrypt($data->password)) == $password
			){
				$result = $data;
			}
		}		
		return $result;
	}

    public static function retrievePassword($username)
    {
		$dao = new UserDAO();
        if (($user = $dao->getByUsername($username)) == null)
			return false;

        $passe = Crypt::decrypt($user->password);
		$headers ='From: "FAST "<noreply@fast>' . "\n";
		$headers .='Reply-To: noreply@fast' . "\n";
		$str = "As requested, here are your connection informations.\n\n";
			$str .= "LOGIN : " . $user->username . "\n";
        $str .= "PASSWORD : " . $passe . "\n";
        mail($user->email,'Your FAST password', $str, $headers);
		return true;
	}
}
?>
