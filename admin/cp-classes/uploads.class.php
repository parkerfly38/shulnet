<?php
class uploads extends db
{


    public function add_to_db($saveName, $realName, $extension, $userId, $userType = 'member', $path = '', $label = '', $desc = '', $public = false)
    {
        if ($public) {
            $cp_only = '0';
        } else {
            $cp_only = '1';
        }

        return $this->insert("
            INSERT INTO ppSD_uploads (
                `id`,
                `item_id`,
                `type`,
                `filename`,
                `name`,
                `description`,
                `date`,
                `label`,
                `cp_only`
            ) VALUES (
                '" . $this->mysql_clean($saveName) . "',
                '" . $this->mysql_clean($userId) . "',
                '" . $this->mysql_clean($userType) . "',
                '" . $this->mysql_clean($path) . "',
                '" . $this->mysql_clean($realName) . "',
                '" . $this->mysql_clean($desc) . "',
                '" . current_date() . "',
                '" . $this->mysql_clean($label) . "',
                '" . $this->mysql_clean($cp_only) . "'
            )
        ");
    }

    /**
     * Get all uploads.

     */
    function get_uploads($id, $order = 'date', $dir = 'DESC')
    {
        // Files
        $profile_picture    = '';
        $profile_picture_id = '';
        $all_uploads        = array();
        $return             = array();
        $STH                = $this->run_query("
			SELECT *
			FROM `ppSD_uploads`
			WHERE `item_id`='" . $this->mysql_clean($id) . "'
			ORDER BY `" . $this->mysql_clean($order) . "` " . $this->mysql_clean($dir) . "
		");
        while ($row = $STH->fetch()) {
            if ($row['label'] == 'profile-picture') {
                $profile_picture    = $row['filename'];
                $profile_picture_id = $row['id'];
            }
            $all_uploads[] = $row;
        }
        $return['profile_picture_id'] = $profile_picture_id;
        $return['profile_picture']    = $profile_picture;
        $return['uploads']            = $all_uploads;
        return $return;
    }


    function get_file_label($id)
    {
        $q1 = $this->get_array("
			SELECT `label`
			FROM `ppSD_uploads`
			WHERE `id`='" . $this->mysql_clean($id) . "'
			LIMIT 1
		");
        return $q1['label'];
    }

    /**
     * Get an upload.

     */
    function get_upload($id)
    {
        $q1                   = $this->get_array("
			SELECT * FROM `ppSD_uploads`
			WHERE `id`='" . $this->mysql_clean($id) . "'
			LIMIT 1
		");
        $path                 = PP_PATH . '/custom/uploads/' . $q1['filename'];
        $url                  = PP_URL . '/custom/uploads/' . $q1['filename'];
        $safe_url             = PP_URL . '/pp-functions/download.php?id=' . $q1['id'];
        $size                 = @filesize($path);
        $q1['filesize_bytes'] = $size;
        $q1['filesize']       = format_bytes($size);
        $q1['ext']            = $this->get_ext($q1['filename']);
        $q1['format_date']    = format_date($q1['date']);
        //if ($q1['item_id'] == 'zen_public') {
        $q1['url']            = $safe_url;
        //} else {
        //    $q1['url']            = $url;
        //}
        return $q1;

    }

    /**
     * Get an upload ID by filename
     *
     * @param $filename
     */
    function get_upload_id($filename)
    {
        $q1 = $this->get_array("

            SELECT `id`

            FROM `ppSD_uploads`

            WHERE `filename`='" . $this->mysql_clean($filename) . "'

            LIMIT 1

        ");

        return $q1['id'];

    }

}



