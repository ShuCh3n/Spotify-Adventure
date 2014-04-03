$(function(){
    //Switch Pages
    $( "#homeCharacter"  ).click(function() {
        $("body").load("pages/home_character.html");
    });

    $("#switchCharacter").click(function(){
        $("body").load("pages/switch_character.html");
    });

    $("#createNewCharacter").click(function(){
        $("body").load("pages/create_character.html");
    });
});
