<?php

class yahrzeits extends db
{
    public $final_content;
    public $add_query;
    public $id;
    public $limit;
    public $order, $hold_order;
    public $where;
    public $dir, $hold_dir;
    public $total_results;
    public $display;
    public $page;
    public $pages;
    public $query;
    public $criteria;
    public $table;
    public $join_table;
    public $table_cells;
    /**
     * Construct
     */
    function __construct($item_id = '', $criteria = array(), $page = '1', $display = '50', $order = 'English_Date_of_Death', $dir = 'DESC', $table = 'ppSD_yahrzeits', $join_table = '', $scope_overrides = array())
    {
        $this->criteria   = $criteria;
        $this->table      = $table;
        $this->join_table = $join_table;
        $this->hold_dir   = $dir;
        $this->dir        = $dir;
        $this->page       = $page;
        $this->hold_order = $order;
        $this->hold_dir   = $dir;
        $this->display    = $display;
        if (empty($scope_overrides)) {
            $this->scope = array('page' => '', 'type' => '');
        } else {
            $this->scope = $scope_overrides;
        }
        // All or individual?
        if (!empty($item_id)) {
            $this->get_yahrzeit($item_id);
        } else {
            if (!empty($table)) {
                $this->add_query = $this->form_query($page, $display, $order, $dir, $criteria);
                $this->get_yahrzeits();
            }
        }
    }

