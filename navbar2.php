<?php
$profiledesign=$storydesign=$chatdesign=$matchdesign=$achatdesign=$filename="w3-bar-item w3-tiny w3-center w3-btn w3-hover-white w3-ripple w3-hover-text-blue w3-display-container";
$filename = substr($_SERVER["PHP_SELF"],14);
if($filename == "oaumeetupdatingstories.php"){
$storydesign = "w3-bar-item w3-tiny w3-center w3-btn w3-white w3-ripple w3-text-blue w3-display-container";
}elseif ($filename == "oaumeetupfchat.php") {
$chatdesign ="w3-bar-item w3-tiny w3-center w3-btn w3-white w3-ripple w3-text-blue w3-display-container";
}elseif ($filename == "oaumeetupfindmatch.php") {
$matchdesign = "w3-bar-item w3-tiny w3-center w3-btn w3-white w3-ripple w3-text-blue w3-display-container";
}elseif ($filename == "oaumeetupachat.php") {
$achatdesign = "w3-bar-item w3-tiny w3-center w3-btn w3-white w3-ripple w3-text-blue w3-display-container";
}
?>
<div class="w3-top" style="">
<div class="w3-bar w3-blue"style="">
		<!--oau meetup logo starts here-->
		<h5 class="w3-bar-item w3-text-light-grey w3-italics w3-left" style="letter-spacing:4px;font-family:<?php echo $fonttype;?>"><a href="index.php" style="text-decoration: none;"> Oau Meetup</a></h5>
		<!--oau meetup logo ends here-->
		<div class="w3-bar-item w3-right w3-ripple w3-btn "style="margin-top: 12px;height:100%;"><i class="fa fa-search w3-large"></i></div>
	</div>

<div class="w3-bar w3-blue  w3-center w3-card">
<a href="oaumeetupprofile.php"><div class="<?php echo $profiledesign;?>" style="width:20%;">
		<img src ="profileicon.png"class="w3-circle"style="width:40px;height:40px;"/><br/>
		<span>Profile</span>
		<span class="w3-red w3-circle w3-display-topright w3-padding">2</span>
	</div></a>

	<a href="oaumeetupdatingstories.php" style="text-decoration: none;"><div class="<?php echo $storydesign;?>" style="width:20%;">
<img src ="storylove.jpg"class="w3-circle"style="width:40px;height:40px;"/><br/>
		<span>Stories & Tip</span>
</div></a>

		<a href="oaumeetupfchat.html" style="text-decoration: none;"><div class="<?php echo $chatdesign;?>" style="width:20%;">
<img src ="chaticon.png"class="w3-circle "style="width:40px;height:40px;"/><br/>
		<span>Chat</span>
</div></a>

<a href="oaumeetupfindmatch.html" style="text-decoration: none;"><div class="<?php echo $matchdesign;?>" style="width:20%;">
<img src ="lovematch.png"class="w3-circle "style="width:40px;height:40px;"/><br/>
		<span>Find Match</span>
</div></a>

<a href="oaumeetupdatingachat.html" style="text-decoration: none;"><div class="<?php echo $achatdesign;?>" style="width:20%;">
<img src ="chathide.jpg"class="w3-circle "style="width:40px;height:40px;"/><br/>
		<span>Achat</span>
</div></a>



</div></div>