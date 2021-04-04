<?php

abstract class pluginAdminTools extends db {


    protected $package = array();

    protected $plugin;

    protected $plugin_id;

    protected $plugin_path;


    /**
     * @return mixed
     */
    abstract function getPluginId();


    /**
     *
     */
    public function __construct()
    {
        $this->plugin_id = $this->getPluginId();

        $this->plugin_path = PP_PATH . '/custom/plugins/' . $this->plugin_id;

        $this->package = include $this->plugin_path . '/admin/package.php';

        $this->plugin = new plugin($this->plugin_id);
    }



    /**
     * Validates form data.
     *
     * @param $data
     * @param array $rules
     * @param string $type
     */
    public function validate($data, $rules = array(), $type = 'new')
    {
        if ($type == 'edit') {
            $options = array(
                'skip_default' => '1',
                'edit' => '1',
            );
        } else {
            $options = array(
                'skip_default' => '0',
                'edit' => '0',
            );
        }

        return new ValidatorV2($data, $rules, $options);
    }


    /**
     * @param $table
     * @param array $data
     *
     * @return string
     */
    public function save($table, array $data)
    {
        $desc_cols = $this->get_array("DESCRIBE `" . $table . "`", "0", "2");

        $vals = array(
            'keys' => array(),
            'values' => array(),
        );

        foreach ($data as $key => $value) {
            if (! in_array($key, $desc_cols))
                continue;

            $vals['keys'][] = $key;
            $vals['values'][] = $this->mysql_cleans($value);
        }

        return $this->insert("
            INSERT INTO `$table` (
              `" . implode('`,`', $vals['keys']) . "`
            ) VALUES (
              '" . implode("','", $vals['values']) . "'
            )
        ");
    }


    /**
     * @param $language
     */
    public function throwAjaxError($language)
    {
        echo "0+++" . $language;
        exit;
    }

}