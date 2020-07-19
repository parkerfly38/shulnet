<?php


class formv2 extends db {

    protected $form;
    protected $formData = array();


    public function setForm($id)
    {
        $this->formData = $this->getFormData($id);

        if (! empty($this->formData['id'])) {
            $this->form = $id;
        }

        return $this;
    }


    public function getFormData($id)
    {
        $this->formData = $this->get_array("
            SELECT *
            FROM ppSD_forms
            WHERE `id`='" . $this->mysql_clean($id) . "'
        ");

        return $this->formData;
    }


    public function getFormFields($id)
    {
        // Fieldsets
    }

}