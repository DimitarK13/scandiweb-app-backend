<?php 
	class DbConnect {
		private $server = 'eu-cdbr-west-03.cleardb.net';
		private $dbname = 'heroku_a0e1d5a5f142051';
		private $user = 'b5f10390f36ddc';
		private $pass = 'a92fbbb3';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch (\Exception $e) {
				echo "Database Error: " . $e->getMessage();
			}
		}
	}
 ?>