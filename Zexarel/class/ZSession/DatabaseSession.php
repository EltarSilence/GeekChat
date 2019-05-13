<?php
class DatabaseSession extends ZDatabase{
  public function __construct(){
    $this->host = ZConfig::config("SESSION_DB_HOST", "localhost");
    $this->user = ZConfig::config("SESSION_DB_USER", "root");
    $this->password = ZConfig::config("SESSION_DB_PASSWORD", "");
    $this->database = ZConfig::config("SESSION_DB_DATABASE", "my_database");
    parent::__construct();
  }
  public function __destruct(){
  }
}
