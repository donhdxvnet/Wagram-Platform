<?php

	interface ICoreModel
	{		
		public static function getUser($login, $passe);	
		public static function insertSession($idBeing);
	}

?>
