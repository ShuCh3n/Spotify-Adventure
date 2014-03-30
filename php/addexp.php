<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);
$next_level = $mysqli->real_escape_string($_POST["nextlevel"]);

addExp($hero_id);
checkLevel($hero_id, $next_level);
?>