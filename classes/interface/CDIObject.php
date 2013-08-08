<?php

class CDIObject {
  
  private $identifier;
  private $data;
  
  public function __construct(CDIIdentifierInterface $identifier, $data) {
    $this->identifier = $identifier;
    $this->data = $data;
  }
  
  public function id() {
    return $this->identifier;
  }
  
  public function data() {
    return $this->data;
  }
  
  public function __call($method, $args) {
    $controller = CDIObject::findController($this->identifier->datatype(), $method, CDIBaseController::SCOPE_OBJECT);
    $controller->setDataObject($this);
    return call_user_func_array(array($controller, $method), $args);
  }
  
  protected static function findController($datatype, $method, $scope) {
    $registry = new CDIRegistry();
    $controller = $registry->resolveController($datatype, $method, $scope);
    if (empty($controller)) {
      throw new CDIException(CDIException::NO_CONTROLLER_CLASS,
          'Unable to find a controller to handle the callback for datatype @type
            and method @method', array(
              '@type' => $datatype,
              '@method' => $method,
            ));
    } 
    else {
      return $controller;
    }
  }
  
  public static function __callStatic($method, $args) {
    $type = array_shift($args);
    $dtype = CDIObject::retrieveDataType($type);
    if (is_string($type)) {
      $controller = CDIObject::findController($datatype, $method, CDIBaseController::SCOPE_DATATYPE);
      $controller->setDataType($type);
    } 
    else {
      $controller = CDIObject::findController($datatype, $method, CDIBaseController::SCOPE_IDENTIFIER);
      $controller->setIdentifier($type);
    }
    return call_user_func_array(array($controller, $method), $args);
  }
  
  private static function retrieveDataType($type) {
    if (is_string($type)) {
      return $type;
    } 
    elseif (is_object($type) && ($type instanceof CDIIdentifierInterface)) {
      return $type->datatype();
    }
    else {
      throw new CDIException(CDIException::NO_DATATYPE, 
          'You must provide a datatype or an identifier as the first argument to
            a static callback');
    } 
  }
  
}