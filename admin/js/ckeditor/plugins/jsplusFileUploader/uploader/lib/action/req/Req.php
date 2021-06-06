<?php

class Req {

    public $action;

    public $test_clearAllFiles;
    public $test_serverConfig;

    public $m_fileName;
    public $m_fileSize;
    public $m_file;

}

class ReqError {

    public $message;

    public static function createReqError($msg) {
        $req = new ReqError();
        $req->message = $msg;
        return $req;
    }

}

class ReqUploadId extends Req {

    public $uploadId;

}

class ReqUploadAddFile extends ReqUploadId {

    public $url;

}

class ReqUploadRemoveFile extends ReqUploadId {

    public $name;

}

class ReqUploadCommit extends ReqUploadId {

    public $sizes; // of [enlarge: boolean, width: number, height: number]
    public $doCommit;
    public $autoRename;
    public $dir;
    public $files; // of [name: string, newName: string]

}