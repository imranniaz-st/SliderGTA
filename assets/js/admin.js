(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Media uploader for adding images
        var mediaUploader;
        
        $('#add-slider-images').on('click', function(e) {
            e.preventDefault();
            
            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Select Images for Slider',
                button: {
                    text: 'Add to Slider'
                },
                multiple: true
            });
            
            // When files are selected
            mediaUploader.on('select', function() {
                var attachments = mediaUploader.state().get('selection').toJSON();
                var container = $('#slider-images-container');
                
                $.each(attachments, function(index, attachment) {
                    var imageHtml = '<div class="slider-image-item" data-id="' + attachment.id + '">' +
                        '<img src="' + attachment.sizes.thumbnail.url + '" />' +
                        '<span class="remove-image" title="Remove">&times;</span>' +
                        '<input type="hidden" name="slider_gta_images[]" value="' + attachment.id + '" />' +
                        '</div>';
                    container.append(imageHtml);
                });
            });
            
            // Open the uploader dialog
            mediaUploader.open();
        });
        
        // Remove image
        $(document).on('click', '.remove-image', function() {
            if (confirm('Are you sure you want to remove this image?')) {
                $(this).closest('.slider-image-item').fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
        
        // Make images sortable
        if ($.fn.sortable) {
            $('#slider-images-container').sortable({
                items: '.slider-image-item',
                cursor: 'move',
                scrollSensitivity: 40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                opacity: 0.65,
                placeholder: 'ui-sortable-placeholder',
                start: function(event, ui) {
                    ui.item.css('background-color', '#f6f6f6');
                },
                stop: function(event, ui) {
                    ui.item.removeAttr('style');
                },
                update: function(event, ui) {
                    // Images are automatically reordered in the DOM
                }
            });
        }
    });
    
})(jQuery);
