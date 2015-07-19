$(document).ready(function(){

    $('.del_img_btn').on('click', function(){
        if (confirm($(this).data('confirm')))
            sjx('adminDeleteImg', $(this).data('id'));
        else
            return false;
    });

    $('#save_btn_header').on('click', function(){
        $('#save_btn').click();
    });

    $('#preview_btn_header').on('click', function(){
        $('#save_btn').click();
    });

    $('#delete_btn_header').on('click', function(){
        if (confirm($(this).data('confirm')))
            sjx('adminDeleteCategory', $(this).data('id'));
        else
            return false;
    });

    $('#delete_undo_btn').on('click', function(){
        if (confirm($(this).data('confirm')))
            sjx('adminUndoDeleteCategory', $(this).data('id'));
        else
            return false;
    });

    $('#tags_holder').on('click', '.delete_tag_video', function(){
        if (confirm('Are you sure you want to remove this tag?')) {
            sjx('adminRemoveVideoTag', $(this).data('tag_id'), $(this).data('video_id'));
            return false;
        } else {
            return false;
        }
    });

    $('.a_active_y, .a_active_n').on('click', function(){
        if ($(this).attr('class') == 'a_active_y') {
            var yn = 'y';
        } else {
            var yn = 'n';
        }

        if (confirm($(this).data('confirm'+yn))) {
            sjx('adminArticleActivationStatus', $(this).data('id'));
            return false;
        } else {   
            return false;
        }
    });

    $('.a_delete').on('click', function(){
        if (confirm($(this).data('confirmy'))) {
            sjx('adminRowDelete', $(this).data('id'), $(this).data('table'));
            return false;
        } else {
            return false;
        }
    });

    $('.a_up, .a_down').on('click', function(){
        sjx('adminChangeOrder', $(this).data('id'), $(this).data('table'), $(this).data('tt'));
        return false;
    });
});

jQuery.fn.shake = function() {
    this.each(function(i) {
        $(this).css({ "position": "relative" });
        for (var x = 1; x <= 3; x++) {
            $(this).animate({ left: -10 }, 10).animate({ left: 0 }, 50).animate({ left: 10 }, 10).animate({ left: 0 }, 50);
        }
	});
	return this;
}