<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);
$quest_id = $mysqli->real_escape_string($_POST["questid"]);

finishQuests($hero_id, $quest_id);
?>
