<?php
class TextMessage extends ZModel{
  public $dir = "assets/model/";
  public $model = "TextMessage";

  private $sender;
  private $text;

  public function __contruct($sender, $text){
    $this->sender = $sender;
    $this->$text = $text;
  }
}
?>
