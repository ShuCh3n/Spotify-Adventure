<?php
$spotify_user = $mysqli->real_escape_string($_POST["spotify_user"]);

echo getExistPlayer($spotify_user);
?>