<?php
include '../inc/common.php';
include '../inc/dbconfig.php';
include '../inc/board.php'; // 게시판 클래스
include '../inc/member.php';

$mode    = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$bcode   = (isset($_POST['bcode']) && $_POST['bcode'] != '') ? $_POST['bcode'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';


if ($mode = '') {
  $arr = ["result" => "empty_mode"];
  $json_str = json_encode($arr); // php 배열을 json으로 변환
  die($json_str);
}

if ($bcode = '') {
  $arr = ["result" => "empty_bcode"];
  die(json_encode($arr));
}

$board = new Board($db);
$member = new Member($db);

if ($mode == "input") {

  $memArr = $member->getInfo($ses_id);
  $name = $memArr['name'];

  print_r($memArr);
  exit;

  // $arr = [
  //   'bcode' => $bcode,
  //   'id' => $ses_id,
  //   'name' => $name,
  //   'subject' => $subject,
  //   'content' => $content,
  //   'ip' => $_SERVER['REMOTE_ADDR'],
  // ];

  // $board->input($arr);
}
