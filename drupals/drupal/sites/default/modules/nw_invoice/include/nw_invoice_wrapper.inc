<?php

class NwInvoiceWrapper
{
    protected $wrapper;
    protected $node;
    protected $num_posts;

    const MAX_POSTS_PER_INVOICE = 20;

    public function __construct($writer_id)
    {
        $values = array(
            'type' => 'nw_invoice',
            'uid' => 1,
            'status' => 1,
            'comment' => 0,
            'promote' => 0
        );

        $this->node = entity_create('node', $values);
        $this->wrapper = entity_metadata_wrapper('node', $this->node);
        $this->wrapper->title->set("Writer Invoice");
        $this->num_posts = 0;

        $this->wrapper->nw_invoice_paid->set(0);

        $this->wrapper->nw_date_issued->set(time());

        $this->wrapper->nw_writer->set($writer_id);
        $this->wrapper->nw_total_owed->set(0);
    }

    /* guest_post should be a loaded entity */
    public function add_guest_post($guest_post)
    {
        if ($this->num_posts == self::MAX_POSTS_PER_INVOICE) {
            return FALSE;
        }

        $bonus_rate = empty($guest_post->field_quality_bonus) ? 0 : (int)$guest_post->field_quality_bonus['und'][0]['value'];

        if (empty($guest_post->nw_guest_post_base_rate)) {
            watchdog(
                'nw_invoice',
                'No base rate set for guest post %id! Using $25',
                array('%id' => $guest_post->nid),
                WATCHDOG_WARNING);
        }

        $base_rate = empty($guest_post->nw_guest_post_base_rate) ? 25 : $guest_post->nw_guest_post_base_rate['und'][0]['value'];

        $cur_owed = $this->wrapper->nw_total_owed->value();
        $cur_owed += $base_rate + $bonus_rate;
        $this->wrapper->nw_total_owed->set($cur_owed);

        $guest_post->nw_guest_post_invoice_link = array(
            'und' => array(
                array(
                    'target_id' => $this->wrapper->nid->value()
                ),
            ),
        );

        entity_save('node', $guest_post);

        $this->num_posts++;

        return TRUE;
    }

    public function save()
    {
        $this->wrapper->save();
        entity_save('node', $this->node);
    }
}