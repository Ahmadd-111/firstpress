jQuery(document).ready(function ($) {
    // Load Books
    $('#load-books').on('click', function () {
        $.ajax({
            url: ajaxCPT.ajax_url,
            type: 'POST',
            data: { action: 'fetch_books' },
            success: function (response) {
                $('#books-container').html(response);
            }
        });
    });

    // View Book
    $(document).on('click', '.view-book', function() {
        var bookSlug = $(this).data('slug'); // Get the correct slug
        if (bookSlug) {
            window.location.href = '/firstpress/index.php/book/' + bookSlug + '/';
        } else {
            alert('Error: Book slug is missing.');
        }
    });
});

// $(document).on('click', '#edit-book', function () {
//     let bookId = $(this).data('id');
//     let newTitle = prompt("Enter New Title:");
//     let newContent = prompt("Enter New Content:");

//     $.ajax({
//         url: ajaxCPT.ajax_url,
//         type: 'POST',
//         data: {
//             action: 'update_book',
//             id: bookId,
//             title: newTitle,
//             content: newContent
//         },
//         success: function (response) {
//             alert(response);
//             location.reload();
//         }
//     });
// });

jQuery(document).ready(function($) {
    // Redirect to book listing
    $('#back-to-list').on('click', function() {
        window.location.href = '/firstpress/index.php/books-listing/';
    });

    // Show edit form
    $('#edit-book').on('click', function() {
        $('#edit-form').show();
    });

    // Save updated book
    $('#save-edit').on('click', function() {
        var bookId = $(this).data('id');
        var newTitle = $('#edit-title').val();
        var newContent = $('#edit-content').val();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'update_book',
                id: bookId,
                title: newTitle,
                content: newContent,
            },
            success: function(response) {
                alert(response);
                location.reload(); // Refresh to show updated data
            }
        });
    });
});
