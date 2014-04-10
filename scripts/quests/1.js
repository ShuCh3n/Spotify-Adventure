var finished_1 = 0;

setInterval(function() {
    if(finished_1 == 0){
        var spotifyUSR = $.session.get("spotifyUSR");
        var heroInfo = getSingleHeroInfo(0, spotifyUSR);
        var obj = $.parseJSON(heroInfo);

        $.each(obj, function() {
            hero_id = this['id'];
            level = this['level'];
        });

        if(level >= '1'){
            finishQuest(hero_id, quest_id_1);
            finished_1 = 1;
        }
    }

}, 5000);