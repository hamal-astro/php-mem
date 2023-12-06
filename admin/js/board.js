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

		btn_board_create.disabled = true;

		const board_mode = document.querySelector('#board_mode');

		const xhr = new XMLHttpRequest();
		const f = new FormData();
		f.append('board_title', board_title.value);
		f.append('board_type', document.querySelector('#board_type').value);
		f.append('mode', 'input');

		xhr.open('POST', './pg/board_process.php', true);
		xhr.send(f);
		xhr.onload = () => {
			if (xhr.status == 200) {
				const data = JSON.parse(xhr.responseText);
				if (data.result == 'mode_empty') {
					alert('mode_empty');
					btn_board_create.disabled = false;
					return false;
				} else if (data.result == 'title_empty') {
					alert('title_empty');
					board_title.focus();
					btn_board_create.disabled = false;
					return false;
				} else if (data.result == 'btype_empty') {
					alert('type_empty');
					btn_board_create.disabled = false;
					return false;
				} else if (data.result == 'success') {
					alert('게시판이 생성되었습니다.');
					self.location.reload();
				}
			} else {
				alert('통신 실패' + xhr.status);
				btn_board_create.disabled = false;
			}
		};
	});

	//게시판 생성 버튼 클릭
	btn_create_modal.addEventListener('click', () => {
		board_title.value == '';
		const board_mode = document.querySelector('#board_mode');
		board_mode.value = 'input';
	});

	// 수정 버튼
	const btn_mem_edit = document.querySelectorAll('.btn_mem_edit');
	btn_mem_edit.forEach((box) => {
		box.addEventListener('click', () => {
			const board_mode = document.querySelector('#board_mode');
			board_mode.value = 'edit';

			const idx = box.dataset.idx;
			const f = new FormData();
			f.append('idx', idx);
			f.append('mode', 'getInfo');

			const xhr = new XMLHttpRequest();
			xhr.open('post', 'pg/board_process.php', true);
			xhr.send(f);
			xhr.onload = () => {
				if (xhr.status == 200) {
					const data = JSON.parse(xhr.responseText);
					if (data.result == 'empty_idx') {
						alert('idx 값이 누락되었습니다.');
						return false;
					} else if (data.result == 'success') {
						board_title.value = data.list.name;
						document.querySelector('#board_type').value = data.list.btype;
					}
				} else {
					alert('통신 실패 :' + xhr.status);
				}
			};
		});
	});

	// 삭제버튼
	const btn_mem_delete = document.querySelectorAll('.btn_mem_delete');
	btn_mem_delete.forEach((box) => {
		box.addEventListener('click', () => {
			if (!confirm('본 게시판을 삭제하시겠습니까?')) {
				return false;
			}

			const idx = box.dataset.idx;

			const f = new FormData();
			f.append('idx', idx);
			f.append('mode', 'delete');

			const xhr = new XMLHttpRequest();
			xhr.open('post', 'pg/board_process.php', true);
			xhr.send(f);

			xhr.onload = () => {
				if (xhr.status == 200) {
					const data = JSON.parse(xhr.responseText); // {"result" : "success"}
					if (data.result == 'success') {
						// alert('게시판이 삭제되었습니다.');
						self.location.reload();
					}
				} else {
					alert('통신 실패');
				}
			};
		});
	});
});