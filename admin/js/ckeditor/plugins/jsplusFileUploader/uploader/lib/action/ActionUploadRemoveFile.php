<?php

class ActionUploadRemoveFile extends AActionUploadId {

	public function getName() {
		return "uploadRemoveFile";
	}

	public function run($req) {
		$this->validateUploadId($req);
		$file = new FileUploaded($this->m_config, $req->uploadId, $req->name, $req->name);
		$file->checkForErrors(true);

		if ($file->getErrors()->size() > 0)
            throw new MessageException(Message::createMessageByFile(Message::UNABLE_TO_DELETE_UPLOAD_DIR, $file->getData()));

		$file->delete();
		return new RespOk();
	}

}
