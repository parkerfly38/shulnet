<?php

class export extends db
{

    protected $crit_id;
    public $total_exported;
    public $exported_list;
    protected $delimiter;
    protected $act_id;
    protected $final_content;
    protected $scope_fields;
    protected $special_fields;
    protected $file;
    protected $filename;
    protected $type;
    protected $current_row;

    public function __construct($crit_id = '', $act_id = '', $delimiter = ',')
    {
        if (!empty($crit_id)) {
            $this->crit_id   = $crit_id;
            $this->act_id    = $act_id;
            $this->delimiter = $delimiter;
            $this->export();
        }
    }


    /**
     * Begin the export process.
     */
    protected function export()
    {
        // Get criteria
        $criteria             = new criteria($this->crit_id);
        $this->type           = $criteria->data['type'];
        $this->special_fields = new special_fields($this->type, '1');

        // Top Line
        $this->build_topline();

        // Total exported count
        $this->total_exported = $criteria->count;

        // Start writing file.
        $cur_line = 0;
        $STH      = $this->run_query($criteria->query);
        while ($row = $STH->fetch()) {
            $this->current_row                 = $row;
            $this->special_fields->current_row = $row;
            $this->add_line();
        }

        // Write the file
        $this->write();

        // Download the file
        $this->download_file();

        // Delete the file
        $del = @unlink($this->file);

        // Delete the criteria
        $criteria->delete_criteria($this->crit_id);
    }


    /**
     * Build the top line of the file.
     */
    protected function build_topline()
    {
        if ($this->type == 'member') {
            $main_topline = $this->get_eav_value('options', 'member_export');

            $main_topline = $this->get_eav_value('options', 'member_export');
            $toplineA = $this->fields_in_scope('member');
            $maintop = explode(',', $main_topline);
            $use_array = array_merge($toplineA, $maintop);

            //$toplineA = $this->fields_in_scope('member');
            $topline = implode(',',$use_array);
            $remove  = array('ppSD_members', 'ppSD_member_data');
        }
        else if ($this->type == 'contact') {
            $main_topline = $this->get_eav_value('options', 'contact_export');
            $toplineA = $this->fields_in_scope('contact');
            $maintop = explode(',', $main_topline);
            $use_array = array_merge($toplineA, $maintop);

            //$toplineA = $this->fields_in_scope('contact');
            $topline = implode(',',$use_array);
            $remove  = array('ppSD_contacts', 'ppSD_contact_data');
        }
        else if ($this->type == 'rsvp') {
            $topline = $this->get_eav_value('options', 'rsvp_export');
            $remove  = array('ppSD_event_rsvps', 'ppSD_event_rsvp_data');

        }
        else if ($this->type == 'account') {
            $topline = $this->get_eav_value('options', 'account_export');
            $remove  = array('ppSD_accounts', 'ppSD_account_data');

        }
        else if ($this->type == 'transaction') {
            $topline = $this->get_eav_value('options', 'transaction_export');
            $remove  = array('ppSD_cart_sessions', 'ppSD_cart_session_totals', 'ppSD_shipping');

        }
        $this->scope_fields = explode(',', $topline);
        if ($this->delimiter != ',') {
            $topline = str_replace(',', $this->delimiter, $topline);

        }
        $topline = str_replace($remove, '', $topline);
        $this->final_content .= $topline . "\n";

    }


    /**
     * Add a line to the file.
     */
    protected function add_line()
    {
        $this_line = '';
        $value     = '';
        foreach ($this->scope_fields as $name) {
            if (array_key_exists($name, $this->current_row)) {
                $value = $this->current_row[$name];
                if (empty($value)) {
                    $this_line .= $this->delimiter . '';
                } else {
                    $value = $this->special_fields->process($name, $value);
                    $value = str_replace("\n", '.   ', $value);
                    $value = str_replace("\r\n", '.   ', $value);
                    $value = str_replace("\r", '.   ', $value);
                    if (strpos($value, $this->delimiter) !== false) {
                        $value = '"' . str_replace('"', '""', $value) . '"';
                    }
                    $this_line .= $this->delimiter . $value;
                }
            } else {
                if ($name == 'purchased') {
                    $value = $this->special_fields->process('purchased', $this->current_row['order_id']);
                    $value = str_replace('<ul style="list-style:inside;margin:0;padding:0;">', '', $value);
                    $value = str_replace('<LI>', " | ", $value);
                    $value = str_replace('</li>', "", $value);
                    $value = str_replace('</ul>', '', $value);
                    $value = str_replace('"', '""', $value);
                    $value = str_replace("\r\n", '.   ', $value);
                    $value = str_replace("\n", '.   ', $value);
                    $value = str_replace("\r", '.   ', $value);
                    $value = substr($value, 3);
                    $this_line .= $this->delimiter . '"' . $value . '"';
                } else {
                    $this_line .= $this->delimiter . '';
                }
            }
        }
        $this_line = substr($this_line, 1);
        $this->final_content .= $this_line . "\n";

    }


    /**
     *
     * Write the processed file.
     */
    protected function write()
    {
        // path, filename, content
        $path           = PP_PATH . '/admin/sd-system/exports';
        $filename       = date('Ymd') . '_' . substr(md5(time()), 0, 15) . '.csv';
        $this->file     = $path . '/' . $filename;
        $this->filename = $filename;
        $this->write_file($path, $filename, $this->final_content);

    }


    /**
     * Download the final file.
     */
    protected function download_file()
    {
        $mm_type = "application/octet-stream";
        header("Content-type: application/force-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-length: " . filesize($this->file));
        header("Content-disposition: attachment; filename=\"" . basename($this->filename) . "\"");
        readfile($this->file);
    }

}



