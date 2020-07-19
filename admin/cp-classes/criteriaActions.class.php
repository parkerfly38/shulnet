<?php

class criteriaActions extends db {


    protected $scope = 'member';

    protected $actionData = array();

    protected $actions = array();

    protected $userIds = array();

    protected $fields;

    protected $actionFile;

    public $criteria;

    protected $id;



    public function __construct($scope = 'member')
    {
        $this->fields = new adminFields();

        $this->criteria = new criteria();

        $this->setScope($scope);
    }


    public function setScope($scope)
    {
        $check = strtolower($scope);

        switch($check) {
            case 'member':
            case 'contact':
                $this->scope = $check;
                break;
            default:
                $this->scope = 'member';
        }

        return $this;
    }


    public function setId($act)
    {
        $this->id = $act;

        return $this;
    }


    public function getActionFile()
    {
        return PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope . '/' . $this->id . '/action.php';
    }


    public function checkValidAction($id)
    {
        $this->id = $id;

        //$file = PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope . '/' . $id . '/input.php';
        $this->actionFile = PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope . '/' . $id . '/action.php';
        $file2 = PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope . '/' . $id . '/info.json';

        if (! file_exists($this->actionFile) || ! file_exists($file2)) {
            return false;
        } else {
            return true;
        }
    }


    public function getList()
    {
        $this->actions = array();

        $path = PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope;

        $dir = scandir($path);

        foreach ($dir as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            } else {
                if (is_dir($path . '/' . $file) && file_exists($path . '/' . $file . '/info.json')) {
                    $this->actions[] = $this->getInfo($file);
                }
            }
        }

        return $this->actions;
    }


    public function getInfo($id = '')
    {
        $id = (! empty($this->id)) ? $this->id : $id;

        $path = PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope . '/' . $id . '/info.json';

        if (file_exists($path)) {
            $this->actionData = json_decode(file_get_contents($path));

            return $this->actionData;
        }

        return null;
    }


    public function setCriteria($id)
    {
        $this->criteria->setId($id);

        return $this;
    }


    public function getUserIds()
    {
        $query = $this->criteria->getQuery();

        $run = $this->run_query($query);

        while ($item = $run->fetch()) {
            $this->userIds[] = $item['id'];
        }

        return $this->userIds;
    }


    public function renderFields($id = '')
    {
        // Custom form?
        $path = PP_PATH . '/admin/cp-includes/popups/criteria_actions/' . $this->scope . '/' . $id . '/form.php';

        if (file_exists($path)) {
            ob_start();
            include $path;
            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        }

        // Standard form rendering
        $id = (! empty($this->id)) ? $this->id : $id;

        if (empty($this->actionData)) {
            $data = $this->getInfo($id);
        } else {
            $data = $this->actionData;
        }

        $fields = '';

        foreach ($data->input as $aField) {
            $gen = $this->fields;

            $gen->setLabel($aField->label);

            if (! empty($aField->options)) {
                $gen->setSelectOptions((array)$aField->options);
            }

            if (! empty($aField->filterType)) {
                $gen->setFilter($aField->filterType);
            }

            if (! empty($aField->placeholder)) {
                $gen->setPlaceholder($aField->placeholder);
            }

            if (! empty($aField->description)) {
                $gen->setDescription($aField->description);
            }

            $fields .= $gen->{$aField->type}('data[' . $aField->name . ']', $aField->value, $aField->class);
        }

        return $fields;
    }

}