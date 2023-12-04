<?php

session_start();

$ses_id = (isset($_SESSION["ses_id"]) && $_SESSION['ses_id']) ? $_SESSION["ses_id"] : "";

if ($ses_id == "") {

  echo "<script>
  alert('로그인 후 접근이 가능 합니다.');
  self.location.href='./index.php';
  </script>";
  exit();
}
include 'inc/dbconfig.php';
include 'inc/member.php';

$mem = new Member($db);
$memArr = $mem->getInfo($ses_id);
// print_r($memArr);
// exit;



$js_array = ['js/mypage.js'];
$g_title = '회원정보';
$menu_code = '회원정보';

include 'inc/header.php';
?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>



<main class="w-50 mx-auto border rounded-5 p-5">
  <h1 class="text-center">회원정보 수정</h1>
  <!-- enctype은 파일업로드때문에 필요함 -->
  <form name="input_form" method="post" enctype="multipart/form-data" autocomplete="off" action="pg/member_process.php">
    <input type="hidden" name="mode" value="edit">
    <input type="hidden" name="email_chk" value="0">
    <input type="hidden" name="old_email" value="<?= $memArr['email']; ?>">
    <input type="hidden" name="old_photo" value="<?= $memArr['photo']; ?>">
    <!-- bootstrap form input -->
    <div class="d-flex gap-2 align-items-end">
      <div>
        <label for="f_id" class="form-label">아이디</label>
        <input type="text" name="id" readonly class="form-control" id="f_id" value="<?= $memArr['id']; ?>">
      </div>
    </div>

    <div class="mt-3 d-flex gap-2 align-items-end">
      <div>
        <label for="f_name" class="form-label">이름</label>
        <input type="text" name="name" class="form-control" id="f_name" value="<?= $memArr['name']; ?>" placeholder="이름을 입력해 주세요.">
      </div>
    </div>

    <div class="d-flex mt-3 gap-2 justify-content-between">
      <div class="flex-grow-1">
        <label for="f_password" class="form-label">비밀번호</label>
        <input type="password" name="password" class="form-control" id="f_password" placeholder="비밀번호를 입력해 주세요.">
      </div>
      <div class="flex-grow-1">
        <label for="f_password2" class="form-label">비밀번호 확인</label>
        <input type="password" name="password2" class="form-control" id="f_password2" placeholder="비밀번호를 입력해 주세요.">
      </div>
    </div>

    <div class="d-flex gap-2 align-items-end">
      <div class="flex-grow-1">
        <label for="f_email" class="form-label">이메일</label>
        <input type="text" name="email" class="form-control" id="f_email" placeholder="이메일을 입력해 주세요." value="<?= $memArr['email']; ?>">
      </div>
      <button type="button" id="btn_email_check" class="btn btn-secondary">이메일 중복확인</button>
    </div>

    <div class="d-flex gap-2 mt-3 align-items-end">

      <div>
        <label for="f_zipcode">우편번호</label>
        <input type="text" name="zipcode" id="f_zipcode" value="<?= $memArr['zipcode']; ?>" readonly class="form-control" maxlength="5" minlength="5">
      </div>
      <button type="button" class="btn btn-secondary" id="btn_zipcode">우편번호 찾기</button>
    </div>

    <div class="d-flex mt-3 gap-2 justify-content-between">
      <div class="flex-grow-1">
        <label for="f_addr1" class="form-label">주소</label>
        <input type="text" class="form-control" value="<?= $memArr['addr1']; ?>" name="addr1" id="f_addr1" placeholder="">
      </div>
      <div class="flex-grow-1">
        <label for="f_addr2" class="form-label">상세주소</label>
        <input type="text" class="form-control" value="<?= $memArr['addr2']; ?>" name="addr2" id="f_addr2" placeholder="상세주소를 입력해 주세요">
      </div>
    </div>

    <div class="mt-3 d-flex gap-5">
      <div>
        <label for="f_photo" class="form-label">프로필이미지</label>
        <input type="file" name="photo" id="f_photo" class="form-control">
      </div>
      <?php if ($memArr['photo']) {
        echo '<img src="data/profile/' . $memArr['photo'] . '" id="f_preview" class="w-25" alt="profile image">';
      } else {
        echo '<img src="images/Unknown_person.jpg" id="f_preview" class="w-25" alt="profile image">';
      } ?>
    </div>

    <div class="mt-3 d-flex gap-2">
      <button type="button" class="btn btn-primary flex-grow-1" id="btn_submit">수정확인</button>
      <button type="button" class="btn btn-secondary flex-grow-1">수정취소</button>
    </div>
  </form>
</main>


<?php include 'inc/footer.php'; ?>