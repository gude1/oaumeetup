<?php
session_start();
require "classmeetupvalidate.php";
/**
 * class for handling display of stories start here
 */
class meetupdatingstories extends meetupvalidate
{ 
	private $userid;	
	function __construct()
	{
	$this->createConnection();
  $this->setUserData();
 	}
 	public function setUserData(){
 	$this->userid = $_SESSION["userid"];
 	}
 	//function to get users own story from database if exists
 	public function getUserStories(){
 	$conn = $this->conn;
 	$userid = $this->userid;
 	$sql = "select * from stories where writerid='$userid' and expired = '0' order by date desc limit 5";
 	$result = $conn->query($sql);
 	$data =$writerid=$writername=$storyid=$storytitle=$storycontent=$numviews=$viewerslist=$numcomment=$commenterlist=$anonymous=$expired=$date=$stry=$colorstory=$color_first=$shrtstry= "";
 	if ($result->num_rows > 0) {
 	while ($row = $result->fetch_assoc()) {
    $writerid = $row["writerid"];
    $writername = $this->getUsername($writerid);
    $storyid = $row["storyid"];
    $storytitle = $row["storytitle"];
    $storycontent = $row["storycontent"];
    $numviews = $row["numviews"];
    $viewerslist = $row["viewerslist"];
    $numcomment = $row["numcomment"];
    $commenterlist = $row["commenterslist"];
    $anonymous = $row["anonymous"];
    $expired = $row["expired"];
    $date = $row["date"];
    $storycontent = str_replace("_^_","\ud",$storycontent);
    $stry = json_decode($storycontent,true);
    $stry = str_replace(array("_-_","_+_","_#_"),"",$stry);
    $count = count($stry);
    $colorstory = array_keys($stry);
    $color_first = $colorstory[0];
    $shrtstry = substr($stry[$color_first], 0,18);
    $shrtstry = str_replace("#389","\\",$shrtstry);
    $writername ="<i class='fa fa-user'> </i> $writername"; 
    if ($anonymous == "1") {
    $writername =  "<i class='fa fa-eye-slash'> </i> Anonymous";
    }
    $data .="
    <a href='oaumeetupreadstory.php?storyid=$storyid'style='text-decoration:none;'>
    <li class='w3-bar w3-ripple w3-display-container 'style='padding-left:4px; padding-bottom:4px;'>
   <!--<span class='w3-text-grey w3-display-topmiddle w3-margin-bottom'> $writername</span>-->
   <span class='w3-small w3-text-grey w3-right w3-display-topright w3-margin-left w3-margin-right'style='margin-top:3px;'><i class='fa fa-sticky-note'> </i> $count </span>
   <div class='w3-bar-item w3-circle'style='border: 3px dashed #2196F3;padding: 5px;margin-top:15px;'>
   <div class='w3-circle w3-bar-item  $color_first w3-center w3-tiny'style='width:60px;height:60px;word-wrap:break-word;overflow:hidden;text-overflow: ellipsis;letter-spacing:2px;'/>$shrtstry</div>	
       </div>
   <div class='w3-bar-item ' style='width: 70%; padding: 0;margin:3px; margin-left: 8px;margin-top:20px;border-bottom:0.3px solid lightgrey;'>
   <span class='w3-text-black w3-bold  w3-block'style='width:100%;font-size: 16px;'><b>$storytitle</b></span>
   <span class='w3-text-grey w3-small'style='letter-spacing:2px;'>$shrtstry...</span><br>
   <span class='w3-text-grey w3-small'><i class='fa fa-eye'> $numviews</i></span>&nbsp
   <span class='w3-small w3-text-grey'><i class='fa fa-comments'> </i> $numcomment</span></div>
   </li></a>";
 	}
    }
    return $data;
     
 	}//closing braces for function
 	//function to get stories that have more views 
 	public function getTrendStories()
 	{
 	$conn = $this->conn;
 	$userid = $this->userid;
 	$sql = "select * from stories where writerid !='$userid' and expired = '0' order by numviews desc limit 10";
 	$result = $conn->query($sql);
 	$data = "";
 	if ($result->num_rows > 0) {
 	while ($row = $result->fetch_assoc()) {
    $writerid = $row["writerid"];
    $writername = $this->getUsername($writerid);
    $storyid = $row["storyid"];
    $storytitle = $row["storytitle"];
    $storycontent = $row["storycontent"];
    $mood = $row["mood"];
    $numviews = $row["numviews"];
    $viewerslist = $row["viewerslist"];
    $numcomment = $row["numcomment"];
    $commenterlist = $row["commenterslist"];
    $anonymous = $row["anonymous"];
    $expired = $row["expired"];
    $date = $row["date"];
    $storycontent = str_replace("_^_","\ud",$storycontent);
    $stry = json_decode($storycontent,true);
    $stry = str_replace(array("_-_","_+_","_#_"),"",$stry);
    $count = count($stry);
    $colorstory = array_keys($stry);
    $color_first = $colorstory[0];
    $shrtstry = substr($stry[$color_first], 0,18);
    $shrtstry = str_replace("#389","\\",$shrtstry);
    $writername ="<i class='fa fa-user'> </i> $writername"; 
    if ($anonymous == "1") {
    $writername =  "<i class='fa fa-eye-slash'> </i> Anonymous";
    }
    if($mood == ""){
    $mood = "Happy";
    }
    $data .="
    <a href='oaumeetupreadstory.php?storyid=$storyid'style='text-decoration:none;'>
    <li class='w3-bar w3-ripple w3-display-container'style='padding-left:4px;'>
   <span class='w3-text-grey w3-display-topmiddle w3-margin-bottom'> $writername</span>
   <span class='w3-text-grey w3-display-topmiddle  w3-small'style='margin-left:80px;'>Mood : $mood</span>
   <span class='w3-small w3-text-grey w3-right w3-display-topright w3-margin-left w3-margin-right'style='margin-top:3px;'><i class='fa fa-sticky-note'> </i> $count </span>
   <div class='w3-bar-item w3-circle'style='border: 3px dashed #2196F3;padding: 5px;margin-top:15px;'>
   <div class='w3-circle w3-bar-item  $color_first w3-center w3-tiny'style='width:60px;height:60px;word-wrap:break-word;overflow:hidden;text-overflow: ellipsis;letter-spacing:2px;'/>$shrtstry</div> 
       </div>
   <div class='w3-bar-item' style='width: 70%; padding: 0;margin:3px; margin-left: 8px;margin-top:20px;border-bottom:0.3px solid lightgrey;'>
   <span class='w3-text-black w3-bold  w3-block'style='width:100%;font-size: 16px;'><b>$storytitle</b></span>
   <span class='w3-text-grey w3-small'style='letter-spacing:2px;'>$shrtstry...</span><br>
   <span class='w3-text-grey w3-small'><i class='fa fa-eye'> $numviews</i></span>&nbsp
   <span class='w3-small w3-text-grey'><i class='fa fa-comments'> </i> $numcomment</span></div>
   </li></a>";
  }
    }
    return $data;

 	}

    //function to get username via uid starts here
 	public function getUsername($data){
 	$uname = "";
 	$conn = $this->conn;
 	$uid = $this->clean_input($data);
 	$sql = "select username from oaumeetupusers where userid = '$uid' limit 1";
 	if (!empty($uid)) {
 	$result = $conn->query($sql);
 	if($result->num_rows > 0 && $row = $result->fetch_assoc()){
 	$uname = $row["username"];
 	}
    }
    return $uname;
 	}


 }
 ?>