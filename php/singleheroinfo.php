<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);
$spotify_user = $mysqli->real_escape_string($_POST["spotify_user"]);

getSingleHeroInfo($hero_id, $spotify_user, 1);
?>