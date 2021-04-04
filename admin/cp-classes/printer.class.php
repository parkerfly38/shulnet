<?php
class printer extends db
{

    protected $crit_id;
    protected $type;
    protected $total_printed;
    protected $scope_fields;
    protected $current_row;
    protected $special_fields;
    protected $print_title;
    protected $order;
    public $final_content;

    function __construct($crit_id = '', $print_title = '', $order_criteria = '')
    {
        if (!empty($crit_id)) {
            $this->crit_id = $crit_id;
            if (empty($print_title)) {
                $this->print_title = 'Printing';
            } else {
                $this->print_title = $print_title;
            }
            $this->order = $order_criteria;
            $this->printit();
        }
    }

    /**
     * Return the final template

     */
    function __toString()
    {
        return (string)$this->final_content;
    }

    function printit()
    {
        // Get criteria
        $criteria             = new criteria($this->crit_id);
        $this->type           = $criteria->data['type'];
        $this->special_fields = new special_fields($this->type);
        // Top Line
        $this->build_topline();
        // Total exported count
        $this->total_printed = $criteria->count;

        // Order?
        if (! empty($this->order)) {
            $criteria->query .= ' ORDER BY ' . $this->order;
        }

        // Start writing file.
        $cur_line = 0;
        $STH      = $this->run_query($criteria->query);
        while ($row = $STH->fetch()) {
            $this->current_row                 = $row;
            $this->special_fields->current_row = $row;
            $this->add_line();

        }
        // Write the file
        $this->close_view();
        // Delete the criteria
        $criteria->delete_criteria($this->crit_id);

    }

    function build_topline()
    {
        if ($this->type == 'member') {
            $topline = $this->get_eav_value('options', 'member_print');

        } else if ($this->type == 'contact') {
            $topline = $this->get_eav_value('options', 'contact_print');

        } else if ($this->type == 'rsvp') {
            $topline = $this->get_eav_value('options', 'rsvp_print');

        } else if ($this->type == 'account') {
            $topline = $this->get_eav_value('options', 'account_print');

        }
        $this->scope_fields = explode(',', $topline);
        // Final content... start building it.
        $this->final_content .= '<html>';
        $this->final_content .= '<head>';
        $this->final_content .= '<title>' . $this->print_title . '</title>';
        $this->final_content .= '<link type="text/css" rel="stylesheet" media="all" href="../css/printer_friendly.css" />';
        $this->final_content .= '</head>';
        $this->final_content .= '<body>';
        $this->final_content .= '<h1>' . $this->print_title . '</h1>';
        $this->final_content .= '<table cellspacing="0" cellpadding="0" id="print_table" width="100%"><thead><tr>';
        foreach ($this->scope_fields as $field) {
            $this->final_content .= '<th>' . $field . '</th>';
        }
        $this->final_content .= '</tr></thead>';
        $this->final_content .= '<tbody>';

    }

    function close_view()
    {
        $this->final_content .= '</tbody>';
        $this->final_content .= '</table>';
        $this->final_content .= '</body>';
        $this->final_content .= '</html>';

    }

    function add_line()
    {
        $this_line = '<tr>';
        $value     = '';
        foreach ($this->scope_fields as $name) {
            if (array_key_exists($name, $this->current_row)) {
                $value = $this->current_row[$name];
                if (empty($value)) {
                    $this_line .= '<td><span class="weak">--</span></td>';
                } else {
                    $value = $this->special_fields->process($name, $value);
                    $this_line .= '<td>' . $value . '</td>';
                }
            } else {
                if ($name == 'purchased') {
                    $value = $this->special_fields->process('purchased', $this->current_row['order_id']);
                    $this_line .= '<td>' . $value . '</td>';
                } else {
                    $this_line .= '<td><span class="weak">--</span></td>';
                }
            }
        }
        $this_line .= '</tr>';
        $this->final_content .= $this_line;
    }

}



