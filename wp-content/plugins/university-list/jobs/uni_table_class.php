<?php

/*
 * class for my custom table on Jobs page
 */

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Uni_List_Table extends WP_List_Table {

    var $data;
    var $found_data;

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
//            'id' => 'ID',
            'job_name' => 'Название',
            'city' => 'Город',
            'adress' => 'Адресс',
            'job_name_en' => 'Название - eng',
            'city_en' => 'Город - eng',
            'adress_en' => 'Адресс - eng',
        );
        return $columns;
    }

    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $search = (isset($_POST['s'])) ? $_POST['s'] : '';

        $this->data = get_data_from_db($search);
        usort($this->data, array(&$this, 'usort_reorder'));
        $this->item = $this->data;

        //paging

        $per_page = 15;
        $current_page = $this->get_pagenum();
        $total_items = count($this->data);

        // only ncessary because we have sample data
        $this->found_data = array_slice($this->data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page                     //WE have to determine how many items to show on a page
        ));
        $this->items = $this->found_data;
    }

    function column_default($item, $column_name) {

        if ($item[$column_name]) {
            $show = $item[$column_name];
        } else {
            $show = '<span style="color: orange;">Не заполнено</span>';
        }
        
        switch ($column_name) {
//            case 'id':
            case 'job_name':
            case 'city':
            case 'adress':
            case 'job_name_en':
            case 'city_en':
            case 'adress_en':
                return $show;
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_job_name($item) {

        $actions = array(
            'edit' => sprintf('<a href="?page=job-list&view=%s&job_id=%s">Edit</a>', 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=job-list&view=%s&action=%s&job_id=%s">Delete</a>', 'list', 'delete', $item['id']),
        );
        $name = sprintf('<a href="?page=job-list&view=%s&job_id=%s">%s</a>', 'edit', $item['id'], $item['job_name']);
        return sprintf('%1$s %2$s', $name, $this->row_actions($actions));
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id', true),
            'job_name' => array('job_name', FALSE),
            'city' => array('city', false),
            'adress' => array('adress', false),
            'job_name_en' => array('job_name_en', FALSE),
            'city_en' => array('city_en', false),
            'adress_en' => array('adress_en', false),
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

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );

        return $actions;
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="job_id[]" value="%s" />', $item['id']
        );
    }

}
