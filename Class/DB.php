<?php

Class DB
{
	private static $_instance = null;
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0,
			$_hash_category;

	private function __construct ()
	{
		try{
			$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').
									';dbname='.Config::get('mysql/db'),
									Config::get('mysql/username'),
									Config::get('mysql/password'));
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance ()
	{
		if (!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}


	public function query ($sql, $params = array())
	{
		$this->_error = false;

		if ($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;

			if (count($params)){
				foreach ($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if ($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}else{
				$this->_error = true;
			}
		}
		return $this;
	}

	public function action ($action, $table, $where = array())
	{
		if (count($where) === 3){
			$operators = array('=', '<', '>', '!=', '<=', '>=');

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if (in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				if (!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	public function get ($table, $where)
	{
		return $this->action("SELECT *", $table, $where);
	}

	public function insert ($table, $fields = array())
	{
		if (count($fields)){
			$keys = array_keys($fields);
			$values = '';
			$x = 1;

			foreach ($fields as $field){
				$values .= '?';
				if ($x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}

			$sql = "INSERT INTO {$table} (`". implode("`, `", $keys) ."`) VALUES ({$values})";

			if (!$this->query($sql, $fields)->error()){
				return true;
			}
		}
		return false;
	}

	/**
	* Funtion to randomly select where to store user's data
	* i.e. either on database server or file system on your server
	*/

	public function select_storage ($user_data = array())
	{
		(int)$category = rand(0, 1); //randomly generate either 0(for database) or 1(for filesystem)
		/*
		 * The above numbers is used to select where to store the user's data
		 */

		switch ($category) {
			case 0:
				// Data will be stored in database server
				if ($this->insert('users', $user_data)){
					/**
					 * Now with the help of setEntry() function we will create
					 * an cryptic entry in the database server table to let us know
					 * exactly where we've stored userdata.
					 */

					if ($this->setEntry($user_data['username'], $category)){
						echo "ok!<br>";
					}else{
						echo "fail!<br>";
					}
				}
				break;

			case 1:
				// Data will be stored in filesystem on server
				$filename = hash('sha1', $user_data['username']);
				
				// serliazinig the array which creates a storable representation
				$data = serialize($user_data);

				/** 
				 * Creating a file with filename being hashed
				 * with username. So that when we'll have to retrive
				 * data for that particular user, we just have to hash
				 * the username and search for the file with filename of
				 * that hashed value.
				 */ 

				$file = fopen("user_data/".$filename.".txt", "w");
				fwrite($file, $data);
				if ($this->setEntry($user_data['username'], $category)){
					echo "ok!<br>";
				}else{
					echo "fail!<br>";
				}
				fclose($file);
				
				break;

		}
		return $category;
	}

	/**
	 * This function will create a record in the database that 
	 * will indicate where the data of particular user is stored.
	 */

	private function setEntry ($username, $category)
	{
		
		$hash_username = hash('sha256', $username);
		$hash_category = ($category == 0) ? hash('sha256', "database_server_storage") : 
						(($category == 1) ? hash('sha256', "filesystem_storage") : die("Wrong Category"));
		
		if ($this->insert('_table', array(
				'_column_1' => $hash_username,
				'_column_2' => $hash_category
			))){
			return true;
		}

	}

	/**
	 * This function will look in a table in the database to look for a
	 * record of the user. The table will indicate whether the data is stored 
	 * in database itself or in a file. And will return 0(for database) and 
	 * 1(for filesystem).
	 */

	public function getEntry ($username)
	{
		$hash_name = hash('sha256', $username);

		$search = $this->get('_table', array('_column_1', '=', $hash_name));

		if (!$this->error()){
			$category_hash = $search->first()->_column_2;

			if ($category_hash === hash('sha256', "database_server_storage")){
				$category = 0;
			}else if ($category_hash === hash('sha256', "filesystem_storage")){
				$category = 1;
			}
			return $category;
		}
	}

	/**
	 * This function will return the data of the user.
	 * For use we will have to pass the catergory i.e. where the data is stored,
	 * returned from the function getEntry() and username.
	 */

	public function getData ($category, $username)
	{
		switch ($category) {
			case '0':
				$get = $this->get('users', array('username', '=', $username));
				return $get->first();
				break;
			
			case '1':
				$file = file_get_contents("user_data/".hash('sha1', $username).".txt");
				$this->_results = unserialize($file);
				return $this->results();

				break;
			default:
				echo "Wrong category!";
				break;
		}
	}

	/**
	 * Function checks whether the user's record exists or not.
	 */

	public function exists ($username)
	{
		$results = $this->get('_table', array('_column_1', '=', hash('sha256', $username)));
		if ($this->_count > 0){
			return true;
		}
		return false;
	}

	public function error ()
	{
		return $this->_error;
	}

	public function results ()
	{
		return $this->_results;
	}

	public function first ()
	{
		return $this->results()[0];
	}

}