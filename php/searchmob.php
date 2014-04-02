<?php
$mob_name = $mysqli->real_escape_string($_POST["search"]);

checkMobName($mob_name);
?>