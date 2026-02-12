<?php
function rd_custom_post_types_register() {

  $post_types = [
    'services' => [
      'supports' => [ 'title', 'revisions', 'editor', 'author', 'excerpt', 'thumbnail' ],
      'public' => true,
      'show_in_rest' => true,
      'has_archive' => false,
      'menu_position' => 5,
      'show_in_menu' => true,
      'menu_icon' => 'dashicons-clipboard',
      'rewrite' => [ 'slug' => 'document-preparation', 'with_front' => false ],
      'labels' => [
        'name' => 'Services',
        'singular_name' => 'Services',
        'add_new' => 'Add New Services',
        'add_new_item' => 'Add New Services',
        'edit_item' => 'Edit Services',
        'new_item' => 'New Services',
        'view_item' => 'View Services',
        'view_items' => 'View Servicess',
        'search_items' => 'Search Servicess',
        'not_found' => 'No Servicess found',
        'not_found_in_trash' => 'No Servicess found in trash',
        'parent_item_colon' => 'Parent Services',
        'all_items' => 'All Servicess',
        'archives' => 'Services Archives',
        'attributes' => 'Services Attributes',
        'insert_into_item' => 'Insert into Services',
        'uploaded_to_this_item' => 'Uploaded to this Services',
        'filter_items_list' => 'Filter Servicess list',
        'items_list_navigation' => 'Servicess list navigation',
        'items_list' => 'Servicess list',
        'item_published' => 'Services published',
        'item_published_privately' => 'Services published privately',
        'item_reverted_to_draft' => 'Services reverted to draft',
        'item_scheduled' => 'Services scheduled',
        'item_updated' => 'Services updated',
      ],
    ],
    'documents' => [
      'supports' => [ 'title', 'revisions', 'editor', 'author', 'excerpt', 'thumbnail' ],
      'public' => true,
      'show_in_rest' => true,
      'has_archive' => false,
      'menu_position' => 5,
      'show_in_menu' => true,
      'menu_icon' => 'dashicons-networking',
      'rewrite' => [ 'slug' => 'documents', 'with_front' => false ],
      'labels' => [
        'name' => 'Documents',
        'singular_name' => 'Document',
        'add_new' => 'Add New Document',
        'add_new_item' => 'Add New Document',
        'edit_item' => 'Edit Document',
        'new_item' => 'New Document',
        'view_item' => 'View Document',
        'view_items' => 'View Documents',
        'search_items' => 'Search Documents',
        'not_found' => 'No Documents found',
        'not_found_in_trash' => 'No Documents found in trash',
        'parent_item_colon' => 'Parent Document',
        'all_items' => 'All Documents',
        'archives' => 'Document Archives',
        'attributes' => 'Document Attributes',
        'insert_into_item' => 'Insert into Document',
        'uploaded_to_this_item' => 'Uploaded to this Document',
        'filter_items_list' => 'Filter Documents list',
        'items_list_navigation' => 'Documents list navigation',
        'items_list' => 'Documents list',
        'item_published' => 'Document published',
        'item_published_privately' => 'Document published privately',
        'item_reverted_to_draft' => 'Document reverted to draft',
        'item_scheduled' => 'Document scheduled',
        'item_updated' => 'Document updated',
      ],
    ],
  ];

  foreach ( $post_types as $key => $post_type ) {
    register_post_type($key, $post_type);
  }

}

add_action( 'init', 'rd_custom_post_types_register', 0 );