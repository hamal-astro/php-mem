<?php

include '../common.php';
include '../../inc/dbconfig.php';
include '../../inc/board.php';

$board_title = (isset($_POST['board_title']) && $_POST['board_title'] != '') ? $_POST['board_title'] : '';
$board_type = (isset($_POST['board_type']) && $_POST['board_type'] != '') ? $_POST['board_type'] : '';
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';

if ($mode == '') {
  $arr = ["result" => "mode_empty"];
  die(json_encode($arr)); // {"result":"mode_empty"}
}

// 게시판 생성
if ($mode == 'input') {
  if ($board_title == "") {
    $arr = ["result" => "title_empty"];
    die(json_encode($arr)); // {"result":"mode_empty"}
  }
  if ($board_type == '') {
    $arr = ["result" => "btype_empty"];
    die(json_encode($arr));
  }
}
