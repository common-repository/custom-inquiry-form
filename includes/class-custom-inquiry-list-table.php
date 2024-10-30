<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class WP_Custom_inquiry extends \WP_List_Table {

    function __construct()
    {
        global $page;
        parent::__construct( array(
            'singular' => 'Custom Inquiry',
            'plural'   => 'Custom Inquiries',
            'ajax'     => false
        ) );
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }
    /*function column_name( $item ) {
        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=&action=edit&id=' . $item['id'] ), $item['id'], __( 'Edit this item', '' ), __( 'Edit', '' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=&action=delete&id=' . $item['id'] ), $item['id'], __( 'Delete this item', '' ), __( 'Delete', '' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=&action=view&id=' . $item['id'] ), $item['name'], $this->row_actions( $actions ) );
    }*/
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', 
            'name' => __('Name', 'wp_custom_inquiry'),
            'email' => __('Email', 'wp_custom_inquiry'),
            'phone' => __('Phone', 'wp_custom_inquiry'),
            'subject' => __('Subject', 'wp_custom_inquiry'),
            'website' => __('Website', 'wp_custom_inquiry'),
            'message' => __('Message', 'wp_custom_inquiry'),
            'time' => __('Date & Time', 'wp_custom_inquiry'),
        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'id' => array('id',true),
            'name' => array('name', true),
            'email' => array('email', true),
            'time' => array('time', true),
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_inquiry_az'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items($search = null)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_inquiry_az';
        $per_page = 10;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? intval($_REQUEST['paged']) : 1;
        $offset = ( $paged * $per_page ) - $per_page;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        /* for searching */

        $query = (!empty($search)) ? ' WHERE name LIKE "%'.$search.'%"' : '';
        $query = (!empty($search)) ? ' WHERE email LIKE "%'.$search.'%"' : '';
        
        /* End searching */

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $query");

        $prepare = sprintf("SELECT * FROM %s %s ORDER BY %s %s LIMIT %d, %d", $table_name, $query, $orderby, $order, $offset, $per_page );
        $this->items = $wpdb->get_results($prepare, ARRAY_A);
  
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }
}