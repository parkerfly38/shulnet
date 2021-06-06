<?php

interface IConfig {

    public function setTestConfig($testConf);

    public function getBaseDir();
    public function getTmpDir();

    public function getMaxUploadFileSize();
    public function getAllowedExtensions();
    public function getJpegQuality();

    public function getMaxImageResizeWidth();
    public function getMaxImageResizeHeight();

    public function getCrossDomainUrl();

    public function doKeepUploads();

    public function isTestAllowed();

    public function getRelocateFromHosts();

}