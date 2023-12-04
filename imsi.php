<?php

// db 연결

include 'inc/dbconfig.php';
include 'inc/member.php';


// id 중복테스트

$email = 'emai1l@email.com';

$mem = new Member($db);


if ($mem->email_exists($email)) {
  echo "이메일이 중복 됩니다.";
} else {
  echo "사용할 수 있는 이메일 입니다.";
}