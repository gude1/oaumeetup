<?php
if(isset($_POST["ahha"])){
echo "trousers";	
}
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
<script type="text/javascript" src="jquery.form.min.js"></script>
</head>
<body>
<form method="post" id="me" action="testing.php">
	<input type="text" name="ahha">
	<input type="submit" name="c">
</form>
<div class="w3-light-grey w3-round" style="width:50%; margin:auto;">
<div id="t"class="w3-blue w3-container"style="width:0%;">
0%
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
var t =$("#t");	
$("#me").ajaxSubmit({
 beforeSend:function() {
alert("love");
 },
uploadProgress:function(event,position,total,percentagecomplete){
t.animate({width:percentagecomplete+"%"},"slow");
 },
success:function(){

 },
complete: function(response) {
alert(response.text);
 }
});
});
/*;
var width = 0;
var start = setInterval(move,1000);

function move(){
if(width >= 100){
width = 0;
}else{
width += 10;
}
//t.attr("style","width:"+width+"%");
t.animate({width:width+"%"},"slow");
t.html(width+"%");
}
*/

</script>
</body>
</html>