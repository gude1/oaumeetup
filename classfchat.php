<?php
require_once "classmeetupvalidate.php";
class fchat extends meetupvalidate{
	private $chatid;
	private $uid;
	private $chatpartnerid;
	private $msgdetails;
	
   function __construct(){
	$this->createConnection();
	if(isset($_SESSION["userid"])){
	$this->setUid($_SESSION["userid"]);
	}
	if(isset($_SESSION["chatid"]) && isset($_SESSION["partnerid"])){
	 $this->setPatnerId($_SESSION["partnerid"]);
	$this->setChatId($_SESSION["chatid"]);
	}
    if(isset($_SESSION["m"])){
	$this->msgdetails=$_SESSION["m"];
   }
   
   }//closing Function Construct 

    //settters and getters
    public function setChatId($data){
	 $this->chatid = $this->clean_input($data);
    }
    public function getChatId(){
	 return $this->chatid;
    }
    public function setUid($data){
	 $this->uid = $this->clean_input($data);
    }
    public function getUid(){
	 return $this->uid;
   }
   
    public function setPatnerId($data){
	  $this->chatpartnerid = $this->clean_input($data);
    }
    public function getPatnerId(){
	 return $this->chatpartnerid;
    }
    
     //public function for confirm  chat
    public function confirmChat($chatid){
	 $conn = $this->conn;
	 $uid = $this->getUid();
	 $chatid = $this->clean_input($chatid);
	 if(empty($chatid) || $chatid == ""){
	 echo "chat doesnot exists";
	 exit();
	 }
	 $sql = "select creatorid,recepientid from chatcreate where creatorid='$uid' or
	  recepientid = '$uid' and type='0' and  chatid='$chatid'
	 limit 1";
	$sql1 = "select id  from fchat where chatid='$chatid' limit 1";
	$result = $conn->query($sql);
	if($result->num_rows != 1){
	echo "chat doesnot exists";
	exit();
	}else{
	$row = $result->fetch_assoc();
	$creatorid = $row["creatorid"];
	$recepientid = $row["recepientid"];
	$result1 = $conn->query($sql1);
	if($result1->num_rows  != 1){
	$sql2= "insert into fchat (chatid,creatorid,recepientid) 
	values ('$chatid','$creatorid','$recepientid')";
	if($conn->query($sql2) == "true"){
	$this->setChatId($chatid);
	if($creatorid == $uid){
	$this->setPatnerId($recepientid);
	$_SESSION['chatid'] = $chatid;
	$_SESSION['partnerid'] = $recepientid;
	}else if($recepientid == $uid){
	$this->setPatnerId($creatorid);
	$_SESSION['chatid'] = $chatid;
	$_SESSION['partnerid'] = $creatorid;
	}
	
	
	}		
			
	}else{
	$this->setChatId($chatid);
	if($creatorid == $uid){
	$this->setPatnerId($recepientid);
	$_SESSION['chatid'] = $chatid;
	$_SESSION['partnerid'] = $recepientid;
	}else if($recepientid == $uid){
	$this->setPatnerId($creatorid);
	$_SESSION['chatid'] = $chatid;
	$_SESSION['partnerid'] = $creatorid;
	}

	}
	}
   }//function closing braces 

