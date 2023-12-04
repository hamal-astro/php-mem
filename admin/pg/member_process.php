<?php
include '../common.php';
include '../../inc/dbconfig.php';
include '../../inc/member.php'; // member class 정의 파일

$mem = new Member($db);

$idx       = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$id        = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$email     = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$name      = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$password  = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';
$zipcode   = (isset($_POST['zipcode']) && $_POST['zipcode'] != '') ? $_POST['zipcode'] : '';
$addr1     = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2     = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';
$level     = (isset($_POST['level']) && $_POST['level'] != '') ? $_POST['level'] : '';
$old_photo = (isset($_POST['old_photo']) && $_POST['old_photo'] != '') ? $_POST['old_photo'] : '';

// 회원정보 이미지 수정

if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
  // 기존 사진을 삭제
  if ($old_photo != '') {
    unlink("../../data/profile/" . $old_photo);
  }
  // 새 이미지 대입
  $tmparr = explode('.', $_FILES['photo']['name']);
  $ext = end($tmparr); // 새이미지의 확장자 추출
  $photo = $id . '.' . $ext; // 새 파일 명

  copy($_FILES['photo']['tmp_name'], "../../data/profile/" . $photo);

  $old_photo = $photo;
}

// session_start();

$arr = [
  'idx' => $idx,
  'id' => $id,
  'email' => $email,
  'password' => $password,
  'name' => $name,
  'zipcode' => $zipcode,
  'addr1' => $addr1,
  'addr2' => $addr2,
  'photo' => $old_photo,
  'level' => $level
];

$mem->edit($arr);

echo "
    <script>
    alert('수정되었습니다.');
      self.location.href='../index.php'
    </script>";
