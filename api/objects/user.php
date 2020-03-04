<?php 
	
	class User {

		private $conn;
		private $table_name = "users";

		public $id;
		public $firstname;
		public $lastname;
		public $email;
		public $password;

		//this is automatically called
		public function __construct($db) {

			$this->conn = $db;
		}


		//create user
		public function create() {

			$query = "INSERT INTO " . $this->table_name . " SET firstname = :firstname,
						lastname = :lastname,
						email = :email,
						password = :password";

			//prepare our query
			$stmt = $this->conn->prepare($query);

			//sanitize our input
			$this->firstname = htmlspecialchars(strip_tags($this->firstname));
			$this->lastname = htmlspecialchars(strip_tags($this->lastname));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->password = htmlspecialchars(strip_tags($this->password));


			//hash our password for better security
			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);

			//execute query
			if ($stmt->execute(['firstname' => $this->firstname, 'lastname' => $this->lastname, 'email' => $this->email, 'password' => $password_hash])) {
				return true;
			}

			return false;

		}


		//check if email exist
		public function emailExists() {

			$query = "SELECT id, firstname, lastname, password FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";


			$stmt = $this->conn->prepare($query);

			//sanitize
			$this->email = htmlspecialchars(strip_tags($this->email));

			//bind given email value
			//$stmt->bindParam(1, $this->email);

			//execute query
			$stmt->execute(['email' => $this->email]);

			//get number of rows
			$num = $stmt->rowCount();

			//check if email exist
			if ($num > 0) {
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);

				//assign values
				$this->id = $row['id'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->password = $row['password'];

				return true;
			}

			return false;
		}


		public function update() {

			$password_set = !empty($this->password) ? "password = :password" : "";

			$update_query = "UPDATE " . $this->table_name . " SET firstname = :firstname,
					 lastname = :lastname,
					 email = :email,
					 $password_set
					 WHERE id = :id";


			$stmt = $this->conn->prepare($update_query);

			//sanitize
			$this->firstname = htmlspecialchars(strip_tags($this->firstname));
			$this->lastname = htmlspecialchars(strip_tags($this->lastname));
			$this->email = htmlspecialchars(strip_tags($this->email));


			//hash password before saving to DB
			if (!empty($this->password)) {
				$this->password = htmlspecialchars(strip_tags($this->password));
				$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			}


			//execute query
			if ($stmt->execute(['firstname' => $this->firstname, 'lastname' => $this->lastname, 'email' => $this->email, 'password' => $password_hash, 'id' => $this->id])) {
				return true;
			}

			return false;

		}



		public function delete() {
			
					
				$delete_query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

				$stmt = $this->conn->prepare($delete_query);

				// sanitize
    			$this->id = htmlspecialchars(strip_tags($this->id));

				// bind id of record to delete
    			//$stmt->bindParam(1, $this->id);

				if ($stmt->execute(['id' => $this->id])) {
					return true;
				}


			return false;
			

		} 

	}

 ?>