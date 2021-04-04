<?php

class permissions extends db
{

    protected $employee, $scope, $act_id, $act_table, $action;

    public $result, $reason;

    function __construct($scope, $action, $act_id = '', $act_table = '')
    {
        global $employee;
        $this->employee  = $employee;
        $this->scope     = $scope;
        $this->action    = $action;
        $this->act_id    = $act_id;
        $this->act_table = $act_table;
        $this->check_permission();
        $this->determine_error();

    }

    function check_permission()
    {
        if ($this->employee['permissions']['admin'] == '1') {
            $this->result = '1';

        } else {
            $this->check_scope();

        }

    }

    function check_scope()
    {
        if ($this->employee['permissions']['scopes'][$this->scope] == 'none') {
            $this->result = '0';
            $this->reason = 'You do not have permissions within this scope.';

        } else if ($this->employee['permissions']['scopes'][$this->scope] == 'owned') {
            $history = new history($this->act_id, '', '', '', '', '', $this->act_table);
            if (!empty($history->final_content['owner'])) {
                if ($history->final_content['owner'] == $this->employee['id']) {
                    $this->result = '1';

                } else {
                    $this->result = '0';
                    $this->reason = 'You do not own this item.';

                }

            } else if (!empty($history->final_content['public'])) {
                if ($history->final_content['public'] == '1') {
                    $this->result = '1';

                } else {
                    $this->result = '0';
                    $this->reason = 'Item is not listed as public.';

                }

            } else {
                $this->result = '0';
                $this->reason = 'No owner specified for this item. System only.';

            }

        } else if ($this->employee['permissions']['scopes'][$this->scope] == 'all') {
            $this->check_scope_permission();

        }

    }

    function check_scope_permission()
    {
        if (in_array($this->action, $this->employee['permissions']['scopes'][$this->scope]['list'])) {
            $this->result = '1';

        } else {
            $this->result = '0';
            $this->reason = 'You do not have permission to perform this action within this scope.';

        }

    }

    function determine_error()
    {
        if ($this->result != '1') {
            echo "0+++" . $this->reason;
            exit;

        }

    }

}

