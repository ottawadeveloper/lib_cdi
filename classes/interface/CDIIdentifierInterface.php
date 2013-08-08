<?php

interface CDIIdentifierInterface {
  
  const MODE_LOCAL = 1;
  const MODE_UNIVERSAL = 2;
  
  function datatype();
  function mode();
  function rawID();
  
}