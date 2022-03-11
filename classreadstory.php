<?php
session_start();
require 'classmeetupvalidate.php';


/**
 * class to handle reading of story starts here
 */
class readstory extends meetupvalidate
{
	private $storyid;
	private $userid;
	private $writerid;
	function __construct()
	{
	  $this->createConnection();
	  $this->setUserData();
 	}
 	public function setUserData(){
 	$this->userid = $_SESSION["userid"];
 	}

    public function setStoryId($data)
	{
	  $this->storyid = $this->clean_input($data);
	}
    
    private function getStoryId()
    {
     return $this->storyid; 
    }

    public function setWriterId($data)
    { 
	  $this->writerid = $this->clean_input($data);
    }

    public function getWriterId()
    {
      return $this->writerid;
    }

    public function getStory()
    { 
       $data=$writerid=$storyid="";
       $conn = $this->conn;
       $storyid = $this->getStoryId();
       $uid = $this->userid;
       $sql = "select * from stories where storyid ='$storyid' limit 1";
       $result = $conn->query($sql);
       if($result->num_rows == 1){
       if ($row = $result->fetch_assoc()) {
       $_SESSION["pid"] = $writerid = $row["writerid"];
        $_SESSION["storyid"] =$storyid = $row["storyid"];
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
       $slidenum = count($stry);
       $stry = str_replace(array("_-_","_+_","_#_","#389"),array("\n","\r"," ","\\"),$stry);
       if (empty($viewerslist) || $viewerslist == ""){
       $viewerslist = array();
       }else{
       $viewerslist = json_decode($viewerslist,true);
       }
       $this->updateView($numviews,$storyid,$viewerslist);
       /*$colorstory = array_keys($stry);
       $readstory = array_values($stry);*/
       foreach ($stry as $keys => $values){
       $keys = $this->clean_input($keys);
       $values = strip_tags($values);
       $values = nl2br($values);
       $data .="<div class='$keys w3-animate-left storyctent w3-hide'style='width:100%;margin-right:auto;margin-left:auto;font-size:22px;height:100vh;word-wrap:break-word;padding:15px;'>
       <p class=''style='margin-top: 5px;height:100%;overflow: auto;vertical-align:middle;'>$values</p>
        </div>";
       }
       if($writerid == $uid){
        $data.="<button class='w3-round-large next w3-center w3-display-right deletebtn w3-text-red w3-btn w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-red'style='margin-top:60px;margin-right: 5px;'><span id='trashicon'class=''> <i class='fa fa-trash w3-xlarge'></i></span> <span id='delprg'class='w3-tiny w3-hide'><i class='fa fa-spinner w3-large w3-spin'></i><br>Deleting..</span></button>";
        }

        $data .="
         <button class='w3-round-large w3-display-topright w3-margin w3-text-white w3-btn w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-blue'style='margin-bottom:10px;padding: 7px;margin-left: 30vw;'><i class='fa fa-sticky-note w3-large'></i> <span id='slideindex' class='w3-medium'>1/$slidenum</span> </button>

        <a href='oaumeetupstorycomments.php?storyid=$storyid'style='text-decoration:none;'><button class='w3-round-large commentbtn next w3-display-right w3-text-white w3-btn w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-blue'style='margin-top:120px;margin-right: 5px;'><i class='fa fa-comment w3-xlarge'></i></button></a>

        <button class='w3-round-large  views w3-display-bottomleft w3-text-white w3-btn w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-blue'style='margin-bottom:10px;padding: 7px;margin-left: 30vw;'><i class='fa fa-eye w3-large'></i> <span class='w3-medium'>$numviews</span> </button>
        
        <a href='oaumeetupstorycomments.php?storyid=$storyid'style='text-decoration:none;'><button class='w3-round-large comments next w3-display-bottommiddle w3-text-white w3-btn w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-blue'style='margin-bottom:10px;padding: 7px;margin-left: 20vw;'><i class='fa fa-comments w3-large'></i> <span class='w3-medium'>$numcomment</span></button></a>";
        }
         return $data;
       }else{
       	return "<div class='w3-center w3-text-red w3-large w3-animate-left'style='margin-top:40%;'>
       	<span><i class='fa fa-exclamation-triangle w3-xxlarge'></i> Story not found</span>
       	</div>";
       }
    }

    //function to update view on database starts here
    private function updateView($data,$storyid,$viewarray)
    {
      $view=$id=$arrayv="";
      $conn = $this->conn;
    	$view = $this->clean_input($data);
    	$id = $this->clean_input($storyid);
      $uid = $this->userid;
      $arrayv = $viewarray;
    	if (empty($view) || $view == "") {
      $view = 0; 
    	}
      if(empty($arrayv) || $arrayv == ""){
      $arrayv = array();
    	}
      if(!array_key_exists($uid, $arrayv)){
      $arrayv[$uid] = time();
       ++$view;
      $arrayv = json_encode($arrayv);
      if (!empty($id) || $id != "") {
      $sql = "update stories set numviews ='$view',viewerslist='$arrayv' where storyid = '$id' limit 1";
      $conn->query($sql);          
      }   
      }
     

    }

    //block of code to delete a story 
    public function deleteStory(){
      $conn = $this->conn;
      $uid = $this->userid;
      $storyid = $this->getStoryId();
      $writerid = $this->getWriterId();
      $sql = "delete from stories where storyid='$storyid' limit 1";
      if ($uid == $writerid) {
      if ($conn->query($sql) == "true") {
      unset($_SESSION["storyid"]);
      unset($_SESSION["pid"]);
      return "delete successful";
      }else{return "failed".$conn->error;}
      }else{
       return "You didnt write this story you can't delete it :(";
      }

    }
}

?>