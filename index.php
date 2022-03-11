<?php
/*if ($_SERVER['REQUEST_METHOD'] == "POST" && preg_match("/^[a-zA-Z@]*$/",$_POST["username"])) {
	echo "<script type='text/javascript'> alert('$_POST[username]')</script>";
}*/

?>
 <Doctype html>
<html>
<head>
<title>oaumeetup.com|Homepage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<style type="text/css">
	a{
		text-decoration: none;
	}
</style>
</head>
<body class="w3-light-grey"style="margin:0;font-family: cursive;">
	<!--navbar starts here-->
	<?php include_once "navbar1.php";?>
   <!--navbar ends here-->
    <!--Main page content starts here-->
    <div class=""style="margin-top:55px;margin-bottom:60px;">
    	<!---animation/image starts here-->
  <img src="social.jpg" class="w3-image"style="width:100%;max-height:400px;">
    	<!--animation/image ends here-->
     
      <!--introductory content starts here-->
      <a href="oaumeetupfmatch.php"><div class="w3-container "style="max-width:700px;margin-left:auto;margin-right:auto;margin-top:5px;">
      	<div class="w3-blue w3-center w3-animate-zoom w3-card w3-ripple w3-round-large">
      		<img src ="love.png"class="w3-image w3-spin w3-circle"style="width:100px;height:100px;margin-top: 5px;"/>
      		<p class="w3-text-white w3-animate-zoom"style="">Find a online match within oau campus</p>
      	</div></a>

      	<a href="oaumeetupachat.php"><div class="w3-blue w3-center w3-animate-zoom w3-card w3-ripple w3-round-large">
      		<img src ="anonymouschat.jpeg"class="w3-image w3-spin w3-circle"style="width:100px;height:100px;margin-top: 5px;"/>
      		<p class="w3-text-white w3-animate-zoom"style="">Find out who has being thinking about you  through our anonymous chat messaging system</p>
      	</div></a>

      	<a href="oaumeetupchat.php"><div class="w3-blue w3-center w3-animate-zoom w3-card w3-ripple w3-round-large">
      		<img src ="chatlogo.png"class="w3-image w3-spin w3-circle"style="width:100px;height:100px;margin-top: 5px;"/>
      		<p class="w3-text-white w3-animate-zoom"style="">Send message to friends and loved ones via chat messaging system</p>
      	</div></a>

      		<a href="oaumeetupdatingstories.php"><div class="w3-blue w3-center w3-animate-zoom w3-card w3-ripple w3-round-large">
      		<img src ="story.jpeg"class="w3-image w3-spin w3-circle"style="width:100px;height:100px;margin-top: 5px;"/>
      		<p class="w3-text-white w3-animate-zoom"style="">Read Dating tips and Stories</p>
      	</div></a>


       </div>
      <!--intorductory content ends here-->
  </div>
    <!--Mainpage content ends here-->

  <!--footer starts here-->
<?php include_once "footer.php";?>
<!--footer ends here-->
</body>
</html>