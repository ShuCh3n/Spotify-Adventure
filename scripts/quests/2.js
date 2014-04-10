var finished_2 = 0;
var listentime = 0;

setInterval(function() {
    if(finished_2 == 0){
        var spotifyUSR = $.session.get("spotifyUSR");
        var heroInfo = getSingleHeroInfo(0, spotifyUSR);
        var obj = $.parseJSON(heroInfo);

        $.each(obj, function() {
            hero_id = this['id'];
        });

        getCurrentPlayerInfo(function(playing, position, trackuri) {
            if(playing == true){
                if(trackuri == "spotify:track:6JEK0CvvjDjjMUBFoXShNZ"){
                    listentime = listentime + 5;

                    if(listentime == 195){
                        finishQuest(hero_id, quest_id_2);
                        finished_2 = 1;
                    }
                }
            }
        });
    }

}, 5000);