<?php 
session_start();
require "classmeetupvalidate.php";

/**
 * 
 */
class meetuplogin extends meetupvalidate{
	private $email;
	private $password;
	
	function __construct()
	{
	  $this->createConnection();
	}
	//getters and setters for email and password variable
	public function setEmail($email){
		$this->email = $this->clean_input($email);	
	}
	private function getEmail(){
		return $this->email;
	}
	public function setPassword($pass){
		$this->password = $this->clean_input($pass);	
	}
	private function getPassword(){
		return $this->password;
	}

	//function for logging user
	public function logUserIn(){
    $conn = $this->conn;
    $email = $this->email;
    $uid = "";
    $pass = md5($this->password);
    $sql = "select userid,username,password from oaumeetupusers where email = '$email'and password='$pass' and activated ='1' limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    $userid=$dbuname=$dbpass= "";
    if ($row = $result->fetch_assoc()) {
    $uid = $_SESSION["userid"] = $row["userid"];
    $_SESSION["uname"] = $row["username"];
    $_SESSION["pass"] = $row["password"];
    $time = time();
    $sql2 = "update oaumeetupusers  set lastlogindate = '$time' where userid = '$uid' limit 1";
    $conn->query($sql2);
    return "success login";}	
    }else{
    return $conn->error."<span class='w3-text-red w3-bold'>Incorrect Email or Password</span>";
    }
    }
    
}
?>