     //function to handle  getting of chat starts here not going To BE Called if an ajax request
     public function getChat(){
	  $conn = $this->conn;
	  $uid = $this->getUid();
	 $chatid = $this->getChatId();
	  $patnerid = $this->getPatnerId();
	  $chatid = $this->getChatId();
      $data = ''; 
      $scrollid = '';
      $numc = 0;
      
	  $sql = "select receivermsg, numnewmsg,msgdetails from fchat where chatid='$chatid' limit 1";
     $result = $conn->query($sql);
     if($result->num_rows == 1){
	  if($row = $result->fetch_assoc()){
	  $receivermsg = $row["receivermsg"];
	  $numnewmsg = $row["numnewmsg"];
	  $msgdetails =  $row['msgdetails'];
	  if($msgdetails == "" || empty($msgdetails)){
	  $this->msgdetails = array();
	  return "";
	  }
	  $msgdetails = str_replace('®®©','\ud',$msgdetails);
	  $msgdetails = json_decode($msgdetails,true);
      $this->msgdetails = $_SESSION["m"]=$msgdetails =        $this->updateArrayOpen($msgdetails);
      $msgdetails = json_encode($msgdetails);
$msgdetails = str_replace('\ud','®®©',$msgdetails);
$msgdetails= $conn->real_escape_string($msgdetails);
      if($receivermsg == $uid){
      $sql2 = "update fchat set   receivermsg = '',numnewmsg='0',shortnewmsg ='',msgdetails = '$msgdetails'where chatid= '$chatid' limit 1";
      }else{
      $sql2 = "update fchat set msgdetails = '$msgdetails'where chatid= '$chatid' limit 1";
      }
      $conn->query($sql2);
      $msgdetails = $this->msgdetails;
      /*print_r($msgdetails);
      exit();*/
      $msgdetails = str_replace(array('®®©','<','>'),array('\ud','',''),$msgdetails);
	  $num = count($msgdetails);
	  $index = $num -1;
	  foreach($msgdetails as $key => $a){
	  ++$numc;
	  $msgid = $key;
	  $ar = $a;
	  $msg  = nl2br(strip_tags (stripslashes($ar[0])));
	  $avatarmsg = $ar[1];
	  $senderid = $ar[2];
	  $receiverid = $ar[3];
	  $time  =  $ar[4];
	  $senderdelete = $ar[5];
	  $receiverdelete = $ar[6];
	  $opened = $ar[7];
	  $index = $num -1;
	  //code to get scroll to currrent scrollid
	  if(empty($scrollid) && $numc < $index){
	   if($receiverid  == $uid && $opened == "0" ){
	   $scrollid = $msgid;  
	   }else if($senderid == $uid && $opened == "0"){
	   $scrollid = $msgid;
	   }
	  }else if(empty($scrollid) && $numc >= $index){
	   $scrollid = $msgid;
	  }
	  //code to get Scroll ID Ends Here

	  if($msg != '' && $avatarmsg == ''){
	  if($senderid == $uid){
	  $data .="<div id='$msgid' class='mymsg w3-panel'style='padding:0;margin:0;'>
     <div class='w3-right w3-card msg_txt w3-blue w3-padding w3-animate w3-ripple  w3-animate-zoom w3-medium 'style='max-width:250px;word-wrap: break-word;border-radius: 15px 50px 30px;margin: 5px;font-size:16px;'>
     <p class=''style='margin:2px;'>$msg</p>
     <p class='w3-tiny w3-left'style='margin:0;margin-left:5px;margin-right:10px;'>$time</p>";
  
	  if($opened == 1){
    $data .="<span id='isseen$msgid' class='w3-tiny w3-right'>seen</span>
    </div></div>";
     }else if($opened == 0){
	 $data .="<span id='isseen$msgid' class='w3-tiny w3-right'>sent</span>
    </div></div>";
	  }
	  }else if($receiverid == $uid){
	  $data .="<div id='$msgid' class='w3-panel partnermsg' style='padding:0;margin:0;'>
     <div class='w3-left msg_txt w3-text-blue w3-white w3-card w3-padding w3-ripple w3-animate-zoom'style='max-width:250px;word-wrap: break-word;border-radius:10px 0px 15px 15px;margin: 5px;font-size:16px;'>
     <p class=''style='margin:2px;'>$msg</p>
      <p class='w3-tiny w3-left'style='margin:0;'>$time</p></div></div>";
	  }
	  }else if($msg == '' && $avatarmsg != ''){
	  }	   
	  }//for each loop
	  return array($data,$scrollid);
	  }//fwct_assoc()
	  }else{
	/*echo "<div>Something went Wrong could not get chat please refresh browser again</div>";
	exit();*/
	  }
      }
       
