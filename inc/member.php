<?php
// member class file

class Member
{
  // 멤버 변수, 프로퍼티
  private $conn;

  // 생성자
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // 아이디 중복체크용 멤버 함수
  public function id_exists($id)
  {
    $sql = "SELECT * from member where id=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    return $stmt->rowCount() ? true : false;
  }

  // 이메일 형식 체크
  public function email_format_check($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }


  // 이메일 중복체크용 함수
  public function email_exists($email)
  {
    $sql = "SELECT * from member where email=:email";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    return $stmt->rowCount() ? true : false;
  }

  // 회원 정보 입력

  public function input($marr)
  {
    //var_dump($marray);

    // 단방향 암호화
    $new_hash_password = password_hash($marr["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO member(id,name,password,email,zipcode,addr1,addr2,photo,create_at,ip) 
    values(:id, :name, :password,:email,:zipcode,:addr1,:addr2,:photo,NOW(),:ip)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":email", $marr['email']);
    $stmt->bindParam(":id", $marr['id']);
    $stmt->bindParam(":name", $marr['name']);
    // $stmt->bindParam(":password", $marr['password']);
    $stmt->bindParam(":password", $new_hash_password);
    $stmt->bindParam(":zipcode", $marr['zipcode']);
    $stmt->bindParam(":addr1", $marr['addr1']);
    $stmt->bindParam(":addr2", $marr['addr2']);
    $stmt->bindParam(":photo", $marr['photo']);
    $stmt->bindParam(":ip", $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
  }

  // login_process

  public function login($id, $pw)
  {
    // $sql = "select * from member where id = :id and password=:password";
    $sql = "SELECT password from member where id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    // $stmt->bindParam(":password", $pw);
    $stmt->execute();
    // return $stmt->rowCount() ? true : false;

    if ($stmt->rowCount()) {
      $row = $stmt->fetch();
      if (password_verify($pw, $row['password'])) {
        $sql = "UPDATE member set login_dt=NOW() where id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function logout()
  {
    session_start();
    session_destroy();

    die('<script>self.location.href="../index.php";</script>?');
  }


  public function getInfoFormIdx($idx)
  {
    $sql = 'select * from member where idx=:idx';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function getInfo($id)
  {
    $sql = 'select * from member where id=:id';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function edit($marr)
  {
    $sql = 'UPDATE member set name=:name, email=:email, zipcode=:zipcode, addr1=:addr1, addr2=:addr2, photo=:photo ';
    $params = [
      ':name' => $marr['name'],
      ':email' => $marr['email'],
      ':zipcode' => $marr['zipcode'],
      ':addr1' => $marr['addr1'],
      ':addr2' => $marr['addr2'],
      ':photo' => $marr['photo']
    ];
    if ($marr['password'] != '') {
      // 단방향 암호화
      $new_hash_password = password_hash($marr['password'], PASSWORD_DEFAULT);
      $params[':password'] = $new_hash_password;

      $sql .= ", password=:password";
    }

    // admin의 회원관리는 idx를 사용하기 때문에 판단문 사용
    // 관리자 구분
    if ($_SESSION['ses_level'] == 10 && isset($marr['idx']) && $marr['idx'] != '') {
      $params[':level'] = $marr['level'];
      $params[':idx'] = $marr['idx'];
      $sql .= ", level=:level";
      $sql .= " WHERE idx=:idx";
    } else {
      $params[':id'] = $marr['id'];
      $sql .= " WHERE id=:id";
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
  }


  // 회원 목록
  public function list($page, $limit, $paramArr)
  {
    $start = ($page - 1) * $limit;
    $where = "";
    if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
      switch ($paramArr['sn']) {
        case 1:
          $sn_str = 'name';
          break;
        case 2:
          $sn_str = 'id';
          break;
        case 3:
          $sn_str = 'email';
          break;
      }
      $where = " WHERE " . $sn_str . "=:sf ";
    }
    // 초단위 절삭
    $sql = "select idx,id,name,email,DATE_FORMAT(create_at,'%Y-%m-%d %H:%i') AS create_at 
    from member " . $where . "
    order by idx desc
    limit " . $start . "," . $limit;
    $stmt = $this->conn->prepare($sql);
    if ($where != '') {
      $stmt->bindParam(':sf', $paramArr['sf']);
    }

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function total($paramArr)
  {
    $where = "";
    if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
      switch ($paramArr['sn']) {
        case 1:
          $sn_str = 'name';
          break;
        case 2:
          $sn_str = 'id';
          break;
        case 3:
          $sn_str = 'email';
          break;
      }
      $where = " WHERE " . $sn_str . "=:sf ";
    }

    $sql = "select count(*) cnt from member " . $where;
    $stmt = $this->conn->prepare($sql);
    if ($where != '') {
      $stmt->bindParam(':sf', $paramArr['sf']);
    }

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['cnt'];
  }



  public function getAllData()
  {

    //   $sql = "select idx,id,name,email,DATE_FORMAT(create_at,'%Y-%m-%d %H:%i') AS create_at 
    // from member " . $where . "
    // order by idx desc
    // limit " . $start . "," . $limit;
    $sql = "select * from member order by idx asc";

    $stmt = $this->conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function member_del($idx)
  {
    $sql = "delete from member where idx=:idx";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(":idx", $idx);
    $stmt->execute();
  }
}
