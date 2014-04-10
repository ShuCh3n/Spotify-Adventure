function getUserInfo(callback){
    require(['$api/models'], function(models) {
        var user = models.User.fromURI('spotify:user:@');
        user.load('name').done(function(user) {
            var user_name = user.name.decodeForText();
            callback(user_name);
        });
    });
}

function getCurrentPlayerInfo(callback){
    require(['$api/models'], function(models) {

        models.player.load('playing', 'position', 'track').done(function(player) {
            var playing = player.playing;
            var position = player.position;
            var track = player.track;

            callback(playing, position, track);
        });
    });
}

function getTrackInfo(trackuri){
    require(['$api/models'], function(models) {
        models.Track.fromURI(trackuri).load('artists').done(function(track) {
            artist = track.artists;
        });
    });
}

function getArtistInfo(artisturi){
    require(['$api/models'], function(models) {
        models.Artist.fromURI(artisturi).load('genres').done(function(artist) {
        });
    });
}

function checkHeroName(hero_name){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        data: {
            page: "checkheroname",
            name: hero_name
        },
        cache: false,
        success: function(msg){
            if(msg == 0){
                $(".nameCheckResults").html("<font color='#95c600'>Available</font>");
            }else{
                $(".nameCheckResults").html("<font color='#c60000'>Not available</font>");
            }
            returnval = msg;
        }
    });

    return returnval;
}

function getSingleHeroInfo(hero_id, user_name){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "singleheroinfo",
            heroid: hero_id,
            spotify_user: user_name
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function getAllHeroInfo(user_name){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "allheroinfo",
            spotify_user: user_name
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function getCurrentHeroInfo(){
	//Get Hero Information
    spotifyUSR = $.session.get("spotifyUSR");

    heroInfo = getSingleHeroInfo(0, spotifyUSR);
    var obj = $.parseJSON(heroInfo);

    $.each(obj, function() {
        hero_id = this['id'];
        hero_name = this['name'];
        hero_gender = this['gender'];
        hero_level = this['level'];
        full_hero_health = this['health'];
        hero_exp = this['exp'];
        hero_gold = this['gold'];
    });

    next_level = parseInt(hero_level) + 1;

    next_level_exp = nextLevelExp(next_level);	
}

function checkExistPlayer(user_name){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "existplayer",
            spotify_user: user_name
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function switchCharacter(heroID){
    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "swtichhero",
            hero_id: heroID
        },
        cache: false
    });
}

function nextLevelExp(level){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "calclevelexp",
            level: level
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function addExp(hero_id, next_level){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "addexp",
            heroid: hero_id,
            nextlevel: next_level
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function getQuestList(hero_id){
	var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "getquests",
            heroid: hero_id
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function getAcceptedQuestList(hero_id){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "getacceptedquests",
            heroid: hero_id
        },
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function displayQuestButton(hero_id){
	var quests = getQuestList(hero_id);
	
	if(quests != 0){
		$("#questlist_button").html("<a href='#' id='getQuest'>!</a>");
	}
	
}

function acceptedQuestScripts(quests){
    var obj = $.parseJSON(quests);

    $.each(obj, function() {

        eval("quest_id_" + this['id'] + " = " + this['id']);

        if(this['finished'] == 0){
            $.getScript("scripts/quests/" + this['id'] + ".js");
        }
    });
}

function displayAcceptedQuestButton(hero_id){
    var quests = getAcceptedQuestList(hero_id);

    if(quests != 0){
        $("#accepted_quest_button").html("<a href='#' id='acceptedQuest'>?</a>");
        acceptedQuestScripts(quests)
    }

}

function questAction(hero_id, quest_id, typeaction){
    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "questaction",
            heroid: hero_id,
            questid: quest_id,
            type: typeaction
        },
        cache: false
    });
}

function finishQuest(hero_id, quest_id){
    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "finishquest",
            heroid: hero_id,
            questid: quest_id
        },
        cache: false
    });
}

function completeQuest(hero_id, quest_id){
    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        //dataType: "json",
        data: {
            page: "completequest",
            heroid: hero_id,
            questid: quest_id
        },
        cache: false
    });
}

/*From here we start to using the new JSON function*/
function requestJSON(data){
    var returnval;

    $.ajax({
        type: "POST",
        async: false,
        url: "http://stud.cmi.hro.nl/0876292/jaar1/proj3/index.php",
        data: data,
        cache: false,
        success: function(msg){
            returnval = msg;
        }
    });

    return returnval;
}

function searchMob(search_string){
    var data = {'page':'searchmob','search':search_string};

    var returnval = requestJSON(data);

    return returnval;
}

function getMobInfo(mob_id){
    var data = {'page':'mobinfo','id':mob_id};

    var returnval = requestJSON(data);

    return returnval;
}

function getHeroInventory(heroID){
    var data = {'page':'heroinventory','heroid':heroID};

    var returnval = requestJSON(data);

    return returnval;
}

function randomNumber(min, max){
    var randomnum =  Math.round(Math.random() * (max - min) + min);

    return randomnum;
}

function defeatedMob(mob_id, hero_id){
    var data = {'page':'defeatedmob','mob_id':mob_id, 'hero_id':hero_id};
    requestJSON(data);
}

function loadPage(type){
    if(type == "home"){
        var page = "pages/home_character.html";
    }

    if(type == "switch_character"){
        var page = "pages/switch_character.html";
    }

    if(type == "create_new_character"){
        var page = "pages/create_character.html";
    }

    $("body").load(page);
}