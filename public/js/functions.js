function Click_Out_Something(hide_box_ref, hide_class, mark_class) {
	if (!hide_box_ref.hasClass(hide_class)) {
		document.onclick = function (e) {
			let all_classes = e.target.className;
			if (!all_classes.includes(mark_class)) {
				hide_box_ref.addClass(hide_class);
				hide_box_ref.slideUp(300);
			}
		};
	}
}

function File_Input($file_inp, $file_butt, $popup_file)
{
	$file_butt.on('click', function () {
		$file_inp[0].click();
	});
	
	$file_inp.on('change', function(){
	
		let file = $(this)[0].files[0];
		let file_name = file.name;
		let dt = new DataTransfer();
		dt.items.add(file);
		$popup_file[0].files = dt.files;
		$file_butt.html(file_name);
	
	});
}

/**поиск***/

function Validate($form_ref) {
	var until_mb_photo = 50;//ограничение на отправку файла по мб для фото
	var until_mb_doc = 10;//ограничение на отправку файла по мб для документов
	var pattern_passw = /(?=^.{6,}$)(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[^A-Za-z0-9]).*/;//для пароля
	var err = 0;

	$form_ref.find('.required').each(function () {

		let $this = $(this);
		var inp_val = $this.val();

		var bool;

		if ($this.hasClass('phone')) {
			bool = (inp_val.length != 16);
		}
		else if ($this.hasClass('file_photo')) {
			if ($this[0].files.length != 0) {
				let name = $this[0].files[0].type;
				let type_file = name.split('/')[0];
				let size_b = $this[0].files[0].size;
				let size_mb = size_b / 1048576;
				if (size_mb > until_mb_photo) {
					$('.photo_label').addClass('error');
					bool = true;
				}
				else if(type_file != 'image'){
					$('.photo_label').addClass('error');
					bool = true;
				}
				else {
					$('.photo_label').removeClass('error');
					bool = false;
				}
			}
		}
		else if ($this.hasClass('file_doc')) {
			if ($this[0].files.length != 0) {
				let size_b = $this[0].files[0].size;
				let size_mb = size_b / 1048576;
				if (size_mb > until_mb_doc) {
					$('.file_label').addClass('error');
					bool = true;
				}
				else {
					$('.file_label').removeClass('error');
					bool = false;
				}
			}
		}
		else if ($this.hasClass('password')) {
			bool = !pattern_passw.test(inp_val);
		}
		else {
			bool = (inp_val == '');
		}

		if (bool) {
			err++;
			$this.addClass("error");
		}
		else {
			$this.removeClass("error");
		}
	});

	return err;
}

