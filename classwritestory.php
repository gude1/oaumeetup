<?php
session_start();
require "classmeetupvalidate.php";
/**
 * class to handle database operations for writing story into database
 */
class writestory extends meetupvalidate
{
	private $storytitle;
	private $colorpref;
	private $storycontent;
	private $storymode;
	private $userid;
	private $mood;

	function __construct()
	{
	$this->createConnection();
	}
	public function setStoryTitle($data){
	$this->storytitle = $this->clean_input($data);
	}
	private function getStoryTitle(){
	return $this->storytitle;
	}
	public function setColorPref($data){
	$this->colorpref = $data;
	}
	private function getColorPref(){
	return $this->colorpref;
	}
	public function setStoryContent($data){
	$this->storycontent = $data;
	}
	private function getStoryContent(){
	return $this->storycontent;
	}
    public function setStoryMode($data){
	$this->storymode = $this->clean_input($data);
	}
	private function getStoryMode(){
	return $this->storymode;
	}
	public function setUserid($data){
	$this->userid = $this->clean_input($data);
	}
	private function getUserid(){
	return $this->userid;
	}
	public function setMood($data){
	$this->mood = $this->clean_input($data);
	}
	private function getMood(){
	return $this->mood;
	}

	public function insertStory(){
	$conn = $this->conn;
	$title = $this->getStoryTitle();
	$content = $this->getStoryContent();
	$colorpref = $this->getcolorpref();
	$userid = $this->getuserid();
	$mode = $this->getStoryMode();
	$mood = $this->getMood();
	$time = time();
	$num = "";
	if(empty($title)){
	return "story title is empty";
	}elseif (count($content) < 1) {
    return "story is empty";
	}elseif (count($colorpref) < 1) {
    return "sorry couldnt get color preference";
	}elseif (empty($userid)) {
    return "sorry cannot get user details";
	}
	if($mode == "nonsecret"){
	$num = 0;
	}elseif($mode == "secret"){
	$num = 1;
	}
	
	$k = str_replace(array("\r","\n"," ","\\","<",">"),array("_+_","_-_","_#_","#389","",""),$content);
    /*me = json_encode($k);
	echo $me;
	print_r(json_decode($me,true));
	print_r($dbstory);
	return;
	return;*/
	$dbstory = json_encode(array_combine($colorpref,$k));
	$dbstory = str_replace("\ud","_^_",$dbstory);
	$dbstory = $conn->real_escape_string($dbstory);
	$idstory = md5(rand(100,1000000)).md5(rand(50,30000));
    $sql = "insert into stories (writerid,storyid,storytitle,storycontent,mood,anonymous,date) values('$userid','$idstory','$title','$dbstory','$mood','$num','$time')";
    if ($conn->query($sql)){
    return "successful";
    }else{
    return $conn->error."failed";
    }
	}


	
}
?>