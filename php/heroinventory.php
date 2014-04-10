<?php
$hero_id = $mysqli->real_escape_string($_POST["heroid"]);

heroInventory($hero_id);
?>