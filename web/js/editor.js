(function(){
    var content = $("#postform-content");
    var preview = $("#editor-preview");
    var icons = $(".editor-icons");

    /*Список тэгов для форматирования текста*/
    var tag_description = '<div class="post-description "> <div class="fat-border"> Пример пример</div> </div>';
    var tag_under_picture = '<span class="post-under-picture">Пример пример</span>';
    /* * * * */

    content.change(function () {
        previewUpdate ();
    })

    icons.click(function (e) {
        var icon = $.clone(e.target);
        icon.classList = 'post-icons';
        contentAdd(icon.outerHTML);
        previewUpdate();
    })

    $("#desc").click(function(){
        content.val (content.val() + tag_description);
        previewUpdate ();
    })

    $("#und-picture").click(function(){
        content.val (content.val() + tag_under_picture);
        previewUpdate ();
    })
    
    
    $("#preview-btn").click(function () {
        preview.css("display", function () {
           if (preview.css("display") == "none"){
               return "block";
           } else{
               return "none";
           }
        });
    })

    function previewUpdate () {
        preview.html(content.val());
    }

    function contentAdd(value) {
        content.val (content.val() + value);
    }
})();
