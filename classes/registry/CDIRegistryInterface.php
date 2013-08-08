<?php

interface CDIRegistryInterface {
  
  function findControllerWeight($datatype, $method);
  function registerController($controllerClass, $weight = 0);
  
}