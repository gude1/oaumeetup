<?php
session_start();
require 'classmeetupvalidate.php';
/**
 * class to handle database function for story comment and views starts here
 */
class storycomment extends meetupvalidate
{  
	private $storyid;
	private $storytitle;
  private $userid;
  private $changeid;
  private $commentnum;
  private $viewerlist;
	
	function __construct()
	{
		$this->createConnection();
    $this->setUserid($_SESSION["userid"]);
	}
	 public function setStoryId($data)
	{
	  $this->storyid = $this->clean_input($data);
	}
    
    public function getStoryId()
    {
     return $this->storyid; 
    }

    public function setStoryTitle($data)
	{
	  $this->storytitle = $this->clean_input($data);
	}
    
    public function getStoryTitle()
    {
     return $this->storytitle; 
    }
    public function setChangeId($data)
  {
    $this->changeid = $this->clean_input($data);
  }
    
   public function getChangeId()
    {
     return $this->changeid; 
    }
   public function setUserid($data)
  {
    $this->userid = $this->clean_input($data);
  }
    
  public function getUserid()
  {
   return $this->userid; 
  }
   public function setCommntNum($data)
  {
    $this->commentnum = $this->clean_input($data);
  }   
  public function getCommntNum()
  {
     return $this->commentnum; 
    }
   public function setViewer($data)
  {
    $this->viewerlist = $data;
  }   
  public function getViewer()
  {
     return $this->viewerlist; 
  }
  
	public function getStory()
	{
	     $conn = $this->conn;
	     $data=$writerid=$storyid="";
       $storyid = $this->getStoryId();
       $sql = "select * from stories where storyid ='$storyid' limit 1";
       $result = $conn->query($sql);
       if($result->num_rows == 1){
       if ($row = $result->fetch_assoc()){
       $writerid = $row["writerid"];
       $storyid = $row["storyid"];
       $storytitle = $this->setStoryTitle($row["storytitle"]);
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
       $viewerslist = json_decode($viewerslist,true); $this->setViewer($viewerslist);}
       //begining of for each loop
       foreach ($stry as $color => $story) {
       $color = $this->clean_input($color);
       $story =strip_tags($story);
       $story = nl2br($story);
       $data .="<div class='$color w3-animate-left storycntent w3-hide'style='width:100%;margin-right:auto;margin-left:auto;font-size:22px;height:50vh;word-wrap:break-word;padding:15px;'>
       <p class=''style='margin-top: 5px;height:100%;overflow: auto;vertical-align:middle;'>$story</p>
        </div>";
       }
       //end of for each loop
       $data .="
      <button class='w3-round-large w3-display-topright w3-margin w3-text-white w3-btn w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-blue'style='margin-bottom:10px;padding: 7px;margin-left: 30vw;'><i class='fa fa-sticky-note w3-large'></i> <span id='slideindex' class='w3-medium'>1/$slidenum</span> </button>
      <!--bar for sharing and the rest starts here-->
      <div class='w3-bar'style='margin-top:2px;margin-right:auto;margin-left:auto;width:95%;'>
      <div class='w3-bar-item  w3-center w3-border-top w3-border-bottom'style='width:100%;'>
      <button id='showcmnt'class='w3-text-blue w3-center w3-small w3-button w3-round-large w3-hover-blue w3-hover-text-white 'style='font-size:15px;width:40%;'><i class='fa fa-comments'></i> <span id='numcmmnttxt'> $numcomment comments</span>
      </button>
      <button id='showview'class='w3-text-blue w3-center w3-button w3-small w3-round-large w3-hover-blue w3-hover-text-white'style='font-size:15px;width:40%;'><i class='fa fa-eye'></i><span> $numviews views</span>
      </button>
      </div>
      <div class='w3-bar-item w3-border-bottom'style='width:100%;padding:0;'>
      <button  onclick='sharE(\"$storyid\")' class='w3-button w3-bar-item w3-small  w3-round-large w3-text-blue w3-hover-blue w3-hover-text-white'style='margin:5px;width:45%;'>
      <i class='fa fa-share-alt w3-xlarge'></i>
      </button>
      <button id='scbtn' class='w3-button w3-bar-item w3-small  w3-round-large w3-text-blue w3-hover-blue w3-hover-text-white'style='margin:5px;width:45%;'>
      <i class='fa fa-comment-o w3-xlarge'></i>
      </button>
      </div>
      </div>
<!--bar for sharing and the rest ends here-->
      ";
      return $data;
       }//ending braces for if result== fetch_assoc()
       return $data;
       }else{ return "<div class='w3-center w3-text-red w3-large w3-animate-left'style='margin-top:40%;'>
       	<span><i class='fa fa-exclamation-triangle w3-xxlarge'></i> Story not found</span>
       	</div>";}
    }
      
