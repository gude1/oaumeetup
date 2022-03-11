<?php
session_start();
require "classmeetupvalidate.php";
/**
 * class meant for database operation on the mainpage
 */
class oaumeetupmain extends meetupvalidate
{	
	function __construct()
	{
	 $this->createConnection();
	}

}
?>