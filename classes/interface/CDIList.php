<?php

class CDIList {
  
  private $items = array();
  
  public function __construct() {
    
  }
  
  public function addItem(CDIListItem $item) {
    $this->items[$item->key()] = $item;
  }
  
  public function getItems() {
    return $this->items;
  }
  
  public function getOptionList() {
    $options = array();
    foreach ($this->items as $item) {
      $options[$item->key()] = $item->label();
    }
    return $options;
  }
  
  public function getItem($key) {
    if (!isset($this->items[$key])) {
      return NULL;
    }
    return $this->items[$key];
  }
  
  public function sort($sort = '_cdi_sort_list_items_by_label') {
    uasort($this->items, $sort);
  }
  
}

function _cdi_sort_list_items_by_label($a, $b) {
  strcasecmp($a->label(), $b->label());
}
