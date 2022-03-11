<?php
require "classoaumeetupmain.php";
$mainpage=$fonttype="";
$mainpage = new oaumeetupmain();
if ($mainpage->validateUser() == "false") {
header("location:oaumeetuplogin.php");
exit();
}
$fonttype = $mainpage->getFont();
 ?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup|Mainpage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website,oau social main page,oau meetup homepage ">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<body style="font-family: <?php echo $fonttype;?>">
<!--navbar for main page starts here-->
<?php include_once "navbar2.php";?>
<!--navbar for main page ends here-->
<!--mainpage starts here-->
<div class=""style="margin-top:140px;margin-bottom:60px;">
</div>
<!--mainpage ends here-->
<!--footer starts here-->
<?php include_once "footer.php";?>
<!--footer ends here-->
</body>
</html>