<?php

class alerts extends db
{

    /**
     * @var int Employee ID.
     */
    private $employee;

    private $data = [];


    public function __construct($employeeId)
    {
        $this->employee = $employeeId;
    }


    public function setEmployee($employeeId)
    {
        $this->employee = $employeeId;

        return $this;
    }


    public function get($format = 'json')
    {
        if ($format == 'array') {
            return $this->data;
        } else {
            return json_encode($this->data);
        }
    }


    public function getAlerts()
    {
        $rows = [];

        $query = $this->run_query("
            SELECT
                *
            FROM
                `ppSD_reminders`
            WHERE
                `for` = '" . $this->mysql_clean($this->employee) . "' AND
                `remind_on` = '" . $this->mysql_clean(date('Y-m-d')) . "' AND
                `seen` != '1'
        ");

        while ($row = $query->fetch()) {
            $rows[] = $row;
        }

        $this->data = $rows;

        return $this;
    }


    public function getAlert($id)
    {
        return $this->get_array("
            SELECT *
            FROM ppSD_reminders
            WHERE `id`='" . $this->mysql_clean($id) . "'
            LIMIT 1
        ");
    }


    public function markSeen($id)
    {
        $alert = $this->getAlert($id);

        if ($alert['for'] != $this->employee)
            return false;

        return $this->update("
            UPDATE
                `ppSD_reminders`
            SET
                `seen` = '1',
                `seen_on` = '" . current_date() . "'
            WHERE
                `id` = '" . $this->mysql_clean($id) . "'
            LIMIT 1
        ");
    }


    public function delay($id)
    {
        $alert = $this->getAlert($id);

        if ($alert['for'] != $this->employee)
            return false;

        $oneDay = date('Y-m-d', strtotime($alert['remind_on'])+86400);

        $update = $this->update("
            UPDATE
                `ppSD_reminders`
            SET
                `remind_on`='" . $oneDay . "'
            WHERE
                `id` = '" . $this->mysql_clean($id) . "'
            LIMIT 1
        ");

        return $oneDay;
    }


    public function create(array $data)
    {
        return $this->insert("
            INSERT INTO `ppSD_reminders` (
                `for`,
                `created`,
                `remind_on`,
                `user_id`,
                `user_type`,
                `title`,
                `message`
            ) VALUES (
                '" . $this->mysql_clean($this->employee) . "',
                '" . current_date() . "',
                '" . $this->mysql_clean($data['remind_on']) . "',
                '" . $this->mysql_clean($data['user_id']) . "',
                '" . $this->mysql_clean($data['user_type']) . "',
                '" . $this->mysql_clean($data['title']) . "',
                '" . $this->mysql_clean($data['message']) . "'
            )
        ");
    }

}



