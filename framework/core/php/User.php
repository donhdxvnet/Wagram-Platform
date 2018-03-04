<?php

	/*
	 * OBSERVER
	 */

	interface IObserver
	{
		function onChanged($sender);		
	}
	
	interface IObservable
	{
		function addObserver($observer);
		function informObserver($sender);
	}
	
	class User implements IObservable 
	{
		private $observers = array();
		public $users = array();
		
		public function User()
		{				
			$this->addObserver(new UserObserver());
		}
		
		public function addUser($name)
		{			
			$this->users[] = $name;
						
			//informObserver
			$this->informObserver($this);
		}
		
		public function addObserver($observer)
		{
			$this->observers[] = $observer;
		}
		
		public function informObserver($sender)
		{
			foreach ($sender->observers as $obs)
			{
				$obs->onChanged($sender);
			}
		}
	}
	
	class UserObserver implements IObserver
	{
		public function onChanged($sender)
		{
			echo "users : ";
			foreach ($sender->users as $user)
			{
				echo $user;
			}
		}
	}
	
	//Test
	$user = new User();
	$user->addUser("Jack");
	
?>