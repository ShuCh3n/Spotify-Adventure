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

    $mysqli->query("INSERT INTO `prj3_heroes` VALUES (NULL , '" . $user_id . "', '" . $hero_name ."', '" . $gender . "', '0', '80', '0', '0', CURRENT_TIMESTAMP)");
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
                "health":"' . $hero_info_row->health . '" ,
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
function questInfo($quest_id){
    global $mysqli;
    $query = $mysqli->query("SELECT * FROM `prj3_quests` WHERE id = '" . $quest_id . "'");
    $query_row = $query->fetch_object();

    $id = $query_row->id;
    $level_req = $query_row->level_req;
    $title = $query_row->title;
    $description = $query_row->description;
    $reward_type = $query_row->reward_type;
    $amount = $query_row->amount;

    return array($id, $level_req, $title, $description, $reward_type, $amount);
}

function getAcceptedQuests($hero_id){
    global $mysqli;

    $query = $mysqli->query("SELECT * FROM `prj3_heroes_quest` WHERE hero_id = '" . $hero_id . "' AND completed = '0'");
    $count_query = $query->num_rows;

    if($count_query == 0){
        echo 0;
    }else{
        $i = 0;
        echo  '[';
        while($query_row = $query->fetch_object()){
            $i++;

            list($quest_id, $level_req, $title, $description, $reward_type, $amount) = questInfo($query_row->quest_id);
            echo '{
	                "id":"' . $quest_id . '" ,
	                "level_req":"' . $level_req . '" ,
	                "title":"' . addslashes($title) . '" ,
	                "description":"' . addslashes($description) . '",
                    "reward_type":"' . $reward_type . '",
                    "amount":"' . $amount . '",
                    "finished":"' . $query_row->finished . '"';

            if($i != $count_query){
                echo '},';
            }else{
                echo '}';
            }
        }
        echo ']';
    }
}

function getQuests($hero_id){
	global $mysqli;
	list($hero_id, $hero_name, $hero_gender, $hero_level, $hero_exp, $hero_gold) = getSingleHeroInfo($hero_id, 0, 0);

    $accepted_quest_query = $mysqli->query("SELECT * FROM `prj3_heroes_quest` WHERE hero_id = '" . $hero_id . "'");
    $count_accepted_quest = $accepted_quest_query->num_rows;

    if($count_accepted_quest != 0){
        while($accepted_quest_row = $accepted_quest_query->fetch_object()){
            $quest_id[] = $accepted_quest_row->quest_id;
        }
        $query = $mysqli->query("SELECT * FROM `prj3_quests` WHERE id NOT IN (" . implode(",", $quest_id). ") AND level_req <= '" . $hero_level . "'");
        $count_query = $query->num_rows;
    }else{
        $query = $mysqli->query("SELECT * FROM `prj3_quests` WHERE level_req <= '" . $hero_level . "'");
        $count_query = $query->num_rows;
    }

	if($count_query == 0){
		echo 0;
	}else{
		$i = 0;
	    echo  '[';
	    while($query_row = $query->fetch_object()){
            $i++;

            list($quest_id, $level_req, $title, $description, $reward_type, $amount) = questInfo($query_row->id);

	        echo '{
	                "id":"' . $quest_id . '" ,
	                "level_req":"' . $level_req . '" ,
	                "title":"' . addslashes($title) . '" ,
	                "description":"' . addslashes($description) . '",
                    "reward_type":"' . $reward_type . '",
                    "amount":"' . $amount . '"';
	        if($i != $count_query){
	            echo '},';
	        }else{
	            echo '}';
	        }
	    }
	    echo ']';
	}
}

function questAction($hero_id, $quest_id, $type){
    global $mysqli;

    if($type == 1){
        $mysqli->query("INSERT INTO `prj3_heroes_quest` VALUES ('" . $hero_id . "', '" . $quest_id . "', '0', '0', CURRENT_TIMESTAMP)");
    }

    if($type == 0){
        $mysqli->query("DELETE FROM prj3_heroes_quest WHERE hero_id = '" . $hero_id . "' AND quest_id = '" . $quest_id . "'");
    }
}

