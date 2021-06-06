<?php

class ActionUploadInit extends AAction {

    public function getName() { return "uploadInit"; }

    public function run($req){
        $alphabeth = "abcdefghijklmnopqrstuvwxyz0123456789";
        do {
            $id = "";
            for ($i=0; $i<6; $i++) {
                $charNumber = rand(0, strlen($alphabeth)-1);
                $id .= substr($alphabeth, $charNumber, 1);
            }
            $dir = $this->m_config->getTmpDir() . "/" . $id;
        } while (file_exists($dir));

        if (!mkdir($dir))
            throw new MessageException(Message::createMessage(Message::UNABLE_TO_CREATE_UPLOAD_DIR));

		return new RespUploadInit($id, $this->m_config);
	}

}