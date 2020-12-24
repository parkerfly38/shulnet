<?php

class modrewrite extends db
{

    private $path;

    private $folder_id;

    private $file;

    private $server;

    public $error;

    public $error_details;

    /**
     * @param string $url_string Sent to index.php as GET:in
     */
    function __construct($path, $id)
    {
        $this->path      = $path;
        $this->folder_id = $id;
        $this->determine_conflict();
        $this->determine_server();

    }

    function determine_conflict()
    {
        $check = $this->path . '/.htaccess';
        if (file_exists($check)) {
            $this->error         = '1';
            $this->error_details = 'There is already a ".htaccess" file in this directory. This may cause errors with another program. For that reason, we have not proceeded to secure the folder. Please resolve the conflict before continuing.';

        }

    }

    /**
     * Secure a folder using
     * mod_rewrite

     */
    function determine_server()
    {
        if ($this->error != '1') {
            if (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {
                $this->server = 'Apache';
                $this->secure_apache();

            } else if (strpos($_SERVER['SERVER_SOFTWARE'], 'IIS') !== false) {
                $this->server = 'IIS';
                $this->secure_iis();

            } else {
                $this->server        = '';
                $this->error         = '1';
                $this->error_details = 'Unsupported Server.';

            }

        }

    }

    /**
     * Secure a folder using
     * mod_rewrite

     */
    function secure_apache()
    {
        // Prepare some paths and URLs
        $sessions        = PP_PATH . '/custom/sessions';
        $https_login_url = PP_URL . '/login.php?code=L027&r=%{HTTP_HOST}%{REQUEST_URI}?%{QUERY_STRING}';
        //$https_login_url = str_replace('http://', 'https://', $https_login_url);
        $https_login_url = $this->getSecureLink(true, $https_login_url);

        $http_login_url  = PP_URL . '/login.php?code=L027&r=%{HTTP_HOST}%{REQUEST_URI}?%{QUERY_STRING}';
        //$http_login_url  = str_replace('https://', 'http://', $http_login_url);
        $http_login_url = $this->getSecureLink(true, $http_login_url);

        // Prepare the file.
        $this->file = "# --------------------------------------------------------\n";
        $this->file .= "#   This folder is secured by ShulNET.\n";
        $this->file .= "#   Last updated on " . current_date() . "\n";
        $this->file .= "#   Please do not edit or remove this file!\n\n";
        $this->file .= "<IfModule mod_rewrite.c>\n\n";
        $this->file .= "  RewriteEngine On\n";
        $this->file .= "  BrowserMatch \"MSIE\" force-no-vary\n";
        $this->file .= "  RewriteCond %{HTTP_COOKIE} zenseshold=([a-zA-Z0-9]+)\n";
        $this->file .= "  RewriteCond " . $sessions . "/%1," . $this->folder_id . " -f\n";
        $this->file .= "  RewriteRule ^(.*)$ - [L]\n";
        $this->file .= "  RewriteCond %{HTTPS} on\n";
        $this->file .= "  RewriteRule ^(.*)$ " . $https_login_url . " [L,R]\n";
        $this->file .= "  RewriteRule ^(.*)$ " . $http_login_url . " [L,R]\n\n";
        $this->file .= "</IfModule>\n";
        // Write the file.
        $this->write_file($this->path, '.htaccess', $this->file);

    }

    /**
     * Secure a folder using
     * whatever crap IIS has.

     */
    function secure_iis()
    {

    }

}