function Send_Form($form_ref, urll, event) {
	event.preventDefault();
	var err = Validate($form_ref);
	var formData = new FormData($form_ref[0]);
	var id_form = $form_ref.attr('id');

	
	if (err == 0)
	{
		if ($form_ref.hasClass('loader_form')) {
			var $send = $form_ref.find('.opt_butt.send');
			var $loader = $form_ref.find('.opt_butt.loader');
			var $ready = $form_ref.find('.opt_butt.redy');
			$send.addClass('hide');
			$ready.addClass('hide');
			$loader.removeClass('hide');
		}

		$.ajax({
			type: "POST",
			url: urll,
			contentType: false,
			processData: false,
			data: formData,
			dataType: "json",
			success: function (data) {

				if (id_form == 'head_popup') {
					if (data.status) {
						$form_ref.addClass('hide');
						$('#call_popup .succes').removeClass('hide');
					}
				}

				if (id_form == 'sbm_form') {
					if (data.fields.auth_reg != '') 
					{
						//console.log(data.status);
						$('#check_cod #type_form').val(data.fields.auth_reg);
						$('#check_cod #name').val(data.fields.name);
						$('#check_cod #phone').val(data.fields.phone);
						$('#check_cod #role').val(data.fields.role);
						$('#check_cod #id_user').val(data.fields.id_user);

						// заказ
						$('#check_cod #tech').val(data.order.tech);
						$('#check_cod #when').val(data.order.when);
						$('#check_cod #time').val(data.order.time);
						$('#check_cod #interval').val(data.order.interval);
						$('#check_cod #where').val(data.order.where);
						$('#check_cod #job').val(data.order.job);
						$('#check_cod #money').val(data.order.money);
						$('#check_cod #price').val(data.order.price);
						// заказ
						Set_Timer();
						$.fancybox.open({ src: '#check_popup' });
					}
				}

				if (id_form == 'registr_form') {
					if (!data.status) {
						$loader.addClass('hide');
						$ready.html('Такой телефон уже есть').removeClass('hide');
						$form_ref.find('.phone').addClass("error");
					}
					else if (!data.wazz_status) {
						$loader.addClass('hide');
						$ready.html('Нет ответа от сервера').removeClass('hide');
					}
					else {
						$ready.html('Подтвердите код');
						//console.log(data);
						$('form#check_cod #role').val(data.fields.role);
						$('form#check_cod #name').val(data.fields.name);
						$('form#check_cod #phone').val(data.fields.phone);
						$('form#check_cod #type_form').val('registr');
						setTimeout(function () {
							$.fancybox.open({ src: '#check_popup' });
							Set_Timer();
						}, 500);
					}
				}

				if (id_form == 'check_cod') {
					if (data.status) {
						$('#check_popup .form_wrap').addClass('hide');
						$('#check_popup .succes').removeClass('hide');
						//if (data.role_id != 2)
						if(true)//заглушка
						{
							$('#check_popup .result').html(data.succes);
							setTimeout(function () {
								window.location = '/';
							}, 500);
						}
						else {
							$('#check_popup .result').html('Анкета на модерации!');
						}

						setTimeout(function () {
							$.fancybox.close({ src: '#check_popup' });
							setTimeout(function () {
								$('#check_popup .form_wrap').removeClass('hide');
								$('#check_popup .succes').addClass('hide');
							}, 300);
						}, 1000);
					}
					else {
						$loader.addClass('hide');
						$ready.removeClass('hide').html('Неверный код!');
					}
				}

				if (id_form == 'go_out_cab_form') {
					location.reload();
				}

				if (id_form == 'auth_form') {
					$loader.addClass('hide');
					$ready.html(data.text).removeClass('hide');
					if (!data.status || !data.wazz_status) {
						if (data.text == 'Ошиблись в данных!') {
							$form_ref.find('input').addClass("error");
						}
					}
					else 
					{
						$('form#check_cod #phone').val(data.fields.phone);
						$('form#check_cod #id_user').val(data.fields.id_user);
						$('form#check_cod #type_form').val('auth');
						setTimeout(function () {
							$.fancybox.open({ src: '#check_popup' });
							Set_Timer();
						}, 500);
					}
				}

				if (data.status)//общее
				{
					if (id_form != 'sbm_form' && id_form != 'registr_form' && id_form != 'auth_form')
					{
						$form_ref[0].reset();
					}
					if ($form_ref.hasClass('loader_form')) {
						$loader.addClass('hide');
						$ready.removeClass('hide');

						setTimeout(function () {
							$ready.addClass('hide');
							$send.removeClass('hide');
						}, 1500);
					}
				}
			}
		});
	}
	else {
		if ($form_ref.hasClass('loader_form')) {
			$form_ref[0].scrollIntoView({
				behavior: 'smooth',
				block: 'start'
			});
		}
	}
}

function Set_Timer()
{
	let time = 100;//cекунды
	let $time_box = $('#check_popup #time_wats');
	let time_val = $time_box.html();
	if(time_val == 1 || time_val == '')
	{
		$time_box.html(time);
		$('#check_popup .time_box').removeClass('hide');

		let id = setInterval(function() {
			time--;
			if (time == 0) 
			{
				clearInterval(id);
				$('#check_popup .time_box').addClass('hide');
				$('#check_popup #send_cod').addClass('hide');
				$('#check_popup #send_once_more').removeClass('hide');
				$('#send_once_more .opt_butt.send').removeClass('hide');
			} 
			else
			{
				$time_box.html(time);
			}
		}, 1000);
	}
}

function Update_Cod($form_ref, urll, event) {
	event.preventDefault();
	var formData = new FormData($form_ref[0]);
	var $send = $('#send_once_more .send');
	var $loader = $('#send_once_more .loader');
	$send.addClass('hide');
	$loader.removeClass('hide');
	$.ajax({
		type: "POST",
		url: urll,
		contentType: false,
		processData: false,
		data: formData,
		dataType: "json",
		success: function (data) {
			$loader.addClass('hide');
			if(!data.wazz_status) 
			{
				$send.html('Нет ответа от сервера!').removeClass('hide');
			}
			else
			{
				$send.html('Код отправлен!').removeClass('hide');

				setTimeout(function() {
					$('#check_popup #send_once_more').addClass('hide');
					$('#check_popup #send_cod').removeClass('hide');
					$('#check_popup .time_box').removeClass('hide');
					$('#send_cod .opt_butt.send').removeClass('hide');
					$('#send_cod .opt_butt.redy').addClass('hide');
					Set_Timer();
					$send.html('Отправить код');
				}, 500);
			}
		}
	});
}