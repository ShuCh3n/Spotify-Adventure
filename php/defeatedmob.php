<?php
$mob_id = $mysqli->real_escape_string($_POST["mob_id"]);
$hero_id = $mysqli->real_escape_string($_POST["hero_id"]);

defeatedMob($mob_id, $hero_id);
?>