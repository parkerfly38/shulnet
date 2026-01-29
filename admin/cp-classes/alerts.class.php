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
                `for` = ? AND
                `remind_on` = ? AND
                `seen` != '1'
        ", [$this->employee, date('Y-m-d')]);

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
            WHERE `id`=?
            LIMIT 1
        ", [$id]);
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
                `seen_on` = ?
            WHERE
                `id` = ?
            LIMIT 1
        ", [current_date(), $id]);
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
                `remind_on`=?
            WHERE
                `id` = ?
            LIMIT 1
        ", [$oneDay, $id]);

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
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ", [
            $this->employee,
            current_date(),
            $data['remind_on'],
            $data['user_id'],
            $data['user_type'],
            $data['title'],
            $data['message']
        ]);
    }

}



