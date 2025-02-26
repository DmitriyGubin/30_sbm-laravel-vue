//*********меню******/
let $header = $('header');
let $body = $('body');
$('header .burger').on('click', function(){
    $header.toggleClass('active');
	$body.toggleClass('overflow');
});
//*********меню******/


$("input.phone").mask("+7(999) 999-9999");
/***********файл***********/

File_Input($('#file_inp'), $('#file_button'), $('#popup_hidden_file'));

File_Input($('#doc_inp'), $('#recv_button'), $('#popup_hidden_file_doc'));

/***********файл***********/

/*******селект*******/

$('.inp_box.select').each(function(){
	let $inp = $(this).find('.select_inp');
	let $var_box = $(this).find('.var_box');

	$(this).on('click', function(){
		$var_box.slideToggle(300);
		$var_box.toggleClass('hide_box');
		Click_Out_Something($var_box, 'hide_box', 'mark_class');
	});

	$(this).find('.var_item').on('click', function(){
		let name = $(this).find('.name').html();
		$inp.val(name);
	});
});

/*******селект*******/

/**поиск***/

$('#send_form_butt').on('click', () => Send_Form($('#sbm_form'), '/rent-form', event));

$('#send_registr_form_butt').on('click', () => Send_Form($('#registr_form'), '/registr', event));

$('#go_out_cab_butt').on('click', () => Send_Form($('#go_out_cab_form'), '/go_out', event));

$('#send_auth_form_butt').on('click', () => Send_Form($('#auth_form'), '/auth_user', event));

$('#call_butt_head').on('click', () => Send_Form($('#head_popup'), '/call-order-form', event));

$('#test_butt').on('click', () => Send_Form($('#test_form'), '/file', event));

$('#send_cod').on('click', () => Send_Form($('#check_cod'), '/check_this_cod', event));

$('#call_popup .pop_butt#ready').on('click', function(){
	$.fancybox.close({ src: '#call_popup' });
});

$('header .call_order').on('click', function(){
	$('#head_popup').removeClass('hide');
	$('#call_popup .succes').addClass('hide');
	if(screen.width < 750)
	{
		$('header .burger')[0].click();
	}
});

$('#send_once_more').on('click', () => Update_Cod($('#check_cod'), '/update_this_cod', event));

// $('#tech_inp_vue').on('input', function(){
// 	$('#popup_tech_main .remark_price').css("display", "none");
// })


//минимальное количество часов
var $min_hour = $('#min_hour_order');
var $remark = $('#min_hour_remark');
$('input#interval').on('input', function(){
	let val = $(this).val();
	let min_val = $min_hour.html();
	
	if(/^\d+$/.test(val) && min_val != '' && /^\d+$/.test(min_val))
	{
		if(Number(val) < Number(min_val))
		{
			$remark.removeClass('hide');
		}
		else
		{
			$remark.addClass('hide');
		}
	}
	else
	{
		$remark.addClass('hide');
	}
});
//минимальное количество часов

//обновление техники из гугл таблицы
let $text = $('#update_providers_tech .send');
let $loader = $('#update_providers_tech .loader');
$('#update_providers_tech').on('click', function(){
	$text.addClass('hide');
	$loader.removeClass('hide');
	$.ajax({
		type: "POST",
		url: '/cron/google_tables.php',
		contentType: false,
		processData: false,
		data: {},
		dataType: "json",
		success: function (data) {
			// $text.removeClass('hide');
			// $loader.addClass('hide');
			location.reload();
		}
	});
});
//обновление техники из гугл таблицы

