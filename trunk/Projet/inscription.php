<?php
	$connect = mysql_connect("localhost","root","root")
		or die(mysql_error());
	
	$result = mysql_select_db("GeekProduct",$connect)
		or die(mysql_error());
	
?>