<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);
getQuests($hero_id);
?>