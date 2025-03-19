jQuery(document).ready(function ($) {
    // Load Books
    $('#load-books').on('click', function () {
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
            window.location.href = '/firstpress/index.php/book/' + bookSlug + '/';
        } else {
            alert('Error: Book slug is missing.');
        }
    });

    $(document).on('click', '.edit-book', function () {
        var bookSlug = $(this).data('slug');
        if (bookSlug) {
            window.location.href = '/firstpress/edit-book/?book=' + bookSlug;
        } else {
            alert('Error: Book slug is missing.');
        }
    });

    $('#edit-book-form').on('submit', function (e) {
        e.preventDefault();

        var bookId = $('#book-id').val();
        var title = $('#book-title').val();
        var content = $('#book-content').val();
        var genres = $('#book-genre').val();
        console.log("ajax data : ",bookId,title,content,genres);

        if (!title) {
            showNotification('Book title is required!', 'error');
            return;
        }
        if (!content) {
            showNotification('Book content is required!', 'error');
            return;
        }
        if (!genres) {
            showNotification('Book genre is required!', 'error');
            return;
        }

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
            // beforeSend: function () {
            //     alert('Updating book...');
            // },
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

    function showNotification(message, type) {
        var notification = $('#ajax-notification');
    
        notification.text(message).removeClass('error').addClass(type);
        notification.addClass('show');
    
        setTimeout(function () {
            notification.removeClass('show');
        }, 3000);
    }

    $(document).on('click', '.fetch-book-api', function () {
        var bookId = $(this).data('id');

        if (bookId) {
            $.ajax({
                url: '/firstpress/wp-json/custom/v1/book/' + bookId,
                type: 'GET',
                success: function (data) {
                    if (data) {
                        console.log("API Response: ", data);
                    } else {
                        console.log("API Response error: ", data);
                    }
                },
                error: function () {
                    alert('Error fetching book details.');
                }
            });
        } else {
            alert('Error: Book ID is missing.');
        }
    });
    
});
