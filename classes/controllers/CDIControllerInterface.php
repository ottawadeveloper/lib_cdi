<?php

interface CDIControllerInterface {
  
  function supports($datatype, $method, $scope);
  function setDataObject($dataObject);
  function setIdentifier($identifier);
  function setDataType();
  
  function object();
  function identifier();
  function datatype();
}