<?php

/*
 * class for my custom table on Jobs page
 */

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Export_List_Table extends WP_List_Table {

    var $data;
    var $found_data;

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'post_title' => 'Название статьи',
            'myauthors' => 'Авторы',
            'tags' => 'Рубрика',
//            'ID' => 'ID',
        );
        return $columns;
    }

    function prepare_items($pageposts) {
        $columns = $this->get_columns();
        $hidden = array();
//        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden);

//        $search = (isset($_POST['s'])) ? $_POST['s'] : '';

        $this->data = $pageposts;
//        usort($this->data, array(&$this, 'usort_reorder'));
        $this->items = $this->data;

        //paging
//
//        $per_page = 15;
//        $current_page = $this->get_pagenum();
//        $total_items = count($this->data);
//
//        // only ncessary because we have sample data
//        $this->found_data = array_slice($this->data, (($current_page - 1) * $per_page), $per_page);
//
//        $this->set_pagination_args(array(
//            'total_items' => $total_items, //WE have to calculate the total number of items
//            'per_page' => $per_page                     //WE have to determine how many items to show on a page
//        ));
//        $this->items = $this->found_data;
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'ID':
            case 'post_title':
                return $item[$column_name];
            case 'myauthors':
            case 'tags':
                $cat = get_the_category($item['ID']);
                return $cat[0]->name;
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_post_title($item) {

//        $actions = array(
//            'edit' => sprintf('<a href="?page=job-list&view=%s&job_id=%s">Edit</a>', 'edit', $item['id']),
//            'delete' => sprintf('<a href="?page=job-list&view=%s&action=%s&job_id=%s">Delete</a>', 'list', 'delete', $item['id']),
//        );
        $name = sprintf('<a href="post.php?post=%s&action=edit" target="_blank">%s</a>', $item['ID'], $item['post_title']);
        return sprintf('%1$s %2$s', $name, $this->row_actions($actions));
    }
    
    function column_myauthors( $item ) {
        if (array_pop(get_post_custom_values('stol', $item['ID'])) !== 'yes') {
            $authors = get_post_meta($item['ID'], 'coauthor');
            if ($authors) {
                foreach ($authors as $i => $author) {
                    $id = get_user_by_display_name($author)->ID;
                    $link = '<a class="edit-link" href="' . home_url() . '/wp-admin/user-edit.php?user_id=' . $id . '" target="_blank">' . $author . '</a>';
                    echo $link;
                    if (count($authors) - 1 != $i) {
                        echo "<br>";
                    }
                }
            }
        }
	}

    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id', true),
            'job_name' => array('job_name', FALSE),
            'city' => array('city', false),
            'adress' => array('adress', false)
        );
        return $sortable_columns;
    }

    function usort_reorder($a, $b) {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby']) ) ? $_GET['orderby'] : 'job_name';
        // If no order, default to asc
        $order = (!empty($_GET['order']) ) ? $_GET['order'] : 'asc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ( $order === 'asc' ) ? $result : -$result;
    }

//    function get_bulk_actions() {
//        $actions = array(
//            'delete' => 'Delete'
//        );
//
//        return $actions;
//    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="post_id[]" value="%s" />', $item['ID']
        );
    }

}
