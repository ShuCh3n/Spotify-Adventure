$(function(){
    //Get Hero Information
    var spotifyUSR = $.session.get("spotifyUSR");

    var heroInfo = getSingleHeroInfo(0, spotifyUSR);
    var obj = $.parseJSON(heroInfo);

    $.each(obj, function() {
        hero_id = this['id'];
        name = this['name'];
        gender = this['gender'];
        level = this['level'];
        full_hero_health = this['health'];
        exp = this['exp'];
        gold = this['gold'];
    });

    var next_level = parseInt(level) + 1;

    var next_level_exp = nextLevelExp(next_level);

    $("#hero_name").html(name);
    $("#hero_level").html(level);
    $("#hero_exp").html(exp + "/" + next_level_exp);
    $("#hero_gold").html(gold);
    $("#hero_health").html(full_hero_health);


    //Experience Interval
    setInterval(function() {
        getCurrentPlayerInfo(function(playing, position, trackuri) {
            if(playing == true){
                getTrackInfo(trackuri);
                getArtistInfo(artist);

                var returnExp = addExp(hero_id, next_level);

                var heroInfo = getSingleHeroInfo(0, spotifyUSR);
                var obj = $.parseJSON(heroInfo);

                var exp;

                $.each(obj, function() {
                    exp = this['exp'];
                });

                $("#hero_exp").html(exp + "/" + next_level_exp);

                if(returnExp == 1){
                    level = parseInt(level) + 1;
                    next_level = parseInt(level) + 1;
                    next_level_exp = nextLevelExp(next_level);
                    $("#hero_level").html(level);
                }
            }
        });
    }, 5000);
});