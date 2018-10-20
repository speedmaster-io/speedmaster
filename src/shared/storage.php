<?php
class SpeedmasterStorage {
  function __construct() {
    $this->storage = [];
    $this->loadStorageFile();
  }

  public function get($primary_key, $secondary_key = null, $default = false) {
    if (isset($this->storage[$primary_key][$secondary_key])) {
      return $this->storage[$primary_key][$secondary_key];
    } else if (isset($this->storage[$primary_key]) && !isset($secondary_key)) {
      return $this->storage[$primary_key];
    } else {
      return $default;
    }
  }

  public function increment($primary_key, $secondary_key = null) {
    if (!isset($this->storage[$primary_key][$secondary_key]))
      return false;

    $this->storage[$primary_key][$secondary_key] = $this->storage[$primary_key][$secondary_key] + 1;
    $this->save();
  }

  function loadStorageFile() {
    if ($file_contents = @file_get_contents(SPEEDMASTER_STORAGE_FILE)) {
      $this->storage = json_decode($file_contents, true);
    } else {
      $this->storage = [];
    }
  }
  
  function save() {
    file_put_contents(SPEEDMASTER_STORAGE_FILE, json_encode($this->storage));
  }
}

global $smdb;
$smdb = new SpeedmasterStorage();