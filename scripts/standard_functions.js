$(function(){
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
                    hero_level = parseInt(hero_level) + 1;
                    next_level = parseInt(hero_level) + 1;
                    next_level_exp = nextLevelExp(next_level);
                    $("#hero_level").html(hero_level);
                }
            }
        });
    }, 5000);
});