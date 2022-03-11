<?php
require "classmeetsignup.php";
//declare variable to be used in the script
$signup = new oaumeetupsignup();
if ($signup->validateUser() == "true") {
header("location:oaumeetupmain.php");
exit();
}
$name=$username=$institution=$gender=$email=$phone=$password=$errmsg=$fonttype= "";
if (isset($_COOKIE["fontpref"])) {
$fonttype = $signup->clean_input($_COOKIE["fontpref"]);
}
if (empty($fonttype)) {
$fonttype = "cursive";
}




//for browser with enabled javascript
if (isset($_POST["clicked"]) && $_POST["clicked"] == "submit") {
  $name = $signup->clean_input($_POST["name"]);
  $username = $signup->clean_input($_POST["uname"]);
  $institution = $signup->clean_input($_POST["institution"]);
  $gender = $signup->clean_input($_POST["gender"]);
  $email = $signup->clean_input($_POST["email"]);
  $phone = $signup->clean_input($_POST["phone"]);
  $password = $signup->clean_input($_POST["password"]);

//data input checking,validation and cleaning starts here 
  if (empty($name) || empty($username) || empty($institution) || empty($gender) || empty($email) || empty($phone) || empty($password)) {
    if (empty($name)) {
      $errmsg.=" <span class='w3-text-red w3-bold'>Name input field is empty</span><br>";
    }
    if (empty($username)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Username input field is empty</span><br>";
    }
    if (empty($institution)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Institution has to be specified</span><br>";
    }
    if (empty($gender)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Gender has to be specified</span><br>";
    }
    if (empty($email)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Email input field is empty</span><br>";
    }
    if (empty($phone)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Phone number input field is empty</span><br>";
    }
    if (empty($password)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Password input field is empty</span><br>";
    }
    echo $errmsg;
    exit();

  }else{
    //start checking for name 
    if (strlen($name) > 50) {
      $errmsg.="<span class='w3-text-red w3-bold'>Name cannot be longer than 50 characters</span><br>";
    }elseif (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Name can only contain letters and whitespace</span><br>";
    }

    //start checking for username 
    if (strlen($username) > 15 || strlen($username) < 3) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Username must be between 3-15 characters long</span><br>";
    }elseif (!preg_match("/^[a-zA-Z@]*$/",$username)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Username can only contain letters and @ and no whitespace</span><br>";
    }

    //start checking for institution
    if (strlen($institution) > 10) {
      $errmsg.="<span class='w3-text-red w3-bold'>Institution cannot be longer than 10 characters</span><br>";
    }elseif (!preg_match("/^[a-zA-Z]*$/",$institution)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Institution should only contain letters</span><br>";
    }

    //start checking for gender
    if (strlen($gender) > 6) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Gender should not  be longer than 6 characters</span><br>";
    }elseif (!preg_match("/^[a-zA-Z]*$/",$gender)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Gender should only contain letters</span><br>";
    }

     //start checking for email
    if (strlen($email) > 50) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Email  cannot  be longer than 50 characters</span><br>";
    }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Invalid email format</span><br>";
    }

      //start checking for email
    if (strlen($phone) != 11) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Phone number  must be 11 characters long</span><br>";
    }elseif (!is_numeric($phone)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Invalid phone number</span><br>";
    }

     //start checking for email
    if (strlen($password) < 10 || strlen($password) > 15) {
      $errmsg.="<span class='w3-text-red w3-bold'>Password must be between 10-15 characters long</span><br>";
    }elseif (!preg_match("/^[a-zA-Z]*$/",$password)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Password can only contain letters</span><br>";
    }


    if (!empty($errmsg)) {
      echo $errmsg;
      exit();
    }else{
      $signup->setName($name);
      $signup->setUsername($username);
      $signup->setInstitution($institution);
      $signup->setGender($gender);
      $signup->setEmail($email);
      $signup->setPhone($phone);
      $signup->setPassword($password);
      $result = $signup->insertUser();

      if ($result == "success"){
        echo "success";
        exit();
      }else{echo $result;exit();}
    }


}

