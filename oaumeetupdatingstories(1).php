<?php
require "classdatingstories.php";
$datestory=$fonttype=$userstory=$trendstory="";
$datestory = new meetupdatingstories();
if($datestory->validateUser() == "false") {
header("location:oaumeetuplogin.php");
exit();
}
$fonttype = $datestory->getFont();
$userstory = $datestory->getUserStories();
$trendstory = $datestory-> getTrendStories();
?>
<!DOCTYPE html>
<html>
<head>
<title>oameeetup|Dating Stories</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website,oau social page,oau meetup Dating stories ">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<body style="font-family:<?php echo $fonttype;?> ">
<!--navbar starts here-->
<?php include_once "navbar2.php"?>
<!--navbar ends here-->
<!--main page content starts here-->
<div class=""style="margin-top:135px;margin-bottom:60px;">
<!--container for stories list-->
<ul class="w3-ul">
<!--for your own story-->
<div id="taketowritestoryctn"class="">
<!-- button to take you to where you can write your story starts here-->
<a href="oaumeetupwritestory.php"style="text-decoration: none;">		
<h6 class="w3-light-grey w3-bold w3-text-black"style="padding:5px;margin:0;">Your Story</h6>
<div class="w3-ripple w3-bar"style="padding-top:5px;padding-bottom:2px;margin:5;width:90%;">
<button class="w3-circle w3-bar-item w3-display-container w3-card w3-white w3-center w3-border w3-text-blue w3-border-blue w3-tiny"style="width:60px;height:60px;word-wrap:break-word;overflow:hidden;padding: 0;margin-left: 8px;"/><i class="fa fa-pencil w3-display-middle w3-xxlarge"></i></button>
<span class="w3-text-blue w3-bar-item w3-large"style="padding: 2px;margin-top:12px;margin-left:3px;">Write your Story</span>
</div>
</a>
<!-- button to take you to where you can write your story ends here-->

<!--dynamic stories from database starts here-->
<div id="yourstory">
<?php echo $userstory;?>
</div>
<!--dynamic stories from database ends here-->
</div>
<!--for your own story ends here-->

<!--other stories-->
<div class="w3-blue w3-padding w3-bold">Dating stories</div>
<?php echo $trendstory;?>
<!--other stories end here-->


</ul>
<!--container for stories list ends here-->	
</div>
<!--main page content ends here-->
<!--footer-->
<?php include_once "footer.php";?>
<!--footer-->
<!--javascript-->
<!--javascript-->
</body>
</html>