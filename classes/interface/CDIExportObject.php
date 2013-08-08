<?php

class CDIExportObject {
  
  private $uuid = NULL;
  private $exportData = NULL;
  
  public function __construct(CDIIdentifier $uuid, $exportData) {
    $this->uuid = $uuid;
    $this->exportData = $exportData;
  }
  
  public function uuid() {
    return $this->uuid;
  }
  
  public function exportData() {
    return $this->exportData;
  }
  
  public function export() {
    return serialize(array(
      'uuid' => $this->uuid->export(),
      'raw' => $this->exportData,
    ));
  }
  
  public static function rebuild($exportString) {
    $exportArray = unserialize($exportString);
    return new CDIExportObject($exportArray['uuid'], $exportArray['raw']);
  }
  
}