<?php
session_start();
require "classmeetupvalidate.php";
/**
 *
 */
class profile extends meetupvalidate
{
	private $userid;
	private $profileownerid;
	private $achatid;
	private $chatid;
	public $chatexists = false;
	public $achatexists = false;

    function __construct()
	{
	  $this->createConnection();
	if(isset($_SESSION["userid"])){
    $this->setUserid   ($_SESSION["userid"]);
	}
	}

    public function setUserId($data){
    $this->userid = $this->clean_input($data);
    }
    public function getUserId(){
    return $this->userid;
    }
    public function setOwnerId($data){
    $this->profileownerid = $this->clean_input($data);
    }
    public function getOwnerId(){
    return $this->profileownerid;
    }
    public function setChatId($data){
    $this->chatid = $this->clean_input($data);
    }
    public function getChatId(){
    return $this->chatid;
    }
    public function setAchatId($data){
    $this->achatid = $this->clean_input($data);
    }
    public function getAchatId(){
    return $this->achatid;
    }


    public function getProfileDetails(){
    $conn = $this->conn;
    $uid = $this->getUserId();
    $ownerid = $this->getOwnerId();
    $sql = "select * from oaumeetupusers where userid = '$ownerid' and activated = '1' limit 1";
    $result = $conn->query($sql);
    if($result->num_rows  == 1){
    if($row = $result->fetch_assoc()){
    $userid = $row["userid"];
    $name = $row["name"];
    $username = $row["username"];
    $email = $row["email"];
    $phonenumber = $row["phonenumber"];
    $institution = $row["institution"];
    $gender = $row["gender"];
    $pass = $row["password"];
    $signupdate = $row["signupdate"];
    $avatar = $row["avatar"];
    $farray = json_decode($row["friend_array"],true);
    $mprefernce = json_decode($row["meetup_preference"],true);
    $bio = $row["bio"];
    $lastlog = $row["lastlogindate"];
    $attributes = json_decode($row["attributes"],true);
    }
    if(empty($avatar) && $gender == "female"){
    $avatar = "femaledefault.jpeg";
    }elseif(empty($avatar) && $gender == "male"){
    $avatar = "maledefault.jpeg";
    }
    if(empty($bio) && $gender == "female"){
    $bio = "Don't doubt it,you are a beauty :)";
    }elseif(empty($bio) && $gender == "male"){
    $bio="Bro you are cool";
    }
    return array($name,$username,$institution,$gender,$avatar,$bio,$lastlog,$attributes,$mprefernce);
    }else{
    return "";
    }
    }
    //function to Handle Posting Of Status Starts Here
    public function updateStatus($data){
    $conn = $this->conn;
    $uid = $this->getUserId();
    $ownerid = $this->getOwnerId();
    $status = $this->clean_input($data);
    $sql= "update oaumeetupusers set bio ='$status' where userid='$ownerid' limit 1";
    if($uid != $ownerid){
    return "You are not the owner of this profile and cannot  upload status";   }
    if(empty($status) || $status == ""){
    return "sorry your status contains character that are not accepted";
    }
    
    if($conn->query($sql) == "true"){
    return "success";
    }else{
    return "sorry could not upload your status please try again";
    }
    }//ClosinG Braces For Function
    
    //function to handle uploading Of Profile Pic Starts Here
    public function updateProfilePic($data){
        $conn = $this->conn;
        $file = $this->clean_input($data);
        $uid = $this->getUserId();
        $ownerid = $this->getOwnerId();
        $sql = "update oaumeetupusers set avatar = '$file' where userid='$ownerid' limit 1";
        if(!file_exists($file)){
         return "sorry  your file has not yet being uploaded";
        }else if($uid != $ownerid){
        return "You Are Not The Owner Of This Profile And Cannot Change ProFile Picture";
        }
        $sql1= "select avatar from oaumeetupusers where userid='$ownerid' limit 1";
        $result1 = $conn->query($sql1);
        if($result1->num_rows == 1){
        if($row1 = $result1->fetch_assoc()){
        $avatar = $row1["avatar"];
        }else{
        return "Sorry user does not";
        }
        }//closing braces for getting dbpic
        //to insert the picture into The database
        if($conn->query($sql) == "true"){
        if(file_exists($avatar)){
        unlink($avatar);
        }
        return "success";
        }else{
        if(file_exists($file)){
        unlink($file);
        }
        return "sorry could save image to server please try again";
        }
    }//closing braces for function
    
    //function to handle getting and set function starts here
    public function chatCreate(){
    $conn = $this->conn;
    $uid = $this->getUserId();
    $ownerid = $this->getOwnerId();
    if($uid == $ownerid){
    return;
    }else if(empty($uid) || empty($ownerid)){
    return;
    }
    //for Creating normal Chat
    $sql = "select chatid from chatcreate where creatorid='$uid' and recepientid='$ownerid' and type='0' or creatorid = '$ownerid' and recepientid='$uid' and type='0' limit 1";
    $result = $conn->query($sql);
    if($result->num_rows == 1){
    if($row = $result->fetch_assoc()){
    $chatid  = $row["chatid"];
    $this->setChatId($chatid);
    $this->chatexists = "true";
    }
    }else{
    $time = time();
    $chatid = md5(rand(0,7000).rand(0,4000));
    $sql = "insert into chatcreate(creatorid,recepientid,type,chatid,date) values('$uid','$ownerid','0','$chatid','$time')";
    if($conn->query($sql) == "true"){
    $this->setChatId($chatid);
    $this->chatexists = "true";
    }else{
    echo $conn->error;
    exit();
    }
    }
    //for achat starts Here
    $sql = "select chatid from chatcreate where creatorid='$uid' and recepientid='$ownerid' and type='1' or creatorid = '$ownerid' and recepientid='$uid' and type='1' limit 1";
    $result = $conn->query($sql);
    if($result->num_rows == 1){
    if($row = $result->fetch_assoc()){
    $chatid  = $row["chatid"];
    $this->setAchatId($chatid);
    $this->achatexists = "true";
    }
    }else{
    $time = time();
    $chatid = md5(rand(0,7000).rand(0,4000));
    $sql = "insert into chatcreate(creatorid,recepientid,type,chatid,date) values('$uid','$ownerid','1','$chatid','$time')";
    if($conn->query($sql) == "true"){
    $this->setAchatId($chatid);
    $this->achatexists = "true";
    }else{
    echo $conn->error;
    exit();
    }
    }
      
    }
}
?>