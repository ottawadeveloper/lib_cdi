<?php

class CDIException extends Exception {
  
  const INVALID_CONTROLLER_CLASS = 2;
  const NO_DATATYPE = 3;
  const UNSUPPORTED_METHOD = 4;
  
  private $messageArgs = array();
  
  public function __construct($code, $message, $args = array(), $previous = NULL) {
    parent::__construct($message, $code, $previous);
    $this->messageArgs = $args;
  }
  
  public function getMessageArgs() {
    return $this->messageArgs;
  }
  
  public function translatedException() {
    return t($this->getMessage(), $this->getMessageArgs());
  }
  
  public function dsm($type = 'error') {
    drupal_set_message($this->translatedException(), $type);
  }
  
  public function watchdog() {
    watchdog_exception('cdi_exception', $this, $this->getMessage(), $this->getMessageArgs());
  }
  
}