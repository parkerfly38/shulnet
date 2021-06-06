<?php

class MessageException extends Exception {

    protected $m_message;

    public function __construct($message) {
        $this->m_message = (array)$message;
    }

    public function getFailMessage() {
        return $this->m_message;
    }

}
