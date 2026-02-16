jQuery(document).ready(function ($) {

    let file_frame;

    $('.bm-upload-pdf').on('click', function (e) {
        e.preventDefault();

        const button = $(this);
        const inputField = button.prev('input');

        // If the media frame exists, reopen it
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame
        file_frame = wp.media({
            title: 'Select Book PDF',
            button: {
                text: 'Use this PDF'
            },
            library: {
                type: 'application/pdf'
            },
            multiple: false
        });

        // When a file is selected
        file_frame.on('select', function () {
            let attachment = file_frame.state().get('selection').first().toJSON();
            inputField.val(attachment.url);
        });

        // Open the uploader
        file_frame.open();
    });


        // var table = $('#bm_chapters_table tbody');
        // var index = <?php echo count($chapters); ?>;

    var table = $('#bm_chapters_table tbody');

    // start index by counting existing rows
    var index = table.find('tr').length;

    function renumberRows() {
        console.log("renumberrows line_49");
        table.find('tr').each(function(i){
            console.log("find line_50");
            // Set visible index number
            $(this).find('.chapter-index').text(i + 1);

            // Update input name indexes
            $(this).find('input, textarea').each(function(){
                var name = $(this).attr('name');

                // Replace previous index with new one
                var newName = name.replace(/\[\d+\]/, '[' + i + ']');
                $(this).attr('name', newName);
            });
        });
    }

        $('#bm_add_chapter').on('click', function(e){
            e.preventDefault();
            var row = '<tr>' +
                '<td  class="chapter-index"  style="border:1px solid #ccc;padding:5px;text-align: center;font-weight: 700;"> </td>' +
                '<td style="border:1px solid #ccc; padding:5px;"><input type="text" name="bm_chapters['+index+'][name]" value="" style="width:100%;" /></td>' +
                '<td style="border:1px solid #ccc; padding:5px;"><textarea name="bm_chapters['+index+'][description]" rows="4" style="width:100%;"></textarea></td>' +
                '<td style="border:1px solid #ccc;padding:5px;text-align: center;"><button class="button bm_remove_chapter">Remove</button></td>' +
                '</tr>';
            table.append(row);
            renumberRows();
        });

    $(document).on('click', '.bm_remove_chapter', function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
        renumberRows();
    });
    renumberRows();
    
});
