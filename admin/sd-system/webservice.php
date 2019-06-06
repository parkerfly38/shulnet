<?php
    session_start();
    
    //MySQL Settings
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'spring2014_conferences');
    define('DB_USER', 'naacos_conferenc');
    define('DB_PASS', 'KCfBK2wtyPd4HXyAywPh'); //!@#naacos0
    define('DB_PORT', 3306);
    //MySQL connection file

    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
    try {
        //shell_exec("ssh -f -L 3307:127.0.0.1:3306 developer@162.209.88.85 sleep 10 >> logfile");
        $db = new PDO($dsn, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo 'Connection error : '.$e->getMessage();
        exit;
    }

    //only one applicable get action
    if (isset($_GET["action"]))
    {
        if ($_GET["action"] == "getdocument")
        {
            if (isset($_GET["docid"]))
            {
                getDocument($_GET["docid"]);
            } else {
                header("X-PHP-Response-Code: 400", true, 400);
            }
        } else {
            header("X-PHP-Response-Code: 400", true, 400);
        }
    }

    if (isset($_POST["action"]))
    {
        $action = $_POST["action"];
        
        switch ($action)
        {
            case "login":
                if (!isset($_POST["username"]) || !isset($_POST["password"]))
                {                    
                    header("X-PHP-Response-Code: 400", true, 400);
                } else {
                    return checkLogin($_POST["username"],$_POST["password"]);
                }
                break;
            case "checksession":
                echo checkSession();
                break;
            case "logout":
                session_destroy();
                break;
            case "checkisadmin":
                echo checkIsAdmin();
                break;
            case "getusers":
                getUsers();
                break;
            case "getdocuments":
                getDocuments();
                break;
            case "deleteuser":
                if (!isset($_POST["profileID"]))
                {
                    header("X-PHP-Response-Code: 400", true, 400);
                } else {
                    deleteUser($_POST["profileID"]);
                }
                break;
            default:
                header("X-PHP-Response-Code: 400", true, 400);
        }
        
    }

    function checkSession()
    {
        if (!isset($_SESSION["profileid"]))
        {
            return "false";
        } else {
            return "true";
        }
    }

    function checkIsAdmin()
    {
        if (isset($_SESSION["isAdmin"]))
        {
            if ($_SESSION["isAdmin"] == 1)
            {
                return "true";
            } else {
                return "false";
            }
        } else {
            return "false";
        }
    }

    function deleteUser($profileID)
    {
        if (checkIsAdmin() == "false") {
            header("X-PHP-Response-Code: 401", true, 401);
            return;
        }
        // can't delete our own profileID
        if ($profileID == $_SESSION["profileid"])
        {
            header("X-PHP-Response-Code: 400", true, 400);
            return;
        }
        //first check to make sure it's not an arbitrary delete - users can only delete users in their organization
        global $db;
        $sql = "SELECT idbcapaorganization FROM bcapaOrganizationUsers WHERE profileID = '".$profileID."'";
        $getData = $db->query($sql);
        $record = $getData->fetch();
        if ($record["idbcapaOrganization"] != $_SESSION["idbcapaOrganization"])
        {
            header("X-PHP-Response-Code: 400", true, 400);
            return;
        }
        $sql = "UPDATE idbcapaorganization SET isRemoved = 1 WHERE profileID = '".$profileID."'";
        $dataexecute = $db->prepare($sql);
        $dataexecute->execute();
    }

    function getDocuments()
    {
        if (!isset($_SESSION["idbcapaOrganization"]))
        {
            header("X-PHP-Response-Code: 404", true, 400);
            return;
        }
        header('Content-Type: application/json');
        global $db;
        $countsql = "SELECT COUNT(idbcapaOrganization) as bcapaCount FROM bcapaOrganization WHERE parentidbcapaOrganization = ".$_SESSION["idbcapaOrganization"];
        $getcountData = $db->query($countsql);
        $record = $getcountData->fetch(PDO::FETCH_ASSOC);
        if ((int)$record['bcapaCount'] > 0)
        {
            $sql = "SELECT a.idbcapa, a.filedate, a.filename, a.Description, b.ACONumber, b.OrganizationName FROM bcapaUploads a 
                INNER JOIN bcapaOrganization b on a.idbcapaOrganization = b.idbcapaOrganization 
                WHERE a.idbcapaOrganization = ".$_SESSION["idbcapaOrganization"]." OR a.idbcapaOrganization IN ( SELECT idbcapaOrganization FROM bcapaOrganization WHERE parentidbcapaOrganization = ".$_SESSION["idbcapaOrganization"].") ORDER BY a.filedate desc";
        } else {
            $sql = "SELECT a.idbcapa, a.filedate, a.filename, a.Description, b.ACONumber, b.OrganizationName FROM bcapaUploads a 
                INNER JOIN bcapaOrganization b on a.idbcapaOrganization = b.idbcapaOrganization 
                WHERE a.idbcapaOrganization = ".$_SESSION["idbcapaOrganization"]. " ORDER BY a.filedate desc";
        }
        $getData = $db->query($sql);
        $records = $getData->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($records);
        echo $json;
    }

    function getDocument($idbcapa)
    {
        if (checkSession() == "false")
        {
            header("X-PHP-Response-Code: 401", true, 401);
        } else {
            global $db;
            $sql = "SELECT filename from bcapaUploads WHERE idbcapa = ".$idbcapa;
            $getData = $db->query($sql);
            $record = $getData->fetch();
            $filename = $record["filename"];

            if (file_exists("/usr/local/www/naacos.com/sub/admin/bcapauploads/".$filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize("/usr/local/www/naacos.com/sub/admin/bcapauploads/".$filename));
                readfile("/usr/local/www/naacos.com/sub/admin/bcapauploads/".$filename);
                exit;
            }
        }
    }

    function getUsers()
    {
        if (checkIsAdmin() == "false") {
            header("X-PHP-Response-Code: 401", true, 401);
            return;
        }
        if (!isset($_SESSION["idbcapaOrganization"]))
        {
            header("X-PHP-Response-Code: 404", true, 400);
            return;
        }
        header('Content-Type: application/json');
        global $db;
        $sql = "SELECT a.lastname, a.firstname, b.profileID, a.organization, b.isAdmin FROM membersClick a
        INNER JOIN bcapaOrganizationUsers b ON a.profileID = b.profileID
        WHERE b.isRemoved = 0 AND b.idbcapaOrganization = ".$_SESSION["idbcapaOrganization"];
        $getData = $db->query($sql);
        $records = $getData->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($records);
        echo $json;
    }

    function checkLogin($username, $password)
    {
        global $db;
        //returns null object or token for localStorage otherwise
        $url = 'https://naacos.memberclicks.net/oauth/v1/token';
        $data = "grant_type=password&scope=read&username=".$username."&password=".$password;

        $authorization = "Basic ".base64_encode("2ks6Ki02Eql22yLJPppa:0f824fe3c13f48f692dff7b2d66cf931");

        // Get the curl session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Uncomment the following if you want JSON - the response is XML by default
        $httpHeaders = array("ContentType: application/x-www-form-urlencoded", "Authorization: ".$authorization);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders );

        $result = curl_exec($ch);
        $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        if ($httpCode == 200)
        {
            //retrieve user details and return user object
            // Parse the json result
            $body = substr($result, $header_size);

            $jsonResult = json_decode( $body );
            $token = $jsonResult->access_token;
            curl_close($ch);
            //echo $token;
            $url = "https://naacos.memberclicks.net/api/v1/profile/me";
            $authorization = "Bearer ".$token;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $httpHeaders = array("Accept: application/json","Authorization: ".$authorization);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders );

            $result = curl_exec($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($result, $header_size);
            $jsonResult = json_decode($body);

            $profileId = $jsonResult->{"[Profile ID]"};
            $memberName = $jsonResult->{"[Name | First]"}." ".$jsonResult->{"[Name | Last]"};
            //is profile id in the list of allowed users?
            $sql = "SELECT profileID, idbcapaOrganization, COALESCE(isAdmin, 0) as isAdmin FROM bcapaOrganizationUsers WHERE profileID = '".$profileId."'";
            $getData = $db->query($sql);
            $records = $getData->rowCount();
            $rows = $getData->fetch();
            if($records > 0)
            {
                $_SESSION["profileid"] = $profileId;
                $_SESSION["idbcapaOrganization"] = $rows["idbcapaOrganization"];
                $_SESSION["isAdmin"] = $rows["isAdmin"];
                $_SESSION["memberName"] = $memberName;
                echo $memberName;
            } else {
                session_destroy();
                header("X-PHP-Response-Code: 400", true, 400);
            }
        } else {
            header("X-PHP-Response-Code: 400", true, 400);
        }
    }