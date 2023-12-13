<?php
// 게시판 클래스
class Board
{
  private $conn;
  public function __construct($db)
  {
    $this->conn = $db;
  }
  // 글 등록
  public function input($arr)
  {
    $sql = "INSERT INTO board (bcode,id,name,subject,content,ip,create_at) values(:bcode,:id,:name,:subject,:content,:ip,NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":bcode", $arr['bcode']);
    $stmt->bindValue(":id", $arr['id']);
    $stmt->bindValue(":name", $arr['name']);
    $stmt->bindValue(":subject", $arr['subject']);
    $stmt->bindValue(":content", $arr['content']);
    $stmt->bindValue(":ip", $arr['ip']);
    $stmt->execute();
  }
}
