<?php
/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Brian Kresge
 * @link        https://www.covebrookcode.com/
 * @copyright   (c) 2013-2016 Castlamp, 2019 Brian Kresge
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */
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
            $this->get_item($item_id);
        } else {
            if (!empty($table)) {
                $this->add_query = $this->form_query($page, $display, $order, $dir, $criteria);
                $this->get_yahrzeits();
            }
        }
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
        $total               = $this->get_array("SELECT COUNT(*) FROM `" . $this->mysql_cleans($this->table) . "` $this->where", '1');
        $this->total_results = $total['0'];
        if ($display > 0) {
            $this->pages         = ceil($this->total_results / $display);
        } else {
            $this->pages         = '1';
        }
        // Limit?
        $this->limit = "LIMIT $low,$display";
        // Order?
        $this->order = "ORDER BY $order " . $dir;
    }
    /**
     * Get a single yahrzeit item
     */
    function get_item($id)
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
			SELECT *
			FROM `" . $this->mysql_cleans($this->table) . "`
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

        $table         = $admin->get_table($table, $_GET, $defaults, $force_filters, '', '', $this->query);

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