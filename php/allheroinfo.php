<?php
$spotify_user = $mysqli->real_escape_string($_POST["spotify_user"]);

getAllHeroInfo($spotify_user);
?>