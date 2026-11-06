jQuery(document).ready(function($){
    var mediaUploader;
    $('.upload_category_icon_button').click(function(e){
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'انتخاب آیکن دسته',
            button: { text: 'انتخاب' },
            multiple: false
        });

        mediaUploader.on('select', function(){
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category_icon').val(attachment.url);
        });

        mediaUploader.open();
    });
});
