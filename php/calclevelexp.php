<?php
$level = $mysqli->real_escape_string($_POST["level"]);

echo calcLevelExp($level);
?>