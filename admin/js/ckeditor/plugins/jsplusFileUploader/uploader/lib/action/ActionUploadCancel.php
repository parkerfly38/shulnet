<?php

class ActionUploadCancel extends AActionUploadId {

	public function getName() {
		return "uploadCancel";
	}

	public function run($req) {
		$this->validateUploadId($req);
		if (!$this->m_config->doKeepUploads()) {
            try {
                UtilsPHP::delete($this->m_config->getTmpDir() . "/" . $req->uploadId);
            } catch (Exception $e) {
                error_log($e);
                throw new MessageException(Message::createMessage(Message::UNABLE_TO_DELETE_UPLOAD_DIR));
            }
		}
		return new RespOk();
	}

}