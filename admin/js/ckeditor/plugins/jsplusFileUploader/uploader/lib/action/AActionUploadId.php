<?php

abstract class AActionUploadId extends AAction {

    protected function validateUploadId($req) {
        if ($req->uploadId === null)
            throw new MessageException(Message::createMessage(Message::UPLOAD_ID_NOT_SET));

        $dir = $this->m_config->getTmpDir() . "/" . $req->uploadId;
        if (!file_exists($dir) || !is_dir($dir))
            throw new MessageException(Message::createMessage(Message::UPLOAD_ID_INCORRECT));
    }

}
