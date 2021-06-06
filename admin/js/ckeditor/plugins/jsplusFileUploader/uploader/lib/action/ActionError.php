<?php

class ActionError extends AAction {

    public function getName() { return "error"; }

	public function run($req) {
		return new RespFail($req->message);
	}

}