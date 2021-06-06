<?php

require 'lib/action/req/Req.php';

require 'lib/action/resp/FileData.php';
require 'lib/action/resp/Message.php';
require 'lib/action/resp/Resp.php';

require 'lib/action/AAction.php';
require 'lib/action/AActionUploadId.php';
require 'lib/action/ActionError.php';
require 'lib/action/ActionUploadAddFile.php';
require 'lib/action/ActionUploadCancel.php';
require 'lib/action/ActionUploadCommit.php';
require 'lib/action/ActionUploadInit.php';
require 'lib/action/ActionUploadRemoveFile.php';

require 'lib/config/IConfig.php';

require 'lib/file/Utils.php';
require 'lib/file/UtilsPHP.php';
require 'lib/file/URLDownloader.php';
require 'lib/file/AFile.php';
require 'lib/file/FileUploaded.php';
require 'lib/file/FileCommited.php';

require "servlet/UploaderServlet.php";
require 'servlet/ServletConfig.php';

require 'lib/Actions.php';
require 'lib/JsonCodec.php';
require 'lib/MessageException.php';
require 'lib/Uploader.php';

require "config.php";

define('ROOTPATH', dirname(__FILE__));
error_reporting(E_ALL);
ini_set("display_errors", 0);

try {
    $servlet = new UploaderServlet();
    $servlet->init($config);
    $servlet->doPost($_POST, $_FILES);
} catch (Exception $e) {
    error_log($e);
    throw $e;
}
