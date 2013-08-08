<?php

class CDIVariableStorageRegistry implements CDIRegistryStorageInterface {
  
  private $information = array();
  private $name = '';
  
  public function __construct($registryName) {
    $this->name = $registryName;
    $this->loadRegistry();
  }
  
  public function wipeRegistry() {
    $this->information = array();
  }
  
  public function addEntry($key, $data) {
    $this->information[$key] = $data;
    return $this;
  }
  
  public function getEntry($key) {
    if (!isset($this->information[$key])) {
      return NULL;
    }
    return $this->information[$key];
  }
  
  public function getEntries() {
    return $this->information;
  }
  
  public function clearEntry($key) {
    unset($this->information[$key]);
    return $this;
  }
  
  public function saveRegistry() {
    variable_set('cdi_registry_' . $this->name, $this->information);
  }
  
  public function loadRegistry() {
    $this->information = variable_get('cdi_registry_' . $this->name, array());
  }
  
  public function sortRegistry($callback) {
    uasort($this->information, $callback);
  }
  
}
