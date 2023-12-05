document.addEventListener('DOMContentLoaded', () => {
	const board_title = document.querySelector('#board_title');
	const btn_board_create = document.querySelector('#btn_board_create');
	const btn_create_modal = document.querySelector('#btn_create_modal');

	btn_board_create.addEventListener('click', () => {
		if (board_title.value == '') {
			alert('게시판 이름을 입력해 주세요');
			board_title.focus();
			return false;
		}

		const xhr = new XMLHttpRequest();
		const f = new FormData();
		f.append('board_title', board_title.value);
		f.append('board_type', document.querySelector('#board_type').value);
		f.append('mode', 'input');

		xhr.open('POST', './pg/board_process.php', true);
		xhr.send(f);
		xhr.onload = () => {
			if (xhr.status == 200) {
				//alert('통신 성공');
				const data = JSON.parse(xhr.responseText);

				if (data.result == 'mode_empty') {
					alert('mode_empty');
					return false;
				} else if (data.result == 'title_empty') {
					alert('title_empty');
					board_title.focus();
					return false;
				} else if (data.result == 'btype_empty') {
					alert('type_empty');
					return false;
				}
			} else {
				alert('통신 실패' + xhr.status);
			}
		};
	});

	//게시판 생성 버튼 클릭
	btn_create_modal.addEventListener('click', () => {
		board_title.value == '';
	});
});
