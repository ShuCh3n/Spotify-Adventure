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

        models.player.load('playing', 'position').done(function(player) {
            var playing = player.playing;
            var position = player.position;

            callback(playing, position);
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


function getArtist(callback){
    require(['$api/models'], function(models) {

        models.player.load('track').done(function(player) {
            var artist = player.track.artists[0].uri;
            // console.log(artist);
            models.Artist.fromURI(artist).load('genres').done(function(artist) {

            console.log(artist.uri + ': ' + artist.genres);
            });
            //callback(track);
        });
            
    });
}

getArtist();