/*for javascript disabled users*/}else if(!isset($_POST["clicked"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
 $name = $signup->clean_input($_POST["oaumeetupname"]);
  $username = $signup->clean_input($_POST["oaumeetupusername"]);
  $institution = $signup->clean_input($_POST["institution"]);
  $gender = $signup->clean_input($_POST["oaumeetupgender"]);
  $email = $signup->clean_input($_POST["oaumeetupemail"]);
  $phone = $signup->clean_input($_POST["oaumeetupphone"]);
  $password = $signup->clean_input($_POST["oaumeetuppass"]);

//data input checking,validation and cleaning starts here 
  if (empty($name) || empty($username) || empty($institution) || empty($gender) || empty($email) || empty($phone) || empty($password)) {
    if (empty($name)) {
      $errmsg.=" <span class='w3-text-red w3-bold'>Name input field is empty</span><br>";
    }
    if (empty($username)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Username input field is empty</span><br>";
    }
    if (empty($institution)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Institution has to be specified</span><br>";
    }
    if (empty($gender)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Gender has to be specified</span><br>";
    }
    if (empty($email)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Email input field is empty</span><br>";
    }
    if (empty($phone)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Phone number input field is empty</span><br>";
    }
    if (empty($password)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Password input field is empty</span><br>";
    }

  }else{
    //start checking for name 
    if (strlen($name) > 50) {
      $errmsg.="<span class='w3-text-red w3-bold'>Name cannot be longer than 50 characters</span><br>";
    }elseif (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Name can only contain letters and whitespace</span><br>";
    }

    //start checking for username 
    if (strlen($username) > 15 || strlen($username) < 3) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Username must be between 3-15 characters long</span><br>";
    }elseif (!preg_match("/^[a-zA-Z@]*$/",$username)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Username can only contain letters and @ and no whitespace</span><br>";
    }

    //start checking for institution
    if (strlen($institution) > 10) {
      $errmsg.="<span class='w3-text-red w3-bold'>Institution cannot be longer than 10 characters</span><br>";
    }elseif (!preg_match("/^[a-zA-Z]*$/",$institution)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Institution should only contain letters</span><br>";
    }

    //start checking for gender
    if (strlen($gender) > 6) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Gender should not  be longer than 6 characters</span><br>";
    }elseif (!preg_match("/^[a-zA-Z]*$/",$gender)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Gender should only contain letters</span><br>";
    }

     //start checking for email
    if (strlen($email) > 50) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Email  cannot  be longer than 50 characters</span><br>";
    }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Invalid email format</span><br>";
    }

      //start checking for email
    if (strlen($phone) != 11) {
      $errmsg.="<span class='w3-text-red w3-bold'>  Phone number  must be 11 characters long</span><br>";
    }elseif (!is_numeric($phone)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Invalid phone number</span><br>";
    }

     //start checking for email
    if (strlen($password) < 10 || strlen($password) > 15) {
      $errmsg.="<span class='w3-text-red w3-bold'>Password must be between 10-15 characters long</span><br>";
    }elseif (!preg_match("/^[a-zA-Z]*$/",$password)) {
      $errmsg.="<span class='w3-text-red w3-bold'>Invalid phone number</span><br>";
    }

    //if there are no error msg proceed with signing up the user
    if (empty($errmsg)) {
    $signup->setName($name);
    $signup->setUsername($username);
    $signup->setInstitution($institution);
    $signup->setGender($gender);
    $signup->setEmail($email);
    $signup->setPhone($phone);
    $signup->setPassword($password);
    $result = $signup->insertUser();
    if ($result == "success"){
    header("location:oaumeetuplogin.php");
    }else{$errmsg.=$result;}}

}

}
?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup.com|signup</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website,oau social login,oau meetup signup ">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>

<style type="text/css">
	    body{
	    	height: 100vh;
	    	width: 100vw;
	    	background-image:url("social.jpg"); 
	    	background-repeat: no-repeat;
	    	background-position:center , top right; 
	    	background-attachment: fixed;
	    	background-size: cover;
	    	background-origin: padding-box; 
}
 
@media only screen and (max-width: 600px) {
	 #oaumeetupsignupctn{
   width: 90%;
 }
  #oaumeetupsignupctn{
   margin: auto;
   margin-top:2%;
 }
 }

@media only screen and (min-width: 600px) {
	 #oaumeetupsignupctn{
   width: 90%;
 }
#oaumeetupsignupctn{
   margin: auto;
   margin-top:2%;
 }
}



@media only screen and (min-width: 768px) {
	 #oaumeetupsignupctn{
   width: 60%;
 }
  #oaumeetupsignupctn{
   margin: auto;
   margin-top:2%;
 }

} 



@media only screen and (min-width: 992px) {
	 #oaumeetupsignupctn{
   width: 60%;
 }
  #oaumeetupsignupctn{
   margin: auto;
   margin-top:2%;
 }
} 

@media only screen and (min-width: 1200px) {
	 #oaumeetupsignupctn{
   width: 60%;
 }
   #oaumeetupsignupctn{
   margin: auto;
   margin-top:2%;
 }
}



	</style>
