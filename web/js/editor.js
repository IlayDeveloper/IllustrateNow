(function(){
    var content;

    $("#desc").click(function(){
        content = $("#postform-content");
        console.log(content);
        var tag = '<div class="post-description "> <div class="fat-border"> Пример пример</div> </div>';

        content.val (content.val() + tag);
    })

    $("#und-picture").click(function(){
        content = $("#postform-content");
        console.log(content);
        var tag = '<span class="post-under-picture">Пример пример</span>';

        content.val (content.val() + tag);
    })
})();
