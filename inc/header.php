<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= (isset($g_title) && $g_title != '') ? $g_title : '네카라쿠배' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
  </script>

  <?php
  if (isset($js_array)) {
    foreach ($js_array as $var) {
      echo  '<script src="' . $var . '?v=' . date("YmdHis") . '"></script>' . PHP_EOL; // 해당 php내용을 넣으면 새로고침할때 마다 시간이 바뀌어서 캐쉬에서 과거파일을 불러오는 경우를 해소
    }
  }
  ?>

</head>

<body>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <img src="images/logo.svg" alt="logo" style="width:2rem" class="me-2">
        <span class="fs-4">네카라쿠배</span>
      </a>

      <ul class="nav nav-pills">
        <?php if (isset($ses_id) && $ses_id != '') {
          // 로그인 상태
        ?>

          <li class="nav-item"><a href="../index.php" class="nav-link <?= ($menu_code == 'home') ? 'active' : ''; ?>" aria-current="page">Home</a></li>
          <li class="nav-item"><a href="../company.php" class="nav-link <?= ($menu_code == 'company') ? 'active' : ''; ?>">회사소개</a></li>
          <?php if (isset($ses_level) && $ses_level == 10) {
          ?>
            <li class="nav-item"><a href="../admin/" class="nav-link <?= ($menu_code == '회원정보') ? 'active' : ''; ?>">관리자페이지</a></li>
          <?php
          } else { ?>
            <li class="nav-item"><a href="../mypage.php" class="nav-link <?= ($menu_code == '회원정보') ? 'active' : ''; ?>">회원정보</a></li>
          <?php } ?>

          <?php
          if (isset($boardArr)) {
            foreach ($boardArr as $row) {
              echo '<li class="nav-item"><a href="board.php?bcode=' . $row['bcode'] . '" class="nav-link';
              if (isset($_GET['bcode']) && $_GET['bcode'] == $row['bcode']) {
                echo ' active';
              }
              echo '">' . $row['name'] . '</a></li>';
            }
          }
          ?>

          <li class="nav-item"><a href="../pg/logout.php" class="nav-link <?= ($menu_code == 'login') ? 'active' : ''; ?>">로그아웃</a></li>
        <?php
        } else {
          // 로그인 안된 상태
        ?>
          <li class="nav-item"><a href="../index.php" class="nav-link <?= ($menu_code == 'home') ? 'active' : ''; ?>" aria-current="page">Home</a></li>
          <li class="nav-item"><a href="../company.php" class="nav-link <?= ($menu_code == 'company') ? 'active' : ''; ?>">회사소개</a></li>
          <li class="nav-item"><a href="../stipulation.php" class="nav-link <?= ($menu_code == 'member') ? 'active' : ''; ?>">회원가입</a></li>
          <li class="nav-item"><a href="../board.php" class="nav-link <?= ($menu_code == 'board') ? 'active' : ''; ?>">게시판</a></li>
          <li class="nav-item"><a href="../login.php" class="nav-link <?= ($menu_code == 'login') ? 'active' : ''; ?>">로그인</a></li>
        <?php
        }
        ?>
      </ul>
    </header>