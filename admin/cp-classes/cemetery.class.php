<?php

class cemetery extends db
{
    function get_cemeteries()
    {
        $result = $this->get_array("SELECT * FROM `ppSD_cemetery`");
        return $result;
    }
}