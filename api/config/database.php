<?php 

	class Database {

		private $db_host = 'localhost';
		private $db_name = 'api_db';
		private $db_username = 'root';
		private $db_password = '';
		public $conn;
		


		public function getConnection() {

			$this->conn = null;

			try {
				
				$this->conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->db_username, $this->db_password);

				$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (PDOException $e) {
				
				echo "Connection Error" . $e->getMessage();
			}

			return $this->conn;
		}
	}


 ?>