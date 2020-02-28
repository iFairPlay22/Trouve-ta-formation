<?php
	/**
	* 
	*/
	class DatabaseActions
	{
        private $_pdo;
		
		function __construct()
		{
            require("params/params.inc.php");
            
            try {
                $this->_pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8;", $user, $pwd, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
            } catch(Exception $e) {
                die('Database connexion error!' . $e->getMessage());
            }
        }
        
        public function addClick($id) {
            $clicks = $this->_pdo->query("SELECT * FROM UserActions WHERE id = \"$id\";");
            if ($clicks->rowCount() == 0) {
                $this->_pdo->query("INSERT INTO UserActions (id, clics) VALUES (\"$id\", 1);");
                return 0;
            }
            $clicks = $clicks->fetch(PDO::FETCH_ASSOC)["clics"] + 1;
            $res = $this->_pdo->query("UPDATE UserActions SET clics = $clicks WHERE id = \"$id\";");
            return $clicks;
        } 

        public function getTop3() {
            $sql = "SELECT id FROM UserActions ORDER BY clics DESC LIMIT 3;";

            $podium = array();
            
            foreach  ($this->_pdo->query($sql) as $row) {
                array_push($podium, array("etablissement" => $row["id"]));
            }

            return $podium;
        }
		
	}
?>