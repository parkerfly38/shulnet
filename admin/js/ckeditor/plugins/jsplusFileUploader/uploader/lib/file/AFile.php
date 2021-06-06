<?php

abstract class AFile {

    protected $m_config;

    private $m_name = null;
    private $m_dir = null;

    protected $m_commonErrors = [];

    public function __construct($config, $dir, $name) {
        $this->m_config = $config;
        $this->m_dir = $dir;
        $this->m_name = $name;
    }

    public function getData() {
        $data = new FileData();
		$data->isCommited = $this->isCommited();
		$data->name = $this->getName();
		$data->dir = $this->getDir();
		$data->bytes = $this->getSize();
        $errors = $this->getErrors();
		$data->errors = [];
		for ($i=0; $i<count($errors); $i++)
		    $data->errors[] = (array)$errors[$i];

		$data->isImage = $this->isImage();
        $data->sizes = [];
		if ($data->isImage) {
            $data->width = $this->getImageWidth();
            $data->height = $this->getImageHeight();
            if ($data->isCommited) {
				if ($this->m_mainFile === null) { // m_mainFile is property of FileCommited
                    $modifications = $this->getModifications();
					for ($i=0; $i<count($modifications); $i++)
						$data->sizes[$modifications[$i]->getModificationName()] = $modifications[$i]->getData();
				}
			}
        }
		return $data;
	}

	public function getModifications() { return []; }
	public function getModificationName() { return null; }

	public function getSize() {
        $path = $this->getFullPath();
        if (file_exists($path))
            return filesize($path);
		return 0;
	}

	public function getErrors() {
		return $this->m_commonErrors;
	}

	// Returns do we need to continue check or not
	public function checkForErrors($checkForExist) {
        $this->m_commonErrors = [];

        if (!Utils::isFileNameSyntaxOk($this->getName())) {
            $this->m_commonErrors[] = Message::createMessage(Message::FILE_ERROR_SYNTAX, $this->getName());
            return false; // do not do any other checks by security reasons
        }

        if ($checkForExist && !$this->exists())
            $this->m_commonErrors[] = Message::createMessage(Message::FILE_ERROR_DOES_NOT_EXIST);

        return true;
    }

	public function setName($name) { $this->m_name = $name; }
	public function setDir($dir) { $this->m_dir = $dir; }

	public abstract function isCommited();
	public abstract function getBaseDir();

	public function getName() { return $this->m_name; }
	public function getDir() {
		if (strlen($this->m_dir) != 0 && substr($this->m_dir, strlen($this->m_dir)-1) !== "/")
            return $this->m_dir . "/";
		return $this->m_dir;
	}
	public function getPath() { return $this->getDir() . $this->getName(); }
	public function getFullPath() { return $this->getBaseDir() . "/" . $this->getPath(); }
	public function getExt() {
		return Utils::getExt($this->m_name);
	}

	public function getNameWithoutExt() {
        $ext = $this->getExt();
		if ($ext === null)
            return $this->m_name;
		return substr($this->m_name, 0, strlen($this->m_name) - strlen($ext) - 1);
	}

	public function exists() {
	    return file_exists($this->getFullPath());
	}

	public function delete() {
	    if (!unlink($this->getFullPath()))
            throw new MessageException(Message::createMessage(Message::UNABLE_TO_DELETE_FILE, $this->getName()));
}

	public function isImage() {
		return Utils::isImage($this->getName());
	}

	public function getImageWidth() {
	    if ($size = @getimagesize($this->getFullPath()))
            return $size === null ? -1 : $size[0];
	    else
            throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }

	public function getImageHeight() {
        if ($size = @getimagesize($this->getFullPath()))
            return $size === null ? -1 : $size[1];
        else
            throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }

	public function getImage() {
	    $path = $this->getFullPath();
	    $image = null;
        switch (strtolower($this->getExt())) {
            case 'gif':  $image = @imagecreatefromgif($path);  break;
            case 'jpeg':
            case 'jpg':  $image = @imagecreatefromjpeg($path); break;
            case 'png':  $image = @imagecreatefrompng($path);  break;
            case 'bmp':  $image = @imagecreatefromwbmp($path); break;
        }
        if (!$image)
            throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
        imagesavealpha($image, TRUE);
        return $image;
	}

	protected function setFreeFileName() {
	    $name = Utils::getFreeFileName($this->getBaseDir() . $this->getDir(), $this->getName(), false);
		$this->setName($name);
	}

	public function copyTo($dstFile){
        try {
            UtilsPHP::copyFile($this->getFullPath(), $dstFile->getFullPath());
        } catch (Exception $e) {
            error_log($e);
            throw new MessageException(Message::createMessage(Message::UNABLE_TO_COPY_FILE, $this->getName(), $dstFile->getName()));
        }
	}

}
