<?php


include 'inc/common.php';
include 'inc/dbconfig.php';
include 'inc/board.php';

$bcode = (isset($_GET['bcode']) && $_GET['bcode'] != '') ? $_GET['bcode'] : '';

if ($bcode == '') {
  die("<script>alert('게시판코드가 빠졌습니다.');history.go(-1);</script>");
}

// 게시판 목록
include 'inc/boardmanage.php';

$boardm = new BoardManage($db);
$boardArr = $boardm->list();
$board_name = $boardm->getBoardName($bcode);

$board = new Board($db);

$menu_code  = 'board';
$js_array = ['js/board.js'];
$g_title = $board_name;
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
    <tr>
      <td>1</td>
      <td>test</td>
      <td>name</td>
      <td>00-00</td>
      <td>5</td>
    </tr>
    <tr>
      <td>2</td>
      <td>test</td>
      <td>name</td>
      <td>00-00</td>
      <td>5</td>
    </tr>
    <tr>
      <td>3</td>
      <td>test</td>
      <td>name</td>
      <td>00-00</td>
      <td>5</td>
    </tr>
    <tr>
      <td>4</td>
      <td>test</td>
      <td>name</td>
      <td>00-00</td>
      <td>5</td>
    </tr>
  </table>

  <div class="d-flex justify-content-between align-items-start">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
    <button class="btn btn-primary" id="btn_write">글쓰기</button>
  </div>

</main>


<?php include 'inc/footer.php'; ?>