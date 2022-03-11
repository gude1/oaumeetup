<?php
require "conn.php";
/**
 * this class is to validate user on every page
 */
class meetupvalidate extends conn
{ 
	protected $fonttype;
	public function validateUser(){
	if (isset($_SESSION["userid"])) {
	$conn = $this->conn;
	$uid = $this->clean_input($_SESSION["userid"]);
	$uname = $this->clean_input($_SESSION["uname"]);
	$password = $this->clean_input($_SESSION["pass"]);
	$sql = "select fontpref from oaumeetupusers where userid = '$uid' and username='$uname' and password = '$password' and activated = '1' limit 1";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
	if($row = $result->fetch_assoc()){
	$this->fonttype = $row["fontpref"];	
	if (empty($this->fonttype)) {
	$this->fonttype = "cursive";}
	}
	$this->createCookie($this->fonttype);
	return 'true';
	}else{
    unset($_SESSION["userid"]);
	unset($_SESSION["uname"]);
	unset($_SESSION["pass"]);
	session_destroy();
	return 'false';
	}
	}else{
    return 'false';
	}
	/*closing braces for function*/}
	//public function to set font if user is verified
	public function getFont(){
	return $this->fonttype;
    }

    protected function createCookie($data){
    setcookie("fontpref", $data, strtotime( '+30 days' ), "/", "", "");
    }

	 /*function for cleaning data input**/
	public function clean_input($data){
	 $conn = $this->conn;
     $data = trim($data); 
     $data = strip_tags($data); 
     $data = stripslashes($data);  
     $data = htmlentities($data); 
     $data = $conn->real_escape_string($data);
     return $data;   
	}
}
?>