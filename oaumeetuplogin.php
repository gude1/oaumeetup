<?php
require "classoaumeetuplogin.php";
//declare variables needed
$type="password";
$email=$password=$errmsg =$fonttype="";
$login = new meetupLogin();
$b = $login->validateUser();
if ($b == "true") {
header("location:oaumeetupmain.php");
exit();
}

if (isset($_COOKIE["fontpref"])) {
$fonttype =$login->clean_input($_COOKIE["fontpref"]);
}
if (empty($fonttype)) {
$fonttype = "cursive";
}
//for javascript enabled users 
if (isset($_POST["click"]) && $_POST["click"] == "submit") {
	$email = $login->clean_input($_POST["email"]);
	$password = $login->clean_input($_POST["pass"]);
	if (empty($email) || empty($password)) {
	if (empty($email)) {
	$errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Email input field is empty</span><br>";
    }
    if (empty($password)) {
	$errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Password input field is empty</span><br>";
    }
    echo $errmsg;
    exit();
   /*if inputs are not empty*/}else{
   	//validate email
   	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Invalid email format</span><br>";}
   	//validate password
   	if (strlen($password) < 10 || strlen($password) > 15) {
	$errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Invalid password</span><br>";}

	//if their is any error display and kill the script
	if(!empty($errmsg)){
    echo $errmsg;
	exit();
	}

	//set email and password data for login
	$login->setEmail($email);
	$login->setPassword($password);
	$result = $login->logUserIn();
	if ( $result == "success login") {
		echo "success";
		exit();
	}else{
	  echo $result;exit();}


   }

 	
 /*for javascript disabled users*/}elseif (!isset($_POST["click"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $login->clean_input($_POST["oaumeetupemail"]);
	$password = $login->clean_input($_POST["oaumeetuplogpass"]);
	if (empty($email) || empty($password)) {
	if (empty($email)) {
	$errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Email input field is empty</span><br>";
    }
    if (empty($password)) {
	$errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Password input field is empty</span><br>";
    }
   /*if inputs are not empty*/}else{
   	//validate email
   	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Invalid email format</span><br>";}
   	//validate password
   	if (strlen($password) < 10 || strlen($password) > 15) {
	$errmsg.="<span class='w3-text-red w3-bold w3-animate-zoom'>Invalid password</span><br>";}

	//if their is no error
	if(empty($errmsg)){
	//set email and password data for login
	$login->setEmail($email);
	$login->setPassword($password);
	$result = $login->logUserIn();
	if ( $result == "success login") {
	header("location:oaumeetupmain.php");
	exit();
	}else{
	$errmsg.=$result;
    }}
   }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup.com|Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content="social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website,oau social login,oau meetup login ">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
	<style type="text/css">
	    body{
	    	height: 100vh;
   margin-top:2%;
        width: 100vw;
        background-image:url("social.jpg"); 
        background-repeat: no-repeat;
        background-position:center , top right; 
        background-attachment: fixed;
        background-size: cover;
        background-origin: padding-box; 
}
 
@media only screen and (max-width: 600px) {
   #oaumeetuploginctn{
   width: 90%;
 }
  #oaumeetuploginctn{
   margin: auto;
 }
 }

@media only screen and (min-width: 600px) {
	 #oaumeetuploginctn{
   width: 90%;
 }
#oaumeetuploginctn{
   margin: auto;
   margin-top:2%;
 }
}



@media only screen and (min-width: 768px) {
	 #oaumeetuploginctn{
   width: 60%;
 }
  #oaumeetuploginctn{
   margin: auto;
   margin-top:2%;
 }

} 



@media only screen and (min-width: 992px) {
	 #oaumeetuploginctn{
   width: 60%;
 }
  #oaumeetuploginctn{
   margin: auto;
   margin-top:2%;
 }
} 

@media only screen and (min-width: 1200px) {
	 #oaumeetuploginctn{
   width: 60%;
 }
   #oaumeetuploginctn{
   margin: auto;
   margin-top:2%;
 }
}



	</style>
