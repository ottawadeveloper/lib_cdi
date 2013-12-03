<?php

function _lib_cdi_build_data_type_info() {
  $data_types = array();
  $modules = module_implements('cdi_data_types');
  foreach ($modules as $module) {
    $hook = $module . '_cdi_data_types';
    if (function_exists($hook)) {
      $data_types += $hook();
    }
  }
  drupal_alter('cdi_data_types', $data_types);
  return $data_types;
}

function _lib_cdi_build_receiver_info() {
  $delegates = array();
  $modules = module_implements('cdi_receivers');
  foreach ($modules as $module) {
    $hook = $module . '_cdi_receivers';
    if (function_exists($hook)) {
      $temp = $hook();
      foreach ($temp as $key => $receiver_info) {
        $delegates[$key] = $receiver_info + array(
          'weight' => 0,
        );
      }
    }
  }
  drupal_alter('cdi_receivers', $delegates);
  return $delegates;
}

function _lib_cdi_build_module_list() {
  $cdi_modules = array();
  $modules = module_implements('cdi_modules');
  foreach ($modules as $module) {
    $hook = $module . '_cdi_modules';
    if (function_exists($hook)) {
      $cdi_modules += $hook();
    }
  }
  drupal_alter('cdi_modules', $cdi_modules);
  return $cdi_modules;
}

function _lib_cdi_build_enabled_modules_list() {
  $enabled_list = array();
  $modules = module_implements('cdi_enabled_modules');
  foreach ($modules as $module) {
    $hook = $module . '_cdi_enabled_modules';
    if (function_exists($hook)) {
      $temp = $hook();
      $enabled_list += drupal_map_assoc($temp);
    }
  }
  drupal_alter('cdi_enabled_modules', $enabled_list);
  return $enabled_list;
}

function _lib_cdi_cached_module_list($reset = FALSE) {
  $cdi_modules = drupal_static(__FUNCTION__, array());
  if ($reset || empty($cdi_modules)) {
    $cdi_modules = array();
    $cache = cache_get(__FUNCTION__);
    if ((!$reset) && (!empty($cache->data))) {
      $cdi_modules = $cache->data;
    }
    if (empty($cdi_modules)) {
      $cdi_modules = _lib_cdi_build_module_list();
    }
    cache_set(__FUNCTION__, $cdi_modules);
  }
  return $cdi_modules;
}

function _lib_cdi_cached_enabled_module_list($reset = FALSE) {
  $cdi_modules = drupal_static(__FUNCTION__, array());
  if ($reset || empty($cdi_modules)) {
    $cdi_modules = array();
    $cache = cache_get(__FUNCTION__);
    if ((!$reset) && (!empty($cache->data))) {
      $cdi_modules = $cache->data;
    }
    if (empty($cdi_modules)) {
      $cdi_modules = _lib_cdi_build_enabled_modules_list();
    }
    cache_set(__FUNCTION__, $cdi_modules);
  }
  return $cdi_modules;
}

function _lib_cdi_cached_receiver_info($reset = FALSE) {
  $cdi_modules = drupal_static(__FUNCTION__, array());
  if ($reset || empty($cdi_modules)) {
    $cdi_modules = array();
    $cache = cache_get(__FUNCTION__);
    if ((!$reset) && (!empty($cache->data))) {
      $cdi_modules = $cache->data;
    }
    if (empty($cdi_modules)) {
      $cdi_modules = _lib_cdi_build_receiver_info();
    }
    cache_set(__FUNCTION__, $cdi_modules);
  }
  return $cdi_modules;
}

function _lib_cdi_cached_data_type_info($reset = FALSE) {
  $cdi_modules = drupal_static(__FUNCTION__, array());
  if ($reset || empty($cdi_modules)) {
    $cdi_modules = array();
    $cache = cache_get(__FUNCTION__);
    if ((!$reset) && (!empty($cache->data))) {
      $cdi_modules = $cache->data;
    }
    if (empty($cdi_modules)) {
      $cdi_modules = _lib_cdi_build_data_type_info();
    }
    cache_set(__FUNCTION__, $cdi_modules);
  }
  return $cdi_modules;
}