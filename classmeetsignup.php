<?php
session_start();
require "classmeetupvalidate.php";
/**
 * php file  for handling signup database operations
 */
class oaumeetupsignup extends meetupvalidate
{
	private $name;
	private $username;
	private $institution;
	private $gender;
	private $email;
	private $phone;
	private $password;


	 function __construct()
  {
    $this->createConnection();
  }
    public function setName($name){
		$this->name = $this->clean_input($name);
	}

	private function getName(){
		return $this->name;
	}

	public function setUsername($uname){
		$this->username = $this->clean_input($uname);
	}
	
	private function getUsername(){
		return $this->username;
	}

	public function setInstitution($school){
		$this->institution = $this->clean_input($school);
	}
	
	private function getInstitution(){
		return $this->institution;
	}

	public function setGender($gender){
		$this->gender = $this->clean_input($gender);
	}
	
	private function getGender(){
		return $this->gender;
	}


	public function setEmail($email){
		$this->email = $this->clean_input($email);
	}
	
	private function getEmail(){
		return $this->email;
	}

	public function setPhone($phone){
		$this->phone = $this->clean_input($phone);
	}
	
	private function getPhone(){
		return $this->phone;
	}

	public function setPassword($pass){
		$this->password = $this->clean_input($pass);
	}
	
	private function getPassword(){
		return $this->password;
	}

	public function insertuser(){
		$name = $this->getName();
		$username = $this->getUsername();
		$institution = $this->getInstitution();
		$gender = $this->getGender();
		$email = $this->getEmail();
		$phone = $this->getPhone();
		$pass = md5($this->getPassword());
		$conn = $this->conn;

		$query = "select id from oaumeetupusers where email = '$email' or phonenumber = '$phone' limit 1";
		$query1 = "select id from oaumeetupusers where username ='$username' limit 1";
		$result = $conn->query($query);
		$result1 = $conn->query($query1);
		if ($result->num_rows > 0) {
		return "<span class='w3-text-red w3-bold'>Email or Phone number is already in use</span>";	
		}elseif ($result1->num_rows > 0) {
		return "<span class='w3-text-red w3-bold'>Username already exists please try another</span>";	
		}else{
		$userid = md5(rand(0,7000).rand(0,4000));
		$date = time();
		$query ="insert into oaumeetupusers(userid,name,username,email,phonenumber,institution,gender,password,signupdate,activated) values('$userid','$name','$username','$email','$phone','$institution','$gender','$pass','$date','1')";
		if ($conn->query($query) == true) {
		return "success";
		}else{return "<span class='w3-text-red w3-bold'>Failed to register user please try again ".$conn->error."</span>";}}
    }

}
?>