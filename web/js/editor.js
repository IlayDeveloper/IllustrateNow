(function(){
    var content = $("#postform-content");
    var preview = $("#editor-preview");
    var icons = $(".editor-icons");

    /*Запуск редактора*/
    if ($("#codeEditor")[0]){
        var editor = ace.edit("codeEditor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/html");
        editor.setOption("maxLines", 25);
        editor.setValue(content.val());
        editor.commands.addCommand({
            name: 'ExitFullMode',
            bindKey: {win: 'Esc',  mac: 'Command-M'},
            exec: function(editor) {
                var edit =  $("#codeEditor");
                edit.detach();
                edit.insertAfter($(".field-postform-content"));
                edit.removeClass("codeEditor-full");
                edit.addClass("codeEditor");
                edit.css({
                    'position' : 'relative',
                    'font-size' : '16px',
                });
                editor.setOption("maxLines", 25);
                editor.resize();
            },
            readOnly: true // false if this command should not apply in readOnly mode
        });

        document.getElementById('codeEditor').style.fontSize='12px';
        editor.session.on('change', function(delta) {
            content.val (editor.getValue());
            previewUpdate ();
        });
        $("#btn-toggle").click(function(){
            var edit =  $("#codeEditor");
            edit.detach();
            edit.prependTo("body");
            edit.removeClass("codeEditor");
            edit.addClass("codeEditor-full");
            edit.css({
                'position' : 'absolute',
                'font-size' : '16px',
            });
            editor.setOption("maxLines", 500);
            editor.resize();
        });
    }


    /* * * * */

    /*Список тэгов для форматирования текста*/
    var tag_description = '<div class="post-description "> <div class="fat-border"> Пример пример</div> </div>';
    var tag_under_picture = '<div class="post-under-picture text-center">Пример пример</div>';
    var tag_underline = '<span class="post-underline"> Пример пример </span>';
    var tag_warning = ' <div class="post-warning">Пример пример </div>';
    var tag_title = ' <div class="post-title">Пример пример </div>';
    var tag_desc_picture = ' <div class="post-desc-picture">Пример пример </div>';
    var tag_text_tag = ' <span class="post-text-tag">Пример пример </span>';
    var tag_table = '<div class="post-table"> <div class="row"> <div class="col-md-7 text-center"> <div class="row post-table-title"></div> </div> <div class="col-md-1"></div> <div class="col-md-4 text-center"> <div class="row post-table-title"></div> </div> </div> <div class="row"> <div class="col-md-7"> <div class="row post-table-usual">Пример строки</div> </div> <div class="col-md-1"></div> <div class="col-md-4"> <div class="row post-table-usual">Пример строки</div> </div> </div> </div>';
    var tag_note_with_pick = '<div class="row"> <div class="col-md-1 text-center"><img id="icon-warning" class="post-icons" src="/assets/pictures/interface/icons/warning.png" alt=""></div> <div class="text-left col-md-11 post-text-indent">Инструмент «Перо» - Pen Tool<br>Инструмент «Перо+»  - Add Anchor Point Tool<br> </div> </div>';
    /* * * * */

    content.change(function () {
        previewUpdate ();
    })

    icons.click(function (e) {
        var icon = $.clone(e.target);
        icon.classList = 'post-icons';
        contentAdd(icon.outerHTML);
        previewUpdate();
    });

    $("#desc").click(function(){contentAdd(tag_description);});
    $("#und-picture").click(function(){contentAdd(tag_under_picture);});
    $("#underline").click(function(){contentAdd(tag_underline);});
    $("#warning").click(function(){contentAdd(tag_warning);});
    $("#title").click(function(){contentAdd(tag_title);});
    $("#desc-picture").click(function(){contentAdd(tag_desc_picture);});
    $("#text-tag").click(function(){contentAdd(tag_text_tag);});
    $("#table").click(function(){contentAdd(tag_table);});
    $("#note").click(function(){contentAdd(tag_note_with_pick);});
    
    
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
        editor.insert(value);
    }

/*Обработка загрузки изображений*/

    var pictures = $(".form-pictures");
    var btnDel = $("#pictures-btn-del");
    var btnAdd = $("#pictures-btn-add");
    var currentFocusImg;

    $("#postform-pictures").change(function () {
        var $input = $("#postform-pictures");
        var id = $("#post-id").val();
        var fd = new FormData;

        fd.append('pictures', $input.prop('files')[0]);
        fd.append('id', id);
        $.ajax({
            url: 'uploadpictures',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                updatePictures(data);
            }
        });
    });

    pictures.click(function (e) {
        resetFocus();
        var target = e.target;
        if (target.localName == 'img'){
            target.classList = 'post-pictures-focus';
            showButtons();
            currentFocusImg = target;
        } else{
            hideButtons();
        }
    });

    btnAdd.click(function () {
        var img = $.clone(currentFocusImg);
        img.classList = 'post-pictures-in-post img-responsive';
        contentAdd(img.outerHTML);
        previewUpdate();
    });

    btnDel.click(function () {
        $.ajax({
            url: 'deletepictures',
            data: 'id=' + currentFocusImg.getAttribute('id'),
            type: 'POST',
            success: function () {
                currentFocusImg.remove();
            }
        });
    });

    function updatePictures(data) {
        var img;
        pictures.html('');
        for (var pic in data){
            img = '<img id=' + data[pic].id + ' class="post-pictures" src=' + data[pic].link + '>';
            pictures.prepend(img);
        }
    }

    function resetFocus(){
        var children = pictures.children("img");
        for(var img in children){
            if(typeof (children[img]) == 'object' && children[img].localName == 'img'){
                if (children[img].classList.value == 'post-pictures-focus'){
                    children[img].classList = 'post-pictures';
                }
            }
        }
    }

    function showButtons() {
        btnAdd.removeClass('hidden');
        btnDel.removeClass('hidden');
    }

    function hideButtons() {
        btnAdd.addClass('hidden');
        btnDel.addClass('hidden');
    }


})();


