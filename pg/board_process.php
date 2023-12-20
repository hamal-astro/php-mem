<?php
$err_array = error_get_last();

if (isset($_SERVER['CONTENT_LENGTH'])  && $_SERVER['CONTENT_LENGTH'] > (int) ini_get('post_max_size') * 1024 * 1024) {

  $arr = ['result' => 'post_size_exceed'];
  die(json_encode($arr));
}

include '../inc/common.php';
include '../inc/dbconfig.php';
include '../inc/board.php'; // 게시판 클래스
include '../inc/member.php';

$mode    = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$bcode   = (isset($_POST['bcode']) && $_POST['bcode'] != '') ? $_POST['bcode'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';

if ($mode == '') {
  $arr = ["result" => "empty_mode"];
  $json_str = json_encode($arr); // php 배열을 json으로 변환
  die($json_str);
}

if ($bcode == '') {
  $arr = ["result" => "empty_bcode"];
  die(json_encode($arr));
}

$board = new Board($db);
$member = new Member($db);

if ($mode == "input") {

  // 이미지 변환하여 저장
  preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);

  $img_array = [];
  foreach ($matches[1] as $key => $row) {
    if (substr($row, 0, 5) != 'data:') {
      continue;
    }
    list($type, $data) = explode(';', $row);
    list(, $data) = explode(',', $row);
    $data = base64_decode($data);
    list(, $ext) = explode('/', $type);
    $ext = ($ext == 'jpeg') ? 'jpg' : $ext;

    $filename = date('YmdHis') . '_' . $key . '.' . $ext;

    file_put_contents(BOARD_DIR . "/" . $filename, $data);

    $content = str_replace($row, BOARD_WEB_DIR . "/" . $filename, $content);
    $img_array[] = BOARD_WEB_DIR . "/" . $filename;
  }

  if ($subject == '') {
    $arr = ["result" => "empty_subject"];
    die(json_encode($arr));
  }

  if ($content == '' || $content == '<p><br></p>') {
    $arr = ["result" => "empty_content"];
    die(json_encode($arr));
  }

  // 다중 파일 첨부
  //파일 첨부
  $file_list_str = '';
  if (isset($_FILES['files'])) {
    // 우회하여 파일을 3개 초과 업로드 할때 방지
    if (sizeof($_FILES['files']['name']) > 3) {
      $arr = ['result' => 'file_upload_count_exceed'];
      die(json_encode($arr));
    }

    $tmp_arr = [];
    foreach ($_FILES['files']['name'] as $key => $val) {
      // $_FILES['files']['name'][$key];
      $full_str = '';
      $tmparr = explode('.', $_FILES['files']['name'][$key]);
      $ext = end($tmparr);

      $allowed_file_ext = ['txt', 'png', 'jpg', 'jpeg'];
      // $not_allowed_file_ext = ['exe', 'txt', 'xls'];
      // if (in_array($ext, $not_allowed_file_ext)) {
      if (!in_array($ext, $allowed_file_ext)) {
        $arr = ['result' => 'not_allowed_file'];
        die(json_encode($arr));
      }
      $flag = rand(1000, 9999);
      $filename = 'a' . date('YmdHis') . $flag . '.' . $ext;
      $file_ori = $_FILES['files']['name'][$key];
      /// a202311111111.jpg|새파일.jpg
      copy($_FILES['files']['tmp_name'][$key], BOARD_DIR . "/" . $filename);
      $full_str = $filename . '|' . $file_ori;
      $tmp_arr[] = $full_str;
    }
    $file_list_str = implode('?', $tmp_arr);
  }


  $memArr = $member->getInfo($ses_id);
  $name = $memArr['name'];

  $arr = [
    'bcode' => $bcode,
    'id' => $ses_id,
    'name' => $name,
    'subject' => $subject,
    'content' => $content,
    'files' => $file_list_str,
    'ip' => $_SERVER['REMOTE_ADDR'],
  ];

  $board->input($arr);

  die(json_encode(['result' => 'success']));
}
