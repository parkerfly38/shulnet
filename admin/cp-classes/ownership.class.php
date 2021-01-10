<?php

class ownership
{

    protected $table;
    protected $data;
    protected $owner;
    protected $public;
    protected $employee;
    public $result;
    public $reason;

    /**
     * Data comes for the returned item's array.
     * @param string $owner  Owner
     * @param bool   $public Public
     */
    function __construct($owner = '', $public = '')
    {
        global $employee;
        $this->employee = $employee;
        $this->owner    = $owner;
        $this->public   = $public;
        $this->check();
    }

    /**
     * Check the item for ownership privileges.
     */
    function check()
    {
        if ($this->employee['permissions']['admin'] == '1') {
            $this->result = '1';
        }
        else if (! empty($this->owner) && $this->owner == $this->employee['id']) {
            $this->result = '1';
        }
        else if ($this->public == '1') {
            $this->result = '1';
        }
        else {
            $this->result = '0';
            $this->reason = 'You do not have permission to alter this item.';
        }
    }

}

