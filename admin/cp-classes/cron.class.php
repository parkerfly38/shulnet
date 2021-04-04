<?php


class cron extends db {

    private $alerts = 0;

    private $alertLog = array();

    private $start, $end;


    public function __construct()
    {
        $this->start = microtime(true);
    }


    public function end()
    {
        $this->end = microtime(true);

        $time = $this->end - $this->start;

        $this->update_option('cron_last_run', current_date());

        $this->update_option('cron_time', $time);

        if ($this->alerts > 0) {
            $this->update_option('cron_alerts', $this->alerts);

            foreach ($this->alertLog as $item) {
                $this->add_history('error', '2', '', '4', '', $item);
            }
        } else {
            $this->update_option('cron_alerts', '0');
        }
    }


    public function alert($alert)
    {
        $this->alerts++;

        $this->alertLog[] = $alert;
    }

}