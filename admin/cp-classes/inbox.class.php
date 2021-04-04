<?php
class inbox
{

    // imap server connection
    public $conn;

    public $error;

    public $error_details;

    public $inbox;

    private $msg_cnt;

    private $server;

    private $user;

    private $pass;

    private $port;

    // connect to the server and get the inbox emails
    function __construct($server = '', $username = '', $password = '', $port = '110')
    {
        if (!empty($server) && !empty($username) && !empty($password) && !empty($port)) {
            $this->server = $server;
            $this->user   = $username;
            $this->pass   = $password;
            $this->port   = $port;
            $this->connect();
            $this->inbox();

        } else {
            $this->error         = '1';
            $this->error_details = 'Insufficient login credentials.';

        }

    }

    // open the server connection
    // the imap_open function parameters will need to be changed for the particular server
    // these are laid out to connect to a Dreamhost IMAP server
    function connect()
    {
        if ($this->conn = @imap_open('{' . $this->server . ':' . $this->port . '/pop3/novalidate-cert}INBOX', $this->user, $this->pass)) {
            $this->error         = '0';
            $this->error_details = '';

        } else {
            $this->error         = '1';
            $this->error_details = 'Could not connect to the mail inbox.';

        }

    }

    // close the server connection
    function close()
    {
        $this->inbox   = array();
        $this->msg_cnt = 0;
        @imap_expunge($this->conn);
        @imap_close($this->conn);

    }

    // move the message to a new folder
    function move($msg_index, $folder = 'INBOX.Processed')
    {
        @imap_mail_move($this->conn, $msg_index, $folder);
        @imap_expunge($this->conn);
        $this->inbox();

    }

    // get a specific message (1 = first email, 2 = second email, etc.)
    function get($msg_index = NULL)
    {
        if (count($this->inbox) <= 0) {
            return array();

        } elseif (!is_null($msg_index) && isset($this->inbox[$msg_index])) {
            return $this->inbox[$msg_index];

        }

        return $this->inbox[0];

    }

    // read the inbox
    function inbox()
    {
        $this->msg_cnt = @imap_num_msg($this->conn);
        $in            = array();
        for ($i = 1; $i <= $this->msg_cnt; $i++) {
            $in[] = array(
                'index'     => $i,
                'header'    => @imap_headerinfo($this->conn, $i),
                'body'      => @imap_body($this->conn, $i),
                'structure' => @imap_fetchstructure($this->conn, $i)
            );
            @imap_delete($this->conn, $i);

        }
        $this->inbox = $in;

    }

}