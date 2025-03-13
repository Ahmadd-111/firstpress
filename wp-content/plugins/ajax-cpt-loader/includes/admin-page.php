<?php
function ajax_cpt_loader_admin_menu() {
    add_menu_page(
        'AJAX CPT Loader',
        'AJAX CPT Loader',
        'manage_options',
        'ajax_cpt_loader',
        'ajax_cpt_loader_admin_page',
        'dashicons-book',
        20
    );
}
add_action('admin_menu', 'ajax_cpt_loader_admin_menu');

function ajax_cpt_loader_admin_page() {
?>
    <div class="wrap">
        <h1>Manage Books</h1>
        <button id="load-books">Load Books</button>
        <div id="book-list"></div>
    </div>
<?php
}