</head>
<body class="w3-light-grey"style="margin:0;font-family: <?php echo $fonttype;?>;">
<!--navbar starts here-->
<?php include_once "navbar1.php";  ?>
<!--navbar ends here-->
   
   <!--Mainpage starts here-->
   <div style="margin-bottom:60px;margin-top:100px;">


   	<!--login form starts here-->
   	   <div id="oaumeetuploginctn" style="">
		<form method="post" name="oaumeetuploginform"id="oaumeetuploginform"class="w3-form  w3-container w3-center w3-animate-zoom w3-opacity w3-blue w3-card-4 w3-round w3-block"action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>"style="">

			<div style="margin-top:20px;"><img src="cool.jpg"class="w3-image w3-circle w3-spin-slow" style="width:80px;height:75px;" /></div>
	       <label class="w3-label"for="oaumeetupemail">Email</label>
			<input type="email" id="oaumeetupemail"name="oaumeetupemail"class="w3-input stafflog_input w3-border w3-round-large"type="text"placeholder="johndoe@example.com"value="<?php echo $email;?>"required>			
			<label class="w3-label"for="stafflogpass">Password</label>
			<input id="oaumeetuplogpass"name="oaumeetuplogpass"class="w3-input stafflog_input w3-round-large"type="<?php echo $type;?>"placeholder="**********"value="<?php echo $password;?>"required>
		    <label  for="showpass" class="w3-bold">Show Password</label>
			<input name="showpass" id="showpass" type="checkbox"class="w3-check"><br/> 
			<div class="w3-black w3-round-large w3-card-4 w3-large"style="width:70%;margin:auto;margin-top:5px;"><span class='w3-text-green w3-bold w3-animate-zoom w3-hide'id="logmsg"><i class='fa fa-spinner w3-spin'></i> Login in...</span>
			<p id="errmsg"><?php echo $errmsg;?></p>
			</div>
			<input type="submit" name="loginbtn"id="loginbtn" class="w3-btn w3-card w3-block w3-hover-white w3-round-large w3-border w3-border-white w3-hover-text-blue"style="width:100px; margin-left: auto;margin-right:auto;margin-top:20px; margin-bottom:10px;" value="Login">
			<a class="w3-text-white w3-right w3-bold w3-padding"style="font-size:;text-decoration: underline;">Forgot password?</a>	
		</form>
	</div>
		<!--login form ends here-->
  
   </div>
   <!--Mainpage ends here-->

 <!--footer starts here-->
 <?php include_once "footer.php";?>
 <!--footer ends here-->
 <script type="text/javascript">
 	$(document).ready(function(){
 	 $("#oaumeetuploginform").submit(function(e){
 		e.preventDefault();
 		var email,password,btn,errmsg,ro,log;
 		email = $("#oaumeetupemail").val();
 		password = $("#oaumeetuplogpass").val();
 		btn = $("#loginbtn");
 		errmsg = $("#errmsg");
 		log = $("#logmsg");
 		ro = $("#footer").offset().top;
    btn.hide();
    errmsg.html("");
    log.removeClass("w3-hide");
   $(this).scrollTop(ro);
 		$.ajax({
 		url : "oaumeetuplogin.php",
 		method : "post",
 		data : {email:email,pass:password,click:"submit"},
 		success : function(result){
 		if (result.indexOf("success") > -1) {
 		log.addClass("w3-hide");
 		errmsg.html("<span class='w3-text-green w3-bold w3-animate-zoom'> Login Succesful <i class='fa fa-check'> you will be redirected in 1 seconds</i></span>");
 		function rDirect(){
        window.location = "oaumeetupmain.php"; 
        }
       setTimeout(rDirect,"1000");

 		}else{

 		log.addClass("w3-hide");
 	    errmsg.html(result);
 	    $(window).scrollTop(ro);
        btn.show();}

 		},error:function(xhr,status,error){
        alert("Could not connect to server maybe due to bad network please try again");
        log.addClass(" w3-hide");
        errmsg.html("");
        btn.show();
        }

 		});});

 	   //toggle btw showpassword and hide in loginforms password
       $("#showpass").click(function(){
       var pass = $("#oaumeetuplogpass");
       if(pass.attr("type") === "text"){
       pass.attr("type","password");
       }else{
       pass.attr("type","text");
       }});

      //scroll to navbar on top when user reacts with 
     /* $("input").on({
      	focus :function(){
      	$("#oaumeetuploginform").scrollTop($("#footer").offset().top);
      },
      click :function(){
      	$(window).scrollTop($("#footer").offset().top);
      },
      hover :function(){
      	$(window).scrollTop($("#footer").offset().top);
      }
      });*/

 	});	
 </script>
</body>