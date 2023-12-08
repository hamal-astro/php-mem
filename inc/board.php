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

  // 게시판 생성
  public function create($arr)
  {
    $sql = "INSERT into board_manage(name,bcode,btype,create_at)
    values (:name,:bcode,:btype,NOW())";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':name', $arr['name']);
    $stmt->bindParam(':bcode', $arr['bcode']);
    $stmt->bindParam(':btype', $arr['btype']);
    $stmt->execute();
  }

  // 게시판 정보 수정
  public function update($arr)
  {
    $sql = "UPDATE board_manage SET name=:name,btype=:btype where idx=:idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':name', $arr['name']);
    $stmt->bindValue(':btype', $arr['btype']);
    $stmt->bindValue(':idx', $arr['idx']);
    $stmt->execute();
  }

  // 게시판 idx로 정보 가져오기 
  public function getBcode($idx)
  {
    $sql = "SELECT bcode from board_manage where idx=:idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->setFetchMode(PDO::FETCH_COLUMN, 0);
    $stmt->execute();
    return $stmt->fetch();
  }

  // 게시판 삭제
  public function delete($idx)
  {
    $bcode = $this->getBcode($idx);

    $sql = 'DELETE from board_manage where idx = :idx';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->execute();

    $sql = "DELETE from board where bcode=:bcode";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':bcode', $bcode);
    $stmt->execute();
  }

  //게시판 코드 생성
  public function bcode_create()
  {
    $letter = range('a', 'z');
    $bcode = '';
    for ($i = 0; $i < 6; $i++) {
      $r = rand(0, 25);
      $bcode .= $letter[$r];
    }
    return $bcode;
  }

  //게시판 정보 불러오기
  public function getInfo($idx)
  {
    $sql = "SELECT * from board_manage where idx=:idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':idx', $idx);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetch();
  }
}
