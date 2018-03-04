<?php 

	//Interfaces
	
	interface ILog {
		public function add($msg);
		public function save();
	}

	interface IStopwatch {
		public function start();
		public function end();
		public function getElapsedTime();
		public function getHours();
		public function getMinutes();
	}

	interface IDb {
	  public function query($sql);
	  public function connect();
	}

	interface IDoc {
		public function load();
		public function scan();
	}

?>