<x-layout>
	<x-slot:title>
		Авторизация
	</x-slot>
	<section class="form_box full">
        <div class="wrap">
            <h1 class="title">Авторизация</h1>
            <div class="three_col">
                <img class="col" src="{{ config('global.path') }}/img/car_1.png">
                <form class="col univ_form loader_form" id="auth_form">

					<div class="inp_box">
                        <label for="phone">Ваш телефон, привязанный к WhatsApp*</label>
                        <input name="phone" id="phone" class="required phone" type="text">
                    </div>

                    <button id="send_auth_form_butt" class="univ_butt">
                        <span class="opt_butt send">Авторизоваться</span>
                        <span class="hide opt_butt redy">Вы авторизовались!</span>
                        <div class="opt_butt loader hide"></div>
                    </button>
                </form>
                <img class="col" src="{{ config('global.path') }}/img/car_2.png">
            </div>
        </div>
    </section>
</x-layout>