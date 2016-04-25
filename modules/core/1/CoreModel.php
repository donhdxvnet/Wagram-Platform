<?php

	require_once('ICoreModel.php');
			
	class CoreModel implements ICoreModel
	{
		public static function getUser($login, $password)
		{
			$con = ConnectionHelper::getConnection();
			$sql = "
				SELECT 
					id,
					firstname,
					lastname
				FROM being 
				WHERE login = :login
				AND password = :password
			"; //SQL
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':login', $login); //BIND
			$stmt->bindParam(':password', $password); //BIND
			$stmt->execute();
			$su = $stmt->fetch(PDO::FETCH_OBJ);
			
			return $su;
		}
	
		public static function login($login, $password)
		{
			//User
			$oUser = self::getUser($login, $password);
			if ($oUser == null) throw new Exception(BackendTexts::get('auth_rs_error'));

			//Session					
			self::insertSession($oUser->id);				
			$_SESSION['oUser'] = $oUser;
			
			return true;
		}
		
		public static function logout()
		{
			$sessid = session_id();
			$idUser = $_SESSION['oUser']->id;
			
			$con = ConnectionHelper::getConnection();
			$sql = "
				UPDATE lifetime SET
					sessid = '',
					conn = :conn,
					discDate = NOW()		 					
				WHERE idBeing = :idUser
				AND sessid = :sessid				
			";
			
			$stmt = $con->prepare($sql);		
			$conn = 0; 
			$stmt->bindParam(':conn', $conn); 
			$stmt->bindParam(':idUser', $idUser);		
			$stmt->bindParam(':sessid', $sessid);
			$stmt->execute();
					
			$_SESSION = array();
			if (isset($_COOKIE[session_name()])){
				setcookie(session_name(), '', time() - 42000, '/');
			}
			session_destroy();
			header('location:index.php');
		}
		
		public static function insertSession($idBeing)
		{
			$con = ConnectionHelper::getConnection();
			$sql = "
				INSERT INTO lifetime
				(idBeing, connDate, conn, sessid)
				VALUES (:idBeing, NOW(), :conn, :sessid)
			";
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':idBeing', $idBeing);
			$val = 1; 
			$stmt->bindParam(':conn', $val);
			$sessid = session_id();
			$stmt->bindParam(':sessid', $sessid);
			$stmt->execute();
		}
	}

?>
