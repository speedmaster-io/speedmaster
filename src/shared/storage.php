<?php
class SpeedmasterStorage {
  function __construct() {
    $this->config = [];
    $this->loadStorageFile();
  }

  public function get($primary_key, $secondary_key = null, $default = false) {
    if (isset($this->config[$primary_key][$secondary_key])) {
      return $this->config[$primary_key][$secondary_key];
    } else if (isset($this->config[$primary_key]) && !isset($secondary_key)) {
      return $this->config[$primary_key];
    } else {
      return $default;
    }
  }

  function loadStorageFile() {
    if ($file_contents = @file_get_contents(SPEEDMASTER_STORAGE_FILE)) {
      $this->config = json_decode($file_contents, true);
    } else {
      $this->config = [];
    }
  }
}

global $smdb;
$smdb = new SpeedmasterStorage();