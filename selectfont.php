<?php
require "classselectfont.php";
//create object
$prefsave = new selectfont();
if($prefsave->validateUser() != "true") {
header("location:oaumeetuplogin.php");
exit();
}
$fonttype = $prefsave->getFont();
//code to check if data has being sent from ajax
if (isset($_POST["pref"]) && isset($_POST["click"]) && $_POST["click"] == "clicked") {
$pref = $prefsave->clean_input($_POST["pref"]);
if(empty($pref)){
echo "<span class='w3-text-red w3-bold w3-animate-zoom'>Prefernce should not be empty</span><br>";
exit();
}elseif (!preg_match("/^[a-zA-Z ]*$/",$pref)) {
echo "<span class='w3-text-red w3-bold w3-animate-zoom'>Prefernce should only contain letters and whitespaces</span><br>";
exit();
}else{
$prefsave->setPref($pref);
//UPDATE USERS PREFERENCE HERE
$result = $prefsave->updatePref();
if ($result == "update successful") {
echo "saved";
exit();
}else{
echo $result;
exit();
}
}


}
?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup|Select Font</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content="social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website,oau social select,oau meetup select font">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<body class=""style="font-family: <?php echo $fonttype?>;">
<!--navbar for main page starts here-->
<div class="w3-top" style="">
<div class="w3-bar w3-blue w3-card-4"style="">
<div class="w3-bar-item w3-card-4 w3-white w3-left w3-margin w3-round-large w3-text-blue w3-ripple w3-hover-blue w3-hover-text-white"><i class="fa fa-arrow-left w3-bold w3-large "></i></div>
<h5 class="w3-bar-item w3-text-light-grey w3-italics w3-left" style="font-family: <?php echo $fonttype?>;">Change Font</h5>
<div class="w3-bar-item w3-card-4 w3-white w3-right w3-margin w3-round-large w3-text-blue w3-ripple w3-hover-blue w3-hover-text-white"><i class="fa fa-foursquare w3-bold w3-large "></i></div>
</div>
</div>
<!--navbar ends here-->
<!--Mainpage starts here-->
<div style="margin-bottom:60px;margin-top:100px;">
<!--Container for choosing font and testing it-->
<div class="w3-panel w3-padding-large w3-center w3-card-4 w3-light-grey w3-opacity w3-round-large"style="width:90%;margin:auto;">
 <p id="me" class="w3-label w3-bold w3-text-blue w3-large w3-padding">Select Your Preferred Font <i class="fa fa-foursquare w3-bold w3-xlarge w3-text-blue w3-card-4 w3-ripple w3-padding w3-round-large w3-ripple w3-hover-blue w3-hover-text-white"></i></p>
 <select  id="coll" class="w3-select w3-round-large selectfont" name="selectfont">
 <option  class="f"value="cursive">Cursive</option>
 <option value="Arial">Arial</option>
 <option value="New Times Roman">New Times Roman</option>
 <option value="Lato">Lato</option>
 </select>	
 <p id="sampletxt"style="font-family:cursive;padding:0;margin:25px;">Black Barbie :) , lets play a game of Love and Romance</p>
 <p class="w3-black w3-round-large w3-card-4"id="prgmsg"style="width:70%;margin:auto;margin-top:5px;margin-bottom:10px;"></p>
 <button id="savebtn"class="w3-btn w3-blue w3-text-white w3-block w3-round-large w3-hover-white w3-hover-text-blue"style="width:200px; margin:auto;">Save</button>
</div>



</div>
<!--Mainpage ends here-->
<!--footer starts here-->
<?php include_once "footer.php";?>
<!--footer ends here-->
<!--JAVASCRIPT-->
<script type="text/javascript">
$(document).ready(function(){
var check = $("#coll");
var txt = $("#sampletxt");
var prgmsg = $("#prgmsg");
var btn = $("#savebtn");
//code to change sample test appearance	
$(check).change(function(){
txt.attr("style","font-family :"+check.val());
});

//code for saving font preference starts here

$(btn).click(function(){
btn.hide();
prgmsg.html("<span class='w3-text-green w3-bold w3-animate-zoom'><i class='fa fa fa-spinner w3-spin'></i> Saving your preference please wait...</span>");
$.ajax({
url : "selectfont.php",
method : "post",
data : {pref:check.val(),click:"clicked"},
success : function(result){
if (result.indexOf("saved") > -1) {
prgmsg.html("<span class='w3-text-green w3-bold w3-animate-zoom'>Font prefernce saved <i class='fa fa-check'></i> ..You can change your font preference anytime from your settings page<br>You will be redirected in 5 seconds</span>");
function rDirect(){
window.location = "oaumeetupmain.php"; 
}
setTimeout(rDirect,"4000");
}else{
prgmsg.html(result)	;
btn.show();
}
},
error :function(xhr,status,err){
alert("Could not connect to server maybe due to bad network");
btn.show();
prgmsg.html("");


}


});});

});
</script>
</body>
</html>
