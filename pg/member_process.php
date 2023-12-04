<?php

include '../inc/dbconfig.php';
include '../inc/member.php'; // member class 정의 파일

$mem = new Member($db);

$id       = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$email    = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$name     = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';
$zipcode  = (isset($_POST['zipcode']) && $_POST['zipcode'] != '') ? $_POST['zipcode'] : '';
$addr1    = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2    = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';

$mode     = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';


// 아이디 중복체크
if ($mode == 'id_chk') {
  if ($id == '') {
    die(json_encode(['result' => 'empty_id']));
  }

  if ($mem->id_exists($id)) {
    // echo '아이디가 중복됨';
    $arr = ['result' => 'fail']; // 배열
    $json = json_encode($arr); // json 타입으로 변경 
    die($json);
    //die(json_encode(['result' => 'fail'])); //한줄로 표현가능

  } else {
    //echo '사용할 수 있는 아이디임.';
    die(json_encode(['result' => 'success']));
  }

  // 이메일 중복 체크
} else if ($mode == 'email_chk') {
  if ($email == '') {
    die(json_encode(['result' => 'empty_email']));
  }

  // 이메일 형식 체크
  if ($mem->email_format_check($email) === false) {
    die(json_encode(['result' => 'email_format_wrong']));
  }

  if ($mem->email_exists($email)) {
    $arr = ['result' => 'fail'];
    $json = json_encode($arr);
    die($json);
  } else {
    die(json_encode(['result' => 'success']));
  }
} else if ($mode == 'input') {
  //

  // profile img 처리
  $photo = '';
  if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
    $tmparr = explode('.', $_FILES['photo']['name']);
    $ext = end($tmparr);
    $photo = $id . '.' . $ext;

    copy($_FILES['photo']['tmp_name'], "../data/profile/" . $photo);
  }
  $arr = [
    'id' => $id,
    'email' => $email,
    'password' => $password,
    'name' => $name,
    'zipcode' => $zipcode,
    'addr1' => $addr1,
    'addr2' => $addr2,
    'photo' => $photo
  ];

  $mem->input($arr);

  echo "
  <script>
    self.location.href='../member_success.php'
  </script>";

  // 회원정보 이미지 수정
} else if ($mode == "edit") {

  $old_photo = (isset($_POST["old_photo"]) && $_POST["old_photo"] != "") ? $_POST["old_photo"] : "";

  if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
    // 기존 사진을 삭제
    if ($old_photo != '') {
      unlink("../data/profile/" . $old_photo);
    }
    // 새 이미지 대입
    $tmparr = explode('.', $_FILES['photo']['name']);
    $ext = end($tmparr);
    $photo = $id . '.' . $ext;

    copy($_FILES['photo']['tmp_name'], "../data/profile/" . $photo);

    $old_photo = $photo;
  }

  session_start();

  $arr = [
    'id' => $_SESSION['ses_id'],
    'email' => $email,
    'password' => $password,
    'name' => $name,
    'zipcode' => $zipcode,
    'addr1' => $addr1,
    'addr2' => $addr2,
    'photo' => $old_photo
  ];

  $mem->edit($arr);

  echo "
    <script>
    alert('수정되었습니다.');
      self.location.href='../index.php'
    </script>";
};
