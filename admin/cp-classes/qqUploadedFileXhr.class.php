<?php





/**
 * Handle file uploads via XMLHttpRequest

 */
class qqUploadedFileXhr extends db
{

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path)
    {
        // Direct read from php://input - more reliable than stream copying
        $input = file_get_contents("php://input");
        
        if ($input === false) {
            return false;
        }
        
        $actualSize = strlen($input);
        $expectedSize = $this->getSize();
        
        // Allow for small size differences that can occur due to encoding/buffering
        // but still catch major issues
        if ($actualSize == 0 || abs($actualSize - $expectedSize) > 1024) {
            return false;
        }
        
        // Write directly to the target file
        $result = file_put_contents($path, $input, LOCK_EX);
        
        return ($result !== false);
    }

    function getName()
    {
        return $_GET['qqfile'];

    }

    function getSize()
    {
        /*

        if (isset($_SERVER["CONTENT_LENGTH"])){

            return (int)$_SERVER["CONTENT_LENGTH"];

        } else {

            throw new Exception('Getting content length is not supported.');

        }

        */
        if (isset($_SERVER["CONTENT_LENGTH"]) || isset($_SERVER['HTTP_CONTENT_LENGTH'])) {
            if (isset($_SERVER['HTTP_CONTENT_LENGTH']))
                return (int)$_SERVER["HTTP_CONTENT_LENGTH"];
            else

                return (int)$_SERVER["CONTENT_LENGTH"];

        } else {
            die("{'error':'Getting content length is not supported.'}");

        }

    }

}