      public function getComment($storyid)
      {
      $data = "";
      $conn = $this->conn;
      $uid = $this->getUserid();
      $storyid = $this->clean_input($storyid);
      $sql = "select * from storycomment where storyid='$storyid' order by date desc limit 10";
      $result = $conn->query($sql);
      if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
      $id = $row["id"];
      $storyid = $row["storyid"];
      $commenterid = $row["commenterid"];
      $commentid = $row["commentid"];
      $comment = nl2br($row["comment"]);
      $date = strftime("%b %d %Y",$row["date"]);
      $numreply = $row["numreply"];
      $numshare = $row["numshare"];
      $userdetail = $this->getUserDetail($commenterid);
      $username = $userdetail[0];
      $avatar = $userdetail[1];
      $gender = $userdetail[2];
      if($uid == $commenterid){$username = "You";}
      if($gender == "female"){
      $gender = "<i class='fa fa-female'></i> Female";
      }elseif($gender == "male"){
      $gender = "<i class='fa fa-male'></i> Male";
      }
      $data .="<a style='text-decoration:none;'><li id='comment$commentid' class='w3-bar w3-ripple w3-display-container w3-border-0'style='padding: 10px;'>
      <span class='w3-display-topright w3-small w3-text-blue'style='margin: 8px;'><i>$gender</i></span>
      <img src='$avatar'class='w3-circle w3-bar-item'style='margin-top:8px;width:70px;height:70px;padding:2px;'/>
      <div class='w3-bar-item w3-border-bottom w3-border-grey' style='width: 70%; padding: 0;margin:6px; margin-left:6px;'>
      <span class='w3-text-black'style='font-size:16px;'><b>$username</b></span> <span class='w3-small w3-text-grey'>$date</span><br>
      <span class='w3-text-black'style='width:100%;word-wrap: break-word;'>$comment
      </span><br>
      <button class='w3-button w3-round-large w3-text-blue w3-hover-blue w3-hover-text-white'style='margin:5px;'>
      <i class='fa fa-share-alt w3-large'></i> <span>$numshare</span>
     </button>
     <button class='w3-button w3-round-large w3-text-blue w3-hover-blue w3-hover-text-white'style='margin:5px;''>
     <i class='fa fa-comment-o w3-large'></i> <span>$numreply</span>
     </button> 
     </div>
     </li></a>";
      }
      /**/}else{
      $data = "<div id='nocmmntctn' class='w3-container w3-text-blue w3-center w3-margin'>
      <i class='fa fa-comments w3-xlarge'></i> Be the first to comment
      </div>";
      }
      return $data;
      }

      //function to get username and profile pics starts here
      public function getUserDetail($uid)
      {
       $conn = $this->conn;
       $uid = $this->clean_input($uid);
       $ar = array();
       $sql = "select username,gender,avatar from oaumeetupusers where userid ='$uid' limit 1";
       $result = $conn->query($sql);
       if($result->num_rows == 1){
       if ($row = $result->fetch_assoc()){
       $username = $row["username"];
       $gender = $row["gender"];
       $avatar = $row["avatar"];
       if(empty($username) || $username == ""){
       $username = "Unknown";
       }
       if(empty($avatar) || $avatar == ""){
        $avatar = "default.png";
       }
       if (empty($gender) || $gender == "") {
        $gender = "Unknown";
       }
       $ar = array($username,$avatar,$gender);
       }//closing braces for if result->fetch_assoc()
       return $ar;
       }else{
        return array("Unknown","default.png","Unknown");
       }
      }

      //function to insert comment starts here
      public function insertComment($comment){
      $conn = $this->conn;
      $comment = $this->clean_input($comment);
      $uid = $this->getUserid();
      $storyid = $this->getStoryId();
      $numcomment = $this->getNumCmnt($storyid);
      $commentid = md5(rand(0,100000).rand(0,1000000).rand(0,100000));
      $date = time();
      ++$numcomment;
      $sql = "insert into storycomment (storyid,commenterid,commentid,comment,date) values('$storyid','$uid','$commentid','$comment','$date')";
      $sql2 = "update stories set numcomment = '$numcomment' where storyid = '$storyid' limit 1";
      if (empty($comment) || $comment = ""){
      return "failed s";
      }
      if ($conn->query($sql) == "true"){
      $this->setChangeId($commentid);
      $conn->query($sql2);
      $this->setCommntNum($numcomment);
      return $this->getComment($storyid);
      }else{
      return "failed";
      }
      }

      //function to get latest num comment
      public function getNumCmnt($data){
      $conn = $this->conn;
      $storyid = $this->clean_input($data);
      $sql = "select numcomment from stories where storyid = '$storyid' limit 1";
      $result = $conn->query($sql);
      if($result->num_rows == 1){
      if($row = $result->fetch_assoc()){
      $numcomment = $row["numcomment"];
      if($numcomment == "" || empty($numcomment)){
      $numcomment = 0;
      }
      return $numcomment;
      }
      }else{
      return 0;
      }
      }

      //function to get details of viewers starts here 
      public function getViewers($data)
      {
      $conn = $this->conn;
      $uid = $this->userid;
      $dat = "";
      $a = $data;
      if($a == "" || empty($a) || count($a) < 1){
      return "";
      }
      foreach ($a as $key => $values) {
      $values = $this->clean_input($values);
      $key = $this->clean_input($key);
      $sql = "select userid,username,gender,avatar from oaumeetupusers where userid ='$key' limit 1";
      $result = $conn->query($sql);
      $values = strftime("%b %d %Y",$values);
      if($row = $result->fetch_assoc()){
      $userid = $row["userid"];
      $username = $row["username"];
      $gender = $row["gender"];
      $avatar = $row["avatar"];
      if ($avatar == ""|| !file_exists($avatar)){
      $avatar = "default.png";}
      if($userid == $uid){$username = "You";}
      if($gender == "female"){
      $gender = "<i class='fa fa-female'></i> Female";
      }elseif($gender == "male"){
      $gender = "<i class='fa fa-male'></i> Male";
      }
      $dat .="<li class='w3-bar w3-ripple w3-display-container w3-border-0' style='padding: 10px;'>
      <span class='w3-display-topright w3-small w3-text-blue w3-margin 'style=''><i>$gender</i></span>
      <img src='$avatar'class='w3-circle w3-bar-item'style='margin-top:2px;width:70px;height:70px;padding:2px;'/>
      <div class='w3-bar-item' style='width: 70%; padding: 0;margin:6px; margin-left: 6px;'>
      <span class='w3-text-black'style='font-size:16px;''><b>$username</b></span><br>
      <span class='w3-text-grey w3-small'style='width:100%;word-wrap: break-word;'>
      Viewed $values
      </span></div>
      </li>";
      }
      }//for each loop
      return $dat;
      }

  }
?> 