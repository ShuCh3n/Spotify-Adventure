<?php
$hero_name = $mysqli->real_escape_string($_POST["name"]);

if(checkHeroName($hero_name) == 0){
    echo 0;
}else{
    echo 1;
}
?>