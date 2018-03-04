<?php

	class Stopwatch implements IStopwatch {

		private $start = null;
		private $end = null;
		private $elapsedTime = null;
		private $hours = null;
		private $minutes = null;

		public function __construct(){
			
		}

		public function start(){
			$this->start = microtime(true);
		}

		public function end(){
			$this->end = microtime(true);
		}		

		public function getElapsedTime(){
			$this->elapsedTime = $this->end - $this->start;
			return $this->elapsedTime;
		}

		public function getHours(){
			$this->hours = (int)($this->elapsedTime/60/60);
			return $this->hours;
		}

		public function getMinutes(){
			$this->minutes = (int)($this->elapsedTime/60)-$this->hours*60;
			return $this->minutes;
		}

	}

?>