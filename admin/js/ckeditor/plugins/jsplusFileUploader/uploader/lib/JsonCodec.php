<?php

class JsonCodec {

    protected $m_actions;

    public function __construct($actions) {
        $this->m_actions = $actions;
    }

    public function fromJson($json) {
        $jsonObj = json_decode($json, false);
        if ($jsonObj === null)
            throw new Exception('Unable to parse JSON');
        if (!array_key_exists('action', $jsonObj))
            throw new Exception('"Unable to detect action in JSON"');
        $action = $this->m_actions->getAction($jsonObj->action);
        if ($action === null)
            throw new Exception("JSON action is incorrect: " . $action);
        return $jsonObj;
    }

    public function toJson($resp) {
        $json = json_encode($resp);
        $json = str_replace('\\u0000*\\u0000', '', $json);
        $json = str_replace('\\u0000', '', $json);
        return $json;
    }

}
