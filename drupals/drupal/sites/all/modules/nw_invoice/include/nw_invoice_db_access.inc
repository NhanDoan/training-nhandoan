<?php

class NwInvoiceDBAccess {
    public static function get_uninvoiced_guest_post_ids()
    {
        $query = new EntityFieldQuery;

        $guest_post_ids = $query
            ->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'guest_post')
            ->addTag('nw_invoice_not_invoiced')
            ->execute();

        if (empty($guest_post_ids) || empty($guest_post_ids['node'])) {
            return array();
        }

        $ret = array();
        foreach ($guest_post_ids['node'] as $node_obj) {
            $ret[] = $node_obj->nid;
        }

        return $ret;
    }

    public static function get_unprocessed_invoices()
    {
        $query = self::get_base_invoice_query();

        $query->where('p.nw_invoice_paid_value = 0');
        $query->orderBy('writer_full_name');

        $ret = $query->execute();
        return $ret;
    }

    public static function get_guest_post_names_for_id($invoice_id)
    {
        $args = array(
            ':entity_type' => 'node',
            ':invoice_id' => $invoice_id
        );

        $query = db_select('node', 'invoice_node');
        $query->innerJoin('field_data_nw_guest_post_invoice_link', 'l', 'invoice_node.nid=l.nw_guest_post_invoice_link_target_id AND l.entity_type=:entity_type', $args);
        $query->innerJoin('node', 'guest_post', 'guest_post.nid=l.entity_id');
        $query->addField('guest_post', 'title', 'guest_post_title');
        $query->addField('l', 'nw_guest_post_invoice_link_target_id', 'guest_post_id');
        $query->where('invoice_node.nid = :invoice_id', $args);
        $query->orderBy('guest_post_id');

        $res = $query->execute();

        $ret = array();
        foreach($res as $row) {
            $ret[] = $row->guest_post_title;
        }

        return $ret;
    }

    protected static function get_base_invoice_query()
    {
        $args = array(':entity_type' => 'node');

        $query = db_select('node');

        $query->innerJoin('field_data_nw_invoice_paid', 'p', 'node.nid=p.entity_id AND p.entity_type = :entity_type', $args);
        $query->innerJoin('field_data_nw_writer', 'w', 'node.nid=w.entity_id AND w.entity_type = :entity_type', $args);
        $query->innerJoin('field_data_nw_total_owed', 'o', 'node.nid=o.entity_id AND o.entity_type = :entity_type', $args);
        $query->innerJoin('field_data_nw_date_issued', 'i', 'node.nid=i.entity_id AND i.entity_type = :entity_type', $args);
        $query->innerJoin('field_data_field_full_name', 'f', 'w.nw_writer_target_id=f.entity_id AND f.entity_type = :user_entity_type',
            array(':user_entity_type' => 'user'));


        $query->addField('f', 'field_full_name_value', 'writer_full_name' );
        $query->addField('o', 'nw_total_owed_value', 'total_owed');
        $query->addField('i', 'nw_date_issued_value', 'date_issued');

        $query->fields('node', array('title', 'nid'));
        return $query;
    }


}