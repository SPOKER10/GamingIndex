<?php
	$id = $_POST["sad"];
    if($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_numeric($id)) exit();
    require_once 'mdb.php';
  	$link = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_query($link, "UPDATE indexano SET Views=Views+1 WHERE ID='$id'");
    mysqli_close($link);
?>