<?php

class familymembers extends db
{

    function __construct()
    {

    }

    function getFamilyMembersByMemberID($member_id, $page = 0, $limit = 50)
    {
        $query = "SELECT * FROM `ppSD_member_family` WHERE `member_id` = '".$member_id."' LIMIT ".$page.",".$limit;
        $familymembers = array();
        $STH = $this->run_query($query);
        while ($row = $STH->fetch())
        {
            $fm = new familymember($row["id"],$row["member_id"],$row["first_name"],$row["last_name"],$row["address_line_1"],
                $row["address_line_2"],$row["city"],$row["state"],$row["zip"],$row["country"],$row["phone"],$row["email"],$row["DOB"],
                $row["hebrew_name"],$row["bnai_mitzvah_date"]);
            array_push($familymembers, $fm);
        }
        return $familymembers;
    }

    function getFamilyMemberByID($id)
    {
        if (empty($id))
        {
            $id = 0;
        }
        $query = "SELECT * FROM `ppSD_member_family` WHERE `id` = ".$id;
        $STH = $this->run_query($query);
        while ($row = $STH->fetch())
        {
            $fm = new familymember($row["id"],$row["member_id"],$row["first_name"],$row["last_name"],$row["address_line_1"],
                $row["address_line_2"],$row["city"],$row["state"],$row["zip"],$row["country"],$row["phone"],$row["email"],$row["DOB"],
                $row["hebrew_name"],$row["bnai_mitzvah_date"]);
        }
        return $fm;
    }

    function addFamilyMember($fm)
    {
        $query = "INSERT INTO `ppSD_member_family` (member_id, first_name, last_name, address_line_1, address_line_2, city, `state`, zip, country, phone, email, DOB, hebrew_name, bnai_mitzvah_date)
            VALUES (
                '".$fm->member_id."',
                '".$fm->first_name."',
                '".$fm->last_name."',
                '".$fm->address_line_1."',
                '".$fm->address_line_2."',
                '".$fm->city."',
                '".$fm->state."',
                '".$fm->zip."',
                '".$fm->country."',
                '".$fm->phone."',
                '".$fm->email."',
                ".(empty($fm->DOB) ? "null" : "'".$fm->DOB."'").",
                '".$fm->hebrew_name."',
                ".(empty($fm->bnai_mitzvah_date) ? "null" : "'".$fm->bnai_mitzvah_date."'").")";
        $insertedid = $this->insert($query);
        return $insertedid;
    }

    function updateFamilyMember($fm)
    {
        $query = "UPDATE `ppSD_member_family`
            SET first_name = '".$fm->first_name."',
                last_name = '".$fm->last_name."',
                address_line_1 = '".$fm->address_line_1."',
                address_line_2 = '".$fm->address_line_2."',
                city = '".$fm->city."',
                `state` = '".$fm->state."',
                zip = '".$fm->zip."',
                country = '".$fm->country."',
                phone = '".$fm->phone."',
                email = '".$fm->email."',
                DOB = ".(empty($fm->DOB) ? "null" : "'".$fm->DOB."'").",
                hebrew_name = '".$fm->hebrew_name."',
                bnai_mitzvah_date = ".(empty($fm->bnai_mitzvah_date) ? "null" : "'".$fm->bnai_mitzvah_date."'")."
            WHERE id = ".$fm->id;
        $this->update($query);
        return "";
    }

    function deleteFamilyMember($id)
    {
        $query = "DELETE FROM `ppSD_member_family` WHERE id = ".$id;
        $this->delete($query);
        return "";
    }
}

class familymember {

    public $id;
    public $member_id;
    public $first_name;
    public $last_name;
    public $address_line_1;
    public $address_line_2;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $phone;
    public $email;
    public $DOB;
    public $hebrew_name;
    public $bnai_mitzvah_date;

    function __construct($id, $member_id, $first_name, $last_name, $address_line_1,
        $address_line_2, $city, $state, $zip, $country, $phone, $email, $DOB, $hebrew_name, $bnai_mitzvah_date)
    {
        $this->id = $id;
        $this->member_id = $member_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->address_line_1 = $address_line_1;
        $this->address_line_2 = $address_line_2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->country = $country;
        $this->phone = $phone;
        $this->email = $email;
        $this->DOB = $DOB;
        $this->hebrew_name = $hebrew_name;
        $this->bnai_mitzvah_date = $bnai_mitzvah_date;
    }
}