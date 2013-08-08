<?php

class CDIFieldsController extends CDIBaseController {
  
  public function __construct() {
    parent::__construct('field', array(
      'uuid' => CDIBaseController::SCOPE_DATATYPE, 
      'id' => CDIBaseController::SCOPE_DATATYPE,
      'listAll' => CDIBaseController::SCOPE_DATATYPE,
      'import' => CDIBaseController::SCOPE_DATATYPE, 
      'validate' => CDIBaseController::DATATYPE,
      'export' => CDIBaseController::SCOPE_IDENTIFIER, 
      'load' => CDIBaseController::SCOPE_IDENTIFIER,
      'save' => CDIBaseController::SCOPE_OBJECT,
    ));
  }
  
  public function validate($data) {
    if (empty($data['field_name'])) {
      return FALSE;
    }
    if (empty($data['type'])) {
      return FALSE;
    }
    return TRUE;
  }
  
  public function listAll() {
    $results = new CDIList();
    $fields = field_info_field_map();
    foreach ($fields as $field) {
      $item = new CDIListItem($this->uuid($field['field_name']), $field['field_name'], $field['field_name']);
      $results->addItem($item);
    }
    $results->sort();
    return $results;
  }
  
  public function export() {
    $object = $this->load();
    $field = $object->data();
    unset($field['id']);
    return new CDIExportObject($this->uuid(), $field);
  }
  
  public function import(CDIExportObject $exportObject) {
    CDIObject::save($exportObject->uuid(), $exportObject->exportData());
  }
  
  public function load() {
    if ($this->checkScope(CDIBaseController::SCOPE_OBJECT)) {
      return $this->object();
    }
    else {
      $data = field_info_field($this->identifier()->rawID());
      if (!empty($data)) {
        return new CDIObject($this->identifier(), $data);
      }
    }
    return NULL;
  }
  
  public function save() {
    $existing = $this->load();
    if ($existing) {
      field_update_field($this->object()->data());
    } else {
      field_create_field($this->object()->data());
    }
    return $this->object();
  }
  
  public function id($field_name = NULL) {
    return $this->createID(CDIIdentifierInterface::MODE_LOCAL, $field_name);
  }
  
  public function uuid($field_name = NULL) {
    return $this->createID(CDIIdentifierInterface::MODE_UNIVERSAL, $field_name);
  }
  
  private function createID($type = CDIIdentifierInterface::MODE_LOCAL, $field_name = NULL) {
    if ($this->maxScope(CDIBaseController::SCOPE_IDENTIFIER)) {
      if (empty($field_name)) {
        return NULL;
      }
    }
    else {
      $field_name = $this->identifier()->rawID();
    }
    return new CDIIdentifier('field', $field_name, $type);
  }
  
}