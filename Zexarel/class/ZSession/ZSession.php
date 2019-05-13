<?php
class ZSession{
  public static function start(){
    $session = new SessionHandle();
    session_set_save_handler(
      [$session, 'open'],
      [$session, 'close'],
      [$session, 'read'],
      [$session, 'write'],
      [$session, 'destroy'],
      [$session, 'gc']
    );
    session_start();
  }
}
if(ZConfig::config("SESSION_ENABLE", "false") == "true"){
  ZSession::start();
}
