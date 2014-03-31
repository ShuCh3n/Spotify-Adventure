<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);
getAcceptedQuests($hero_id);
?>