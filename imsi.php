<?php
// a~z 6자리 게시판 코드

//$letter = range('a', 'z');
// echo "<pre>";
// print_r($letter);
// echo "</pre>";
$letter = range('a', 'z');
$bcode = '';

for ($i = 0; $i < 6; $i++) {
  $r = rand(0, 25);
  $bcode .= $letter[$r];
}
