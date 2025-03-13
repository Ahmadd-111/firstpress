jQuery(document).ready(function ($) {
    // Load Books
    $("#load-books").click(function () {
        $.ajax({
            type: "POST",
            url: ajaxCPT.ajax_url,
            data: {
                action: "ajax_cpt_loader_fetch_books",
                security: ajaxCPT.nonce,
            },
            success: function (response) {
                $("#book-list").html(response);
            },
        });
    });

    // Edit Book Title
    $(document).on("click", ".edit-book", function () {
        let bookId = $(this).closest(".book-item").data("id");
        let newTitle = prompt("Enter new title:");
        if (newTitle) {
            $.ajax({
                type: "POST",
                url: ajaxCPT.ajax_url,
                data: {
                    action: "ajax_cpt_loader_update_book",
                    security: ajaxCPT.nonce,
                    book_id: bookId,
                    new_title: newTitle,
                },
                success: function (response) {
                    alert(response);
                    $("#load-books").click(); // Reload books
                },
            });
        }
    });
});
