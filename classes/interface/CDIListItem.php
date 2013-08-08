<?php

class CDIListItem {
  
  private $uuid;
  private $label;
  private $key;
  
  public function __construct(CDIIdentifierInterface $uuid, $label, $key = NULL) {
    $this->uuid = $uuid;
    $this->label = $label;
    if (empty($key)) {
      $key = serialize($uuid->rawData());
    }
    $this->key = $key;
  }
  
  public function uuid() {
    return $this->uuid;
  }
  
  public function key() {
    return $this->key;
  }
  
  public function label() {
    return $this->label;
  }
  
}