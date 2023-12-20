<?php

include 'inc/common.php'; // 세션
include 'inc/dbconfig.php';
include 'inc/board.php'; // 게시판 클래스
include 'inc/lib.php'; // 페이지네이션

$bcode = (isset($_GET['bcode']) && $_GET['bcode'] != '') ? $_GET['bcode'] : '';
$idx = (isset($_GET['idx']) && $_GET['idx'] != '' && is_numeric($_GET['idx'])) ? $_GET['idx'] : '';

if ($bcode == '') {
  die("<script>alert('게시판 코드가 빠졌습니다.');history.go(-1);</script>");
}

if ($idx == '') {
  die("<script>alert('게시물 번호가 빠졌습니다.');history.go(-1);</script>");
}

// 게시판 목록
include 'inc/boardmanage.php';

$boardm = new BoardManage($db);
$boardArr = $boardm->list();
$board_name = $boardm->getBoardName($bcode);

$board = new Board($db); //게시판 클래스

$menu_code  = 'board';
$js_array = ['js/board_view.js'];
$g_title = $board_name;

$paramArr = ['sn' => $sn, 'sf' => $sf];
$total = $board->total($bcode, $paramArr);

$limit = 10;
$page_limit = 5;
$boardRs = $board->list($bcode, $page, $limit, $paramArr);

// print_r($boardRs);

include_once 'inc/header.php';
?>
<style>
  .tr {
    cursor: pointer;
  }
</style>

<main class="w-100 mx-auto border rounded-2 p-5">
  <h1 class="text-center"><?= $board_name; ?></h1>

  <table class="table table-striped table-hover mt-5">
    <colgroup>
      <col width="10%">
      <col width="45%">
      <col width="10%">
      <col width="15%">
      <col width="10%">
    </colgroup>
    <tr>
      <th>번호</th>
      <th>제목</th>
      <th>작성자</th>
      <th>날짜</th>
      <th>조회수</th>
    </tr>
    <?php
    $cnt = 0;
    $ntotal = $total - ($page - 1) * $limit;
    foreach ($boardRs as $boardRow) {
      $number = $ntotal - $cnt;
      $cnt++;
    ?>

      <tr class="tr" data-idx="<?= $boardRow['idx']; ?>">
        <td><?= $number; ?></td>
        <td><?= $boardRow['subject']; ?></td>
        <td><?= $boardRow['name']; ?></td>
        <td><?= $boardRow['create_at']; ?></td>
        <td><?= $boardRow['hit']; ?></td>
      </tr>
    <?php } ?>
  </table>
  <div class="container mt-3 w-50 d-flex gap-2">
    <select name="" id="sn" class="form-select w-25">
      <option value="1" <?php if ($sn == 1) echo ' selected'; ?>>제목+내용</option>
      <option value="2" <?php if ($sn == 2) echo ' selected'; ?>>제목</option>
      <option value="3" <?php if ($sn == 3) echo ' selected'; ?>>내용</option>
      <option value="4" <?php if ($sn == 4) echo ' selected'; ?>>글쓴이</option>
    </select>
    <input type="text" class="form-control w-25" id="sf" value="<?= $sf ?>">
    <button class="btn btn-primary w-25" id="btn_search">검색</button>
    <button class="btn btn-info w-25" id="btn_all">전체목록</button>
  </div>

  <div class="d-flex justify-content-between align-items-start">
    <?php
    $param = '&bcode=' . $bcode;
    if (isset($sn) && $sn != '' && isset($sf) && $sf != '') {
      $param .= '&sn=' . $sn . '&sf=' . $sf;
    }
    echo my_pagination($total, $limit, $page_limit, $page, $param);
    ?>
    <button class="btn btn-primary" id="btn_write">글쓰기</button>
  </div>

</main>


<?php include 'inc/footer.php'; ?>