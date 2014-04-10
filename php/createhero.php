<?php
$gender = $mysqli->real_escape_string($_POST["gendertype"]);
$spotify_user = $mysqli->real_escape_string($_POST["spotify_user"]);
$hero_name = $mysqli->real_escape_string($_POST["hero_name"]);

createNewHero($gender, $spotify_user, $hero_name);
?>