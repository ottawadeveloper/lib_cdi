<?php

interface CDIRegistryStorageInterface {
  
  function addEntry($key, $data);
  function getEntry($key);
  function getEntries();
  function clearEntry($key);
  function saveRegistry();
  function loadRegistry();
  function sortRegistry($callback);
  function wipeRegistry();
  
}