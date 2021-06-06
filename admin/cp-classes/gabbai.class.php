<?php

class gabbai extends db
{
    function __construct()
    {
        
    }

    function getAliyotByDate($date)
    {
        $query = "SELECT * FROM `ppSD_parashat` WHERE parsha_date = date('".$date."')";
        $rows = array();
        $aliyot = array();
        $STH = $this->run_query($query);
        while ($row = $STH->fetch())
        {
            $rows[] = $row;
        }
        foreach ($rows as $r)
        {   
            $leyning = array();
            $query2 = "SELECT * FROM `ppSD_leyning` WHERE parashat_id = ".$r["id"];
            $STH2 = $this->run_query($query2);
            while ($row2 = $STH2->fetch())
            {
                //get hebrewname
                $query3 = "SELECT b.hebrew_name, b.first_name, b.last_name
                FROM `ppSD_members` a
                INNER JOIN `ppSD_member_data` b ON a.id = b.member_id
                WHERE a.username = '".$row2["honoree"]."'";
                $STH3 = $this->run_query($query3);
                $honoree = $STH3->fetch();
                $leyn = new leyning($row2["id"],$row2["parashat_id"], $row2["honor"], ($honoree != null ? $honoree["first_name"]." ".$honoree["last_name"] : $row2["honoree"]),($honoree != null ? $honoree["hebrew_name"] : ""));
                array_push($leyning, $leyn);
            }
            $aliyah = new parashat($r["id"], $r["parsha_date"],$r["title"],$r["category"], $leyning);
            array_push($aliyot, $aliyah);
        }
        return $aliyot;
    }
}

class parashat {

    function __construct($id, $parsha_date, $title, $category, $leyning)
    {
        $this->id = $id;
        $this->parsha_date = $parsha_date;
        $this->title = $title;
        $this->category = $category;
        $this->leyning = $leyning;
    }

    public $id;
    public $parsha_date;
    public $title;
    public $category;
    public $leyning; //this is the object, if any
}

class leyning {

    public $id;
    public $parashat_id;
    public $honor;
    public $honoree;
    public $hebrew_name;

    function __construct($id, $parashat_id, $honor, $honoree, $hebrew_name)
    {
        $this->id = $id;
        $this->parashat_id = $parashat_id;
        $this->honor = $honor;
        $this->honoree = $honoree;
        $this->hebrew_name = $hebrew_name;
    }
}