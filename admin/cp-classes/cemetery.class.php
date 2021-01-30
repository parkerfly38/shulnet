<?php

class cemetery extends db
{
    function get_cemeteries()
    {
        $result = $this->run_query("SELECT * FROM `ppSD_cemetery`");
        $cemeteries = array();
        while ($row = $result->fetch())
        {
            $cemeteries[] = $row;
        }
        return $cemeteries;
    }
}