(function(){

    /*Обработка загрузки Тэгов*/
    var tags = $('.form-tags');
    var buttonTagAdd = $("#tag-btn-add");
    var buttonTagDel = $("#tag-btn-del");
    var currentFocusSpan;
    var currentFocusPickedSpan;
    var pickedTags = $(".form-post-tags");

    var postId = $("#post-id").val();

    tags.click(function (e) {
        resetFocus();
        var target = e.target;
        if (target.localName == 'span'){
            buttonTagAdd.removeClass('hidden');
            target.classList = 'post-tag-focus';
            currentFocusSpan = target;
        } else{
            buttonTagAdd.addClass('hidden');
        }
    });

    pickedTags.click(function (e) {
        resetFocusPicked();
        var target = e.target;
        if (target.localName == 'span'){
            buttonTagDel.removeClass('hidden');
            target.classList = 'post-tag-picked-focus';
            currentFocusPickedSpan = target;
        } else{
            buttonTagDel.addClass('hidden');
        }
    });


    buttonTagDel.click(function () {
        $.ajax({
            url: 'deltag',
            data: 'post_id=' + postId + '&tag_id=' + currentFocusPickedSpan.getAttribute('id'),
            type: 'POST',
            success: function (data) {
                if(data == 1){
                    currentFocusPickedSpan.remove();
                } else {
                    alert("Ошибка удаления");
                }
            }
        });
    });

    buttonTagAdd.click(function () {
        $.ajax({
            url: 'addtag',
            data: 'post_id=' + postId + '&tag_id=' + currentFocusSpan.getAttribute('id'),
            type: 'POST',
            success: function (data) {
                if (data == 1){
                    var newSpan = $.clone(currentFocusSpan);
                    newSpan.classList = 'post-tag';
                    pickedTags.prepend(newSpan);
                } else{
                    alert("Ошибка добавления тэга");
                }
            }
        });
    });

    function resetFocus(){
        var children = tags.children("span");
        for(var span in children){
            if(typeof (children[span]) == 'object' && children[span].localName == 'span'){
                if (children[span].classList.value == 'post-tag-focus'){
                    children[span].classList = 'post-tag';
                }
            }
        }
    }

    function resetFocusPicked(){
        var children = pickedTags.children("span");
        for(var span in children){
            if(typeof (children[span]) == 'object' && children[span].localName == 'span'){
                if (children[span].classList.value == 'post-tag-picked-focus'){
                    children[span].classList = 'post-tag';
                }
            }
        }
    }
})();