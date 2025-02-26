<x-layout>
	<x-slot:title>
		Главная страница
	</x-slot>
    @if($role != 3)
	<section class="form_box">
        <div class="wrap">
            <h1 class="title">Аренда спецтехники</h1>
            <div class="three_col">
                <img class="col" src="{{ config('global.path') }}/img/car_1.png">
                <form class="col univ_form loader_form" id="sbm_form">

                    <div class="inp_box select mark_class">
                        <label class="mark_class">
                            Выберите технику из каталога с оценкой или введите интересующую*
                        </label>
                        <input id="tech_inp_vue" value="{{ $order->tech ?? '' }}" autocomplete="off" name="tech" class="required select_inp" type="text">
                        <a data-fancybox="" data-src="#tech_popup" class="univ_butt tech" href="javascript:;">
                            Выбрать технику
                        </a>
                        <div id="popup_tech_main"></div>
                    </div>
                    

                    <div class="inp_box">
                        <label for="when">Когда едем*</label>
                        <input name="when" id="when" class="required" type="date">
                    </div>

                    <div class="inp_box">
                        <label for="time">Ко скольки едем*</label>
                        <input name="time" id="time" class="required" type="time">
                    </div>

                    <div class="inp_box">
                        <label for="interval">На сколько едем, ч*</label>
                        <input autocomplete="off" value="{{ $order->interval ?? '' }}" name="interval" id="interval" class="required" type="text">
                    </div>
                    <div class="remark_price hide" id="min_hour_remark">
                        Вы указали время меньше минимального значения, технику будет подобрать сложнее, менеджер свяжется для уточнения.
                    </div>

                    <div class="inp_box">
                        <label for="too">Куда едем*</label>
                        <input value="{{ $order->where ?? '' }}" name="where" id="too" class="required" type="text">
                    </div>

                    <div class="inp_box"> 
                        <label for="job">Что делаем*</label> 
                        <textarea name="job" id="job" class="required">{{ $order->job ?? '' }}</textarea>
                    </div>

                    <div class="inp_box select mark_class">
                        <label class="mark_class">Какой расчёт*</label>
                        <input class="select_inp mark_class required" name="money" readonly id="money" type="text">
                        <div class="var_box hide_box mark_class">
                            <div class="var_item mark_class"><span class="name mark_class">Безналичные с НДС</span></div>
                            <div class="var_item mark_class"><span class="name mark_class">Безналичные без НДС</span></div>
                            <div class="var_item mark_class"><span class="name mark_class">Наличные</span></div>
                        </div>
                    </div>
                    
                    <div class="inp_box" style="display: none;">
                        <label class="photo_label" for="file_inp">Фото работы (до 50 МБ)</label>
                        <input class="file_photo required" name="file" id="file_inp" type="file" style="display: none;">
                        <div id="file_button" class="file_button">
                            Прикрепите файл
                        </div>
                    </div>

                    @if(($recv == null) && ($role != 2) && ($role != 1))
                    <div class="inp_box"><!-- до 10 мб -->
                        <label class="file_label" for="doc_inp">Файл реквизитов</label>
                        <input class="file_doc required" name="file_rekv" id="doc_inp" type="file" style="display: none;">
                        <div id="recv_button" class="file_button">
                            Прикрепите файл
                        </div>
                    </div>
                    @endif

                    <!-- <div class="inp_box">
                        <label for="recviz">Реквизиты</label>
                        <textarea name="recviz" id="recviz"></textarea>
                    </div> -->

                    <div class="inp_box">
                        <label for="price">Желаемая стоимость</label>
                        <input value="{{ $order->price ?? '' }}" name="price" id="price" type="text">
                    </div>

                    @if(!$chek_auth)
                    <div class="inp_box">
                        <label for="phone">Ваш телефон, привязанный к WhatsApp*</label>
                        <input name="phone" id="phone" class="required phone" type="text">
                    </div>
                    @endif

                    <button id="send_form_butt" class="univ_butt">
                        <span class="opt_butt send">Отправить</span>
                        <span class="hide opt_butt redy">Форма отправлена!</span>
                        <div class="opt_butt loader hide"></div>
                    </button>
                </form>
                <img class="col" src="{{ config('global.path') }}/img/car_2.png">
            </div>
        </div>
    </section>
    @endif

    <section class="rent">
        <div class="wrapper">
            <h2 class="main_title">
                Аренда на смену или длительный срок
            </h2>
            <div class="rent_grid">
                <div class="rent_item">
                    <img class="rent_img" src="{{ config('global.path') }}/img/rent_1.svg" alt="#">
                    <div class="rent_title">
                        Без залога
                    </div>
                    <div class="rent_text">
                        Для клиентов от 1 года сотрудничества
                    </div>
                </div>

                <div class="rent_item">
                    <img class="rent_img" src="{{ config('global.path') }}/img/rent_2.svg" alt="#">
                    <div class="rent_title">
                        Вы платите только за выполненные работы
                    </div>
                    <div class="rent_text">
                        Время подачи техники - от 1 часа!
                    </div>
                </div>

                <div class="rent_item">
                    <img class="rent_img" src="{{ config('global.path') }}/img/rent_3.svg" alt="#">
                    <div class="rent_title">
                        Предложим цены ниже конкурентов
                    </div>
                    <div class="rent_text">
                        Вся техника застрахована и в отличном состоянии
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>