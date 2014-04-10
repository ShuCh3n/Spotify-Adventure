<?php
header("Access-Control-Allow-Origin: *");
include("config.php");
include("global_functions.php");

if(isset($_POST["page"])){
    $page = $_POST["page"];
    include($page . ".php");
}
?>
