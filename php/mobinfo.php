<?php
$mob_id = $mysqli->real_escape_string($_POST["id"]);

mobInfo($mob_id, 1);
?>