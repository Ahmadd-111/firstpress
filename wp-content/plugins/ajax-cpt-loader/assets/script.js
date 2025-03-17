jQuery(document).ready(function ($) {
    // Load Books
    $('#load-books').on('click', function () {
        alert(ajaxCPT.ajax_url);
        $.ajax({
            url: ajaxCPT.ajax_url,
            type: 'GET',
            data: { action: 'fetch_books' },
            beforeSend: function () {
                $('#books-container').html('<p>Loading books...</p>');
            },
            success: function (response) {
                $('#books-container').html(response);
            },
            error: function () {
                alert('Failed to load books.');
            }
        });
    });

    // View Book
    $(document).on('click', '.view-book', function() {
        var bookSlug = $(this).data('slug'); 
        if (bookSlug) {
            alert(bookSlug);
            window.location.href = '/firstpress/index.php/book/' + bookSlug + '/';
        } else {
            alert('Error: Book slug is missing.');
        }
    });

    // $(document).on('click', '#edit-book', function () {
    //     var bookSlug = $(this).data('slug');
    //     if (bookSlug) {
    //         alert(bookSlug);
    //         window.location.href = '/firstpress/index.php/edit-book/?book=' + bookSlug;
    //     } else {
    //         alert('Error: Book slug is missing.');
    //     }
    // });

    $(document).on('click', '.edit-book', function () {
        var bookSlug = $(this).data('slug');
        if (bookSlug) {
            window.location.href = '/firstpress/edit-book/?book=' + bookSlug;
        } else {
            alert('Error: Book slug is missing.');
        }
    });
    
});

jQuery(document).ready(function ($) {
    $('#edit-book-form').on('submit', function (e) {
        e.preventDefault();

        var bookId = $('#book-id').val();
        var title = $('#book-title').val();
        var content = $('#book-content').val();
        var genres = $('#book-genre').val();

        $.ajax({
            url: ajaxCPT.ajax_url,
            type: 'POST',
            data: {
                action: 'update_book',
                id: bookId,
                title: title,
                content: content,
                genres: genres
            },
            beforeSend: function () {
                alert('Updating book...');
            },
            success: function (response) {
                if (response.success) {
                    showNotification(response.data.message, 'success');
                    // setTimeout(function () {
                    //     window.location.href = '/firstpress/index.php/book/' + bookId + '/';
                    // }, 1500);
                } else {
                    showNotification(response.data.message, 'error');
                }
            },
            error: function () {
                showNotification('Error updating book.', 'error');
            }
        });
    });

    // function showNotification(message, type) {
    //     Swal.fire({
    //         text: message,
    //         icon: type,
    //         timer: 2000,
    //         showConfirmButton: false
    //     });
    // }

    function showNotification(message, type) {
        var notification = $('#ajax-notification');
        notification.removeClass('error success').addClass(type).text(message).fadeIn();

        setTimeout(function () {
            notification.fadeOut();
        }, 3000);
    }
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

// jQuery(document).ready(function($) {
//     // Redirect to book listing
//     $('#back-to-list').on('click', function() {
//         window.location.href = '/firstpress/index.php/books-listing/';
//     });

//     // Show edit form
//     $('#edit-book').on('click', function() {
//         $('#edit-form').show();
//     });

//     // Save updated book
//     $('#save-edit').on('click', function() {
//         var bookId = $(this).data('id');
//         var newTitle = $('#edit-title').val();
//         var newContent = $('#edit-content').val();

//         $.ajax({
//             type: 'POST',
//             url: ajaxurl,
//             data: {
//                 action: 'update_book',
//                 id: bookId,
//                 title: newTitle,
//                 content: newContent,
//             },
//             success: function(response) {
//                 alert(response);
//                 location.reload(); // Refresh to show updated data
//             }
//         });
//     });
// });
