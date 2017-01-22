<?php
 
class DB_Functions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
	$pdo= new DB_Connect();
        $this->db =$pdo->connect();

    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid) {
        $query=$this->db->query("select * from gcm_users where name='$name'");
        // insert user into database
        if($query->rowCount()>0){
            $result = $this->db->exec("UPDATE gcm_users SET name='$name', email='$email', gcm_regid='$gcm_regid', created_at=NOW() WHERE name='$name';" );
        }else{
            $result = $this->db->exec("INSERT INTO gcm_users(name, email, gcm_regid, created_at) VALUES('$name', '$email', '$gcm_regid', NOW())");
        }
        // check for successful store
        if ($result) {
            // get user details
            $id = $this->db->lastInsertId(); // last inserted id
            $result = $this->db->query("SELECT * FROM gcm_users WHERE id = $id") or die(PDOException());
            // return user details
            if ($result->rowCount() > 0) {
                return $result->fetchAll(PDO::FETCH_BOTH);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
	print_r($db);
        $result = $this->db->query("select * FROM gcm_users");
        return $result;
    }
}
?>
