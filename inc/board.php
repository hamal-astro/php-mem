<?php
// 게시판 관리 클래스

class Board
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // 게시판 목록
  public function list()
  { // 게시판 갯수가 많아지면 회원 목록을 참고하여 페이징 적용

    // 초단위 절삭
    $sql = "SELECT idx,name,bcode,btype,cnt,DATE_FORMAT(create_at,'%Y-%m-%d %H:%i') AS create_at 
    from board_manage
    order by idx ASC ";
    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