      //public function  to insert chat starts here
       public function insertChat($data){
	     $conn = $this->conn;
	     $uid = $this->getUid();
	     $frmsgdetails = $this->msgdetails;
	     //$_SESSION["chatid"];
	     $partnerid = $this->getPatnerId();
	     $ndata = "";
	     $numc = 0;
	     $chatid = $this->getChatId();
	     $chat = $data;
	     if($chat == '' || empty($chat)){
		  return 'sorry your chat contains characters that are not accepted';
		  }
		  $sql = "select receivermsg,numnewmsg,shortnewmsg,msgdetails from fchat where chatid = '$chatid' limit 1";
		  $result =$conn->query($sql);
		  if($result->num_rows == 1){
		  $row = $result->fetch_assoc();
		  $receivermsg = $row["receivermsg"];
		  $numnewmsg = $row["numnewmsg"];
		  $shortnewmsg = $row["shortnewmsg"];
	      $msgdetails =  $row['msgdetails'];
	      $msgdetails = str_replace('®®©','\ud',$msgdetails);
	      if(empty($msgdetails)){
	      $msgdetails = array();
	      }else{
          $msgdetails = json_decode($msgdetails,true);
	      }
          $array = array($chat,'',$uid,$partnerid,time(),'0','0','0',time());
          $dbmsgid = md5(rand(0,7000).rand(0,4000));
          $msgdetails[$dbmsgid] = $array;
        $this->msgdetails=$_SESSION["m"]=$msgdetails = $this->updateArrayOpen($msgdetails);
        
        
$dbmsgdetails = json_encode($msgdetails);
          $dbmsgdetails = str_replace(array('\ud','<','>'),array('®®©','',''),$dbmsgdetails);
          
//insert Into Database Starts Here
          $dbmsgdetails= $conn->real_escape_string($dbmsgdetails);
          if($receivermsg == $uid){
          $numnewmsg = 0;
          }
          ++$numnewmsg;
          $chat = $conn->real_escape_string($chat);
          if(empty($shortnewmsg)){
          $sql2 = "update fchat set receivermsg='$partnerid',numnewmsg='$numnewmsg',shortnewmsg='$chat',msgdetails='$dbmsgdetails'where chatid='$chatid' limit 1";
         }else{
          $sql2 = "update fchat set receivermsg='$partnerid',numnewmsg='$numnewmsg',msgdetails='$dbmsgdetails' where chatid='$chatid' limit 1";
         }

          
          if($conn->query($sql2) != "true"){
       $this->msgdetails =$_SESSION["m"]=$frmsgdetails;
       return "Failed".$conn->error;
          }
//insert into Database Ends Here

        $newmsgs= array_diff_key($msgdetails,$frmsgdetails);
        $oldmsgs = array_intersect_key($msgdetails,$frmsgdetails);
        //code to Get Update For Stale Messages Starts Here
        $oldarraytosend = array();
        foreach($oldmsgs as $value => $a){
        $oldchatid = $value;
        $oldarr = $a;
        $oldsenderid = $oldarr[2];
        $oldopened = $oldarr[7];
        if($oldsenderid == $uid && $oldopened == 1){
        array_push($oldarraytosend,$oldchatid);
        }
        }
        //code to Get Update For Stale Messages ends Here
        
        //to get new messages starts here
        $num = count($newmsgs);
        $index = $num -1;
        foreach($newmsgs as $key => $a){
	  ++$numc;
	  $msgid = $key;
	  $ar = $a;
	  $msg  = nl2br(strip_tags (stripslashes($ar[0])));
	  $avatarmsg = $ar[1];
	  $senderid = $ar[2];
	  $receiverid = $ar[3];
	  $time  =  $ar[4];
	  $senderdelete = $ar[5];
	  $receiverdelete = $ar[6];
	  $opened = $ar[7];
	  
      //code to get scroll to currrent scrollid
	  if(empty($scrollid) && $numc < $index){
	   if($receiverid  == $uid && $opened == "0" ){
	   $scrollid = $msgid;  
	   }else if($senderid == $uid && $opened == "0"){
	   $scrollid = $msgid;
	   }
	  }else if(empty($scrollid) && $numc >= $index){
	   $scrollid = $msgid;
	  }
	  //code to get Scroll ID Ends Here

	  
	  if($msg != '' && $avatarmsg == ''){
	  if($senderid == $uid){
	  $ndata .="<div id='$msgid' class='mymsg w3-panel'style='padding:0;margin:0;'>
     <div class='w3-right w3-card msg_txt w3-blue w3-padding w3-animate w3-ripple  w3-animate-zoom w3-medium 'style='max-width:250px;word-wrap: break-word;border-radius: 15px 50px 30px;margin: 5px;font-size:16px;'>
     <p class=''style='margin:2px;'>$msg</p>
     <p class='w3-tiny w3-left'style='margin:0;margin-left:5px;margin-right:10px;'>$time</p>";
  
	  if($opened == 1){
    $ndata .="<span id='isseen$msgid'class='w3-tiny w3-right'>seen</span>
    </div></div>";
     }else if($opened == 0){
	 $ndata .="<span id='isseen$msgid' class='w3-tiny w3-right'>sent</span>
    </div></div>";
	  }
	  }else if($receiverid == $uid){
	  $ndata .="<div id='$msgid' class='w3-panel partnermsg' style='padding:0;margin:0;'>
     <div class='w3-left msg_txt w3-text-blue w3-white w3-card w3-padding w3-ripple w3-animate-zoom'style='max-width:250px;word-wrap: break-word;border-radius:10px 0px 15px 15px;margin: 5px;font-size:16px;'>
     <p class=''style='margin:2px;'>$msg</p>
      <p class='w3-tiny w3-left'style='margin:0;'>$time</p></div></div>";
	  }
	  }else if($msg == '' && $avatarmsg != ''){
	  }	   
	  }//for each loop
     //to get new Messages EndS here
     $oldmsgtosend = implode("©©©",$oldarraytosend);
     return $oldmsgtosend."®®®".$ndata."®®®".$scrollid;
     
		  }else{
		  return "Failed".$conn->error;
		  }
		  
		  
        }
        
        
        
        
       //public function to update chat
       public function updateArrayOpen($data){
       global $uid;
       $uid = $this->getUid();
       function myfunction($v){
       $a = $v;
       global $uid;
       if($uid == $a[3]){
        $a[7] = 1;
       }
       return $a;
       }
       if(!empty($data) && is_array($data)){
         return array_map("myfunction",$data);
       }//if statement
       return array();
       }//closing Braces For Funxtion
    
    
    
    
    //public function To Update Chat Starts Here
    public function updateChat(){
    $conn = $this->conn;
    $uid = $this->getuid();
    $partnerid = $this->getPatnerId();
    $frmsgdetails = $this->msgdetails;
    $chatid = $this->getChatId();
    $scrollid = "";
    $ndata = "";
    $numc = 0;
    if(empty($chatid)){
    return "";
    }
   		  $sql = "select receivermsg,numnewmsg,shortnewmsg,msgdetails from fchat where chatid = '$chatid' limit 1";
		  $result =$conn->query($sql);
		  if($result->num_rows == 1){
		  $row = $result->fetch_assoc();
		  $receivermsg = $row["receivermsg"];
		  $numnewmsg = $row["numnewmsg"];
		  $shortnewmsg = $row["shortnewmsg"];
	      $msgdetails =  $row['msgdetails'];
	      if(empty($msgdetails)){
	      return "";
	      }else{
	      $msgdetails = str_replace('®®©','\ud',$msgdetails);       $msgdetails = json_decode($msgdetails,true);
if(!is_array($msgdetails)){
return "";
}
	      }
        $this->msgdetails=$_SESSION["m"]=$msgdetails = $this->updateArrayOpen($msgdetails);
$dbmsgdetails = json_encode($msgdetails);
         $dbmsgdetails = str_replace(array('\ud','<','>'),array('®®©','',''),$dbmsgdetails);
          
//insert Into Database Starts Here
          $dbmsgdetails= $conn->real_escape_string($dbmsgdetails);
          if($receivermsg == $uid){
          $numnewmsg = 0;
          }
          ++$numnewmsg;
          if($receivermsg == $uid){
      $sql2 = "update fchat set   receivermsg = '',numnewmsg='0',shortnewmsg ='',msgdetails = '$dbmsgdetails'where chatid= '$chatid' limit 1";
      }else{
      $sql2 = "update fchat set msgdetails = '$dbmsgdetails'where chatid= '$chatid' limit 1";
      }

          
          if($conn->query($sql2) != "true"){
       $this->msgdetails =$_SESSION["m"]=$frmsgdetails;
       return "Failed".$conn->error;
          }
//insert into Database Ends Here
        $newmsgs= array_diff_key($msgdetails,$frmsgdetails);
        $oldmsgs = array_intersect_key($msgdetails,$frmsgdetails);
        
        //code to Get Update For Stale Messages Starts Here
        if(count($oldmsgs) > 0){
        $oldarraytosend = array();
        foreach($oldmsgs as $value => $a){
        $oldchatid = $value;
        $oldarr = $a;
        $oldsenderid = $oldarr[2];
        $oldopened = $oldarr[7];
        if($oldsenderid == $uid && $oldopened == 1){
        array_push($oldarraytosend,$oldchatid);
        }
        }
        }
        //code to Get Update For Stale Messages ends Here
        
        //to get new messages starts here
        $num = count($newmsgs);
        $index = $num -1;
        foreach($newmsgs as $key => $a){
	  ++$numc;
	  $msgid = $key;
	  $ar = $a;
	  $msg  = nl2br(strip_tags (stripslashes($ar[0])));
	  $avatarmsg = $ar[1];
	  $senderid = $ar[2];
	  $receiverid = $ar[3];
	  $time  =  $ar[4];
	  $senderdelete = $ar[5];
	  $receiverdelete = $ar[6];
	  $opened = $ar[7];
	  
      //code to get scroll to currrent scrollid
	  if(empty($scrollid) && $numc < $index){
	   if($receiverid  == $uid && $opened == "0" ){
	   $scrollid = $msgid;  
	   }else if($senderid == $uid && $opened == "0"){
	   $scrollid = $msgid;
	   }
	  }else if(empty($scrollid) && $numc >= $index){
	   $scrollid = $msgid;
	  }
	  //code to get Scroll ID Ends Here

	  
	  if($msg != '' && $avatarmsg == ''){
	  if($senderid == $uid){
	  $ndata .="<div id='$msgid' class='mymsg w3-panel'style='padding:0;margin:0;'>
     <div class='w3-right w3-card msg_txt w3-blue w3-padding w3-animate w3-ripple  w3-animate-zoom w3-medium 'style='max-width:250px;word-wrap: break-word;border-radius: 15px 50px 30px;margin: 5px;font-size:16px;'>
     <p class=''style='margin:2px;'>$msg</p>
     <p class='w3-tiny w3-left'style='margin:0;margin-left:5px;margin-right:10px;'>$time</p>";
  
	  if($opened == 1){
    $ndata .="<span id='isseen$msgid'class='w3-tiny w3-right'>seen</span>
    </div></div>";
     }else if($opened == 0){
	 $ndata .="<span id='isseen$msgid' class='w3-tiny w3-right'>sent</span>
    </div></div>";
	  }
	  }else if($receiverid == $uid){
	  $ndata .="<div id='$msgid' class='w3-panel partnermsg' style='padding:0;margin:0;'>
     <div class='w3-left msg_txt w3-text-blue w3-white w3-card w3-padding w3-ripple w3-animate-zoom'style='max-width:250px;word-wrap: break-word;border-radius:10px 0px 15px 15px;margin: 5px;font-size:16px;'>
     <p class=''style='margin:2px;'>$msg</p>
      <p class='w3-tiny w3-left'style='margin:0;'>$time</p></div></div>";
	  }
	  }else if($msg == '' && $avatarmsg != ''){
	  }	   
	  }//for each loop
     //to get new Messages EndS here
     $oldmsgtosend = implode("©©©",$oldarraytosend);
     return $oldmsgtosend."®®®".$ndata."®®®".$scrollid;
     
		  }else{
		  return "Failed".$conn->error;
		  }
    
    }
    //public Function To UPdate Chat Ends Here
    
    //function to Get User Details starts Here
    public function getPartnerDetails(){
    $conn = $this->conn;
    $sql = "select username,avatar,lastlogindate from oaumeetupusers where userid = '$partnerid' limit 1";
    $result = $conn->query($sql);
    if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $uname = $row["username"];
    $avatar = $row["avatar"];
    $lastlogindate = $row["lastlogindate"];
    return array($uname,$avatar,$lastlogindate);
    }else{
    return "";
    }
        
    }
    //function to get User DetaIls Ends Here
    
}
?>
