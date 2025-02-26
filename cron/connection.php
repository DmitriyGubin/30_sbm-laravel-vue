<?php
$HOST = "**********";
$USER = "**********";
$PASSWORD = "***********";
$BDname = "*********";

$link = new mysqli ($HOST, $USER, $PASSWORD, $BDname);
$link -> query ('SET NAMES "utf8"');

?>