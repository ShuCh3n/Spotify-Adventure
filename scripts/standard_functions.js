$(function(){
    getCurrentHeroInfo();

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