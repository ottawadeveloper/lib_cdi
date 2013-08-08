<?php

class CDIIdentifier implements CDIIdentifierInterface {
  
  private $dtype;
  private $identifier;
  private $mode;
  
  public function __construct($dtype, $identifier, $mode = CDIIdentifierInterface::MODE_LOCAL) {
    $this->dtype = $dtype;
    $this->identifier = $identifier;
    $this->mode = $mode;
  }
  
  public function datatype() {
    return $this->dtype;
  }
  
  public function mode() {
    return $this->mode;
  }
  
  public function rawID() {
    return $this->identifier;
  }
  
  public function export() {
    return array(
      'type' => $this->dtype,
      'mode' => $this->mode,
      'id' => $this->identifier,
    );
  }
  
  public static function rebuild($exportArray) {
    return new CDIIdentifier($exportAray['type'], $exportArray['id'], $exportArray['mode']);
  }
  
}
