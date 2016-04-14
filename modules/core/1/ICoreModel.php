<?php

interface ICoreModel
{
	public static function getGlobalMenu($oUser);
	public static function getClientMenu($oUser);
	public static function getEventMenu($oUser, $idOp, $idClient);
	public static function getContentMenu($oUser, $idOp, $idClient);
	public static function getStatsMenu($oUser, $idOp, $idClient);
	public static function getGlobalClientsMenu();
	public static function log(Log $l);
	public static function getIdModuleByName($name);
	public static function getUser($login, $passe);
	public static function retrievePassword($email);
}
?>
