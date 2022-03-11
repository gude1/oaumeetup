<?php
/**
 *
 */
class conn
{
protected $conn;

protected function createConnection()
  {
DEFINE("server","localhost");
DEFINE("username","root");
DEFINE("password","");
DEFINE("dbname","oaumeetupdb");
$this->conn = new mysqli(server, username, password,dbname);

if(mysqli_connect_error()){
echo mysqli_connect_error();
 }else{
 echo "";
 }


/*$sql3 = "create table if not exists storycomment(
id INT(11) AUTO_INCREMENT,
storyid VARCHAR(150) NOT NULL,
commenterid VARCHAR(150) NOT NULL,
commentid VARCHAR(150) NOT NULL,
comment MEDIUMTEXT NOT NULL,
date  INT(20) NOT NULL,
numreply INT(20) NOT NULL,
numshare INT(20) NOT NULL,
PRIMARY KEY(id)
)";
if($this->conn->query($sql3) == true){
echo "storycomment table created";
}else{
echo $this->conn->error;
}*/

/*$sql2 ="create table if not exists oaumeetupusers (
id INT(11) AUTO_INCREMENT,
userid VARCHAR(150) NOT NULL ,
name  VARCHAR(255)  NOT NULL,
username VARCHAR(80) NOT NULL,
email VARCHAR(80) NOT NULL ,
phonenumber VARCHAR(20) NOT NULL,
institution VARCHAR(50) NOT NULL,
gender VARCHAR(50) NOT NULL
password VARCHAR(255) NOT NULL,
signupdate  INT(20) NOT NULL,
avatar VARCHAR(80) NOT NULL,
friend_array MEDIUMTEXT NOT NULL,
meetup_preference MEDIUMTEXT NOT NULL,
bio VARCHAR(255) NULL,
lastlogindate INT(20) NOT NULL ,
notescheckdate INT(20) NOT NULL,
fontpref VARCHAR(20) NOT NULL,
attributes MEDIUMTEXT NOT NULL,
activated ENUM('0','1') NOT NULL DEFAULT '0',
PRIMARY KEY(id),
UNIQUE userid(userid,email)
)";
 if($this->conn->query($sql2) == true){
echo "oaumeetupusers table created";
 }else{
echo $this->conn->error;
}*/

/*$sql = "create database oaumeetupdb";
 if($this->conn->query($sql) == true){
echo "database created successfully";
 }else{
echo $this->conn->error;
}*/


/*$sql2 ="create table  if not exists stories(
id INT(11) AUTO_INCREMENT,
writerid VARCHAR(150) NOT NULL ,
storyid VARCHAR(150) NOT NULL,
storytitle  VARCHAR(255)  NOT NULL,
storycontent MEDIUMTEXT NOT NULL,
mood VARCHAR(20) NOT NULL,
numviews INT(20) NOT NULL,
viewerslist MEDIUMTEXT NOT NULL,
numcomment INT(20) NOT NULL,
commenterslist MEDIUMTEXT NOT NULL,
anonymous ENUM('0','1') NOT NULL DEFAULT '0',
expired ENUM('0','1') NOT NULL DEFAULT '0',
date INT(20) NOT NULL,
PRIMARY KEY(id)
)";
 if($this->conn->query($sql2) == true){
echo "stories created succesfully";
 }else{
echo $this->conn->error;
}*/

/*$sql3 = "create table if not exists chatcreate(
id INT(11) AUTO_INCREMENT,
creatorid VARCHAR(150) NOT NULL,
recepientid VARCHAR(150) NOT NULL,
type ENUM('0','1') NOT NULL DEFAULT '0',
chatid VARCHAR(150) NOT NULL,
date INT(20) NOT NULL,
PRIMARY KEY(id)
)";

if($this->conn->query($sql3) == true){
echo "chatcreate succesfully";
 }else{
echo $this->conn->error;
}*/

}
}
/**
 *
 */




 /*$sql = "create database oaumeetupdb";
 if($conn->query($sql) == true){
echo "database created successfully";
 }else{
echo $conn->error;
}*/

/*$sql2 ="create table if not exists oaumeetupusers (
id INT(11) AUTO_INCREMENT,
userid VARCHAR(150) NOT NULL ,
name  VARCHAR(255)  NOT NULL,
username VARCHAR(80) NOT NULL,
email VARCHAR(80) NOT NULL ,
phonenumber VARCHAR(20) NOT NULL,
institution VARCHAR(50) NOT NULL,
password VARCHAR(255) NOT NULL,
signupdate  INT(20) NOT NULL,
avatar VARCHAR(80) NOT NULL,
friend_array MEDIUMTEXT NOT NULL,
meetup_preference MEDIUMTEXT NOT NULL,
bio VARCHAR(255) NULL,
lastlogindate INT(20) NOT NULL ,
notescheckdate INT(20) NOT NULL,
fontpref VARCHAR(20) NOT NULL,
attributes MEDIUMTEXT NOT NULL,
activated ENUM('0','1') NOT NULL DEFAULT '0',
PRIMARY KEY(id),
UNIQUE userid(userid,email)
)";
 if($conn->query($sql2) == true){
echo "oaumeetupusers table created";
 }else{
echo $conn->error;
}*/



