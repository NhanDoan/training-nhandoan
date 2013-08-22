<?php

class guest_post_access_handler_node_access extends views_handler_filter {
    function can_expose() { return FALSE; }
    function admin_summary() { return t('Accessible [Permissions]'); }
    function query() {
        // override - we don't change the query, everything is in post exec
        $this->view->gpa_filter_access = TRUE;
    }
}

function guest_post_access_views_post_execute($view) {
    if (!empty($view->gpa_filter_access)) {
        ob_start();
        foreach ($view->result as $i => $row) {
            $node = node_load($row->nid);
            if(node_access('view', $node) === FALSE) {
                unset($view->result[$i]);
            }
        }
        ob_end_clean();
    }
}    
function guest_post_access_views_data() {
    $data['views']['permissions'] = array(
        'title' => t('Accessible [Permissions]'),
        'help' => t('Permissions based checks'),
        'filter' => array(
            'help' => t('Call node_access() on each returned node - could cause performance issues!'),
            'handler' => 'guest_post_access_handler_node_access'
        )
    );

    return $data;
}

    


            
