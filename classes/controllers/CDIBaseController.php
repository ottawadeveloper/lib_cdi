<?php

abstract class CDIBaseController implements CDIControllerInterface {
  
  const SCOPE_NONE = 10;
  const SCOPE_DATATYPE = 20;
  const SCOPE_IDENTIFIER = 30;
  const SCOPE_OBJECT = 40;
  
  private $dataObject;
  private $identifier;
  private $datatype;
  
  private $scope = CDIBaseController::SCOPE_NONE;
  
  private $dtypes = array();
  private $methods = array();
  
  public function __construct($dtypes, $methods) {
    if (!is_array($dtypes)) {
      $dtypes = array($dtypes);
    }
    $this->dtypes = $dtypes;
    if (!is_array($methods)) {
      $methods = array($methods);
    }
    $this->methods = $methods;
  }
  
  public function supports($dtype, $method, $scope) {
    if (!in_array($dtype, $this->dtypes)) {
      return FALSE;
    }
    if (!isset($this->methods[$method])) {
      return FALSE;
    }
    if ($this->methods[$method] > $scope) {
      return FALSE;
    }
    return TRUE;
  }
  
  protected function object() {
    return $this->dataObject;
  }
  
  protected function identifier() {
    return $this->identifier;
  }
  
  protected function datatype() {
    return $this->datatype;
  }
  
  protected function executionScope() {
    return $this->scope;
  }
  
  public function setDataObject(CDIObject $object) {
    $this->dataObject = $object;
    $this->setIdentifier($object->id());
    $this->datatype = CDIBaseController::SCOPE_OBJECT;
  }
  
  public function setIdentifier(CDIIdentifierInterface $identifier) {
    $this->identifier = $identifier;
    $this->setDataType($identifier->datatype());
    $this->datatype = CDIBaseController::SCOPE_IDENTIFIER;
  }
  
  public function setDataType($datatype) {
    $this->datatype = $datatype;
    $this->scope = CDIBaseController::SCOPE_DATATYPE;
  }
  
  public function minScope($scope) {
    return $this->executionScope() >= $scope;
  }
  
  public function maxScope($scope) {
    return $this->executionScope() <= $scope;
  }
  
  public function checkScope($scope) {
    return $this->executionScope() == $scope;
  }
  
  public function __call($method, $arguments) {
    throw new CDIException(CDIException::UNSUPPORTED_METHOD, 
        'Method @method is not available on this class.');
  }
  
}
