<?php

$g_title = "네카라쿠배";
$js_array = ['js/home.js'];

$menu_code = 'home';

include 'inc/common.php';
include 'inc/dbconfig.php';

// 게시판 목록
include 'inc/boardmanage.php';
$boardm = new BoardManage($db);
$boardArr = $boardm->list();

include 'inc/header.php';
?>

<main class='w-75 mx-auto border rounded-5 p-5 d-flex gap-5' style="height: calc(100vh - 257px)">

  <img src="images/logo.svg" alt="" class="w-50">
  <div>
    <h3>Home 입니다.</h3>
  </div>
</main>

<?php

include 'inc/footer.php';

?>