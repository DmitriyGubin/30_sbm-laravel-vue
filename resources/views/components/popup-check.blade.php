
    <div class="univers_popup" style="display: none;" id="check_popup">
        <form id="check_cod" class="form_wrap loader_form">
            <div class="pop_title">Код отправлен на watsapp</div>
            <div class="inp_box">
                <label for="cod">Введите код</label>
                <input class="required" type="text" id="cod" name="cod" autocomplete="off">
            </div>

            <input type="hidden" name="role" id="role">
            <input type="hidden" name="name" id="name">
            <input type="hidden" name="phone" id="phone">
            <input type="hidden" name="id_user" id="id_user">
            <input type="hidden" name="type_form" id="type_form">
            <!-- заказ -->
            <input type="hidden" name="tech" id="tech">
            <input type="hidden" name="when" id="when">
            <input type="hidden" name="time" id="time">
            <input type="hidden" name="interval" id="interval">
            <input type="hidden" name="where" id="where">
            <input type="hidden" name="job" id="job">
            <input type="hidden" name="money" id="money">
            <input type="hidden" name="price" id="price">
            <input name="file" style="display: none;" type="file" id="popup_hidden_file">
            <input name="file_rekv" style="display: none;" type="file" id="popup_hidden_file_doc">
            <!-- заказ -->

            <div class="time_box">
                Отправить повторно можно через <span id="time_wats"></span> секунд
            </div>

            <button class="pop_butt" id="send_cod">
                <span class="opt_butt send">Проверить код</span>
                <span class="opt_butt redy hide">Форма отправлена!</span>
                <div class="opt_butt loader hide"></div>
            </button>

            <button class="pop_butt hide" id="send_once_more">
                <span class="opt_butt send">Отправить код</span>
                <div class="opt_butt loader hide"></div>
            </button>

        </form>

        <div class="hide succes">
            <div class="pop_title result">Вы успешно зарегистрировались!</div>
        </div>
    </div>