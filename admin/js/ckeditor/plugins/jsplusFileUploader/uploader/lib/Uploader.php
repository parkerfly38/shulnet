<?php

class Uploader {

    protected $m_actions;
    protected $m_config;

    public function __construct($config, $actions) {
        $this->m_config = $config;
        $this->m_actions = $actions;
    }

    public function run($req) {
        $actionName = $req->action;
        $action = $this->m_actions->getAction($actionName);
		if ($action === null) {
            $action  = $this->m_actions->getActionError();
            $req = ReqError::createReqError(Message::createMessage(Message::ACTION_NOT_FOUND));
        }
		$action->setConfig($this->m_config);
		$resp = null;
		try {
            $resp = $action->run($req);
        } catch (MessageException $e) {
            $resp = new RespFail($e->getFailMessage());
        }
		return $resp;
	}

}