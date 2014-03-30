<?php
function getUserInfo($spotify_user){
    global $mysqli;

    $user_query = $mysqli->query("SELECT * FROM prj3_spotify_users WHERE spotify_user = '" . $spotify_user . "' LIMIT 1");
    $user_row = $user_query->fetch_object();

    $user_id = $user_row->id;
    $spotify_user = $user_row->spotify_user;
    $date_joined = $user_row->date_joined;

    return array($user_id, $spotify_user, $date_joined);
}

function getExistPlayer($spotify_user){
    global $mysqli;

    $check_exist_user_query = $mysqli->query("SELECT * FROM prj3_spotify_users WHERE spotify_user = '" . $spotify_user . "'");
    $count_exist_user = $check_exist_user_query->num_rows;

    return $count_exist_user;
}

function createNewUser($spotify_user){
    global $mysqli;

    $mysqli->query("INSERT INTO `prj3_spotify_users` VALUES (NULL, '" . $spotify_user . "',CURRENT_TIMESTAMP)");
}

function createNewHero($gender, $spotify_user, $hero_name){
    global $mysqli;

    $count_exist_user = getExistPlayer($spotify_user);

    if($count_exist_user == 0){
        createNewUser($spotify_user);
    }

    list($user_id, $spotify_user, $date_joined) = getUserInfo($spotify_user);

    switch ($gender) {
        case "male":
            $gender = 1;
            break;
        case "female":
            $gender = 0;
            break;
    }

    $mysqli->query("INSERT INTO `prj3_heroes` VALUES (NULL , '" . $user_id . "', '" . $hero_name ."', '" . $gender . "', '0', '0', '0', CURRENT_TIMESTAMP)");
}

function checkHeroName($hero_name){
    global $mysqli;

    $check_hero_name_query = $mysqli->query("SELECT * FROM prj3_heroes WHERE name = '" . $hero_name . "'");
    $count_hero_name = $check_hero_name_query->num_rows;

    return $count_hero_name;
}

function getSingleHeroInfo($hero_id, $spotify_user, $json){
    global $mysqli;

    if($hero_id == 0){
        $hero_info_query = $mysqli->query("SELECT * FROM prj3_spotify_users LEFT JOIN prj3_heroes ON prj3_spotify_users.id=prj3_heroes.user_id WHERE prj3_spotify_users.spotify_user ='" . $spotify_user . "' ORDER BY `prj3_heroes`.`last_played` DESC LIMIT 1");
    }else{
        $hero_info_query = $mysqli->query("SELECT * FROM `prj3_heroes` WHERE id ='" . $hero_id . "'");
    }

    $hero_info_row = $hero_info_query->fetch_object();

    if($json == 1){
        echo  '[{
                "id":"' . $hero_info_row->id . '" ,
                "name":"' . $hero_info_row->name . '" ,
                "gender":"' . $hero_info_row->gender . '" ,
                "level":"' . $hero_info_row->level . '" ,
                "exp":"' . $hero_info_row->exp . '" ,
                "gold":"' . $hero_info_row->gold . '"
               }]';
    }else{
        return array($hero_info_row->id, $hero_info_row->name, $hero_info_row->gender, $hero_info_row->level, $hero_info_row->exp, $hero_info_row->gold);
    }
}

function getAllHeroInfo($spotify_user){
    global $mysqli;

    $hero_info_query = $mysqli->query("SELECT * FROM prj3_spotify_users LEFT JOIN prj3_heroes ON prj3_spotify_users.id=prj3_heroes.user_id WHERE prj3_spotify_users.spotify_user ='" . $spotify_user . "' ORDER BY `prj3_heroes`.`last_played`");
    $hero_count = $hero_info_query->num_rows;

    $i = 0;
    echo  '[';
    while($hero_info_row = $hero_info_query->fetch_object()){
        $i++;

        echo '{
                "id":"' . $hero_info_row->id . '" ,
                "name":"' . $hero_info_row->name . '" ,
                "gender":"' . $hero_info_row->gender . '" ,
                "level":"' . $hero_info_row->level . '" ,
                "exp":"' . $hero_info_row->exp . '"';
        if($i != $hero_count){
            echo '},';
        }else{
            echo '}';
        }
    }
    echo ']';
}

function switchHero($hero_id){
    global $mysqli;
    $mysqli->query("UPDATE `prj3_heroes` SET `last_played` = CURRENT_TIMESTAMP WHERE `id` ='" . $hero_id . "';");
}

function calcLevelExp($level){
    $total_exp = 0;

    for($i=1;$i<=$level;$i++){
        $square = pow(1.2, $i); // 1
        $total_exp = $total_exp + 100 * $square;
    }

    return round($total_exp, 0);
}

function addExp($hero_id){
    global $mysqli;
    list($id, $name, $gender, $level, $exp, $gold) = getSingleHeroInfo($hero_id, 0, 0);
    $addexp = $exp + 1;

    $mysqli->query("UPDATE `prj3_heroes` SET `exp` = '" . $addexp . "' WHERE `id` ='" . $hero_id . "'");
}

function checkLevel($hero_id, $next_level){
    global $mysqli;
    list($id, $name, $gender, $level, $exp, $gold) = getSingleHeroInfo($hero_id, 0, 0);
    $next_level_exp = calcLevelExp($next_level);

    if($exp >= $next_level_exp){
        $level = $level + 1;
        $mysqli->query("UPDATE `prj3_heroes` SET `level` = '" . $level . "' WHERE `id` ='" . $hero_id . "'");
        echo 1;
    }

}

function getQuests($hero_id){
	global $mysqli;
	list($hero_id, $hero_name, $hero_gender, $hero_level, $hero_exp, $hero_gold) = getSingleHeroInfo($hero_id, 0, 0);
	$query = $mysqli->query("SELECT * FROM prj3_quests INNER JOIN prj3_heroes_quest ON prj3_quests.id!=prj3_heroes_quest.quest_id AND prj3_quests.level_req <= '" . $hero_level . "'");
	$count_query = $query->num_rows;
	
	if($count_query == 0){
		echo 0;
	}else{
		$i = 0;
	    echo  '[';
	    while($query_row = $query->fetch_object()){
	        $i++;
	
	        echo '{
	                "id":"' . $query_row->id . '" ,
	                "level_req":"' . $query_row->level_req . '" ,
	                "title":"' . $query_row->title . '" ,
	                "level":"' . $query_row->description . '"';
	        if($i != $count_query){
	            echo '},';
	        }else{
	            echo '}';
	        }
	    }
	    echo ']';	
	}
}
?>