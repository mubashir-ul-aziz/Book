console.log("book filter js file");
jQuery(function ($) {

    $("#book-filter-form").on("submit", function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: bm_ajax_obj.ajax_url,
            data: {
                action: "filter_books",
                ...Object.fromEntries(new URLSearchParams(formData))
            },
            success: function (response) {
                $(".bk_manager-archive-wrapper").html(response);
            }
        });

    });

});



