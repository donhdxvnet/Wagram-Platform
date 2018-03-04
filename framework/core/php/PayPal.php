<?php 

	/*
	 * ADAPTER
	 */

	// Concrete Implementation of PayPal Class
	class PayPal
	{
		 
		public function __construct()
		{
			//Code
		}
		 
		public function sendPayment($amount) {
			// Paying via Paypal //
			echo "Paying via PayPal: ". $amount;
		}
	}	
	
	interface paymentAdapter
	{
		public function pay($amount);
	}
	
	class paypalAdapter implements paymentAdapter
	{		 
		private $paypal;
	
		public function __construct(PayPal $paypal) {
			$this->paypal = $paypal;
		}
		 
		public function pay($amount) {
			$this->paypal->sendPayment($amount);
		}
	}

?>