<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);
$quest_id = $mysqli->real_escape_string($_POST["questid"]);
$type = $mysqli->real_escape_string($_POST["type"]);

questAction($hero_id, $quest_id, $type);
?>