/*$slq = "CREATE TABLE IF NOT EXISTS blockedusers ( id INT(11) NOT NULL AUTO_INCREMENT, blocker VARCHAR(255) NOT NULL, blockee VARCHAR(255) NOT NULL, blockdate DATETIME NOT NULL, PRIMARY KEY (id) )";


$sql1= "CREATE TABLE IF NOT EXISTS nesafriends ( id INT(11) NOT NULL AUTO_INCREMENT, nesauser1 VARCHAR(16) NOT NULL, user2 VARCHAR(16) NOT NULL, datemade DATETIME NOT NULL, accepted ENUM('0','1') NOT NULL DEFAULT '0', chatid varchar(255) NOT NULL, PRIMARY KEY (id) ,UNIQUE chatid(chatid))";




$sql2 ="create table  if not exists stories(
id INT(11) AUTO_INCREMENT,
writerid VARCHAR(150) NOT NULL ,
storyid VARCHAR(150) NOT NULL,
storytitle  VARCHAR(255)  NOT NULL,
storycontent MEDIUMTEXT NOT NULL,
mood VARCHAR(20) NOT NULL,
numviews VARCHAR(255) NOT NULL,
viewerslist MEDIUMTEXT NOT NULL,
numcomment VARCHAR(255) NOT NULL,
commenterslist MEDIUMTEXT NOT NULL,
anonymous ENUM('0','1') NOT NULL DEFAULT '0',
expired ENUM('0','1') NOT NULL DEFAULT '0',
date INT(20) NOT NULL,
PRIMARY KEY(id)
)";
 if($this->conn->query($sql2) == true){
echo "stories created succesfully";
 }else{
echo $this->conn->error;
}





if($conn->query($sql1) == true){


echo "nesafriends tanle creta";
 }else{

echo $conn->error;
}


if($conn->query($slq) == true){


echo "blocked tanle creta";
 }else{

echo $conn->error;
}




$sql3 = "CREATE TABLE IF NOT EXISTS nesaprivatechat ( id INT(11) NOT NULL AUTO_INCREMENT, sender VARCHAR(16) NOT NULL, receiver VARCHAR(16) NOT NULL, message VARCHAR(255) NOT NULL, sender_delete ENUM('0','1') NOT NULL DEFAULT '0',
receiver_delete ENUM('0','1') NOT NULL DEFAULT '0',
opened ENUM('0','1') NOT NULL DEFAULT '0',
 datesent DATETIME NOT NULL,
 dateopened DATETIME NOT NULL,
    chatid varchar(255) NOT NULL,
   PRIMARY KEY (id))";



if($conn->query($sql3) === true){

echo "nesa chat created successfully";

}else{

echo $conn->error;

}*/


/*$sql = "Insert into nesaprivatechat(sender,receiver,message,datesent,opened,chatid) values('Babatunde1','Tadashi001','God is great',now(),'1','da17bdcb4e80f5be2fb3d37c4b5942e15285b91a0868a607dcd544cff050c6ac')";


if($conn->query($sql) == true){
echo "done";


}else{
echo $conn->error;
}*/





/**$sql3 = "CREATE TABLE IF NOT EXISTS nesagroups ( id INT(11) NOT NULL AUTO_INCREMENT, admin VARCHAR(16) NOT NULL, members VARCHAR(255) NOT NULL,
 datemade DATETIME NOT NULL,
    groupid varchar(255) NOT NULL,
    PRIMARY KEY (id),
UNIQUE groupid(groupid)

)";


if($conn->query($sql3) == true){
echo "done";


}else{
echo $conn->error;,
}**/


/**$sql3 = "CREATE TABLE IF NOT EXISTS groupinvite ( id INT(11) NOT NULL AUTO_INCREMENT, sender VARCHAR(16) NOT NULL, receiver VARCHAR(16) NOT NULL,
senderacceptmsg VARCHAR(100) NULL,
receiverdeletemsg VARCHAR(100) NULL,
  datemade DATETIME NOT NULL,
     groupid varchar(255) NOT NULL,
     accepted ENUM('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (id)

 )";

if($conn->query($sql3) == true){
echo "done";


}else{
echo $conn->error;
}**/

/**$sql3 = "CREATE TABLE IF NOT EXISTS poetinvite ( id INT(11) NOT NULL AUTO_INCREMENT, requester VARCHAR(16) NOT NULL, receiver VARCHAR(16) NOT NULL,
requseteracceptmsg VARCHAR(100) NULL,
receiverdeletemsg VARCHAR(100) NULL,
  datemade DATETIME NOT NULL,
     poetid varchar(255) NOT NULL,
     accepted ENUM('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (id)

 )";

 if($conn->query($sql3) == true){
echo "done";


}else{
echo $conn->error;
}**/

/**$sql3 = "CREATE TABLE IF NOT EXISTS replycommentpoetslikes( id INT(11) NOT NULL AUTO_INCREMENT,
replyid VARCHAR(255) NOT NULL,
likes VARCHAR(255) NOT NULL,
likersnames VARCHAR(255) NOT NULL,
       PRIMARY KEY (id)

 )";

       if($conn->query($sql3) == true){
    echo "done";
}else{
 $co = new conn();
$co->createConnection();
 echo $conn->error;
$co = new conn();
$co->createConnection();
 echo $conn->error;
}**/
