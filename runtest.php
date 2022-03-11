<?php
if (isset($_POST['g'])) {
$arrayName = array($_POST['g']);
/*$k = str_replace(array("\r","\n"," "),array("_+_","_-_","_=_"),$arrayName);
print_r($k);*/
echo $b = nl2br($_POST['g']);
echo $c = json_encode($arrayName,true);
}
?>
<form action ="runtest.php"method="post">
<textarea name="g">
</textarea>
<input type="submit" name="ga">
</form>