</head>
<body class="w3-light-grey w3-display-container"style="margin:0;font-family: <?php echo $fonttype;?>;">
<!--navbar starts here-->
  <?php include_once "navbar1.php";?>
   <!--navbar ends here-->
   <!--Mainpage starts here-->
   <div style="margin-bottom:60px;margin-top:100px;">
  <!--login form starts here-->
   	   <div id="oaumeetupsignupctn" style="">
		<form name="oaumeetupsignupform" id="oaumeetupsignupform"class="w3-form  w3-container w3-center w3-animate-zoom w3-opacity w3-blue w3-card-4 w3-round w3-block" method="post"action="<?php echo htmlentities($_SERVER["PHP_SELF"])."#footer";?>"style="">

			<div style="margin-top:20px;"><img src="cool.jpg"class="w3-image w3-circle w3-spin-slow" style="width:80px;height:75px;" /></div>
			<label class="w3-label w3-bold"for="oaumeetupname">Name</label>
             <input name="oaumeetupname"id="oaumeetupname"class="w3-input stafflog_input w3-border w3-round-large"type="text"placeholder="Name eg:John Doe" value="<?php echo $name;?>"required>
             <label class="w3-label w3-bold"for="oaumeetupusername">Username</label>
            <input name="oaumeetupusername" id="oaumeetupusername"class="w3-input stafflog_input w3-border w3-round-large"type="text"placeholder="username"value="<?php echo $username;?>" required>
            <label for ="institution" class="w3-label w3-bold">Institution</label>
            <select id="institution" class="w3-select w3-round-large" name="institution">
            <option value="oau">OAU</option>
            <option value="ui">UI</option>
            <option value="uniilorin">UNIILORIN</option>
            <option value="unilag">UNILAG</option>
            </select>
            <label for ="oaumeetupgender" class="w3-label w3-bold">Gender</label>
            <select id="oaumeetupgender" class="w3-select w3-round-large" name="oaumeetupgender">
            <option value="female">FEMALE</option>
            <option value="male">MALE</option>
            </select>



            <label class="w3-label w3-bold"for="oaumeetupemail">Email</label>
            <input  name="oaumeetupemail" id="oaumeetupemail"class="w3-input stafflog_input w3-border w3-round-large"type="email"placeholder="johndoe@example.com"value="<?php echo $email;?>"required>	
			      <label class="w3-label w3-bold"for="oaumeetupphone">Phone number</label>
            <input name="oaumeetupphone" id="oaumeetupphone"class="w3-input stafflog_input w3-border w3-round-large"type="tel"placeholder="eg:0801233...."value="<?php echo $phone;?>" required>	
        <label class="w3-label w3-bold"for="oaumeetuppass">Create Password</label>
			<input name="oaumeetuppass" id="oaumeetuppass"class="w3-input stafflog_input w3-round-large"type="password"placeholder="**********"value="<?php echo $password;?>" required>
			<label  for="showpass" class="w3-bold">Show Password</label>
      <input name="showpass" id="showpass" type="checkbox"class="w3-check"><br/> 
     <p class="w3-black w3-round-large w3-card-4 w3-large"id="errmsg"style="width:70%;margin:auto;margin-top:5px;"><?php echo $errmsg;?></p>
<input id="signupbtn"name="signupbtn"type="submit"class="w3-btn w3-card w3-block w3-hover-white w3-round-large w3-border w3-border-white w3-hover-text-blue"value="Submit"style="width:100px; margin-left: auto;margin-right:auto;margin-top:20px; margin-bottom:10px;">
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
  $("#oaumeetupsignupform").submit(function(e){
    e.preventDefault();
    var name,username,institution,gender,email,phone,password,btn,errctn,ro;
    name = $("#oaumeetupname").val();
    username = $("#oaumeetupusername").val();
    institution = $("#institution").val();
    gender = $("#oaumeetupgender").val();
    email = $("#oaumeetupemail").val();
    phone = $("#oaumeetupphone").val();
    password = $("#oaumeetuppass").val();
    btn = $("#signupbtn");
    errctn = $("#errmsg");
    ro = $("#footer").offset().top ;
    btn.hide();
    errctn.html("<span class='w3-text-green w3-bold w3-animate-zoom'><i class='fa fa fa-spinner w3-spin'></i> Processing...</span>");
  $.ajax({
    url : "oaumeetupsignup.php",
    method : "post",
    data : {name:name,uname:username,institution:institution,gender:gender,email:email,phone:phone,password:password,clicked:"submit"},
    success : function(result){
      if (result.indexOf("success") > -1) {
        errctn.html("<span class='w3-text-green w3-bold w3-animate-zoom'>Signup Sucess!!!</span>");
        $(window).scrollTop(ro);
        window.location = "oaumeetuplogin.php";
      }else{
        errctn.html(result);
        btn.show();
        $(window).scrollTop(ro);
}

    },error:function(xhr,status,error){
       alert("Could not connect to server maybe due to bad network please try again");
       errctn.html("");
       btn.show();
      }
  });
  });



 //scroll to navbar on top when user reacts with 
     /*$("#oaumeetuppass").on({
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

  //toggle btw showpassword and hide in signuform password
$("#showpass").click(function(){
var pass = $("#oaumeetuppass");
if(pass.attr("type") === "text"){
pass.attr("type","password");
}else{
pass.attr("type","text");
}
});


  });
</script>
</body>
</html>