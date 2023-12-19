<?php


include 'inc/common.php'; // 세션
include 'inc/dbconfig.php';
include 'inc/board.php'; // 게시판 클래스
include 'inc/lib.php'; // 페이지네이션

$bcode = (isset($_GET['bcode']) && $_GET['bcode'] != '') ? $_GET['bcode'] : '';
$page = (isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

if ($bcode == '') {
  die("<script>alert('게시판코드가 빠졌습니다.');history.go(-1);</script>");
}

// 게시판 목록
include 'inc/boardmanage.php';

$boardm = new BoardManage($db);
$boardArr = $boardm->list();
$board_name = $boardm->getBoardName($bcode);

$board = new Board($db); //게시판 클래스

$menu_code  = 'board';
$js_array = ['js/board.js'];
$g_title = $board_name;

$paramArr = [];
$total = $board->total($bcode, $paramArr);

$limit = 7;
$page_limit = 5;
$boardRs = $board->list($bcode, $page, $limit, $paramArr);

// print_r($boardRs);

include 'inc/header.php';
?>

<main class="w-75 mx-auto border rounded-2 p-5">
  <h1 class="text-center"><?= $board_name; ?></h1>

  <table class="table table-striped mt-5">
    <tr>
      <th>번호</th>
      <th>제목</th>
      <th>작성자</th>
      <th>날짜</th>
      <th>조회수</th>
    </tr>
    <?php
    foreach ($boardRs as $boardRow) {
    ?>

      <tr>
        <td><?= $boardRow['idx']; ?></td>
        <td><?= $boardRow['subject']; ?></td>
        <td><?= $boardRow['name']; ?></td>
        <td><?= $boardRow['create_at']; ?></td>
        <td><?= $boardRow['hit']; ?></td>
      </tr>
    <?php } ?>
  </table>

  <div class="d-flex justify-content-between align-items-start">
    <?php
    $param = '&bcode=' . $bcode;
    if (isset($sn) && $sn != '' && isset($sf) && $sf != '') {
      $param = '&sn=' . $sn . '&sf=' . $sf;
    }
    echo my_pagination($total, $limit, $page_limit, $page, $param);
    ?>
    <button class="btn btn-primary" id="btn_write">글쓰기</button>
  </div>

</main>


<?php include 'inc/footer.php'; ?>