function finishQuests($hero_id, $quest_id){
    global $mysqli;

    $mysqli->query("UPDATE `prj3_heroes_quest` SET `finished` = '1' WHERE `hero_id` = '" . $hero_id . "' AND `quest_id` = '" . $quest_id . "'");
}

function completeQuests($hero_id, $quest_id){
    global $mysqli;
    list($questid, $level_req, $title, $description, $reward_type, $amount) = questInfo($quest_id);

    $mysqli->query("UPDATE `prj3_heroes_quest` SET `completed` = '1' WHERE `hero_id` = '" . $hero_id . "' AND `quest_id` = '" . $quest_id . "'");

    if($reward_type == 1 || $reward_type == 2){
        list($hero_id, $hero_name, $hero_gender, $hero_level, $hero_exp, $hero_gold) = getSingleHeroInfo($hero_id, 0, 0);
    }

    if($reward_type == 2){
        echo $new_hero_gold = $hero_gold + $amount;

        $mysqli->query("UPDATE `prj3_heroes` SET `gold` = '" . $new_hero_gold . "' WHERE `id` = '" . $hero_id . "'");
    }

}

function mobInfo($mob_id, $json){
    global $mysqli;
    $query = $mysqli->query("SELECT * FROM `prj3_mobs` WHERE `id` = '" . $mob_id . "' LIMIT 1");
    $row = $query->fetch_object();

    if($json == 0){
        return array($row->id, $row->mob_name, $row->mob_level, $row->mob_description, $row->health, $row->experience, $row->gold, $row->boss, $row->elite, $row->loot);
    }else{
        echo '[{
	                "id":"' . $row->id . '" ,
	                "mob_name":"' . addslashes($row->mob_name) . '" ,
	                "mob_level":"' . $row->mob_level . '" ,
	                "mob_description":"' . addslashes($row->mob_description) . '",
	                "health":"' . $row->health . '",
	                "experience":"' . $row->experience . '",
	                "gold":"' . $row->gold . '",
                    "boss_type":"' . $row->boss . '",
                    "elite_type":"' . $row->elite . '",
                    "loot":"' .$row->loot .'"}]';
    }

}

function checkMobName($mob_name){
    global $mysqli;
    $query = $mysqli->query("SELECT * FROM `prj3_mobs` WHERE `mob_name` LIKE '%" . $mob_name . "%'");
    $query_count = $query->num_rows;

    $i = 0;

    if($query_count > 0){
        echo  '[';

        while($row = $query->fetch_object()){
            list($mob_id, $mob_name, $mob_level, $mob_description, $mob_health, $mob_experience, $mob_gold, $boss_type, $elite_type, $loot) = mobInfo($row->id, 0);

            $i++;

            echo '{
	                "id":"' . $mob_id . '" ,
	                "mob_name":"' . addslashes($mob_name) . '" ,
	                "mob_level":"' . $mob_level . '" ,
	                "mob_description":"' . addslashes($mob_description) . '",
	                "health":"' . $mob_health . '",
	                "experience":"' . $mob_experience . '",
	                "gold":"' . $mob_gold . '",
                    "boss_type":"' . $boss_type . '",
                    "elite_type":"' . $elite_type . '",
                    "loot":"' .$loot .'"';
            if($i != $query_count){
                echo '},';
            }else{
                echo '}';
            }

        }

        echo ']';
    }else{
        echo "0";
    }
}

function defeatedMob($mob_id, $hero_id){
    global $mysqli;

    list($mob_id, $mob_name, $mob_level, $mob_description, $mob_health, $mob_experience, $mob_gold, $boss_type, $elite_type, $loot) = mobInfo($mob_id, 0);
    list($hero_id, $hero_name, $hero_gender, $hero_level, $hero_exp, $hero_gold) = getSingleHeroInfo($hero_id, 0, 0);

    $new_gold = $hero_gold + $mob_gold;
    $new_exp = $hero_exp + $mob_experience;

    $mysqli->query("UPDATE `prj3_heroes` SET `exp` = '" . $new_exp . "', `gold` = '" . $new_gold . "' WHERE `id` ='" . $hero_id . "';");
}
?>