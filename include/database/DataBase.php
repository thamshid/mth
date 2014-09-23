<?php


class DataBase {

	public $connection;

	function Database() {
		$config = Bolt::$config;

		$this -> connection = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
		if ($this -> connection -> connect_errno) {
			die("Failed to connect to MySQLi: " . $this -> connection -> connect_error);
		}
		$this -> connection -> query("DROP TABLE IF EXISTS s");
	}

	// methods

	private function exec($query) {

	}

	public function rows($query) {

		$result = $this -> connection -> query($query);

		return $result -> num_rows;
	}

	public function fetchAll($query) {

		$result = $this -> connection -> query($query);
		if (!$result) {
			return false;
		}
		while ($row = $result -> fetch_object()) {
			$rows[] = $row;
		}
		$result -> close();
		return $rows;

	}
	public function query($query) {

		return $this -> connection -> query($query);
	}
	public function fetch($field, $table, $data) {

		$result = $this -> connection -> query($query);
		$feild = $result -> fetch_field();
		return $feild;
	}

	/*public function fetchObject($query) {
            //echo $query;
		$result = $this -> connection -> query($query);
		$obj = $result -> fetch_object();
		return $obj;
	}*/

	public function insert($feilds, $data, $table) {
		$cols = implode(',', array_values($feilds));

		foreach (array_values($data) as $value) {
			isset($vals) ? $vals .= ',' : $vals = '';
			$vals .= '\'' . $this -> connection -> real_escape_string($value) . '\'';
		}
		//echo 'INSERT INTO ' . $table . ' (' . $cols . ') VALUES (' . $vals . ')';
		return $this -> connection -> real_query('INSERT INTO ' . $table . ' (' . $cols . ') VALUES (' . $vals . ')');
	}

	public function addUser($array) {
		$size = count($array);
		for ($i = 0; $i < $size; $i++) {
			$array[$i] = $this -> connection -> escape_string($array[i]);
		}
		$checkusername = $this -> connection -> query("SELECT * FROM users WHERE Username = '" . $username . "'");

		if ($checkusername -> num_rows == 1) {
			return false;
		} else {
			$registerquery = mysql_query("INSERT INTO users (userName, firstName, lastName,email,password) VALUES('$username', '$fname','$lname', '$email','$password')");
			if ($registerquery) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function update($table,$feilds,$values,$where){
          
		$query='UPDATE `'.$table.'` SET ';
                foreach ($feilds as $i => $value){
			$query.='`'.$feilds[$i].'`=\''.$this -> connection -> real_escape_string($values[$i]).'\',';
		}
                $query=  rtrim($query, ',');
		$query.='  WHERE '.$where;
                //echo $query;
		return $this -> connection -> query($query);
		
	}
	public function close(){
		//$this->connection->close();
	}
	public function escape($value){
		return $this->connection->escape_string($value);
	}
	public function getlink($lino){
	$link = $this -> connection -> query("SELECT name FROM link WHERE clno = '" . $lino . "'");
	return $link;}
}
?>