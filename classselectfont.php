<?php
session_start();
require "classmeetupvalidate.php";
/**
 * this class handles storing of users 
 */
class selectfont extends meetupvalidate
{
	function __construct(){
	$this->createConnection();
	}
	private $pref;
	//setter and getter for variables
	public function setPref($pref){
	$this->pref = $this->clean_input($pref);	
	}
	private function getPref(){
    return $this->pref;
	}
    //update users preference on database
	public function updatePref(){
	$conn = $this->conn;
	$dbpref = $this->getPref();
	$uid = $_SESSION["userid"];
	$sql = "update oaumeetupusers set  fontpref = '$dbpref' where userid='$uid' limit 1";
	if ($conn->query($sql) == "true") {
	$this->createCookie($dbpref);
	return "update successful";
 	}else{
 	return "<span class='w3-text-red w3-bold'>Could not save your font preference please try again later</span><br>";}
	}
}
?>