<form class="col univ_form loader_form" id="registr_form">

    <!-- <div class="inp_box select mark_class">
        <label class="mark_class">Статус*</label>
        <input readonly autocomplete="off" name="status" class="required select_inp mark_class" type="text">
        <x-status />
    </div> -->

    <input type="hidden" value='{{ $id }}' name="status">

    <div class="inp_box">
        <label for="phone">Имя*</label>
        <input name="name" class="required" type="text">
    </div>

    <div class="inp_box">
        <label for="phone">Ваш телефон, привязанный к WhatsApp*</label>
        <input name="phone" id="phone" class="required phone" type="text">
    </div>

    <button id="send_registr_form_butt" class="univ_butt">
        <span class="opt_butt send">Зарегистрироваться</span>
        <span class="hide opt_butt redy">Вы зарегистрировались!</span>
        <div class="opt_butt loader hide"></div>
    </button>
    <div class="error_form hide">Пользователь с таким номером уже есть в базе!</div>
</form>

