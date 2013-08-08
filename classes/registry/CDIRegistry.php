<?php

class CDIRegistry implements CDIRegistryInterface {
  
  private $controllers = array();
  
  public function __construct() {
    $this->controllers = new CDIVariableStorageRegistry('cdi_controllers');
  }
  
  private function validateControllerClass($class) {
    if (!class_exists($class)) {
      throw new CDIException(CDIException::INVALID_CONTROLLER_CLASS, 
          'Could not find controller class');
    }
    elseif (!($class instanceof CDIControllerInterface)) {
      throw new CDIException(CDIException::INVALID_CONTROLLER_CLASS,
          'Controller class of incorrect type @type', array(
            '@type' => $class,
          ));
    }
    return TRUE;
  }
  
  public function findControllerWeight($datatype, $method, $scope = CDIBaseController::SCOPE_OBJECT) {
    $info = $this->findBestController($datatype, $method, $scope);
    if (empty($info)) {
      return 0;
    } 
    else {
      return $info['weight'];
    }
  }
  
  public function unregisterAllControllers() {
    $this->controllers->wipeRegistry();
    $this->controllers->saveRegistry();
    return $this;
  }
  
  public function registerController($controllerClass, $weight = 0) {
    $this->validateControllerClass($controllerClass);
    $this->controllers->addEntry($controllerClass, array(
      'class' => $controllerClass,
      'weight' => $weight,
    ));
    $this->controllers->sortRegistry('_cdi_sort_registry_entries');
    $this->controllers->saveRegistry();
    return $this;
  }
  
  private function findBestController($datatype, $method, $scope, $classOnly = FALSE) {
    foreach ($this->controllers->getEntries() as $controllerInfo) {
      $controllerClass = $controllerInfo['class'];
      $instance = new $controllerClass();
      if ($instance->supports($datatype, $method, $scope)) {
        if ($classOnly) {
          return $instance;
        } else {
          return $controllerInfo;
        }
      }
    }
    return NULL;
  }
  
  public function resolveController($datatype, $method, $scope = CDIBaseController::SCOPE_OBJECT) {
    return $this->findBestController($datatype, $method, $scope, TRUE);
  }
  
}

function _cdi_sort_registry_entries($a, $b) {
  return $a['weight'] - $b['weight'];
}