    function create_yahrzeit_relationship($data)
    {
        $q1 = $this->insert("INSERT INTO ppSD_yahrzeit_members (`yahrzeit_id`,`user_id`,`Relationship`)
            VALUES ('".$data["yahrzeit"]."','".$data["user_id"]."','".$data["Relationship"]."')");

        $track_id ='';
        if (! empty($_COOKIE['zen_source'])) {
            $source = new source();
            $source->convert($_COOKIE['zen_source'], $this->id, 'member');
            $track_id = $_COOKIE['zen_source'];
            $this->delete_cookie('zen_source');
        }

        return array('error' => '0', 'error_details' => '', 'id' => $data["yahrzeit"], 'tracking_id' => $track_id);
    }
    /**
     * create new yahrzeit
     * $param array $data Primary yahrzeit data.
     *              'yahrzeit' => array('key1'=>'value1','key2'=>'value2')
     */
    function create_yahrzeit($data, $id = '')
    {
        $q1A = '';
        $q1B = '';
        $q1clean = '';

        //$task_id = $this->start_task('create_yahrzeit', 'user', 0, '');

        /*foreach ($data as $name => $value) 
        {
            $q1A .= ",`" . $name . "`";
            $q1B .= ",'" . $this->mysql_clean($value) . "'";
            $q1clean .= ",'$value'";
        }*/
        $admin = new admin;
        $primary = array('');
        $ignore = array('edit','id','user_id','Relationship');
        $query_form = $admin->query_from_fields($data, 'add', $ignore, $primary );

        if (empty($id))
        {
            $id = generate_id('random','20');
        }

        $q1 = $this->insert("
		    INSERT INTO `ppSD_yahrzeits` (`id`,`English_Name`,`Hebrew_Name`,`English_Date_of_Death`,`Hebrew_Date_of_Death`)
		    VALUES ('".$id."','".$data["English_Name"]."','".$data["Hebrew_Name"]."','".$data["English_Date_of_Death"]."','".$data["Hebrew_Date_of_Death"]."')
        ");

        //$q2 = $this->insert("INSERT INTO ppSD_yahrzeit_members (`yahrzeit_id`,`user_id`,`Relationship`)
        //    VALUES ('".$id."','".$data["user_id"]."','".$data["Relationship"]."')");

        $track_id ='';
        if (! empty($_COOKIE['zen_source'])) {
            $source = new source();
            $source->convert($_COOKIE['zen_source'], $this->id, 'member');
            $track_id = $_COOKIE['zen_source'];
            $this->delete_cookie('zen_source');
        }

        /*$task = $this->end_task($task_id, '1', '', 'member_create', 0, $indata);*/
        
        //$changes = array();
        return array('error' => '0', 'error_details' => '', 'id' => $id, 'tracking_id' => $track_id);

    }
     /**
     * Return the final template
     */
    function __toString()
    {
        return (string)$this->final_content;
    }
    /**
     * Form query
     */
    function form_query($page, $display, $order, $dir)
    {
        // Limit user ID?
        $found_where           = 0;
        $use_advanced_criteria = '0';
        $scope                 = 'AND';
        if (! empty($this->criteria)) {
            foreach ($this->criteria as $name => $value) {
                if ($name == 'use_advanced') {
                    unset($this->criteria[$name]);
                    $use_advanced_criteria = '1';
                    break;
                } else {
                    if ($name == 'scope_type') {
                        $scope = ' ' . $value . ' ';
                    } else {
                        $found_where = 1;
                        if (is_array($value)) {
                            $temp_where = '';
                            $this->where .= " " . $scope . " (";
                            foreach ($value as $group => $inner) {
                                $temp_where .= " $name " . $this->mysql_cleans($group) . "='" . $this->mysql_cleans($inner) . "'";
                            }
                            $temp_where = substr($temp_where, 4);
                            $this->where .= $temp_where . ")";
                        } else {
                            $this->where .= " " . $scope . " " . $this->mysql_cleans($name) . "='" . $this->mysql_cleans($value) . "'";
                        }
                    }
                }
            }
        }
        if ($use_advanced_criteria == '1') {
            $found_where = 1;
            $admin       = new admin;
            $this->where = $admin->build_filter_query($this->criteria, $this->table);
        }
        if ($found_where == '1') {
            $this->where = substr($this->where, 5);
            $this->where = "WHERE " . $this->where;
        }
        $low = $display * $page - $display;
        // Pages?
        //$total               = $this->get_array("SELECT COUNT(*) FROM `" . $this->mysql_cleans($this->table) . "` $this->where", '1');
        $total               = $this->get_array("SELECT COUNT(*) FROM `" . $this->mysql_cleans($this->table) . "`", '1');
        $this->total_results = $total['0'];
        if ($display > 0) {
            $this->pages         = ceil($this->total_results / $display);
        } else {
            $this->pages         = '1';
        }
        // Limit?
        //$this->limit = "LIMIT $low,$display";
        // Order?
        $this->order = "ORDER BY $order " . $dir;
    }
    /**
     * Get yahrzeits by user
     */
    function get_yahrzeits_by_user($id)
    {
    }

    function get_member_yarhzeit($id, $user_id)
    {
        $query = "SELECT a.id, a.English_Name, a.Hebrew_Name, a.English_Date_of_Death, a.Hebrew_Date_of_Death, b.Relationship
            FROM ppSD_yahrzeits a INNER JOIN ppSD_yahrzeit_members b ON a.id = b.yahrzeit_id WHERE a.id = '".$id."' AND b.user_id = '".$user_id."'";
        $STH = $this->run_query($query);
        $row = $STH->fetch();
        return $row;
    }

    /**
     * Get a single yahrzeit item
     */
    function get_yahrzeit($id)
    {
        if (is_numeric($id)) {
            $his                 = $this->get_array("
                SELECT *
                FROM `" . $this->table . "`
                WHERE `id`='" . $this->mysql_clean($id) . "'
                LIMIT 1
            ");
        } else {
            $his                 = $this->get_array("
                SELECT *
                FROM `" . $this->table . "`
                WHERE `id` LIKE '" . $this->mysql_clean($id) . "'
                LIMIT 1
            ");
        }
        $this->final_content = $his;
    }
    /**
     * Get all yahrzeits matching
     * specific criteria
     */
    function get_yahrzeits()
    {
        $historyarr  = array();
        $this->query = "
			SELECT ppSD_yahrzeits.id, ppSD_yahrzeit_members.user_id, ppSD_yahrzeits.English_Name, ppSD_yahrzeits.Hebrew_Name, ppSD_yahrzeits.English_Date_of_Death, ppSD_yahrzeits.Hebrew_Date_of_Death, concat(ppSD_member_data.first_name,' ',ppSD_member_data.last_name) AS Member_Name, Relationship
            FROM `ppSD_yahrzeits`
            INNER JOIN ppSD_yahrzeit_members ON ppSD_yahrzeits.id = ppSD_yahrzeit_members.yahrzeit_id
            INNER Join ppSD_member_data ON ppSD_member_data.member_id = ppSD_yahrzeit_members.user_id
		";
        $this->query .= " " . $this->where;
        $this->query .= " " . $this->order;
        $this->query .= " " . $this->limit;

        $STH = $this->run_query($this->query);
        while ($row = $STH->fetch()) {
            $historyarr[] = $row;
        }
        $this->table_cells   = $this->get_cells();
        $this->final_content = $historyarr;
    }
    /**
     * Generate table cells
     */
    function get_cells()
    {
        global $admin;
        // global $employee;
        $table         = $this->table;
        $order         = $this->hold_order;
        $dir           = $this->hold_dir;
        $display       = $this->display;
        $page          = $this->page;
        $defaults      = array(
            'sort'            => $order,
            'order'           => $dir,
            'page'            => $page,
            'display'         => $display,
            'filters'         => $this->convert_criteria(),
            'scope_page'      => $this->scope['page'], // Only for overrides
            'scope_page_type' => $this->scope['type'], // Only for overrides
        );
        $force_filters = array();
        $force_headings = array("English_Name","Hebrew_Name","English_Date_of_Death","Hebrew_Date_of_Death","Relationship");
        if ($admin != null)
        {
            $table         = $admin->get_table($table, $_GET, $defaults, $force_filters, '', $force_headings, $this->query);
        }

        return $table;
    }
    function convert_criteria($force = '')
    {
        if (empty($force)) {
            $force = $this->criteria;
        }
        $filters = array();
        if (! empty($force) && is_array($force)) {
            foreach ($force as $item => $value) {
                if ($item == 'OR') {
                    $filters['OR'] = $this->convert_criteria($value);
                } else {
                    $filters[] = $value . '||' . $item . '||eq||' . $this->table;
                }
            }
        }
        return $filters;
    }
}

?>