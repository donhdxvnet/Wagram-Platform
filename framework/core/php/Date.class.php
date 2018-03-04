<?php

	class Date {

		private $str;
		private $date;

		public function __construct($str){
			$this->str = $str;
		}

		public function getDate($format, $delimiter){
			$items = str_split($this->str);
			$start = 0;
			$len = 2;
			$date = array();
			foreach ($items as $i => $item){
				if ($item == 'Y') $len = 4;			
				$date[$item] = substr($this->str, $start, $len);
				$start = $start + $len;
			}

			$f = str_split($format);			
			foreach ($f as $j => $k){
				$this->date .= $date[k];				
			}

			echo $this->date;
			return $this->date;
		}

	}

?>