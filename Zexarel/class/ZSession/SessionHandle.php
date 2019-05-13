<?php
class SessionHandle{

  private $conn;

  public function __construct(){
    $this->conn = new DatabaseSession();
    $this->createTable();
  }

  private function createTable(){
    $this->conn->executeSql('CREATE TABLE IF NOT EXISTS '.ZConfig::config("SESSION_DB_TABLE", "session").'(
      id varchar(255) NOT NULL,
      data mediumtext NOT NULL,
      lastUpdate datetime NOT NULL,
      ip varchar(255) NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8');
  }

  /*
  The open callback works like a constructor in classes and is executed when the session is being opened. It is the first callback function executed when the session is started automatically or manually with session_start(). Return value is TRUE for success, FALSE for failure.
  */
  public function open($savePath, $sessionName){
    $this->conn
      ->delete()
      ->from(ZConfig::config("SESSION_DB_TABLE", "session"))
      ->where("lastUpdate", "<", date("Y-m-d H:i:s", strtotime("-7day")))
      ->execute(null, function($sql, $result, $row){
        return $result;
      });
  }

  /*
  The close callback works like a destructor in classes and is executed after the session write callback has been called. It is also invoked when session_write_close() is called. Return value should be TRUE for success, FALSE for failure.
  */
  public function close(){
    return $this->conn->close();
  }

  /*
  The read callback must always return a session encoded (serialized) string, or an empty string if there is no data to read.
  This callback is called internally by PHP when the session starts or when session_start() is called. Before this callback is invoked PHP will invoke the open callback.
  The value this callback returns must be in exactly the same serialized format that was originally passed for storage to the write callback. The value returned will be unserialized automatically by PHP and used to populate the $_SESSION superglobal. While the data looks similar to serialize() please note it is a different format which is specified in the session.serialize_handler ini setting.
  */
  public function read($id){
    $ret = $this->conn
      ->select("data")
      ->from(ZConfig::config("SESSION_DB_TABLE", "session"))
      ->where("id", "=", $id)
      ->execute();
    if(sizeof($ret) > 0){
      return $ret[0];
    }else{
      return false;
    }
  }

  /*
  The write callback is called when the session needs to be saved and closed. This callback receives the current session ID a serialized version the $_SESSION superglobal. The serialization method used internally by PHP is specified in the session.serialize_handler ini setting.
  The serialized session data passed to this callback should be stored against the passed session ID. When retrieving this data, the read callback must return the exact value that was originally passed to the write callback.
  This callback is invoked when PHP shuts down or explicitly when session_write_close() is called. Note that after executing this function PHP will internally execute the close callback.
  */
  public function write($id, $data){
    $sql = sprintf("REPLACE INTO %s VALUES('%s', '%s', '%s', '%s')",
      ZConfig::config("SESSION_DB_TABLE", "session"),
      $id,
      $data,
       date("Y-m-d H:i:s"),
      $_SERVER['REMOTE_ADDR']
    );
    $this->conn->executeSql($sql, null, function($sql, $result, $row){
      return $result;
    });
  }

  /*
  This callback is executed when a session is destroyed with session_destroy() or with session_regenerate_id() with the destroy parameter set to TRUE. Return value should be TRUE for success, FALSE for failure.
  */
  public function destroy($id){
    $this->conn
      ->delete()
      ->from(ZConfig::config("SESSION_DB_TABLE", "session"))
      ->where("id", "=", $id)
      ->execute(null, function($sql, $result, $row){
        return $result;
      });
  }

  /*
  The garbage collector callback is invoked internally by PHP periodically in order to purge old session data. The frequency is controlled by session.gc_probability and session.gc_divisor. The value of lifetime which is passed to this callback can be set in session.gc_maxlifetime. Return value should be TRUE for success, FALSE for failure.
  */
  public function gc($max){
    $this->conn
      ->delete()
      ->from(ZConfig::config("SESSION_DB_TABLE", "session"))
      ->where("lastUpdate", "<", date("Y-m-d H:i:s", strtotime("-7day")))
      ->execute(null, function($sql, $result, $row){
        return $result;
      });
  }
}
?>
