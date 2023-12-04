document.addEventListener('DOMContentLoaded', () => {
	// 돔을 다 불러온 후에 자바스크립트 진행

	const btn_email_check = document.querySelector('#btn_email_check');
	btn_email_check.addEventListener('click', () => {
		const f_email = document.querySelector('#f_email');

		// 이메일 체크
		if (f_email.value == '') {
			alert('이메일을 입력해 주세요.');
			f_email.focus();
			return false;
		}

		if (document.input_form.old_email.value == f_email.value) {
			alert('이메일 변경을 하지 않았습니다.');
			return false;
		}

		// AJAX
		const f1 = new FormData();
		f1.append('email', f_email.value);
		f1.append('mode', 'email_chk');

		const xhr = new XMLHttpRequest();
		xhr.open('POST', './pg/member_process.php', 'true'); // 비동기 true
		xhr.send(f1);

		xhr.onload = () => {
			if (xhr.status == 200) {
				// 200 정상통신, 400 파일없음
				const data = JSON.parse(xhr.responseText);
				if (data.result == 'success') {
					alert('사용 가능한 이메일 입니다.');
					document.input_form.email_chk.value = '1';
				} else if (data.result == 'fail') {
					alert('이미 사용 중인 이메일 입니다. 다른 이메일을 입력해 주세요.');
					f_email.value = '';
					f_email.focus();
				} else if (data.result == 'empty_email') {
					alert('이메일이 비어 있습니다.');
					f_email.focus();
				} else if (data.result == 'email_format_wrong') {
					alert('이메일이 형식에 맞지 않습니다.');
					f_email.value = '';
					f_email.focus();
				}
			}
		};
	});

	// 가입버튼 클릭시
	const btn_submit = document.querySelector('#btn_submit');
	btn_submit.addEventListener('click', () => {
		// 1. 아이디칸 입력체크
		const f = document.input_form;

		// 이름칸 입력
		if (f.name.value == '') {
			alert('이름을 입력해 주세요.');
			f.name.focus();
			return false;
		}

		// 1. 비밀번호 변경시 확인용 비밀번호칸이 비어있는경우
		if (f.password.value != '' && f.password2.value == '') {
			alert('비밀번호 확인을 입력해 주세요.');
			f.password2.focus();
			return false;
		}

		// 2. 비밀번호 일치여부 확인
		if (f.password.value != f.password2.value) {
			alert('비밀번호가 서로 일치하지 않습니다.');
			f.password.value = '';
			f.password2.value = '';
			f.password.focus();
			return false;
		}

		// 3. 이메일 입력 부분 확인
		if (f.email.value == '') {
			alert('이메일을 입력해 주세요.');
			f.email.focus();
			return false;
		}
		// 4. 이메일을 변경했다면 중복체크 필요
		if (f.old_email.value != f.email.value) {
			if (f.email_chk.value == 0) {
				alert('이메일 중복확인을 해주세요.');
				// f.email.focus();
				return false;
			}
		}

		// 4. 우편번호 입력 확인
		if (f.zipcode.value == '') {
			alert('우편번호를 입력해 주세요.');
			//f.email.focus();
			return false;
		}
		// 5. 주소 입력 확인
		if (f.addr1.value == '') {
			alert('주소를 입력해 주세요.');
			f.addr1.focus();
			return false;
		}

		if (f.addr2.value == '') {
			alert('상세주소를 입력해 주세요.');
			f.addr2.focus();
			return false;
		}

		f.submit();
	});

	//우편번호 찾기

	const btn_zipcode = document.querySelector('#btn_zipcode');
	btn_zipcode.addEventListener('click', () => {
		new daum.Postcode({
			oncomplete: function (data) {
				// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
				// 예제를 참고하여 다양한 활용법을 확인해 보세요.
				console.log(data);
				// 지번(J)과 도로명(R) 주소로 구분되어 입력. 자세한것은 주소찾기 콘솔 확인
				let addr = '';
				let extra_addr = '';
				if (data.userSelectedType == 'J') {
					addr = data.jibunAddress;
					//
				} else if (data.userSelectedType == 'R') {
					addr = data.roadAddress;
					//
				}

				if (data.bname != '') {
					extra_addr = data.bname;
				}

				if (data.buildingName != '') {
					if (extra_addr == '') {
						extra_addr = data.buildingName;
					} else {
						extra_addr += ', ' + data.buildingName;
					}
				}

				if (extra_addr !== '') {
					extra_addr = ' (' + extra_addr + ')';
				}

				const f_addr1 = document.querySelector('#f_addr1');
				f_addr1.value = addr;

				const f_zipcode = document.querySelector('#f_zipcode');
				f_zipcode.value = data.zonecode;

				const f_addr2 = document.querySelector('#f_addr2');
				f_addr2.focus();
			},
		}).open();
	});

	// 프로필 이미지 넣기
	const f_photo = document.querySelector('#f_photo');
	f_photo.addEventListener('change', (e) => {
		// console.log(e);
		const reader = new FileReader();
		reader.readAsDataURL(e.target.files[0]);

		// 이미지 로딩 끝나면
		reader.onload = function (event) {
			// console.log(event);
			const f_preview = document.querySelector('#f_preview');
			f_preview.setAttribute('src', event.target.result);
		};
	});
});
