<?php
$hero_id = $mysqli->real_escape_string($_POST["hero_id"]);

switchHero($hero_id);
?>